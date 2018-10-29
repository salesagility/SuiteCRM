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

include_once __DIR__ . '/SharedSecurityRulesHelper.php';

class SharedSecurityRulesChecker
{
    
    /**
     *
     * @var DBManager
     */
    protected $db;
    
    /**
     *
     * @param DBManager $db
     */
    public function __construct(DBManager $db)
    {
        $this->db = $db;
    }
        
    /**
     *
     * @param bool|null $result
     * @param array $action
     * @param SugarBean $module
     * @param string $userId
     * @param SharedSecurityRulesHelper $helper
     * @param array $rule
     * @param SugarBean $moduleBean
     * @param string $view
     * @return bool|null
     */
    protected function updateResultByRule($result, &$action, SugarBean $module, $userId, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $view)
    {
        $sql_query = "SELECT * FROM sharedsecurityrulesactions WHERE sharedsecurityrulesactions.sa_shared_security_rules_id = '{$rule['id']}' AND sharedsecurityrulesactions.deleted = '0'";
        $actions_results = $module->db->query($sql_query);
        while ($action = $module->db->fetchByAssoc($actions_results)) {
            $action['parameters'] = $helper->unserializeIfSerialized($action['parameters']);
            if (!isset($action['parameters']['email_target_type']) || !(is_array($action['parameters']['email_target_type']) || !is_object($action['parameters']['email_target_type']))) {
                LoggerManager::getLogger()->warn('Incorrect action parameter: email_target_type');
            } else {
                $result = $this->updateResultByEmailTargetType($result, $action, $module, $userId, $helper, $rule, $moduleBean, $view);
            }
        }
        return $result;
    }
    
    /**
     *
     * @param bool|null $result
     * @param array $action
     * @param SugarBean $module
     * @param string $userId
     * @param SharedSecurityRulesHelper $helper
     * @param array $rule
     * @param SugarBean $moduleBean
     * @param string $view
     * @return bool|null
     */
    protected function updateResultByEmailTargetType($result, $action, SugarBean $module, $userId, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $view)
    {
        foreach ($action['parameters']['email_target_type'] as $key => $targetType) {
            if (!isset($action['parameters']['email'][$key]['0'])) {
                LoggerManager::getLogger()->warn('action parameter email is not set at key: ' . $key);
            } else {
                if ($targetType == "Users" && $action['parameters']['email'][$key]['0'] == "role") {
                    if (!isset($action['parameters']['email'][$key]['2'])) {
                        LoggerManager::getLogger()->warn('action parameter email [2] is not set at key: ' . $key);
                    } else {
                        $usertRoleResultsAssoc = $this->getUsertRuleResultsAssoc($module, $action['parameters']['email']
                                [$key]['2'], $userId);
                        if ($usertRoleResultsAssoc['user_id'] == $userId) {
                            $result = $this->updateResultByCondition($result, $helper, $rule, $moduleBean, $view,
                                    $action, $key);
                        }
                    }
                } elseif ($targetType == "Users" && $action['parameters']['email'][$key]['0'] == "security_group") {
                    $result = $this->getResultByUserActionKey($result, $helper, $rule, $moduleBean, $action, $key,
                            $userId, $module);
                } elseif (($targetType == "Specify User" && $userId == $action['parameters']['email'][$key]) ||
                                    ($targetType == "Users" && in_array("all", $action['parameters']['email'][$key]))) {
                    //we have found a possible record to check against.
                                $result = $this->updateResultByCondition($result, $helper, $rule, $moduleBean, $view,
                                        $action, $key);
                }
            }
        }
        return $result;
    }
    
    /**
     *
     * @param bool|null $result
     * @param SharedSecurityRulesHelper $helper
     * @param array $rule
     * @param SugarBean $moduleBean
     * @param array $action
     * @param string $key
     * @param string $userId
     * @param SugarBean $module
     * @return boolean|null
     */
    protected function getResultByUserActionKey($result, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $action, $key, $userId, SugarBean $module)
    {
        $actionParamEmail1 = null;
        if (!isset($action['parameters']['email'][$key]['1'])) {
            LoggerManager::getLogger()->warn('action parameter email [1] is not set at key: ' . $key);
        } else {
            $actionParamEmail1 = $action['parameters']['email'][$key]['1'];
        }

        $sec_group_query = "SELECT securitygroups_users.user_id FROM securitygroups_users WHERE securitygroups_users.securitygroup_id = '$actionParamEmail1' && securitygroups_users.user_id = '$userId' AND securitygroups_users.deleted = '0'";
        $sec_group_results = $module->db->query($sec_group_query);
        $secgroup = $module->db->fetchRow($sec_group_results);
        if (!empty($action['parameters']['email'][$key]['2']) && $secgroup[0] == $userId) {
            $userRoleResultsAssoc = $this->getUsertRuleResultsAssoc($module, $action['parameters']['email'][$key]['2'], $userId);
            if ($userRoleResultsAssoc['user_id'] == $userId) {
                $result = $this->updateResultByCondition($result, $helper, $rule, $moduleBean, $view, $action, $key);
            }
        } else {
            if ($secgroup[0] == $userId) {
                $result = $this->updateResultByCondition($result, $helper, $rule, $moduleBean, $view, $action, $key);
            }
        }
        return $result;
    }
    
