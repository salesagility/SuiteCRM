<?php
/**
 * Created by Adam Jakab.
 * Date: 26/04/16
 * Time: 14.35
 */

namespace SuiteCrm\Install;

/**
 * Class Installer
 * @package SuiteCrm\Install
 */
class Installer
{
    /** @var array */
    protected $config = [];

    /** @var LoggerManager */
    protected $loggerManager;


    /**
     * @param array $config
     * @param LoggerManager $logger
     */
    public function __construct($config, LoggerManager $logger)
    {
        $this->config = $config;
        $this->loggerManager = $logger;
    }

    public function install() {
        $this->log("Installer configuration: " . json_encode($this->config), 'info');
        $this->setPhpOptions();
        $this->setupSugarServerValues();
        $this->setupSugarGlobals();
        $this->setupSugarSessionVars();
        $this->setupSugarLogger();
        $this->performInstallation();
    }

    /**
     *  Main setup method
     */
    protected function performInstallation()
    {
        $startTime = microtime(TRUE);

        define('sugarEntry', TRUE);

        /** @var array $sugar_config */
        global $sugar_config;

        /** @var \DBManager $db */
        global $db;

        /** @var array $beanList */
        global $beanList;

        /** @var array $beanFiles */
        global $beanFiles;

        /** @var array $app_list_strings */
        global $app_list_strings;

        /** @var \TimeDate $timedate */
        global $timedate;

        /** @var \User $current_user */
        global $current_user;

        require_once(PROJECT_ROOT . '/sugar_version.php');
        require_once(PROJECT_ROOT . '/suitecrm_version.php');
        require_once(PROJECT_ROOT . '/include/utils.php');
        require_once(PROJECT_ROOT . '/include/TimeDate.php');
        require_once(PROJECT_ROOT . '/include/Localization/Localization.php');
        require_once(PROJECT_ROOT . '/include/SugarTheme/SugarTheme.php');
        require_once(PROJECT_ROOT . '/include/utils/LogicHook.php');
        require_once(PROJECT_ROOT . '/data/SugarBean.php');
        require_once(PROJECT_ROOT . '/include/entryPoint.php');
        require_once(PROJECT_ROOT . '/modules/TableDictionary.php');

        /** @var array $dictionary */
        /** @var string $sugar_version */
        /** @var string $sugar_db_version */
        /** @var string $suitecrm_version */


        $timedate = \TimeDate::getInstance();
        $locale = new \Localization();

        $install_script = TRUE;
        $current_language = 'en_us';

        //@todo: implement multi-language responses for web-installer (add --install-language option)
        $mod_strings = [];
        //@include(PROJECT_ROOT . '/install/language/en_us.lang.php');
        $app_list_strings = return_app_list_strings_language($current_language);


        $this->log("Running System Checks");
        $this->config = SystemChecker::runChecks($this->config);

        $this->log("Running Database Checks");
        $this->config = DatabaseChecker::runChecks($this->config);

        if (is_file("config.php")) {
            $this->log("Removing stale configuration file");
            unlink("config.php");
        }

        $this->log("Pausing TrackerManager");
        $trackerManager = \TrackerManager::getInstance();
        $trackerManager->pause();

        $this->log("Ensuring file/folder states");
        InstallUtils::ensureFileFolderStates();

        $this->log("Creating Default Sugar Configuration");
        $configOverride = array_merge($this->config, [
            'sugar_version' => $sugar_version,
            'suitecrm_version' => $suitecrm_version,
        ]);
        InstallUtils::createDefaultSugarConfig($configOverride);
        $this->log("SUGAR_CONFIG: " . print_r($sugar_config, TRUE), 'debug');

        $this->log("Handling Web Config");
        InstallUtils::handleWebConfig();

        $this->log("Handling Htaccess");
        InstallUtils::handleHtaccess();

        /**
         * Set up database
         */
        $connectionConfig = [
            "database-type" =>          $this->config['database-type'],
            "database-host" =>          $this->config['database-host'],
            "database-port" =>          $this->config['database-port'],
            "database-username" =>      $this->config['database-username'],
            "database-password" =>      $this->config['database-password'],
            "database-host-instance" => $this->config['database-host-instance'],
        ];
        //try to connect to database server without setting the database name
        $db = InstallUtils::getDatabaseConnection($connectionConfig);
        $databaseExists = $db->dbExists($this->config['database-name']);
        if ($this->config['install-create-database']) {
            if($databaseExists) {
                $this->log("Dropping Database: " . $this->config['database-name']);
                $db->dropDatabase($this->config['database-name']);
            }
            InstallUtils::installerHook('pre_handleDbCreateDatabase');
            $this->log("Creating Database: " . $this->config['database-name']);
            $db->createDatabase($this->config['database-name']);
            InstallUtils::installerHook('post_handleDbCreateDatabase');
        } else {
            if(!$databaseExists) {
                $sugar_config['dbconfig'] = '';//sugar_cleanup() trick
                throw new \Exception("Database does not exist! Use the --install-create-database option to create it.");
            } else {
                $this->log("Configuring Database Collation");
                InstallUtils::installerHook('pre_handleDbCharsetCollation');
                InstallUtils::handleDbCharsetCollation($this->config);
                InstallUtils::installerHook('post_handleDbCharsetCollation');
            }
        }
        //now we should have database
        $connectionConfig['database-name'] = $this->config['database-name'];
        $db = InstallUtils::getDatabaseConnection($connectionConfig);

        /**
         * @var string $beanName
         * @var string $beanFile
         */
        $this->log("Loading Bean files");
        foreach ($beanFiles as $beanName => $beanFile) {
            $this->log("Requiring bean[$beanName] file: $beanFile", "debug");
            require_once($beanFile);
        }

        $this->log("Cleaning Vardefs");
        \VardefManager::clearVardef();

        /** @var \DBManager $db */
        $db = InstallUtils::getDatabaseConnection($this->config);

        /**
         * Loop through all the Beans and create their tables
         */
        $this->log("Creating Database Tables");

        $processed_tables = []; //for keeping track of the tables we have worked on
        $nonStandardModules = []; //?useful?

        /**
         * We must place AOW_WorkFlow right after the Relationship module, otherwise
         * if we have empty database we will get tons of sql failures
         */
        $beanFiles = array_merge(
            [
                'ACLAction' => $beanFiles['ACLAction'],
                'ACLRole' => $beanFiles['ACLRole'],
                'Relationship' => $beanFiles['Relationship'],
                'AOW_WorkFlow' => $beanFiles['AOW_WorkFlow'],
            ],
            $beanFiles
        );

        $doNotInitModules = [
            'Scheduler',
            'SchedulersJob',
            'ProjectTask',
            'jjwg_Maps',
            'jjwg_Address_Cache',
            'jjwg_Areas',
            'jjwg_Markers'
        ];

        InstallUtils::installerHook('pre_createAllModuleTables');
        foreach ($beanFiles as $beanName => $beanFile) {
            /** @var \SugarBean $focus */
            if (in_array($beanName, $doNotInitModules)) {
                $focus = new $beanName(FALSE);
            } else {
                $focus = new $beanName();
            }

            if ($beanName == 'Configurator') {
                continue;
            }

            $table_name = $focus->table_name;

            $this->log("Processing Module: " . $beanName . "(" . $focus->table_name . ")", 'info');

            // check to see if we have already setup this table
            if (!in_array($table_name, $processed_tables)) {
                if (!file_exists("modules/" . $focus->module_dir . "/vardefs.php")) {
                    continue;
                }
                if (!in_array($beanName, $nonStandardModules)) {
                    require_once("modules/" . $focus->module_dir . "/vardefs.php"); // load up $dictionary
                    if ($dictionary[$focus->object_name]['table'] == 'does_not_exist') {
                        continue; // support new vardef definitions
                    }
                }
                else {
                    continue; //no further processing needed for ignored beans.
                }

                // table has not been setup...we will do it now and remember that
                $processed_tables[] = $table_name;

                $focus->db->database = $db->database; // set db connection so we do not need to reconnect

                if ($this->config['install-drop-tables'] == true) {
                    InstallUtils::dropBeanTables($db, $focus);
                }

                InstallUtils::createBeanTables($db, $focus);

                //$this->log("creating Relationship Meta for ".$focus->getObjectName());
                InstallUtils::installerHook('pre_createModuleTable', array('module' => $focus->getObjectName()));
                \SugarBean::createRelationshipMeta(
                    $focus->getObjectName(), $db, $table_name, '', $focus->module_dir
                );
                InstallUtils::installerHook('post_createModuleTable', array('module' => $focus->getObjectName()));
            }
        }
        InstallUtils::installerHook('post_createAllModuleTables');


        /**
         * Create Relationships tables
         */
        $this->log("Creating Relationships");
        ksort($dictionary);
        foreach ($dictionary as $rel_name => $rel_data) {
            $table = $rel_data['table'];
            $this->log("Processing Relationship: " . $rel_name . "(" . $table . ")", 'info');
            if ($this->config['install-drop-tables'] == true) {
                if ($db->tableExists($table)) {
                    $db->dropTableName($table);
                }
            }

            if (!$db->tableExists($table)) {
                $fields = isset($rel_data['fields']) ? $rel_data['fields'] : [];
                $indices = isset($rel_data['indices']) ? $rel_data['indices'] : [];
                $db->createTableParams($table, $fields, $indices);
            }

            \SugarBean::createRelationshipMeta($rel_name, $db, $table, $dictionary, '');
        }


        /**
         * Create Default Settings
         */
        $this->log("Creating Default Settings");
        InstallUtils::installerHook('pre_createDefaultSettings');
        $configOverride = array_merge($configOverride, [
            'language' => $current_language,
            'sugar_db_version' => $sugar_db_version,
        ]);
        InstallUtils::loadFixtures($db, $configOverride, 'fixtures/config.yml');
        InstallUtils::installerHook('post_createDefaultSettings');


        /**
         * Create Administrator User
         */
        $this->log("Creating Administrator User");
        InstallUtils::installerHook('pre_createUsers');
        $current_user = InstallUtils::createAdministratorUser($db, $this->config);
        InstallUtils::installerHook('post_createUsers');


        /**
         * Rebuild Shedulers
         */
        $this->log("Rebuilding Schedulers");
        InstallUtils::installerHook('pre_createDefaultSchedulers');
        InstallUtils::loadFixtures($db, $configOverride, 'fixtures/schedulers.yml');
        InstallUtils::installerHook('post_createDefaultSchedulers');


        /**
         * @todo: check this - setup_installed_lang_packs in $config is not set anywhere
         * Update upgrade history - language packs
         */
        if (!empty($this->config['setup_installed_lang_packs'])) {
            $this->log("Registering Language Packs");
            InstallUtils::registerLanguagePacks($this->config);
        }

        /**
         *  Enable Sugar Feeds
         */
        $this->log("Enabling Sugar Feeds");
        InstallUtils::enableSugarFeeds();


        /**
         * Handle Sugar Versions - this has disappeared from branch 2016-04-27 - @todo: check and remove
         */
        //$this->log("Handling Version Info");
        //require_once(PROJECT_ROOT . '/modules/Versions/InstallDefaultVersions.php');


        /**
         * Advanced Password Seeds
         */
        $this->log("Handling Advanced Password Configuration");
        InstallUtils::registerAdvancedPasswordConfiguration($this->config);


        /**
         * Administration Variables
         */
        $this->log("Handling Administration Variables");
        InstallUtils::registerAdministrationVariables($this->config);


        /**
         * Setting Default Tabs
         */
        $this->log("Configuring Default Tabs");
        InstallUtils::installerHook('pre_setSystemTabs');
        InstallUtils::configureDefaultTabs($this->config);
        InstallUtils::installerHook('post_setSystemTabs');


        /**
         * SuiteCrm
         */
        $this->log("Registering SuiteCrm Configuration");
        InstallUtils::registerSuiteCrmConfiguration($configOverride);
        $this->log("SuiteCrm Extra Installs");
        InstallUtils::executeExtraInstallation($this->config);


        /**
         * Modules Post Install - ALL DISABLED  - REMOVE ME!
         */
        $this->log("Executing Modules Post Install");
        InstallUtils::modulesPostInstall();


        /**
         * Install Demo Data
         */
        if ($this->config['install-demo-data']) {
            $this->log("Installing Demo Data");
            InstallUtils::installerHook('pre_installDemoData');
            InstallUtils::installDemoData();
            InstallUtils::installerHook('post_installDemoData');
        }

        /**
         * Save User
         *
         * Old note: set all of these default parameters since the Users save action
         * will undo the defaults otherwise
         *
         * My note: @todo: this is horrible - extract needed functionality from '/modules/Users/Save.php'
         */
        $this->log("Updating Admin User");
        // set locale settings
        $current_user->setPreference('datef', 'Y-m-d');
        $current_user->setPreference('timef', 'H:i:s');
        $current_user->setPreference('timezone', date_default_timezone_get());
        // set some POST data for '/modules/Users/Save.php'
        $_POST['dateformat'] = 'Y-m-d';//$sugar_config['default_date_format']
        $_POST['timeformat'] = 'H:i:s';//$sugar_config['default_time_format']
        $_POST['record'] = $current_user->id;
        $_POST['is_admin'] = 'on';
        $_POST['use_real_names'] = TRUE;
        $_POST['reminder_checked'] = '0';
        $_POST['email_reminder_checked'] = '0';
        $_POST['reminder_time'] = 1800;
        $_POST['email_reminder_time'] = 3600;
        $_POST['mailmerge_on'] = 'on';
        $_POST['receive_notifications'] = $current_user->receive_notifications;
        $_POST['user_theme'] = (string) \SugarThemeRegistry::getDefault();
        require(PROJECT_ROOT . '/modules/Users/Save.php');


        /**
         * Post Install Modules Hook
         */
        $this->log("Calling Post-Install Modules Hook");
        InstallUtils::installerHook('post_installModules');


        //BAN ALL MODULES BY DEFAULT: ['addAjaxBannedModules'][] = '';


        /**
         * DONE
         */
        $endTime = microtime(TRUE);
        $deltaTime = $endTime - $startTime;
        $this->log(str_repeat("-", 80));
        $this->log("Installation complete(" . floor($deltaTime) . "s).");
    }

