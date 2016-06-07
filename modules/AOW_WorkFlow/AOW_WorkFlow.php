<?php
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */



class AOW_WorkFlow extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOW_WorkFlow';
	var $object_name = 'AOW_WorkFlow';
	var $table_name = 'aow_workflow';
	var $importable = false;
	var $disable_row_level_security = true ;

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
	var $assigned_user_id;
	var $assigned_user_name;
	var $assigned_user_link;
	var $flow_module;
	var $status;
	var $run_when;

	public function __construct($init=true){
		parent::__construct();
        if($init){
            $this->load_flow_beans();
            require_once('modules/AOW_WorkFlow/aow_utils.php');
        }
	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function AOW_WorkFlow($init=true){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($init);
    }

	function bean_implements($interface){
		switch($interface){
			case 'ACL': return true;
		}
		return false;
	}

    function save($check_notify = FALSE){
        if (empty($this->id)){
            unset($_POST['aow_conditions_id']);
            unset($_POST['aow_actions_id']);
        }

        parent::save($check_notify);

        require_once('modules/AOW_Conditions/AOW_Condition.php');
        $condition = new AOW_Condition();
        $condition->save_lines($_POST, $this, 'aow_conditions_');

        require_once('modules/AOW_Actions/AOW_Action.php');
        $action = new AOW_Action();
        $action->save_lines($_POST, $this, 'aow_actions_');
    }

    function load_flow_beans(){
        global $beanList, $app_list_strings;

        $app_list_strings['aow_moduleList'] = $app_list_strings['moduleList'];

        if(!empty($app_list_strings['aow_moduleList'])){
            foreach($app_list_strings['aow_moduleList'] as $mkey => $mvalue){
                if(!isset($beanList[$mkey]) || str_begin($mkey, 'AOW_')){
                    unset($app_list_strings['aow_moduleList'][$mkey]);
                }
            }
        }

        $app_list_strings['aow_moduleList'] = array_merge((array)array(''=>''), (array)$app_list_strings['aow_moduleList']);

        asort($app_list_strings['aow_moduleList']);
    }

    /**
     * Select and run all active flows
     */
	function run_flows(){
		$flows = AOW_WorkFlow::get_full_list(''," aow_workflow.status = 'Active'  AND (aow_workflow.run_when = 'Always' OR aow_workflow.run_when = 'In_Scheduler' OR aow_workflow.run_when = 'Create') ");

        foreach($flows as $flow){
            $flow->run_flow();
        }
        return true;
	}

    /**
     * Retrieve the beans to actioned and run the actions
     */
    function run_flow(){
        $beans = $this->get_flow_beans();
        if(!empty($beans)){

            foreach($beans as $bean){
                $bean->retrieve($bean->id);
                $this->run_actions($bean);
            }
        }
    }

    /**
     * Select and run all active flows for the specified bean
     */
    function run_bean_flows(SugarBean &$bean){
        if(!isset($_REQUEST['module']) || $_REQUEST['module'] != 'Import'){

            $query = "SELECT id FROM aow_workflow WHERE aow_workflow.flow_module = '".$bean->module_dir."' AND aow_workflow.status = 'Active' AND (aow_workflow.run_when = 'Always' OR aow_workflow.run_when = 'On_Save' OR aow_workflow.run_when = 'Create') AND aow_workflow.deleted = 0 ";

            $result = $this->db->query($query, false);
            $flow = new AOW_WorkFlow();
            while (($row = $bean->db->fetchByAssoc($result)) != null){
                $flow ->retrieve($row['id']);
                if($flow->check_valid_bean($bean))
                    $flow->run_actions($bean, true);
            }
        }
        return true;
    }

    /**
     * Use the condition statements and processed table to build query to retrieve beans to be actioned
     */
    function get_flow_beans(){
        global $beanList;

        if($beanList[$this->flow_module]){
            $module = new $beanList[$this->flow_module]();

            $query = '';
            $query_array = array();

            $query_array['select'][] = $module->table_name.".id AS id";
            $query_array = $this->build_flow_query_where($query_array);

            if(!empty($query_array)){
                foreach ($query_array['select'] as $select){
                    $query .=  ($query == '' ? 'SELECT ' : ', ').$select;
                }

                $query .= ' FROM '.$module->table_name.' ';

                if(isset($query_array['join'])){
                    foreach ($query_array['join'] as $join){
                        $query .= $join;
                    }
                }
                if(isset($query_array['where'])){
                    $query_where = '';
                    foreach ($query_array['where'] as $where){
                        $query_where .=  ($query_where == '' ? 'WHERE ' : ' AND ').$where;
                    }
                    $query .= ' '.$query_where;
                }
                return $module->process_full_list_query($query);
            }


        }
        return null;
    }

    function build_flow_query_join($name, SugarBean $module, $type, $query = array()){

        if(!isset($query['join'][$name])){

            switch ($type){
                case 'custom':
                    $query['join'][$name] = 'LEFT JOIN '.$module->get_custom_table_name().' '.$name.' ON '.$module->table_name.'.id = '. $name.'.id_c ';
                    break;

                case 'relationship':
                    if($module->load_relationship($name)){
                        $params['join_type'] = 'LEFT JOIN';
                        $params['join_table_alias'] = $name;
                        $join = $module->$name->getJoin($params, true);

                        $query['join'][$name] = $join['join'];
                        $query['select'][] = $join['select']." AS '".$name."_id'";
                    }
                    break;
                default:
                    break;

            }

        }
        return $query;
    }

    function build_flow_query_where($query = array()){
        global $beanList;

        if($beanList[$this->flow_module]){
            $module = new $beanList[$this->flow_module]();

            $sql = "SELECT id FROM aow_conditions WHERE aow_workflow_id = '".$this->id."' AND deleted = 0 ORDER BY condition_order ASC";
            $result = $this->db->query($sql);

            while ($row = $this->db->fetchByAssoc($result)) {
                $condition = new AOW_Condition();
                $condition->retrieve($row['id']);
                $query = $this->build_query_where($condition,$module,$query);
                if(empty($query)){
                    return $query;
                }
            }
            if($this->flow_run_on){
                switch($this->flow_run_on){

                    case'New_Records':
                        $query['where'][] = $module->table_name . '.' . 'date_entered' . ' > ' . "'" .$this->date_entered."'";
                        Break;

                    case'Modified_Records':
                        $query['where'][] = $module->table_name . '.' . 'date_modified' . ' > ' . "'" .$this->date_entered."'" . ' AND ' . $module->table_name . '.' . 'date_entered' . ' <> ' . $module->table_name . '.' . 'date_modified';
                        Break;

                }
            }

            if(!$this->multiple_runs){
                $query['where'][] .= "NOT EXISTS (SELECT * FROM aow_processed WHERE aow_processed.aow_workflow_id='".$this->id."' AND aow_processed.parent_id=".$module->table_name.".id AND aow_processed.status = 'Complete' AND aow_processed.deleted = 0)";
            }

            $query['where'][] = $module->table_name.".deleted = 0 ";
        }

        return $query;
    }

    function build_query_where(AOW_Condition $condition, $module, $query = array()){
        global $beanList, $app_list_strings, $sugar_config, $timedate;
        $path = unserialize(base64_decode($condition->module_path));

        $condition_module = $module;
        $table_alias = $condition_module->table_name;
        if(isset($path[0]) && $path[0] != $module->module_dir){
            foreach($path as $rel){
                $query = $this->build_flow_query_join($rel, $condition_module, 'relationship', $query);
                $condition_module = new $beanList[getRelatedModule($condition_module->module_dir,$rel)];
                $table_alias = $rel;
            }
        }

        if(isset($app_list_strings['aow_sql_operator_list'][$condition->operator])){
            $where_set = false;

            $data = $condition_module->field_defs[$condition->field];

            if($data['type'] == 'relate' && isset($data['id_name'])) {
                $condition->field = $data['id_name'];
            }
            if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                $field = $table_alias.'_cstm.'.$condition->field;
                $query = $this->build_flow_query_join($table_alias.'_cstm', $condition_module, 'custom', $query);
            } else {
                $field = $table_alias.'.'.$condition->field;
            }

            if($condition->operator == 'is_null'){
                $query['where'][] = '('.$field.' '.$app_list_strings['aow_sql_operator_list'][$condition->operator].' OR '.$field.' '.$app_list_strings['aow_sql_operator_list']['Equal_To']." '')";
                return $query;
            }

            switch($condition->value_type) {
                case 'Field':
                    $data = $module->field_defs[$condition->value];

                    if($data['type'] == 'relate' && isset($data['id_name'])) {
                        $condition->value = $data['id_name'];
                    }
                    if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                        $value = $module->table_name.'_cstm.'.$condition->value;
                        $query = $this->build_flow_query_join($module->table_name.'_cstm', $module, 'custom', $query);
                    } else {
                        $value = $module->table_name.'.'.$condition->value;
                    }
                    break;
                case 'Any_Change':
                    //can't detect in scheduler so return
                    return array();
                case 'Date':
                    $params =  unserialize(base64_decode($condition->value));
                    if($params[0] == 'now'){
                        if($sugar_config['dbconfig']['db_type'] == 'mssql'){
                            $value  = 'GetUTCDate()';
                        } else {
                            $value = 'UTC_TIMESTAMP()';
                        }
                    } else if($params[0] == 'today'){
                        if($sugar_config['dbconfig']['db_type'] == 'mssql'){
                            //$field =
                            $value  = 'CAST(GETDATE() AS DATE)';
                        } else {
                            $field = 'DATE('.$field.')';
                            $value = 'Curdate()';
                        }
                    } else {
                        $data = $module->field_defs[$params[0]];
                        if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                            $value = $module->table_name.'_cstm.'.$params[0];
                            $query = $this->build_flow_query_join($module->table_name.'_cstm', $module, 'custom', $query);
                        } else {
                            $value = $module->table_name.'.'.$params[0];
                        }
                    }

                    if($params[1] != 'now'){
                        switch($params[3]) {
                            case 'business_hours';
                                if(file_exists('modules/AOBH_BusinessHours/AOBH_BusinessHours.php') && $params[0] == 'now'){
                                    require_once('modules/AOBH_BusinessHours/AOBH_BusinessHours.php');

                                    $businessHours = new AOBH_BusinessHours();

                                    $amount = $params[2];

                                    if($params[1] != "plus"){
                                        $amount = 0-$amount;
                                    }
                                    $value = $businessHours->addBusinessHours($amount);
                                    $value = "'".$timedate->asDb( $value )."'";
                                    break;
                                }
                                //No business hours module found - fall through.
                                $params[3] = 'hour';
                            default:
                                if($sugar_config['dbconfig']['db_type'] == 'mssql'){
                                    $value = "DATEADD(".$params[3].",  ".$app_list_strings['aow_date_operator'][$params[1]]." $params[2], $value)";
                                } else {
                                    $value = "DATE_ADD($value, INTERVAL ".$app_list_strings['aow_date_operator'][$params[1]]." $params[2] ".$params[3].")";
                                }
                                break;
                        }
                    }
                    break;

                case 'Multi':
                    $sep = ' AND ';
                    if($condition->operator == 'Equal_To') $sep = ' OR ';
                    $multi_values = unencodeMultienum($condition->value);
                    if(!empty($multi_values)){
                        $value = '(';
                        if($data['type'] == 'multienum'){
                            $multi_operator =  $condition->operator == 'Equal_To' ? 'LIKE' : 'NOT LIKE';
                            foreach($multi_values as $multi_value){
                                if($value != '(') $value .= $sep;
                                $value .= $field." $multi_operator '%^".$multi_value."^%'";
                            }
                        }
                        else {
                            foreach($multi_values as $multi_value){
                                if($value != '(') $value .= $sep;
                                $value .= $field.' '.$app_list_strings['aow_sql_operator_list'][$condition->operator]." '".$multi_value."'";
                            }
                        }
                        $value .= ')';
                        $query['where'][] = $value;
                    }
                    $where_set = true;
                    break;
                case 'SecurityGroup':
                    if(file_exists('modules/SecurityGroups/SecurityGroup.php')){
                        //TODO check bean in group
                        return array();
                        break;
                    }

                case 'Value':
                default:
                    $value = "'".$condition->value."'";
                    break;
            }

            //handle like conditions
            Switch($condition->operator) {
                case 'Contains':
                    $value = "CONCAT('%', ".$value." ,'%')";
                    break;
                case 'Starts_With':
                    $value = "CONCAT(".$value." ,'%')";
                    break;
                case 'Ends_With':
                    $value = "CONCAT('%', ".$value.")";
                    break;
            }


            if(!$where_set) $query['where'][] = $field.' '.$app_list_strings['aow_sql_operator_list'][$condition->operator].' '.$value;
        }

        return $query;

    }

    function check_valid_bean(SugarBean &$bean){
        global $app_list_strings, $timedate;

        require_once('modules/AOW_Processed/AOW_Processed.php');
        $processed = new AOW_Processed();
        if(!$this->multiple_runs){
            $processed->retrieve_by_string_fields(array('aow_workflow_id' => $this->id,'parent_id' => $bean->id));

            if($processed->status == 'Complete'){
                //has already run so return false
                return false;
            }
        }

        if(!isset($bean->date_entered)){
            $bean->date_entered = $bean->fetched_row['date_entered'];
        }


        if($this->flow_run_on){

            // database time correction with the user's time-zoneqq
            $beanDateEnteredTimestamp = strtotime($timedate->asUser(new DateTime($timedate->fromDb($bean->date_entered))));
            $beanDateModifiedTimestamp = strtotime($timedate->asUser(new DateTime($timedate->fromDb($bean->date_modified))));
            $thisDateEnteredTimestamp = strtotime($this->date_entered);

            switch($this->flow_run_on){
                case'New_Records':
                    // it is an invalid bean if the user modify it now because the affection need on new records only!
                    if(!empty($bean->fetched_row) ||
                        $beanDateEnteredTimestamp < $thisDateEnteredTimestamp) {
                        return false;
                    }
                    Break;

                case'Modified_Records':
                    // it isn't a valid bean if the user create it now because the affection need on already exists records only!
                    if(empty($bean->fetched_row) ||
                        ($beanDateModifiedTimestamp < $thisDateEnteredTimestamp && $beanDateModifiedTimestamp != $beanDateEnteredTimestamp)) {
                        return false;
                    }
                    Break;

            }
        }

        $sql = "SELECT id FROM aow_conditions WHERE aow_workflow_id = '".$this->id."' AND deleted = 0 ORDER BY condition_order ASC";

        $result = $this->db->query($sql);
        $query_array = array();

        while ($row = $this->db->fetchByAssoc($result)) {
            $condition = new AOW_Condition();
            $condition->retrieve($row['id']);

            $path = unserialize(base64_decode($condition->module_path));

            $condition_bean = $bean;

            if(isset($path[0]) && $path[0] != $bean->module_dir){
                $query_array = $this->build_query_where($condition, $condition_bean, $query_array);
                continue;
            }

            $field = $condition->field;
            $value = $condition->value;

            $dateFields = array('date','datetime', 'datetimecombo');
            if(isset($app_list_strings['aow_sql_operator_list'][$condition->operator])){

                $data = $condition_bean->field_defs[$field];

                if($data['type'] == 'relate' && isset($data['id_name'])) {
                    $field = $data['id_name'];
                    $condition->field = $data['id_name'];
                }
                $field = $condition_bean->$field;

                if(in_array($data['type'],$dateFields)) {
                    $field = strtotime($field);
                }

                switch($condition->value_type) {
                    case 'Field':
                        $data = $condition_bean->field_defs[$value];

                        if($data['type'] == 'relate' && isset($data['id_name'])) {
                            $value = $data['id_name'];
                        }
                        $value = $condition_bean->$value;

                        if(in_array($data['type'],$dateFields)) {
                            $value = strtotime($value);
                        }

                        break;

                    case 'Any_Change':
                        $value = $condition_bean->fetched_row[$condition->field];
                        if(in_array($data['type'],$dateFields)) {
                            $value = strtotime($value);
                        }
                        switch($condition->operator) {
                            case 'Not_Equal_To';
                                $condition->operator = 'Equal_To';
                                break;
                            case 'Equal_To';
                            default:
                                $condition->operator = 'Not_Equal_To';
                                break;
                        }
                        break;

                    case 'Date':
                        $params =  unserialize(base64_decode($value));
                        $dateType = 'datetime';
                        if($params[0] == 'now'){
                            $value = date('Y-m-d H:i:s');
                        } else if($params[0] == 'today'){
                            $dateType = 'date';
                            $value = date('Y-m-d');
                            $field = strtotime(date('Y-m-d', $field));
                        } else {
                            $fieldName = $params[0];
                            $value = $condition_bean->$fieldName;
                        }

                        if($params[1] != 'now'){
                            switch($params[3]) {
                                case 'business_hours';
                                    if(file_exists('modules/AOBH_BusinessHours/AOBH_BusinessHours.php')){
                                        require_once('modules/AOBH_BusinessHours/AOBH_BusinessHours.php');

                                        $businessHours = new AOBH_BusinessHours();

                                        $amount = $params[2];
                                        if($params[1] != "plus"){
                                            $amount = 0-$amount;
                                        }

                                        $value = $businessHours->addBusinessHours($amount, $timedate->fromDb($value));
                                        $value = strtotime($timedate->asDbType( $value, $dateType ));
                                        break;
                                    }
                                    //No business hours module found - fall through.
                                    $params[3] = 'hours';
                                default:
                                    $value = strtotime($value.' '.$app_list_strings['aow_date_operator'][$params[1]]." $params[2] ".$params[3]);
                                    if($dateType == 'date') $value = strtotime(date('Y-m-d', $value));
                                    break;
                            }
                        } else {
                            $value = strtotime($value);
                        }
                        break;

                    case 'Multi':

                        $value = unencodeMultienum($value);
                        if($data['type'] == 'multienum') $field = unencodeMultienum($field);
                        switch($condition->operator) {
                            case 'Not_Equal_To';
                                $condition->operator = 'Not_One_of';
                                break;
                            case 'Equal_To';
                            default:
                                $condition->operator = 'One_of';
                                break;
                        }
                        break;
                    case 'SecurityGroup':
                        if(file_exists('modules/SecurityGroups/SecurityGroup.php')){
                            $sg_module = $condition_bean->module_dir;
                            if(isset($data['module']) && $data['module'] != ''){
                                $sg_module = $data['module'];
                            }
                            $value = $this->check_in_group($field, $sg_module, $value);
                            $field = true;
                        break;
                        }
                    case 'Value':
                    default:
                        if(in_array($data['type'],$dateFields) && trim($value) != '') {
                            $value = strtotime($value);
                        }
                        break;
                }

                if(!($this->compare_condition($field, $value, $condition->operator))){
                    return false;
                }

            }
        }

        if(isset($query_array['where'])){

            $query = 'SELECT '.$bean->table_name.'.id AS id FROM '.$bean->table_name.' ';

            if(isset($query_array['join'])){
                foreach ($query_array['join'] as $join){
                    $query .= $join;
                }
            }
            $query_where = '';
            $query_array['where'][] = $bean->table_name.'.id = '."'".$bean->id."'";
            foreach ($query_array['where'] as $where){
                $query_where .=  ($query_where == '' ? 'WHERE ' : ' AND ').$where;
            }
            $query .= ' '.$query_where;

            $rel_check = $bean->db->getOne($query);

            if($rel_check == ''){
                return false;
            }

        }

        return true;
    }

    function compare_condition($var1, $var2, $operator = 'Equal_To'){
        switch ($operator) {
            case "Not_Equal_To": return $var1 != $var2;
            case "Greater_Than":  return $var1 >  $var2;
            case "Less_Than":  return $var1 <  $var2;
            case "Greater_Than_or_Equal_To": return $var1 >= $var2;
            case "Less_Than_or_Equal_To": return $var1 <= $var2;
            case "Contains" : return strpos($var1,$var2);
            case "Starts_With" : return strrpos($var1,$var2, -strlen($var1));
            case "Ends_With" : return strpos($var1,$var2,strlen($var1) - strlen($var2));
            case "is_null": return $var1 == '';
            case "One_of":
                if(is_array($var1)){
                    foreach($var1 as $var){
                        if(in_array($var,$var2)) return true;
                    }
                    return false;
                }
                else return in_array($var1,$var2);
            case "Not_One_of":
                if(is_array($var1)){
                    foreach($var1 as $var){
                        if(in_array($var,$var2)) return false;
                    }
                    return true;
                }
                else return !in_array($var1,$var2);
            case "Equal_To":
            default: return $var1 == $var2;
        }
    }

    function check_in_group($bean_id, $module, $group){
        $sql = "SELECT id FROM securitygroups_records WHERE record_id = '".$bean_id."' AND module = '".$module."' AND securitygroup_id = '".$group."' AND deleted=0";
        if($module == 'Users')  $sql = "SELECT id FROM securitygroups_users WHERE user_id = '".$bean_id."' AND securitygroup_id = '".$group."' AND deleted=0";
        $id = $this->db->getOne($sql);
        if($id != '') return true;
        return false;
    }

    /**
     * Run the actions against the passed $bean
     */
    function run_actions(SugarBean &$bean, $in_save = false){

        require_once('modules/AOW_Processed/AOW_Processed.php');
        $processed = new AOW_Processed();
        if(!$this->multiple_runs){
            $processed->retrieve_by_string_fields(array('aow_workflow_id' => $this->id,'parent_id' => $bean->id));

            if($processed->status == 'Complete'){
                //should not have gotten this far, so return
                return true;
            }
        }
        $processed->aow_workflow_id = $this->id;
        $processed->parent_id = $bean->id;
        $processed->parent_type = $bean->module_dir;
        $processed->status = 'Running';
        $processed->save(false);
        $processed->load_relationship('aow_actions');

        $pass = true;

        $sql = "SELECT id FROM aow_actions WHERE aow_workflow_id = '".$this->id."' AND deleted = 0 ORDER BY action_order ASC";
        $result = $this->db->query($sql);

        while ($row = $this->db->fetchByAssoc($result)) {
            $action = new AOW_Action();
            $action->retrieve($row['id']);

            if($this->multiple_runs || !$processed->db->getOne("select id from aow_processed_aow_actions where aow_processed_id = '".$processed->id."' AND aow_action_id = '".$action->id."' AND status = 'Complete'")){
                $action_name = 'action'.$action->action;

                if(file_exists('custom/modules/AOW_Actions/actions/'.$action_name.'.php')){
                    require_once('custom/modules/AOW_Actions/actions/'.$action_name.'.php');
                } else if(file_exists('modules/AOW_Actions/actions/'.$action_name.'.php')){
                    require_once('modules/AOW_Actions/actions/'.$action_name.'.php');
                } else {
                    return false;
                }

                $custom_action_name = "custom" . $action_name;
                if(class_exists($custom_action_name)){
                    $action_name = $custom_action_name;
                }


                $flow_action = new $action_name($action->id);
                if(!$flow_action->run_action($bean, unserialize(base64_decode($action->parameters)), $in_save)){
                    $pass = false;
                    $processed->aow_actions->add($action->id, array('status' => 'Failed'));
                } else {
                    $processed->aow_actions->add($action->id, array('status' => 'Complete'));
                }
            }

        }

        if($pass) $processed->status = 'Complete';
        else $processed->status = 'Failed';
        $processed->save(false);

        return $pass;
    }


}
?>
