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
     * @param string $actionParametersEmailKey2
     * @param string $currentUserId
     * @return array
     */
    public function getUsertRuleResultsAssoc(SugarBean $module, $actionParametersEmailKey2, $currentUserId)
    {
        $actionParametersEmailKey2Quote = $module->db->quote($actionParametersEmailKey2);
        $currentUserIdQuote = $module->db->quote($currentUserId);
        $users_roles_query = "SELECT acl_roles_users.user_id FROM acl_roles_users WHERE acl_roles_users.role_id = '$actionParametersEmailKey2Quote' AND acl_roles_users.user_id = '$currentUserIdQuote' AND acl_roles_users.deleted = '0'";
        $users_roles_results = $module->db->query($users_roles_query);
        $usertRoleResultsAssoc = $module->db->fetchByAssoc($users_roles_results);
        return $usertRoleResultsAssoc;
    }
}
