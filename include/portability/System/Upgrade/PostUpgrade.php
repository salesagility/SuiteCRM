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

namespace SuiteCRM\portability\System\Upgrade;

use Administration;
use BeanFactory;
use DBManager;
use DBManagerFactory;
use LoggerManager;
use RepairAndClear;
use SugarBean;
use Throwable;
use TrackerManager;
use UpgradeHistory;

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

class PostUpgrade
{
    /**
     * @var string[]
     */
    protected $debug = [];

    /**
     * Run post upgrade steps
     * @return array
     */
    public function run(): array
    {
        $this->debug = [];

        ini_set('memory_limit', -1);
        set_time_limit(0);

        global $sugar_config;
        global $ACLActions, $beanList, $beanFiles;
        global $dictionary;
        global $cwd;
        $GLOBALS['log'] = LoggerManager::getLogger();
        $cwd = getcwd(); // default to current, assumed to be in a valid SuiteCRM root dir.

        require_once __DIR__ . '/../../../../modules/UpgradeWizard/uw_utils.php';
        require_once __DIR__ . '/../../../../include/utils/php_zip_utils.php';
        require_once __DIR__ . '/../../../../include/utils/sugar_file_utils.php';
        require_once __DIR__ . '/../../../../include/SugarObjects/SugarConfig.php';
        include __DIR__ . '/../../../../modules/ACLActions/actiondefs.php';
        include __DIR__ . '/../../../../include/modules.php';

        require __DIR__ . '/../../../../sugar_version.php';
        require __DIR__ . '/../../../../config.php';

        try {
            ob_start();

            $_SESSION['schema_change'] = 'sugar'; // we force-run all SQL
            $_SESSION['silent_upgrade'] = true;
            $_SESSION['step'] = 'silent'; // flag to NOT try redirect to 4.5.x upgrade wizard
            $_REQUEST['silent'] = true;

            $_REQUEST = [];
            $_REQUEST['addTaskReminder'] = 'remind';

            $this->checkConfigForPermissions();
            $this->checkLoggerSettings();
            $this->checkLeadConversionSettings();
            $this->checkResourceSettings();

            if (!write_array_to_file('sugar_config', $sugar_config, 'config.php')) {
                $this->log('*** ERROR: could not write config.php! - upgrade will fail!');
                $errors[] = 'Could not write config.php!';
            }

            //TODO call viewdefs merge
            //$this->registerUpgrade($errors, $path, $install_file, $zip_from_dir, $manifest, $suitecrm_version, $db);

            $this->cleanModulesCache();
            $this->cleanThemeCache();

            //ob_start();
            //@$this->createMissingRels();
            //ob_end_clean();

            $this->deleteCache();

            //$this->addReminders($errors, $skippedFiles, $path);

            $this->setAdminWizardSetting();

            $errors = [];

            $this->injectLanguageStrings();

            $this->loadAdminUser();

            $this->pauseTrackers();

            $this->upgradeRelationships();

            $this->upgradeUserPreferences();

            $this->clearThemeCache();

            $this->minifyJS();

            $this->deleteCache();

            $this->repairDatabase($beanFiles);

            $this->rebuildRelationships();

            $this->mergeConfigSettings('');

            $this->upgradeConnectors();

            $this->rebuildSprites();

            //Don't think this runs
            //$this->upgradeHistoryTable($sugar_version);

            $this->clearLanguageCache();
            $this->rebuildHTAccess();

            $phpErrors = ob_get_clean();
            $this->log("Potential PHP generated error messages: {$phpErrors}");
        } catch (Throwable $t) {
            $response = [
                'success' => false,
                'messages' => [
                    'Unexpected error running Legacy Post Upgrade'
                ],
                'debug' => $this->debug
            ];

            $this->debug = [];

            return $response;
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->log("Upgrade ERROR: {$error}");
            }

            $response = [
                'success' => false,
                'messages' => [
                    'Post Upgrade process complete with errors. Please check the upgrade log'
                ],
                'debug' => $this->debug
            ];

            $this->debug = [];

            return $response;
        }

