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

namespace SuiteCRM\Robo\Plugin\Commands;

use SuiteCRM\Utility\OperatingSystem;
use SuiteCRM\Robo\Traits\RoboTrait;
use Robo\Task\Base\loadTasks;

class RepairCommands extends \Robo\Tasks
{
    use loadTasks;
    use RoboTrait;

    /**
     * Repair database - Synchronize database with vardefs
     * @param array $opts optional command line arguments
     * execute - Set if you want that the command executes the SQL or not.
     * @throws \RuntimeException
     */
    public function repairDatabase(array $opts = ['execute' => 'yes'])
    {
        global  $beanFiles;
        $this->say('Repairing database...');
        $db = \DBManagerFactory::getInstance();
        $queries = [];
        \VardefManager::clearVardef();

        $execute = false;
        if ($opts['execute'] === 'yes') {
            $execute = true;
        }

        foreach ($beanFiles as $bean_name => $file) {
            require_once $file;

            if (! file_exists($file)) {
                continue;
            }

            $GLOBALS['reload_vardefs'] = true;
            $focus = new $bean_name();

            if (isset($focus->disable_vardefs) && $focus->disable_vardefs == false) {
                if (isset($focus->module_dir)) {
                    include 'modules/'.$focus->module_dir.'/vardefs.php';
                    $sql = $db->repairTable($focus, $execute);

                    if (!empty($sql)) {
                        $queries[] = $sql;
                    }
                }
            }
        }

        if (!$execute) {
            $this->say("You need to execute the following queries in order to get database synchronized with vardefs");
            foreach ($queries as $query) {
                print_r($query);
            }
        } else {
            $total = count($queries);
            $this->say("Database synchronized with vardefs!");
            $this->say("Executed queries: {$total}");
        }
    }



    /**
     * Rebuild Extensions - This Robo task executes rebuildExtensions()
     * @throws \RuntimeException
     */
    public function repairRebuildExtensions(array $opts = ['show-output' => 'no'])
    {
        $this->say("Rebuilding Extensions...");
        require_once 'modules/Administration/QuickRepairAndRebuild.php';
        global $current_user;
        $current_user->is_admin = '1';

        $show_output = false;
        if ($opts['show-output'] === 'yes') {
            $show_output = true;
        }

        $tool = new \RepairAndClear();
        $tool->show_output = $show_output;
        $tool->rebuildExtensions();
        $this->say("Extensions rebuilded!");
    }
}
