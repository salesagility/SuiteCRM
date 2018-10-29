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

class SharedSecurityRulesWhereBuilder
{
    /**
     *
     * @param array $action
     * @param string $key
     * @return mixed
     */
    protected function getTargetType($action, $key)
    {
        if (!isset($action['parameters']['email_target_type'][$key])) {
            LoggerManager::getLogger()->warn('action parameter email_target_type si not set at key: ' . $key);
            $targetType = null;
        } else {
            $targetType = $action['parameters']['email_target_type'][$key];
        }
        return $targetType;
    }
    
    /**
     *
     * @param string $where
     * @param string $parenthesis
     * @param string $logOp
     */
    protected function addParenthesisToWhere(&$where, $parenthesis, $logOp = null)
    {
        if (empty($where)) {
            $where = $parenthesis;
        } else {
            $where .= $parenthesis;
        }
        if (null !== $logOp) {
            $where = $logOp . $where;
        }
    }
    
    /**
     *
     * @param string $where
     * @param string $parenthesis
     * @param array $condition
     * @param string $conditionQuery
     */
    protected function updateWhereAndParenthesis(&$where, &$parenthesis, $condition, $conditionQuery)
    {
        if ($condition['parenthesis'] == "START") {
            if (is_null($parenthesis)) {
                $parenthesis = " ( ";
                $this->addParenthesisToWhere($where, $parenthesis, $condition['logic_op'] . ' ');
            } else {
                $this->addParenthesisToWhere($where, $parenthesis);
            }
        } elseif ($condition['parenthesis'] != "START" && !empty($condition['parenthesis'])) {
            $this->addParenthesisToWhere($where, ' ) ');
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
    }
    
    /**
     *
     * @param string $targetType
     * @param array $action
     * @param string $key
     * @param string $userId
     * @param SugarBean $module
     * @return string
     */
    protected function getUidByTargetType($targetType, $action, $key, $userId, SugarBean $module)
    {
        if ($targetType == "Users" && $action['parameters']['email'][$key]['0'] == "role") {
            $users_roles_query = "SELECT acl_roles_users.user_id FROM acl_roles_users WHERE acl_roles_users.role_id = '{$action['parameters']['email'][$key]['2']}' AND acl_roles_users.user_id = '{$userId}' AND acl_roles_users.deleted = '0'";
            $users_roles_results = $module->db->query($users_roles_query);
            $user_id = $module->db->fetchRow($users_roles_results);
            $uid = $user_id[0];
        } elseif ($targetType == "Users" && $action['parameters']['email'][$key]['0'] == "security_group") {
            $actionParamEmail1 = null;
            if (!isset($action['parameters']['email'][$key]['1'])) {
                LoggerManager::getLogger()->warn('Shared Security Rules trying to build rule where but action parameters email [1] is not set at key: ' . $key);
            } else {
                $actionParamEmail1 = $action['parameters']['email'][$key]['1'];
            }
                                
            $sec_group_query = "SELECT securitygroups_users.user_id FROM securitygroups_users WHERE securitygroups_users.securitygroup_id = '{$actionParamEmail1}' AND securitygroups_users.user_id = '{$userId}' AND securitygroups_users.deleted = '0'";
            $sec_group_results = $module->db->query($sec_group_query);
            $secgroup = $module->db->fetchRow($sec_group_results);
            if (!empty($action['parameters']['email'][$key]['2']) && $secgroup[0] == $userId) {
                $users_roles_query = "SELECT acl_roles_users.user_id FROM acl_roles_users WHERE acl_roles_users.role_id = '{$action['parameters']['email'][$key]['2']}' AND acl_roles_users.user_id = '{$userId}' AND acl_roles_users.deleted = '0'";
                $users_roles_results = $module->db->query($users_roles_query);
                $user_id = $module->db->fetchRow($users_roles_results);
                $uid = $user_id[0];
            } else {
                $uid = $secgroup[0];
            }
        } elseif (($targetType == "Specify User" && $userId == $action['parameters']['email'][$key]) ||
                                    ($targetType == "Users" && in_array("all", $action['parameters']['email'][$key]))) {
            $uid = $userId;
        } else {
            $uid = null;
            LoggerManager::getLogger()->warn('Unable to determinate UID by target type.');
        }
        return $uid;
    }
    
    /**
     *
     * @param array $action
     * @param string $userId
     * @param SugarBean $module
     * @param string $accessLevel
     * @return boolean
     */
    protected function checkTargetLevelUid($action, $userId, SugarBean $module, &$accessLevel)
    {
        foreach ($action['parameters']['accesslevel'] as $key => $accessLevel) {
            $targetType = $this->getTargetType($action, $key);
                            
            $uid = $this->getUidByTargetType($targetType, $action, $key, $userId, $module);
                            
            if ($uid == $userId) {
                return true;
            }
        }
        return false;
    }
    
    /**
     *
     * @param array $action
     * @param string $userId
     * @param SugarBean $module
     * @param string $accessLevel
     * @return boolean
     */
    protected function checkIfActionIsUser($action, $userId, SugarBean $module, &$accessLevel)
    {
        if (!isset($action['parameters']['email_target_type']) || !(is_array($action['parameters']['email_target_type']) || is_object($action['parameters']['email_target_type']))) {
            LoggerManager::getLogger()->warn('Incorrect action parameter: email_target_type');
        } else {
            if (!isset($action['parameters']['accesslevel']) || !(is_array($action['parameters']['accesslevel']) || is_object($action['parameters']['accesslevel']))) {
                LoggerManager::getLogger()->warn('Incorrect action parameter: accesslevel');
            } else {
                if ($this->checkTargetLevelUid($action, $userId, $module, $accessLevel)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     *
     * @param string $accessLevel
     * @param string $where
     * @param string $resWhere
     * @param string $addWhere
     */
    protected function updateWhereResults($accessLevel, $where, &$resWhere, &$addWhere)
    {
        if ($accessLevel == 'none') {
            $resWhere = $where;
        } else {
            $addWhere = $where;
        }
    }

    /**
     *
     * @param SugarBean $module
     * @param resource $actions_results
     * @param string $userId
     * @param string $accessLevel
     * @param boolean $actionIsUser
     */
    protected function updateActionAccess(SugarBean $module, &$actions_results, $userId, &$accessLevel, &$actionIsUser)
    {
        $helper = new SharedSecurityRulesHelper($module->db);
        while (($action = $module->db->fetchByAssoc($actions_results)) != null) {
            if (!isset($action['parameters'])) {
                LoggerManager::getLogger()->warn('Parameters is not set for updating action access.');
            } else {                
                $action['parameters'] = $helper->unserializeIfSerialized($action['parameters']);
            }
            if ($this->checkIfActionIsUser($action, $userId, $module, $accessLevel)) {
                $actionIsUser = true;
                break;
            }
        }
    }

    /**
     *
     * @param bool $related
     * @param array $condition
     * @param array $rule
     * @param SugarBean $module
     */
    protected function updateRelated(&$related, $condition, $rule, SugarBean $module)
    {
        if ($condition['module_path'][0] != $rule['flow_module']) {
            foreach ($condition['module_path'] as $rel) {
                if (empty($rel)) {
                    continue;
                }
                $module->load_relationship($rel);
                $related = $module->$rel->getBeans();
            }
        }
    }
    
    /**
     *
     * @param array $condition
     * @param SugarBean $module
     */
    protected function updateCondValue(&$condition, SugarBean $module)
    {
        if ($condition['value_type'] == "Field" &&
                                    isset($module->{$condition['value']}) &&
                                    !empty($module->{$condition['value']})) {
            $condition['value'] = $module->{$condition['value']};
        }
    }
    
    /**
     *
     * @param resource $conditions_results
     * @param SugarBean $module
     * @param bool $related
     * @param array $rule
     * @param string $accessLevel
     * @param string $resWhere
     * @param string $addWhere
     * @param string $parenthesis
     */
    protected function processConditions($conditions_results, SugarBean $module, &$related, $rule, $accessLevel, $resWhere, $addWhere, $parenthesis)
    {
        $helper = new SharedSecurityRulesHelper($module->db);
        if ($conditions_results->num_rows != 0) {
            while ($condition = $module->db->fetchByAssoc($conditions_results)) {
                $condition['module_path'] = $helper->unserializeIfSerialized($condition['module_path']);

                $this->updateRelated($related, $condition, $rule, $module);

                if ($related == false) {
                    $this->updateCondValue($condition, $module);
                    $value = $condition['value'];
                    $operatorValue = SharedSecurityRules::changeOperator($condition['operator'], $value, $accessLevel == 'none');
                    $table = $module->table_name . ($module->field_defs[$condition['field']]['source'] == "custom_fields" ? '_cstm' : '');
                    $conditionQuery = " " . $table . "." . $condition['field'] . " " . $operatorValue . " ";
                    $where = $accessLevel == 'none' ? $resWhere : $addWhere;
                    $this->updateWhereAndParenthesis($where, $parenthesis, $condition, $conditionQuery);
                    $this->updateWhereResults($accessLevel, $where, $resWhere, $addWhere);
                }
            }
        }
    }
    
    /**
     *
     * @param SugarBean $module
     * @param string $userId
     * @return string
     */
    public function getWhereArray(SugarBean $module, $userId)
    {
        $where = "";
        $addWhere = "";
        $resWhere = "";
        $parenthesis = null;
        $accessLevel = null;
        $sql = "SELECT * FROM sharedsecurityrules WHERE sharedsecurityrules.status = 'Complete' AND sharedsecurityrules.flow_module = '{$module->module_dir}' AND sharedsecurityrules.deleted ='0'";
        $results = DBManagerFactory::getInstance()->query($sql);
        while (($rule = $module->db->fetchByAssoc($results)) != null) {
            $sql_query = "SELECT * FROM sharedsecurityrulesactions WHERE sharedsecurityrulesactions.sa_shared_security_rules_id = '{$rule['id']}' AND sharedsecurityrulesactions.deleted = '0'";
            $actions_results = $module->db->query($sql_query);
            $actionIsUser = false;
            $this->updateActionAccess($module, $actions_results, $userId, $accessLevel, $actionIsUser);
            if ($actionIsUser == true) {
                $sql_query = "SELECT * FROM sharedsecurityrulesconditions WHERE sharedsecurityrulesconditions.sa_shared_sec_rules_id = '{$rule['id']}' AND sharedsecurityrulesconditions.deleted = '0' ORDER BY sharedsecurityrulesconditions.condition_order ASC ";
                $conditions_results = $module->db->query($sql_query);
                $related = false;
                $this->processConditions($conditions_results, $module, $related, $rule, $accessLevel, $resWhere, $addWhere, $parenthesis);
            }
        }
        $whereArray = array();
        $whereArray['resWhere'] = $resWhere;
        $whereArray['addWhere'] = $addWhere;
        return $whereArray;
    }
}