    /**
     * Setup Session variables prior to executing installation
     */
    protected function setupSugarSessionVars()
    {
        if ((function_exists('session_status') && session_status() == PHP_SESSION_NONE) || session_id() == '') {
            session_start();
        }
    }

    /**
     * Setup Globals prior to requiring Sugar application files
     */
    protected function setupSugarGlobals()
    {
        $GLOBALS['installing'] = TRUE;
        define('SUGARCRM_IS_INSTALLING', $GLOBALS['installing']);
    }

    /**
     * Mostly for avoiding undefined index notices
     */
    protected function setupSugarServerValues()
    {
        $_SERVER['SERVER_SOFTWARE'] = isset($this->config['server-software']) ? $this->config['server-software'] : null;
    }

    /**
     * Set up our own LoggerManager for the installation
     */
    protected function setupSugarLogger()
    {
        $GLOBALS['log'] = $this->loggerManager;
    }

    /**
     * Set Php options
     */
    protected function setPhpOptions()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set("output_buffering", "0");

        // http://us3.php.net/manual/en/ref.pcre.php#ini.pcre.backtrack-limit
        // starting with 5.2.0, backtrack_limit breaks JSON decoding
        $backtrack_limit = ini_get('pcre.backtrack_limit');
        if (!empty($backtrack_limit)) {
            ini_set('pcre.backtrack_limit', '-1');
        }
    }

    /**
     * @param string $msg
     * @param string $level - available: debug|info|warn|deprecated|error|fatal|security|off
     */
    public function log($msg, $level = 'warn')
    {
        $this->loggerManager->log($msg, $level);
    }
}