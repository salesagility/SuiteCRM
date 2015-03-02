<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

require_once 'modules/AOR_Scheduled_Reports/lib/Cron/includeCron.php';
class AOR_Scheduled_Reports extends basic {

    var $new_schema = true;
    var $module_dir = 'AOR_Scheduled_Reports';
    var $object_name = 'AOR_Scheduled_Reports';
    var $table_name = 'aor_scheduled_reports';
    var $importable = false;
    var $disable_row_level_security = true;
    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $schedule;
    var $email_recipients;
    var $status;
    var $last_run;
    var $aor_report_id;

	function AOR_Scheduled_Reports(){
        parent::Basic();
	}

    function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }

    function save($check_notify = FALSE){

        if(isset($_POST['email_recipients']) && is_array($_POST['email_recipients'])){
            $this->email_recipients = base64_encode(serialize($_POST['email_recipients']));
        }

        parent::save($check_notify);
    }

    function get_email_recipients(){

        $params = unserialize(base64_decode($this->email_recipients));

        $emails = array();
        if(isset($params['email_target_type'])){
            foreach($params['email_target_type'] as $key => $field){
                switch($field){
                    case 'Email Address':
                        $emails[] = $params['email'][$key];
                        break;
                    case 'Specify User':
                        $user = new User();
                        $user->retrieve($params['email'][$key]);
                        $emails[] = $user->emailAddress->getPrimaryAddress($user);
                        break;
                    case 'Users':
                        $users = array();
                        switch($params['email'][$key][0]) {
                            Case 'security_group':
                                if(file_exists('modules/SecurityGroups/SecurityGroup.php')){
                                    require_once('modules/SecurityGroups/SecurityGroup.php');
                                    $security_group = new SecurityGroup();
                                    $security_group->retrieve($params['email'][$key][1]);
                                    $users = $security_group->get_linked_beans( 'users','User');
                                    $r_users = array();
                                    if($params['email'][$key][2] != ''){
                                        require_once('modules/ACLRoles/ACLRole.php');
                                        $role = new ACLRole();
                                        $role->retrieve($params['email'][$key][2]);
                                        $role_users = $role->get_linked_beans( 'users','User');
                                        foreach($role_users as $role_user){
                                            $r_users[$role_user->id] = $role_user->name;
                                        }
                                    }
                                    foreach($users as $user_id => $user){
                                        if($params['email'][$key][2] != '' && !isset($r_users[$user->id])){
                                            unset($users[$user_id]);
                                        }
                                    }
                                    break;
                                }
                            //No Security Group module found - fall through.
                            Case 'role':
                                require_once('modules/ACLRoles/ACLRole.php');
                                $role = new ACLRole();
                                $role->retrieve($params['email'][$key][2]);
                                $users = $role->get_linked_beans( 'users','User');
                                break;
                            Case 'all':
                            default:
                                global $db;
                                $sql = "SELECT id from users WHERE status='Active' AND portal_only=0 ";
                                $result = $db->query($sql);
                                while ($row = $db->fetchByAssoc($result)) {
                                    $user = new User();
                                    $user->retrieve($row['id']);
                                    $users[$user->id] = $user;
                                }
                                break;
                        }
                        foreach($users as $user){
                            $emails[] = $user->emailAddress->getPrimaryAddress($user);
                        }
                        break;
                }
            }
        }
        return $emails;

    }

    function shouldRun(DateTime $date){
        global $timedate;
        if(empty($date)){
            $date = new DateTime();
        }
        $cron = Cron\CronExpression::factory($this->schedule);
        if(empty($this->last_run) && $cron->isDue($date)){
            return true;
        }
        $lastRun = $timedate->fromDb($this->last_run);
        $next = $cron->getNextRunDate($lastRun);
        if($next < $date){
            return true;
        }
        return false;
    }
}
