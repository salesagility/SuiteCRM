<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

include_once('SharedSecurityRulesHelper.php');
include_once('SharedSecurityRulesChecker.php');

class SharedSecurityRules extends Basic
{

    /**
     *
     * @var bool
     */
    public $new_schema = true;

    /**
     *
     * @var string
     */
    public $module_dir = 'SharedSecurityRules';

    /**
     *
     * @var string
     */
    public $object_name = 'SharedSecurityRules';

    /**
     *
     * @var string
     */
    public $table_name = 'sharedsecurityrules';

    /**
     *
     * @var bool
     */
    public $importable = false;

    /**
     *
     * @param boolean $init
     */
    public function __construct($init = true)
    {
        parent::__construct();
        if ($init) {
            $this->load_flow_beans();
        }
    }

    /**
     *
     * @param string $interface
     * @return boolean
     */
    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }

    /**
     *
     * @global array $beanList
     * @global array $app_list_strings
     */
    public function load_flow_beans()
    {
        global $beanList, $app_list_strings;

        $app_list_strings['sa_moduleList'] = $app_list_strings['moduleList'];

        if (!empty($app_list_strings['sa_moduleList'])) {
            $saModuleListKeys = array_keys($app_list_strings['sa_moduleList']);
            foreach ($saModuleListKeys as $mkey) {
                if (!isset($beanList[$mkey]) || str_begin($mkey, 'AOW_')) {
                    unset($app_list_strings['sa_moduleList'][$mkey]);
                }
            }
        }

        $app_list_strings['sa_moduleList'] = array_merge(array('' => ''), (array) $app_list_strings['sa_moduleList']);

        asort($app_list_strings['sa_moduleList']);
    }

    /**
     *
     * @param boolean $check_notify
     */
    public function save($check_notify = false)
    {
        if (empty($this->id)) {
            unset($_POST['aow_conditions_id']);
            unset($_POST['aow_actions_id']);
        }

        $returnId = parent::save($check_notify);
        
        $helper = new SharedSecurityRulesHelper($this->db);
        $post = $helper->quote($_POST);

        require_once('modules/SharedSecurityRulesConditions/SharedSecurityRulesConditions.php');
        $condition = new SharedSecurityRulesConditions();
        $condition->save_lines($post, $this, 'aor_conditions_');

        require_once('modules/SharedSecurityRulesActions/SharedSecurityRulesActions.php');
        $action = new SharedSecurityRulesActions();
        $action->save_lines($post, $this, 'shared_rules_actions_');
        
        return $returnId;
    }

    /**
     * @param SugarBean $module
     * @param string $view
     *
     * @return bool
     */
    public function checkRules(SugarBean &$module, $view)
    {
        global $current_user;
        
        $helper = new SharedSecurityRulesHelper($this->db);
        $checker = new SharedSecurityRulesChecker();

        LoggerManager::getLogger()->info('SharedSecurityRules: In checkRules for module: ' . $module->name . ' and view: ' . $view);

        $class = get_class($module);
        LoggerManager::getLogger()->info('SharedSecurityRules: Class is: ' . $class);

        $moduleBean = new $class();
        if (!empty($module->fetched_row) && !empty($module->fetched_row['id']) && !empty($module->fetched_row['assigned_user_id']) && !empty($module->fetched_row['created_by'])) {
            $moduleBean->populateFromRow($module->fetched_row);
        } elseif ($moduleBean->module_name != 'Documents') {
            $moduleBean->retrieve($module->id);
        } else {
            LoggerManager::getLogger()->warn('Checking rules does not applyed for ' . $class);
        }

        LoggerManager::getLogger()->info('SharedSecurityRules: Module bean ID: ' . $moduleBean->id);
        $result = null;
        if (empty($moduleBean->id) || $moduleBean->id == "[SELECT_ID_LIST]") {
            return $result;
        }
        $sql_query = "SELECT * FROM sharedsecurityrules WHERE sharedsecurityrules.status = 'Complete' AND sharedsecurityrules.flow_module = '{$module->module_name}' AND sharedsecurityrules.deleted = '0'";

        /* CREATING SQL QUERY VERSION */
        $query_results = $module->db->query($sql_query);
        while ($rule = $module->db->fetchByAssoc($query_results)) {
            $result = $checker->updateResultByRule($result, $action, $module, $current_user->id, $helper, $rule, $moduleBean, $view);
        }

        $converted_res = '';
        if (isset($result)) {
            if ($result == false) {
                $converted_res = 'false';
            } elseif ($result == true) {
                $converted_res = 'true';
            }
        }

        if (!isset($key)) {
            $key = null;
            LoggerManager::getLogger()->warn('Key is not set for Action parameter access level for shared security groups.');
        }

        if (!isset($action['parameters']['accesslevel'][$key])) {
            $action['parameters']['accesslevel'][$key] = null;
            LoggerManager::getLogger()->warn('Action parameter access level at key: ' . $key . ' is needed for shared security groups, but it is not set.');
        }

        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting CheckRules with result: ' . $converted_res . ' for view: ' . $view . ' and action: ' . $action['parameters']['accesslevel'][$key]);
        return $result;
    }

    /**
     *
     * @global array $current_user
     * @global Database $db
     * @param SugarBean $module
     * @return array
     */
    public static function buildRuleWhere(SugarBean $module)
    {
        global $current_user;
        $where = "";
        $addWhere = "";
        $resWhere = "";
        $parenthesis = null;
        $sql = "SELECT * FROM sharedsecurityrules WHERE sharedsecurityrules.status = 'Complete' AND sharedsecurityrules.flow_module = '{$module->module_dir}' AND sharedsecurityrules.deleted ='0'";
        $results = DBManagerFactory::getInstance()->query($sql);
        while (($rule = $module->db->fetchByAssoc($results)) != null) {
            $sql_query = "SELECT * FROM sharedsecurityrulesactions WHERE sharedsecurityrulesactions.sa_shared_security_rules_id = '{$rule['id']}' AND sharedsecurityrulesactions.deleted = '0'";
            $actions_results = $module->db->query($sql_query);
            $actionIsUser = false;
            while (($action = $module->db->fetchByAssoc($actions_results)) != null) {
                $unserialized = unserialize(base64_decode($action['parameters']));
                if ($unserialized != false) {
                    $action['parameters'] = $unserialized;
                }
                if (!isset($action['parameters']['email_target_type']) || !(is_array($action['parameters']['email_target_type']) || is_object($action['parameters']['email_target_type']))) {
                    LoggerManager::getLogger()->warn('Incorrect action parameter: email_target_type');
                } else {
                    if (!isset($action['parameters']['accesslevel']) || !(is_array($action['parameters']['accesslevel']) || is_object($action['parameters']['accesslevel']))) {
                        LoggerManager::getLogger()->warn('Incorrect action parameter: accesslevel');
                    } else {
                        foreach ($action['parameters']['accesslevel'] as $key => $accessLevel) {
                            if (!isset($action['parameters']['email_target_type'][$key])) {
                                LoggerManager::getLogger()->warn('action parameter email_target_type si not set at key: ' . $key);
                                $targetType = null;
                            } else {
                                $targetType = $action['parameters']['email_target_type'][$key];
                            }

                            if ($targetType == "Users" && $action['parameters']['email'][$key]['0'] == "role") {
                                $users_roles_query = "SELECT acl_roles_users.user_id FROM acl_roles_users WHERE acl_roles_users.role_id = '{$action['parameters']['email'][$key]['2']}' AND acl_roles_users.user_id = '{$current_user->id}' AND acl_roles_users.deleted = '0'";
                                $users_roles_results = $module->db->query($users_roles_query);
                                $user_id = $module->db->fetchRow($users_roles_results);
                                if ($user_id[0] == $current_user->id) {
                                    $actionIsUser = true;
                                }
                            } elseif ($targetType == "Users" && $action['parameters']['email'][$key]['0'] == "security_group") {
                                $actionParameterEmailKey1 = null;
                                if (!isset($action['parameters']['email'][$key]['1'])) {
                                    LoggerManager::getLogger()->warn('Shared Security Rules trying to build rule where but action parameters email [1] is not set at key: ' . $key);
                                } else {
                                    $actionParameterEmailKey1 = $action['parameters']['email'][$key]['1'];
                                }
                                
                                $sec_group_query = "SELECT securitygroups_users.user_id FROM securitygroups_users WHERE securitygroups_users.securitygroup_id = '{$actionParameterEmailKey1}' AND securitygroups_users.user_id = '{$current_user->id}' AND securitygroups_users.deleted = '0'";
                                $sec_group_results = $module->db->query($sec_group_query);
                                $secgroup = $module->db->fetchRow($sec_group_results);
                                if (!empty($action['parameters']['email'][$key]['2']) && $secgroup[0] == $current_user->id) {
                                    $users_roles_query = "SELECT acl_roles_users.user_id FROM acl_roles_users WHERE acl_roles_users.role_id = '{$action['parameters']['email'][$key]['2']}' AND acl_roles_users.user_id = '{$current_user->id}' AND acl_roles_users.deleted = '0'";
                                    $users_roles_results = $module->db->query($users_roles_query);
                                    $user_id = $module->db->fetchRow($users_roles_results);
                                    if ($user_id[0] == $current_user->id) {
                                        $actionIsUser = true;
                                    }
                                } else {
                                    if ($secgroup[0] == $current_user->id) {
                                        $actionIsUser = true;
                                    }
                                }
                            } elseif (($targetType == "Specify User" && $current_user->id == $action['parameters']['email'][$key]) ||
                                    ($targetType == "Users" && in_array("all", $action['parameters']['email'][$key]))) {
                                $actionIsUser = true;
                            }
                        }
                    }
                }
            }
            if ($actionIsUser == true) {
                $sql_query = "SELECT * FROM sharedsecurityrulesconditions WHERE sharedsecurityrulesconditions.sa_shared_sec_rules_id = '{$rule['id']}' AND sharedsecurityrulesconditions.deleted = '0' ORDER BY sharedsecurityrulesconditions.condition_order ASC ";
                $conditions_results = $module->db->query($sql_query);
                $related = false;
                if ($conditions_results->num_rows != 0) {
                    while ($condition = $module->db->fetchByAssoc($conditions_results)) {
                        if (unserialize(base64_decode($condition['module_path'])) != false) {
                            $condition['module_path'] = unserialize(base64_decode($condition['module_path']));
                        }

                        if ($condition['module_path'][0] != $rule['flow_module']) {
                            foreach ($condition['module_path'] as $rel) {
                                if (empty($rel)) {
                                    continue;
                                }
                                $module->load_relationship($rel);
                                $related = $module->$rel->getBeans();
                            }
                        }

                        if ($related == false) {
                            if ($condition['value_type'] == "Field" &&
                                    isset($module->{$condition['value']}) &&
                                    !empty($module->{$condition['value']})) {
                                $condition['value'] = $module->{$condition['value']};
                            }
                            $value = $condition['value'];
                            if ($accessLevel == 'none') {
                                $operatorValue = SharedSecurityRules::changeOperator($condition['operator'], $value, true);
                            } else {
                                $operatorValue = SharedSecurityRules::changeOperator($condition['operator'], $value, false);
                            }
                            if ($module->field_defs[$condition['field']]['source'] == "custom_fields") {
                                $table = $module->table_name . "_cstm";
                            } else {
                                $table = $module->table_name;
                            }
                            $conditionQuery = " " . $table . "." . $condition['field'] . " " . $operatorValue . " ";
                            if ($accessLevel == 'none') {
                                $where = $resWhere;
                            } else {
                                $where = $addWhere;
                            }
                            if ($condition['parenthesis'] == "START") {
                                if (is_null($parenthesis)) {
                                    $parenthesis = " ( ";
                                    if (empty($where)) {
                                        $where = $parenthesis;
                                    } else {
                                        $where .= $condition['logic_op'] . " " . $parenthesis;
                                    }
                                } else {
                                    if (empty($where)) {
                                        $where = $parenthesis;
                                    } else {
                                        $where .= $parenthesis;
                                    }
                                }
                            } elseif ($condition['parenthesis'] != "START" && !empty($condition['parenthesis'])) {
                                $parenthesis = " ) ";
                                if (empty($where)) {
                                    $where = $parenthesis;
                                } else {
                                    $where .= $parenthesis;
                                }
                                $parenthesis = null;
                            } else {
                                if (!empty($parenthesis) && $parenthesis == " ( ") {
                                    $where .= $conditionQuery;
                                    $parenthesis = null;
                                } elseif (empty($where)) {
                                    $where = $conditionQuery;
                                } elseif (!empty($condition['logic_op'])) {
                                    $where .= $condition['logic_op'] . " " . $conditionQuery;
                                } else {
                                    $where .= " OR " . $conditionQuery;
                                }
                            }
                            if ($accessLevel == 'none') {
                                $resWhere = $where;
                            } else {
                                $addWhere = $where;
                            }
                        }
                    }
                }
            }
        }
        $whereArray = array();
        $whereArray['resWhere'] = $resWhere;
        $whereArray['addWhere'] = $addWhere;
        return $whereArray;
    }

    /**
     *
     * @global Database $db
     * @param SugarBean $module
     * @param string $field
     * @param string $value
     * @return boolean
     */
    public function checkHistory(SugarBean $module, $field, $value)
    {
        $db = $this->db;
        if (!isset($module->field_defs[$field]['audited'])) {
            LoggerManager::getLogger()->warn("$field field in not exists in given module field_defs for checking shared security rules history");
            return false;
        }
        if ($module->field_defs[$field]['audited'] == true) {
            $value = $db->quote($value);
            $field = $db->quote($field);

            $sql = "SELECT * FROM {$module->table_name}_audit WHERE field_name = '{$field}' AND parent_id = '{$module->id}' AND (before_value_string = '{$value}'
                    OR after_value_string = '{$value}' )";
            $results = $db->getOne($sql);


            if ($results !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * @param string $operator
     * @param string $value
     * @param boolean $reverse
     * @return boolean|string
     */
    public function changeOperator($operator, $value, $reverse)
    {
        switch ($operator) {
            case "Equal_To":
                if ($reverse) {
                    return " != '" . $value . "' ";
                }
                return " = '" . $value . "' ";
            case "Not_Equal_To":
                if ($reverse) {
                    return " = '" . $value . "' ";
                }
                return " != '" . $value . "' ";
            case "Starts_With":
                if ($reverse) {
                    return " NOT LIKE '" . $value . "%'";
                }
                return " LIKE '" . $value . "%'";
            case "Ends_With":
                if ($reverse) {
                    return " NOT LIKE '%" . $value . "'";
                }
                return " LIKE '%" . $value . "'";
            case "Contains":
                if ($reverse) {
                    return " NOT LIKE '%" . $value . "%' ";
                }
                return " LIKE '%" . $value . "%'";
            case "is_null":
                if ($reverse) {
                    return " IS NOT NULL ";
                }
                return " IS NULL ";
        }

        return false;
    }

    /**
     *
     * @param array $fieldDefs
     * @param string $module
     * @return array
     */
    public function getFieldDefs($fieldDefs, $module)
    {
        if ($module == null) {
            return array();
        }
        $defs[''] = "";
        foreach ($fieldDefs as $field) {
            $label = translate($field['vname'], $module);
            if (in_array($field['type'], $this->exemptFields) || in_array($field['dbType'], $this->exemptFields)) {
                continue;
            }
            if (empty($label)) {
                $label = $field['name'];
            }
            if (($module == "Leads" || $module == "Contacts") && ($field['name'] == "full_name" || $field['name'] == "name")) {
                continue;
            }

            $defs[$field['name']] = $label;
        }

        asort($defs);
        return $defs;
    }
}
