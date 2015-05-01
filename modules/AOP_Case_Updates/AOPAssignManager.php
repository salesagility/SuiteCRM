<?php
class AOPAssignManager{
    private $ieX = false;
    private $distributionMethod = '';
    private $aopFallback = true;
    private $assignableUsers = array();

    function __construct($ieX = false){
        global $sugar_config;
        $this->ieX = $ieX;
        if($ieX) {
            $inboundDistribMethod = $ieX->get_stored_options("distrib_method", "");
        }else{
            $inboundDistribMethod = '';
        }
        if($this->isAOPFallback($inboundDistribMethod)){
            $this->distributionMethod = $sugar_config['aop']['distribution_method'];
            $this->aopFallback = true;
        }else{
            $this->distributionMethod = $inboundDistribMethod;
            $this->aopFallback = false;
        }
        $this->assignableUsers = $this->getAssignableUsers();
    }

    private function isAOPFallback($distribMethod){
        return empty($distribMethod) || $distribMethod == 'AOPDefault';
    }

    private function getDistributionOptions(){
        global $sugar_config;
        if($this->aopFallback){
            return $sugar_config['aop']['distribution_options'];
        }else{
            return $this->ieX->get_stored_options("distribution_options", '');
        }
    }

    private function getRoleUsers($roleId){
        require_once('modules/ACLRoles/ACLRole.php');
        $role = new ACLRole();
        $role->retrieve($roleId);
        $role_users = $role->get_linked_beans( 'users','User');
        $r_users = array();
        foreach($role_users as $role_user){
            $r_users[$role_user->id] = $role_user->name;
        }
        return $r_users;
    }

    private function getAssignableUsers(){
        if($this->distributionMethod == 'singleUser'){
            return array();
        }
        $distributionOptions = $this->getDistributionOptions();

        if(empty($distributionOptions)){
            return array();
        }
        switch($distributionOptions[0]) {
            Case 'security_group':
                if(file_exists('modules/SecurityGroups/SecurityGroup.php')){
                    require_once('modules/SecurityGroups/SecurityGroup.php');
                    $security_group = new SecurityGroup();
                    $security_group->retrieve($distributionOptions[1]);
                    $group_users = $security_group->get_linked_beans( 'users','User');
                    $users = array();
                    $r_users = array();
                    if($distributionOptions[2] != ''){
                        $r_users = $this->getRoleUsers($distributionOptions[2]);
                    }
                    foreach($group_users as $group_user){
                        if($distributionOptions[2] != '' && !isset($r_users[$group_user->id])){
                            continue;
                        }
                        $users[$group_user->id] = $group_user->name;
                    }
                    break;
                }
            //No Security Group module found - fall through.
            Case 'role':
                $users = $this->getRoleUsers($distributionOptions[2]);
                break;
            Case 'all':
            default:
                $users = get_user_array(false);
                break;
        }
        return $users;

    }

    private function getSingleUser(){
        global $sugar_config;
        if($this->singleUser){
            return $this->singleUser;
        }
        if($this->aopFallback){
            $this->singleUser = !empty($sugar_config['aop']['distribution_user_id']) ? $sugar_config['aop']['distribution_user_id'] : '';
        }else{
            $this->singleUser = $this->ieX->get_stored_options("distribution_user_id", "");
        }
        return $this->singleUser;
    }

    private function getLeastBusyCounts(){
        if($this->leastBusyUsers){
            return $this->leastBusyUsers;
        }
        global $db;
        $idIn = implode("','",$db->arrayQuote(array_keys($this->assignableUsers)));
        if($idIn){
            $idIn = "'".$idIn."'";
        }
        $res = $db->query("SELECT assigned_user_id, COUNT(*) AS c FROM cases WHERE assigned_user_id IN ({$idIn}) AND deleted = 0 GROUP BY assigned_user_id ORDER BY COUNT(*)");
        $this->leastBusyUsers = array();
        while($row = $db->fetchByAssoc($res)){
            $this->leastBusyUsers[$row['assigned_user_id']] = $row['c'];
        }
        return $this->leastBusyUsers;
    }

    private function getLeastBusyUser(){
        $leastBusyCounts = $this->getLeastBusyCounts();
        asort($leastBusyCounts);
        reset($leastBusyCounts);
        return key($leastBusyCounts);
    }

    private function updateLeastBusy($id){
        if(!$this->leastBusyUsers){
            $this->getLeastBusyCounts();
        }
        $this->leastBusyUsers[$id] = $this->leastBusyUsers[$id] + 1;
    }

    private function getRandomUser(){
        $randKey = array_rand($this->assignableUsers);
        return $this->assignableUsers[$randKey];
    }

    function getNextAssignedUser(){
        switch($this->distributionMethod){
            case 'singleUser':
                $userId = $this->getSingleUser();
                break;
            case 'roundRobin':
                $userId = $this->getRoundRobinUser();
                $this->setLastRoundRobinUser($userId);
                break;
            case 'leastBusy':
                $userId = $this->getLeastBusyUser();
                $this->updateLeastBusy($userId);
                break;
            case 'random':
                $userId = $this->getRandomUser();
                break;
            default:
                $userId = '';
        }
        return $userId;
    }

    private function getRoundRobinUser() {
        $id = empty($this->ieX) ? '' : $this->ieX->id;
        $file = create_cache_directory('modules/AOP_Case_Updates/Users/') . $id . 'lastUser.cache.php';
        if(isset($_SESSION['AOPlastuser'][$id]) && $_SESSION['AOPlastuser'][$id] != '') {
            $lastUserId = $_SESSION['AOPlastuser'][$id];
        }
        else if (is_file($file)){
            include $file;
            if(isset($lastUser['User']) && $lastUser['User'] != '') {
                $lastUserId = $lastUser['User'];
            }
        }
        $users = array_keys($this->assignableUsers);
        $lastOffset = array_search($lastUserId,$users);
        $newOffset = ($lastOffset + 1) % count($users);
        if(!empty($users[$newOffset])) {
            return $users[$newOffset];
        }
        return reset($users);
    }

    private function setLastRoundRobinUser($user_id) {
        $id = empty($this->ieX) ? '' : $this->ieX->id;
        $_SESSION['AOPlastuser'][$id] = $user_id;
        $file = create_cache_directory('modules/AOP_Case_Updates/Users/') . $id . 'lastUser.cache.php';
        $arrayString = var_export_helper(array('User' => $user_id));
        $content =<<<eoq
<?php
	\$lastUser = {$arrayString};
?>
eoq;
        if($fh = @sugar_fopen($file, 'w')) {
            fputs($fh, $content);
            fclose($fh);
        }
        return true;
    }


}