    /**
     *
     * @param bool|null $result
     * @param SharedSecurityRulesHelper $helper
     * @param array $rule
     * @param SugarBean $moduleBean
     * @param string $view
     * @param array $action
     * @param string $key
     * @return boolean|null
     */
    protected function updateResultByCondition($result, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $view, $action, $key)
    {
        $conditionResult = $helper->checkConditions($rule, $moduleBean, $view, $action, $key);
        if ($conditionResult) {
            if (!isset($action['parameters']['accesslevel'][$key])) {
                LoggerManager::getLogger()->warn('Incorrect action parameter access level at key: ' . $key);
            } else {
                if (!$helper->findAccess($view, $action['parameters']['accesslevel'][$key])) {
                    $result = false;
                } else {
                    $result = true;
                }
            }
        }
        return $result;
    }
    
    /**
     *
     * @param SugarBean $module
     * @param string $actionParamEmail2
     * @param string $currentUserId
     * @return array
     */
    protected function getUsertRuleResultsAssoc(SugarBean $module, $actionParamEmail2, $currentUserId)
    {
        $actionParamEmail2Q = $module->db->quote($actionParamEmail2);
        $currentUserIdQuote = $module->db->quote($currentUserId);
        $users_roles_query = "SELECT acl_roles_users.user_id FROM acl_roles_users WHERE acl_roles_users.role_id = '$actionParamEmail2Q' AND acl_roles_users.user_id = '$currentUserIdQuote' AND acl_roles_users.deleted = '0'";
        $users_roles_results = $module->db->query($users_roles_query);
        $userRoleResultsAssoc = $module->db->fetchByAssoc($users_roles_results);
        return $userRoleResultsAssoc;
    }
    
    /**
     *
     * @param SugarBean $module
     * @return SugarBean
     */
    public function getModuleBean(SugarBean $module)
    {
        $class = get_class($module);
        LoggerManager::getLogger()->info('SharedSecurityRules: Class is: ' . $class);
        
        $moduleBean = new $class();
        if (!empty($module->fetched_row) && !empty($module->fetched_row['id']) &&
                !empty($module->fetched_row['assigned_user_id']) && !empty($module->fetched_row['created_by'])) {
            $moduleBean->populateFromRow($module->fetched_row);
        } elseif ($moduleBean->module_name != 'Documents') {
            $moduleBean->retrieve($module->id);
        } else {
            LoggerManager::getLogger()->warn('Checking rules does not applyed for ' . $class);
        }
        return $moduleBean;
    }
    
    /**
     *
     * @param SugarBean $module
     * @param SugarBean $moduleBean
     * @param string $userId
     * @param string $view
     * @return boolean|null
     */
    public function getResult(SugarBean $module, SugarBean $moduleBean, $userId, $view)
    {
        $helper = new SharedSecurityRulesHelper($this->db);
        
        LoggerManager::getLogger()->info('SharedSecurityRules: Module bean ID: ' . $moduleBean->id);
        $result = null;
        if (empty($moduleBean->id) || $moduleBean->id == "[SELECT_ID_LIST]") {
            return $result;
        }
        $sql_query = "SELECT * FROM sharedsecurityrules WHERE sharedsecurityrules.status = 'Complete' AND sharedsecurityrules.flow_module = '{$module->module_name}' AND sharedsecurityrules.deleted = '0'";

        /* CREATING SQL QUERY VERSION */
        $query_results = $module->db->query($sql_query);
        $action = null;
        $key = null;
        while ($rule = $module->db->fetchByAssoc($query_results)) {
            $result = $this->updateResultByRule($result, $action, $module, $userId, $helper, $rule, $moduleBean, $view);
        }

        $converted_res = $helper->getConvertedRes($result);

        if (is_null($key)) {
            LoggerManager::getLogger()->warn('Key is not set for Action parameter access level for shared security groups.');
        }

        if (!isset($action['parameters']['accesslevel'][$key])) {
            $action['parameters']['accesslevel'][$key] = null;
            LoggerManager::getLogger()->warn('Action parameter access level at key: ' . $key . ' is needed for shared security groups, but it is not set.');
        }

        LoggerManager::getLogger()->info('SharedSecurityRules: Exiting CheckRules with result: ' . $converted_res . ' for view: ' . $view . ' and action: ' . $action['parameters']['accesslevel'][$key]);
        
        return $result;
    }
}