        $this->log("Upgrade completed successfully.");

        $response = [
            'success' => true,
            'messages' => [
                'Post Upgrade process complete'
            ],
            'debug' => $this->debug
        ];

        $this->debug = [];

        return $response;
    }

    /**
     * Check permissions
     */
    protected function checkConfigForPermissions(): void
    {
        $this->log('begin check default permissions .');
        global $sugar_config;
        if (!isset($sugar_config['default_permissions'])) {
            $sugar_config['default_permissions'] = [
                'dir_mode' => 02770,
                'file_mode' => 0660,
                'user' => '',
                'group' => '',
            ];
            ksort($sugar_config);
            if (is_writable('config.php')) {
                write_array_to_file("sugar_config", $sugar_config, 'config.php');
            }
        }
        $this->log('end check default permissions .');
    }

    /**
     * @param string $message
     */
    protected function log(string $message): void
    {
        logThis($message, __DIR__ . '/../../../../../../logs/upgrade.log');
        $this->debug[] = $message;
    }

    /**
     * Check logger settings
     */
    protected function checkLoggerSettings(): void
    {
        $this->log('begin check logger settings .');

        global $sugar_config;

        if (!isset($sugar_config['logger'])) {
            $sugar_config['logger'] = [
                'level' => 'fatal',
                'file' => [
                    'ext' => '.log',
                    'name' => 'suitecrm',
                    'dateFormat' => '%c',
                    'maxSize' => '10MB',
                    'maxLogs' => 10,
                    'suffix' => '', // bug51583, change default suffix to blank for backwards comptability
                ],
            ];

            ksort($sugar_config);

            if (is_writable('config.php')) {
                write_array_to_file("sugar_config", $sugar_config, 'config.php');
            }
        }
        $this->log('begin check logger settings .');
    }

    /**
     * Check lead conversion settings
     */
    protected function checkLeadConversionSettings(): void
    {
        $this->log('begin check lead conversion settings .');
        global $sugar_config;

        if (!isset($sugar_config['lead_conv_activity_opt'])) {
            $sugar_config['lead_conv_activity_opt'] = 'copy';
            ksort($sugar_config);

            if (is_writable('config.php')) {
                write_array_to_file('sugar_config', $sugar_config, 'config.php');
            }
        }

        $this->log('end check lead conversion settings .');
    }

    /**
     * Check resource settings
     */
    protected function checkResourceSettings(): void
    {
        $this->log('begin check resource settings .');
        global $sugar_config;

        if (!isset($sugar_config['resource_management'])) {
            $sugar_config['resource_management'] = [
                'special_query_limit' => 50000,
                'special_query_modules' =>
                    [
                        0 => 'AOR_Reports',
                        1 => 'Export',
                        2 => 'Import',
                        3 => 'Administration',
                        4 => 'Sync',
                    ],
                'default_limit' => 1000,
            ];

            ksort($sugar_config);

            if (is_writable('config.php')) {
                write_array_to_file('sugar_config', $sugar_config, 'config.php');
            }
        }

        $this->log('begin check resource settings .');
    }

    /**
     * Clean modules cache
     */
    protected function cleanModulesCache(): void
    {
        //Clean modules from cache
        $cachedir = sugar_cached('smarty');
        if (is_dir($cachedir)) {
            $allModFiles = array();
            $allModFiles = findAllFiles($cachedir, $allModFiles);

            foreach ($allModFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        //Clean modules from cache
        $cachedir = sugar_cached('modules');
        if (is_dir($cachedir)) {
            $allModFiles = [];
            $allModFiles = findAllFiles($cachedir, $allModFiles);
            foreach ($allModFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Clean theme cache
     */
    protected function cleanThemeCache(): void
    {
        $cachedir = sugar_cached('themes');
        if (is_dir($cachedir)) {
            $allModFiles = [];
            $allModFiles = findAllFiles($cachedir, $allModFiles);
            foreach ($allModFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Delete cache
     */
    protected function deleteCache(): void
    {
        //Add the cache cleaning here.
        if (function_exists('deleteCache')) {
            $this->log('Call deleteCache');
            @deleteCache();
        }
    }

    protected function setAdminWizardSetting(): void
    {
        require_once __DIR__ . '/../../../../modules/Administration/Administration.php';

        /** @var Administration $admin */
        $admin = BeanFactory::newBean('Administration');
        $admin->saveSetting('system', 'adminwizard', 1);
    }

    /**
     * Inject language strings
     */
    protected function injectLanguageStrings(): void
    {
        global $mod_strings, $app_list_strings;
        $UWstrings = return_module_language('en_us', 'UpgradeWizard', true);
        $adminStrings = return_module_language('en_us', 'Administration', true);
        $app_list_strings = return_app_list_strings_language('en_us');
        $mod_strings = array_merge($mod_strings, $adminStrings, $UWstrings);
    }

    /**
     * Load admin user
     */
    protected function loadAdminUser(): void
    {
        global $current_user;

        $current_user->retrieve(1);
    }

    /**
     * Pause trackers
     */
    protected function pauseTrackers(): void
    {
        require_once __DIR__ . '/../../../../modules/Trackers/TrackerManager.php';
        $trackerManager = TrackerManager::getInstance();
        $trackerManager->pause();
        $trackerManager->unsetMonitors();
    }

    /**
     * Upgrade relationships
     */
    protected function upgradeRelationships(): void
    {
        require_once __DIR__ . '/../../../../modules/Administration/upgrade_custom_relationships.php';
        upgrade_custom_relationships();
    }

    /**
     * Upgrade User preferences
     */
    protected function upgradeUserPreferences(): void
    {
        $this->log('Upgrading user preferences start .');
        if (function_exists('upgradeUserPreferences')) {
            upgradeUserPreferences();
        }
        $this->log('Upgrading user preferences finish .');
    }

    /**
     * Clean theme chache
     */
    protected function clearThemeCache(): void
    {
        // clear out the theme cache
        if (is_dir($GLOBALS['sugar_config']['cache_dir'] . 'themes')) {
            $allModFiles = [];
            $allModFiles = findAllFiles($GLOBALS['sugar_config']['cache_dir'] . 'themes', $allModFiles);
            foreach ($allModFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Minify js
     */
    protected function minifyJS(): void
    {
        // re-minify the JS source files
        $_REQUEST['root_directory'] = getcwd();
        $_REQUEST['js_rebuild_concat'] = 'rebuild';
        require_once __DIR__ . '/../../../../jssource/minify.php';
    }

    /**
     * Repair database
     * @param array $beanFiles
     */
    protected function repairDatabase(array $beanFiles): void
    {
        //First repair the databse to ensure it is up to date with the new vardefs/tabledefs
        $this->log('About to repair the database.');

        //Use Repair and rebuild to update the database.
        global $dictionary;

        require_once __DIR__ . '/../../../../modules/Administration/QuickRepairAndRebuild.php';
        $rac = new RepairAndClear();
        $rac->clearVardefs();
        $rac->rebuildExtensions();
        //bug: 44431 - defensive check to ensure the method exists since upgrades to 6.2.0 may not have this method define yet.
        if (method_exists($rac, 'clearExternalAPICache')) {
            $rac->clearExternalAPICache();
        }

        $repairedTables = [];
        foreach ($beanFiles as $bean => $file) {
            if (file_exists($file)) {
                unset($GLOBALS['dictionary'][$bean]);
                require_once $file;
                $focus = new $bean();
                if (empty($focus->table_name) || isset($repairedTables[$focus->table_name])) {
                    continue;
                }

                if ($focus instanceof SugarBean) {
                    if (!isset($repairedTables[$focus->table_name])) {
                        $sql = DBManagerFactory::getInstance()->repairTable($focus, true);
                        if (trim($sql) !== '') {
                            $this->log('Running sql:' . $sql);
                        }
                        $repairedTables[$focus->table_name] = true;
                    }

                    //Check to see if we need to create the audit table
                    if ($focus->is_AuditEnabled() && !$focus->db->tableExists($focus->get_audit_table_name())) {
                        $this->log('Creating audit table:' . $focus->get_audit_table_name());
                        $focus->create_audit_table();
                    }
                }
            }
        }

        $dictionary = [];
        include __DIR__ . '/../../../../modules/TableDictionary.php';
        foreach ($dictionary as $meta) {
            $tablename = $meta['table'];

            if (isset($repairedTables[$tablename])) {
                continue;
            }

            $fielddefs = $meta['fields'];
            $indices = $meta['indices'];
            $sql = DBManagerFactory::getInstance()->repairTableParams($tablename, $fielddefs, $indices, true);
            if (!empty($sql)) {
                $this->log($sql);
                $repairedTables[$tablename] = true;
            }
        }

        $this->log('database repaired');
    }

    /**
     * Rebuild relationships
     */
    protected function rebuildRelationships(): void
    {
        $this->log('Start rebuild relationships.');

        $_REQUEST['silent'] = true;
        include __DIR__ . '/../../../../modules/Administration/RebuildRelationship.php';
        $_REQUEST['upgradeWizard'] = true;
        include __DIR__ . '/../../../../modules/ACL/install_actions.php';

        $this->log('End rebuild relationships.');
    }

    /**
     * Merge config si settings
     * @param string $path
     */
    protected function mergeConfigSettings(string $path): void
    {
        //bug: 37214 - merge config_si.php settings if available
        $this->log('Begin merge_config_si_settings');
        merge_config_si_settings(true, '', '', $path);
        $this->log('End merge_config_si_settings');
    }

    /**
     * Upgrade Connectors
     */
    protected function upgradeConnectors(): void
    {
        $this->log('Begin upgrade_connectors');
        upgrade_connectors();
        $this->log('End upgrade_connectors');
    }

    /**
     * Rebuild Sprites
     */
    protected function rebuildSprites(): void
    {
        if (function_exists('rebuildSprites') && function_exists('imagecreatetruecolor')) {
            rebuildSprites(true);
        }
    }

    /**
     * Clean Language cache
     */
    protected function clearLanguageCache(): void
    {
        // Clear language cache
        $repair = new RepairAndClear();
        $repair->clearJsLangFiles();
        $repair->clearLanguageCache();
    }

    /**
     * Rebuild htaccess
     */
    protected function rebuildHTAccess(): void
    {
        require_once __DIR__ . '/../../../../install/install_utils.php';
        handleHtaccess();
    }

    /**
     * Register upgrade in the db
     * @param $install_file
     * @param $zip_from_dir
     * @param $manifest
     * @param $suitecrm_version
     */
    protected function registerUpgrade(
        $install_file,
        $zip_from_dir,
        $manifest,
        $suitecrm_version
    ): void {
        $db = DBManagerFactory::getInstance();

        $this->log('Registering upgrade with UpgradeHistory');

        if (!didThisStepRunBefore('commit', 'upgradeHistory')) {
            set_upgrade_progress('commit', 'in_progress', 'upgradeHistory', 'in_progress');
            $file_action = 'copied';
            // if error was encountered, script should have died before now
            $new_upgrade = new UpgradeHistory();
            $new_upgrade->filename = $install_file;
            $new_upgrade->md5sum = md5_file($install_file);
            $new_upgrade->name = $zip_from_dir;
            $new_upgrade->description = $manifest['description'];
            $new_upgrade->type = 'patch';
            $new_upgrade->version = $suitecrm_version;
            $new_upgrade->status = 'installed';
            $new_upgrade->manifest = (!empty($_SESSION['install_manifest']) ? $_SESSION['install_manifest'] : '');

            if ($new_upgrade->description === null) {
                $new_upgrade->description = 'Silent Upgrade was used to upgrade the instance';
            } else {
                $new_upgrade->description .= ' Silent Upgrade was used to upgrade the instance.';
            }

            // Running db insert query as bean save will throw logic hook errors due to dependencies that are not set yet
            $customID = create_guid();
            $new_upgrade->date_entered = $GLOBALS['timedate']->nowDb();

            $customIDQuoted = $db->quoted($customID);
            $fileNameQuoted = $db->quoted($new_upgrade->filename);
            $md5Quoted = $db->quoted($new_upgrade->md5sum);
            $typeQuoted = $db->quoted($new_upgrade->type);
            $statusQuoted = $db->quoted($new_upgrade->status);
            $versionQuoted = $db->quoted($new_upgrade->version);
            $nameQuoted = $db->quoted($new_upgrade->name);
            $descriptionQuoted = $db->quoted($new_upgrade->description);
            $manifestQuoted = $db->quoted($new_upgrade->manifest);
            $dateQuoted = $db->quoted($new_upgrade->date_entered);

            $upgradeHistoryInsert = "INSERT INTO upgrade_history (id, filename, md5sum, type, status, version, name, description, id_name, manifest, date_entered, enabled)
                                                     VALUES ($customIDQuoted, $fileNameQuoted, $md5Quoted, $typeQuoted, $statusQuoted, $versionQuoted, $nameQuoted, $descriptionQuoted, NULL, $manifestQuoted, $dateQuoted, '1')";
            $result = $db->query($upgradeHistoryInsert, true, "Error writing upgrade history");

            set_upgrade_progress('commit', 'in_progress', 'upgradeHistory', 'done');
            set_upgrade_progress('commit', 'done', 'commit', 'done');
        }
    }

    /**
     * Upgrade history table
     * @param bool|null $sugar_version
     */
    protected function upgradeHistoryTable(?bool $sugar_version): void
    {
        //Run repairUpgradeHistoryTable
        if (version_compare($sugar_version, '6.5.0', '<') && function_exists('repairUpgradeHistoryTable')) {
            repairUpgradeHistoryTable();
        }
    }

    /**
     * Create missing relationships
     */
    protected function createMissingRels()
    {
        $relForObjects = ['leads' => 'Leads', 'campaigns' => 'Campaigns', 'prospects' => 'Prospects'];

        foreach ($relForObjects as $relObjName => $relModName) {
            //assigned_user
            $guid = create_guid();
            $query = "SELECT id FROM relationships WHERE relationship_name = '{$relObjName}_assigned_user'";
            $result = DBManagerFactory::getInstance()->query($query, true);
            $a = null;
            $a = DBManagerFactory::getInstance()->fetchByAssoc($result);
            if (!isset($a['id']) && empty($a['id'])) {
                $qRel = "INSERT INTO relationships (id,relationship_name, lhs_module, lhs_table, lhs_key, rhs_module, rhs_table, rhs_key, join_table, join_key_lhs, join_key_rhs, relationship_type, relationship_role_column, relationship_role_column_value, reverse, deleted)
						VALUES ('{$guid}', '{$relObjName}_assigned_user','Users','users','id','{$relModName}','{$relObjName}','assigned_user_id',NULL,NULL,NULL,'one-to-many',NULL,NULL,'0','0')";
                DBManagerFactory::getInstance()->query($qRel);
            }
            //modified_user
            $guid = create_guid();
            $query = "SELECT id FROM relationships WHERE relationship_name = '{$relObjName}_modified_user'";
            $result = DBManagerFactory::getInstance()->query($query, true);
            $a = null;
            $a = DBManagerFactory::getInstance()->fetchByAssoc($result);
            if (!isset($a['id']) && empty($a['id'])) {
                $qRel = "INSERT INTO relationships (id,relationship_name, lhs_module, lhs_table, lhs_key, rhs_module, rhs_table, rhs_key, join_table, join_key_lhs, join_key_rhs, relationship_type, relationship_role_column, relationship_role_column_value, reverse, deleted)
						VALUES ('{$guid}', '{$relObjName}_modified_user','Users','users','id','{$relModName}','{$relObjName}','modified_user_id',NULL,NULL,NULL,'one-to-many',NULL,NULL,'0','0')";
                DBManagerFactory::getInstance()->query($qRel);
            }
            //created_by
            $guid = create_guid();
            $query = "SELECT id FROM relationships WHERE relationship_name = '{$relObjName}_created_by'";
            $result = DBManagerFactory::getInstance()->query($query, true);
            $a = null;
            $a = DBManagerFactory::getInstance()->fetchByAssoc($result);
            if (!isset($a['id']) && empty($a['id'])) {
                $qRel = "INSERT INTO relationships (id,relationship_name, lhs_module, lhs_table, lhs_key, rhs_module, rhs_table, rhs_key, join_table, join_key_lhs, join_key_rhs, relationship_type, relationship_role_column, relationship_role_column_value, reverse, deleted)
						VALUES ('{$guid}', '{$relObjName}_created_by','Users','users','id','{$relModName}','{$relObjName}','created_by',NULL,NULL,NULL,'one-to-many',NULL,NULL,'0','0')";
                DBManagerFactory::getInstance()->query($qRel);
            }
            $guid = create_guid();
            $query = "SELECT id FROM relationships WHERE relationship_name = '{$relObjName}_team'";
            $result = DBManagerFactory::getInstance()->query($query, true);
            $a = null;
            $a = DBManagerFactory::getInstance()->fetchByAssoc($result);
            if (!isset($a['id']) && empty($a['id'])) {
                $qRel = "INSERT INTO relationships (id,relationship_name, lhs_module, lhs_table, lhs_key, rhs_module, rhs_table, rhs_key, join_table, join_key_lhs, join_key_rhs, relationship_type, relationship_role_column, relationship_role_column_value, reverse, deleted)
							VALUES ('{$guid}', '{$relObjName}_team','Teams','teams','id','{$relModName}','{$relObjName}','team_id',NULL,NULL,NULL,'one-to-many',NULL,NULL,'0','0')";
                DBManagerFactory::getInstance()->query($qRel);
            }
        }
        //Also add tracker perf relationship
        $guid = create_guid();
        $query = "SELECT id FROM relationships WHERE relationship_name = 'tracker_monitor_id'";
        $result = DBManagerFactory::getInstance()->query($query, true);
        $a = null;
        $a = DBManagerFactory::getInstance()->fetchByAssoc($result);
        if (!isset($a['id']) && empty($a['id'])) {
            $qRel = "INSERT INTO relationships (id,relationship_name, lhs_module, lhs_table, lhs_key, rhs_module, rhs_table, rhs_key, join_table, join_key_lhs, join_key_rhs, relationship_type, relationship_role_column, relationship_role_column_value, reverse, deleted)
					VALUES ('{$guid}', 'tracker_monitor_id','TrackerPerfs','tracker_perf','monitor_id','Trackers','tracker','monitor_id',NULL,NULL,NULL,'one-to-many',NULL,NULL,'0','0')";
            DBManagerFactory::getInstance()->query($qRel);
        }
    }

    /**
     * Add reminders
     * @param $errors
     * @param $skippedFiles
     */
    protected function addReminders($errors, $skippedFiles): void
    {
        if (empty($errors)) {
            commitHandleReminders($skippedFiles);
        }
    }

    /**
     * Reload the db instance
     * @return DBManager
     */
    protected function reloadDbInstance(): DBManager
    {
        if (isset($_SESSION['current_db_version'], $_SESSION['target_db_version']) && version_compare(
                $_SESSION['current_db_version'],
                $_SESSION['target_db_version'],
                '='
            )) {
            $_REQUEST['upgradeWizard'] = true;
            ob_start();
            include __DIR__ . '/../../../../include/Smarty/internals/core.write_file.php';
            ob_end_clean();
            $db =& DBManagerFactory::getInstance();
        }

        return $db;
    }
}
