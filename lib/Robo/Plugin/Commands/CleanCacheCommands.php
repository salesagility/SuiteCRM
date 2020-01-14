<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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

namespace SuiteCRM\Robo\Plugin\Commands;

/**
 * Class CleanCacheCommands
 *
 * @category RoboTasks
 * @package  SuiteCRM\Robo\Plugin\Commands
 * @author   Jose C. Massón <jose@gcoop.coop>
 * @license  GNU GPLv3
 * @link     CleanCacheCommands
 */
class CleanCacheCommands extends \Robo\Tasks
{

    /**
     * Clean 'cache/' directory
     * @throws \RuntimeException
     */
    public function cleanCache()
    {
        $toDelete = [];
        $doNotDelete = ['Emails', 'emails', '.', '..'];
        $cacheToDelete = [
            'cache/Relationships',
            'cache/csv',
            'cache/dashlets',
            'cache/diagnostics',
            'cache/dynamic_fields',
            'cache/feeds',
            'cache/import',
            'cache/include/javascript',
            'cache/jsLanguage',
            'cache/pdf',
            'cache/themes',
            'cache/xml',
        ];

        foreach ($cacheToDelete as $dir) {
            if (file_exists($dir) && is_dir($dir)) {
                $toDelete[] = $dir;
            }
        }

        $cacheModules = 'cache/modules';

        foreach (scandir($cacheModules, SCANDIR_SORT_NONE) as $module) {
            if (file_exists($cacheModules . '/' . $module)
                && is_dir($cacheModules . '/' . $module)
                && !in_array($module, $doNotDelete, true)
            ) {
                $toDelete[] = $cacheModules . '/' . $module;
            }
        }
        $this->_cleanDir($toDelete);
    }
}
