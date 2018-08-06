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

class SharedSecurityRulesChecker
{
    public function updateResultByRule($result, &$action, SugarBean $module, $userId, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $view)
    {
        $sql_query = "SELECT * FROM sharedsecurityrulesactions WHERE sharedsecurityrulesactions.sa_shared_security_rules_id = '{$rule['id']}' AND sharedsecurityrulesactions.deleted = '0'";
        $actions_results = $module->db->query($sql_query);
        while ($action = $module->db->fetchByAssoc($actions_results)) {
            $unserialized = unserialize(base64_decode($action['parameters']));
            if ($unserialized != false) {
                $action['parameters'] = $unserialized;
            }
            if (!isset($action['parameters']['email_target_type']) || !(is_array($action['parameters']['email_target_type']) || !is_object($action['parameters']['email_target_type']))) {
                LoggerManager::getLogger()->warn('Incorrect action parameter: email_target_type');
            } else {
                $result = $this->updateResultByEmailTargetType($result, $action, $module, $userId, $helper, $rule, $moduleBean, $view);
            }
        }
        return $result;
    }
    
    public function getResultByTargetType($targetType, $action, $key, SugarBean $module, $userId, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $view)
    {
        if (!isset($action['parameters']['email'][$key]['0'])) {
            LoggerManager::getLogger()->warn('action parameter email is not set at key: ' . $key);
        } else {
            if ($targetType == "Users" && $action['parameters']['email'][$key]['0'] == "role") {
                if (!isset($action['parameters']['email'][$key]['2'])) {
                    LoggerManager::getLogger()->warn('action parameter email [2] is not set at key: ' . $key);
                } else {
                    $userRoleResultsAssoc = $this->getUsertRuleResultsAssoc($module, $action['parameters']['email']
                                [$key]['2'], $userId);
                    if ($userRoleResultsAssoc['user_id'] == $userId) {
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
    
    public function updateResultByEmailTargetType($result, $action, SugarBean $module, $userId, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $view)
    {
        foreach ($action['parameters']['email_target_type'] as $key => $targetType) {
            $result = $this->getResultByTargetType();
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
    public function getResultByUserActionKey($result, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $action, $key, $userId, SugarBean $module)
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
    public function updateResultByCondition($result, SharedSecurityRulesHelper $helper, $rule, SugarBean $moduleBean, $view, $action, $key)
    {
        $conditionResult = $helper->checkConditions($rule, $moduleBean, $view, $action, $key);

        $result = false;
        $error = false;
        if ($conditionResult) {
            if (!isset($action['parameters']['accesslevel'][$key])) {
                $error = true;
                LoggerManager::getLogger()->warn('Incorrect action parameter access level at key: ' . $key);
            }
            if (!$error) {
                $result = !$helper->findAccess($view, $action['parameters']['accesslevel'][$key]) ? false : true;
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
    public function getUsertRuleResultsAssoc(SugarBean $module, $actionParamEmail2, $currentUserId)
    {
        $actionParamEmail2Quote = $module->db->quote($actionParamEmail2);
        $currentUserIdQuote = $module->db->quote($currentUserId);
        $users_roles_query = "SELECT acl_roles_users.user_id FROM acl_roles_users WHERE acl_roles_users.role_id = '$actionParamEmail2Quote' AND acl_roles_users.user_id = '$currentUserIdQuote' AND acl_roles_users.deleted = '0'";
        $users_roles_results = $module->db->query($users_roles_query);
        $userRoleResultsAssoc = $module->db->fetchByAssoc($users_roles_results);
        return $userRoleResultsAssoc;
    }
}
