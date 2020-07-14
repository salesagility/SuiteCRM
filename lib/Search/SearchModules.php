<?php
/**
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

namespace SuiteCRM\Search;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once __DIR__ . '/../../modules/Home/UnifiedSearchAdvanced.php';

/**
 * Class SearchModules fetches the search modules.
 *
 * This class currently depends on the Unified Advanced Search to find the modules.
 */
class SearchModules
{
    /**
     * Returns the list of modules from the search defs.
     *
     * Each entry is defined as key (module name) => value (module translation).
     *
     * @return string[]
     */
    public static function getModulesList()
    {
        $allModules = self::getAllModules();
        $allModules = array_merge($allModules['enabled'], $allModules['disabled']);

        $modules = [];

        foreach ($allModules as $module) {
            $modules[$module['module']] = $module['label'];
        }

        return $modules;
    }

    /**
     * Returns an array with all the enabled modules names.
     *
     * @return string[]
     */
    public static function getEnabledModules()
    {
        $allModules = self::getAllModules();
        $enabledModules = $allModules['enabled'];

        $modules = [];

        foreach ($enabledModules as $module) {
            $modules[] = $module['module'];
        }

        return $modules;
    }

    /**
     * @return array
     */
    private static function getAllModules()
    {
        $unifiedSearch = new \UnifiedSearchAdvanced();
        $allModules = $unifiedSearch->retrieveEnabledAndDisabledModules();
        return $allModules;
    }
}
