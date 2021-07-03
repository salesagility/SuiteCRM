<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

/**
 * This Class handles/controls the User Access against the available ACL privileges to the user
 *
 * Class UserACLService
 * Port of ACLController.php
 */
class UserACLService
{

    /**
     * Check User ACL against the following parameters
     * @param string $routeModule
     * @param string $routeURL
     * @param string $routeAction
     * @return array with feedback
     */
    public function run(string $routeModule, string $routeURL, string $routeAction): array
    {
        if (empty($routeModule)) {
            return [
                'status' => false,
                'message' => 'LBL_MODULE_NOT_FOUND'
            ];
        }

        if (!$routeURL && !$this->handleAclRoles($routeModule, $routeAction)) {
            return [
                'status' => false,
                'message' => 'ERR_UNAUTHORIZED_PAGE_ACCESS_TO_HOME_PAGE'
            ];
        }

        if (!$this->handleAclRoles($routeModule, $routeAction)) {
            return [
                'status' => false,
                'message' => 'ERR_UNAUTHORIZED_PAGE_ACCESS'
            ];
        }

        return [
            'status' => true,
            'message' => ''
        ];
    }

    /**
     * Handle User Acl roles
     * @param string $beanName
     * @param string $routeAction
     * @return bool
     */
    protected function handleAclRoles(string $beanName, string $routeAction): bool
    {
        $routeAction = $routeAction ?: 'view';

        return ACLController::checkAccess($beanName, $routeAction, true, 'module', true);
    }
}
