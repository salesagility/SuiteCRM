<?php
/**
 * Created by Adam Jakab.
 * Date: 08/03/16
 * Time: 9.03
 */

namespace SuiteCrm\Install;

use SuiteCrm\Console\Command\Command;
use SuiteCrm\Console\Command\CommandInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;

/**
 * Class InstallCommand
 * @package SuiteCrm\Install
 */
class InstallCommand extends Command implements CommandInterface
{
    const COMMAND_NAME = 'app:install';
    const COMMAND_DESCRIPTION = 'Install the SuiteCrm application';

    /** @var array */
    protected $configurableSections = ["database", "install"];

    /** @var array */
    protected $config = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(NULL);
    }

    /**
     * Configure command
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::COMMAND_DESCRIPTION);
        $this->readConfig();

        $commandModeMap = [
            'none' => InputOption::VALUE_NONE,
            'required' => InputOption::VALUE_REQUIRED,
            'optional' => InputOption::VALUE_OPTIONAL,
        ];

        //SETUP OPTIONS FROM CONFIGURATION
        foreach ($this->configurableSections as $section) {
            foreach ($this->config[$section] as $name => $data) {
                $commandName = $section . '-' . $name;
                $commandShortcut = NULL;
                $commandMode = InputOption::VALUE_OPTIONAL;
                $commandDescription = NULL;
                $commandDefaultValue = NULL;
                if (is_array($data)) {
                    $commandDefaultValue = isset($data["default"]) ? $data["default"] : $commandDefaultValue;
                    $commandMode = isset($data["mode"])
                                   && array_key_exists(
                                       $data["mode"], $commandModeMap
                                   ) ? $commandModeMap[$data["mode"]] : $commandMode;
                    $commandDescription = isset($data["description"]) ? $data["description"] : $commandDescription;
                    $commandShortcut = isset($data["shortcut"]) ? $data["shortcut"] : $commandShortcut;
                }
                else {
                    $commandDefaultValue = !empty($data) ? $data : $commandDefaultValue;
                }
                $this->addOption(
                    $commandName, $commandShortcut, $commandMode, $commandDescription, $commandDefaultValue
                );
            }
        }

        //ADDITIONAL OPTIONS
        $this->addOption(
            'force', 'f', InputOption::VALUE_NONE,
            "Force the installation to run even if 'installer_locked' is set to true in config.php"
        );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::_execute($input, $output);
        $this->log("Starting command " . static::COMMAND_NAME . "...");
        $this->setPhpOptions();
        $this->setConfigurationOptions();
        $this->setupSugarServerValues();
        $this->setupSugarGlobals();
        $this->setupSugarSessionVars();
        $this->setupSugarLogger();
        $this->performInstallation();
        $this->log("Command " . static::COMMAND_NAME . " done.");
    }

    /**
     *  Main setup method
     */
    protected function performInstallation()
    {
        define('sugarEntry', TRUE);

        $startTime = microtime(TRUE);

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
        /** @var string $suitecrm_version */

        $timedate = \TimeDate::getInstance();

        $locale = new \Localization();

        //@todo: build unified vesion info and add it to $config
        $this->config['config']['setup_sugar_version'] = $sugar_version;
        $this->config['config']['setup_suitecrm_version'] = $suitecrm_version;


        $install_script = TRUE;
        $current_language = 'en_us';

        $mod_strings = [];
        //@include(PROJECT_ROOT . '/install/language/en_us.lang.php');
        $app_list_strings = return_app_list_strings_language($current_language);

        $this->config["config"] = SystemChecker::runChecks($this->config["config"]);
        $this->config["config"] = DatabaseChecker::runChecks($this->config["config"]);

        //INSTALLATION IS GOOD TO GO
        $this->log(str_repeat("-", 80));
        $this->log("Starting installer...");


        if (is_file("config.php")) {
            $this->log("Removing stale configuration file");
            unlink("config.php");
        }

        $this->log("Pausing TrackerManager");
        $trackerManager = \TrackerManager::getInstance();
        $trackerManager->pause();


        $this->log("Ensuring file/folder states");
        InstallUtils::makeWritable(PROJECT_ROOT . '/config.php');
        InstallUtils::makeWritable(PROJECT_ROOT . '/custom');
        InstallUtils::makeWritableRecursive(PROJECT_ROOT . '/modules');
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('custom_fields'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('dyn_lay'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('images'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('modules'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('layout'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('pdf'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('upload'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('upload/import'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('xml'));
        InstallUtils::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('include/javascript'));
        InstallUtils::makeWritableRecursive(PROJECT_ROOT . '/' . sugar_cached('modules'));

        $this->log("Creating Sugar Configuration");
        InstallUtils::handleSugarConfig($this->config["config"]);
        $this->log("Sugar Configuration(config.php) has been written to disk");

        $this->log("Handling Web Config");
        InstallUtils::handleWebConfig();

        $this->log("Handling Htaccess");
        InstallUtils::handleHtaccess();

        if ($this->config["config"]['setup_db_create_database']) {
            InstallUtils::installerHook('pre_handleDbCreateDatabase');
            $db = InstallUtils::getDatabaseConnection($this->config["config"]);
            if ($db->dbExists($this->config["config"]['setup_db_database_name'])) {
                $this->log("Dropping Database: " . $this->config["config"]['setup_db_database_name']);
                $db->dropDatabase($this->config["config"]['setup_db_database_name']);
            }
            $this->log("Creating Database: " . $this->config["config"]['setup_db_database_name']);
            $db->createDatabase($this->config["config"]['setup_db_database_name']);
            InstallUtils::installerHook('post_handleDbCreateDatabase');
        }
        else {
            $this->log("Configuring Database Collation");
            InstallUtils::installerHook('pre_handleDbCharsetCollation');
            InstallUtils::handleDbCharsetCollation($this->config["config"]);
            InstallUtils::installerHook('post_handleDbCharsetCollation');
        }

        /**
         * @var array  $beanFiles - defined in include/modules.php
         * @var string $beanName
         * @var string $beanFile
         */
        $this->log("Loading Bean files");
        foreach ($beanFiles as $beanName => $beanFile) {
            $this->log("Requiring bean[$beanName] file: $beanFile", "info");
            require_once($beanFile);
        }

        $this->log("Cleaning Vardefs");
        \VardefManager::clearVardef();

        /**
         * @todo: check this - does not work: MySQL error 1046: No database selected
         */
        //$db = InstallUtils::getDatabaseConnection($this->config["config"]);
        /** @var \DBManager $db */
        $db = \DBManagerFactory::getInstance();

        /**
         * loop through all the Beans and create their tables
         */
        $this->log("Creating Database Tables");

        $processed_tables = []; //for keeping track of the tables we have worked on
        $nonStandardModules = []; //?useful?

        /**
         * We must place AOW_WorkFlow right after the Relationship module, otherwise
         * if we have empty database we will get tons of sql fails
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
        InstallUtils::installerHook('pre_createAllModuleTables');
        foreach ($beanFiles as $beanName => $beanFile) {
            $doNotInitModules = [
                'Scheduler',
                'SchedulersJob',
                'ProjectTask',
                'jjwg_Maps',
                'jjwg_Address_Cache',
                'jjwg_Areas',
                'jjwg_Markers'
            ];

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

                if ($this->config["config"]['setup_db_drop_tables'] == true) {
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
         * loop through all Relationships and create their tables
         */
        $this->log("Creating Relationships");
        ksort($dictionary);
        foreach ($dictionary as $rel_name => $rel_data) {
            $table = $rel_data['table'];

            $this->log("Processing Relationship: " . $rel_name . "(" . $table . ")", 'info');
            if ($this->config["config"]['setup_db_drop_tables'] == true) {
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
        /**
         * @todo: $sugar_db_version should be in config
         * @var string $sugar_db_version - loaded from sugar_version.php
         */
        InstallUtils::insertDefaultConfigSettings($db, $this->config["config"], $sugar_db_version);
        InstallUtils::installerHook('post_createDefaultSettings');


        /**
         * Create Administrator User
         */
        $this->log("Creating Administrator User");
        InstallUtils::installerHook('pre_createUsers');
        $current_user = InstallUtils::createAdministratorUser($this->config["config"]);
        InstallUtils::installerHook('post_createUsers');


        /**
         * Rebuild Shedulers
         */
        $this->log("Rebuilding Schedulers");
        InstallUtils::installerHook('pre_createDefaultSchedulers');
        InstallUtils::rebuildDefaultSchedulers($db, $this->config["config"]);
        InstallUtils::installerHook('post_createDefaultSchedulers');


        /**
         * @todo: check this - setup_installed_lang_packs in $config is not set anywhere
         * Update upgrade history - language packs
         */
        if (!empty($this->config["config"]['setup_installed_lang_packs'])) {
            $this->log("Registering Language Packs");
            InstallUtils::registerLanguagePacks($this->config["config"]);
        }


        /**
         *  Enable Sugar Feeds
         */
        $this->log("Enabling Sugar Feeds");
        InstallUtils::enableSugarFeeds();


        /**
         * Handle Sugar Versions
         */
        $this->log("Handling Version Info");
        require_once(PROJECT_ROOT . '/modules/Versions/InstallDefaultVersions.php');


        /**
         * Advanced Password Seeds
         */
        $this->log("Handling Advanced Password Configuration");
        InstallUtils::registerAdvancedPasswordConfiguration($this->config["config"]);


        /**
         * Administration Variables
         */
        $this->log("Handling Administration Variables");
        InstallUtils::registerAdministrationVariables($this->config["config"]);


        /**
         * Setting Default Tabs
         */
        $this->log("Configuring Default Tabs");
        InstallUtils::installerHook('pre_setSystemTabs');
        InstallUtils::configureDefaultTabs($this->config["config"]);
        InstallUtils::installerHook('post_setSystemTabs');


        /**
         * SuiteCrm
         */
        $this->log("Configuring SuiteCrm");
        InstallUtils::registerSuiteCrmConfiguration($this->config["config"]);
        InstallUtils::executeExtraInstallation($this->config["config"]);


        /**
         * Modules Post Install - ALL DISABLED  - REMOVE ME!
         */
        $this->log("Executing Modules Post Install");
        InstallUtils::modulesPostInstall();


        /**
         * Install Demo Data
         */
        if ($this->config["config"]['demo-data']) {
            $this->log("Installing Demo Data");
            InstallUtils::installerHook('pre_installDemoData');
            InstallUtils::installDemoData();
            InstallUtils::installerHook('post_installDemoData');
        }


        /**
         * Save Administration Configuration
         */
        $this->log("Updating Administration Configuration");
        $admin = new \Administration();
        $admin->saveSetting('system', 'adminwizard', 1);
        $admin->saveConfig();


        /**
         * Save Configuration Overrides
         */
        $this->log("Saving Configuration Overrides");
        $sugar_config['default_date_format'] = $this->config["config"]['default_date_format'];
        $sugar_config['default_time_format'] = $this->config["config"]['default_time_format'];
        $sugar_config['default_language'] = $this->config["config"]['default_language'];
        $sugar_config['default_locale_name_format'] = $this->config["config"]['default_locale_name_format'];
        $configurator = new \Configurator();
        $configurator->saveConfig();
        write_array_to_file("sugar_config", $configurator->config, "config.php");



        /**
         * Save User
         * old note: set all of these default parameters since the Users save action
         * will undo the defaults otherwise
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
     * Remap Command options to config section of configuration
     * @throws \Exception
     */
    protected function setConfigurationOptions()
    {
        //$this->log("Command Options: " . json_encode($this->cmdInput->getOptions()));

        //REMAP FROM COMMAND OPTIONS
        foreach ($this->configurableSections as $section) {
            foreach ($this->config[$section] as $name => $data) {
                if (is_array($data) && isset($data['config-key']) && !empty($data['config-key'])) {
                    $commandName = $section . '-' . $name;
                    $configKey = $data['config-key'];
                    $configValue = $this->cmdInput->getOption($commandName);
                    //$this->log("Remapping(${commandName} -> ${configKey}): " . $configValue);
                    $this->config["config"][$configKey] = $configValue;
                }
            }
        }

        //ADDITIONAL
        if (isset($this->config["config"]['setup_site_host_name'])) {
            $this->config["config"]['setup_site_url'] = 'http://' . $this->config["config"]['setup_site_host_name'];
        }

        $this->log("CONFIG SECTION: " . print_r($this->config["config"], TRUE), 'info');
    }


    /**
     * Setup Session variables prior to executing installation
     */
    protected function setupSugarSessionVars()
    {
        if ((function_exists('session_status') && session_status() == PHP_SESSION_NONE) || session_id() == '') {
            session_start();
        }
        //$_SESSION = array_merge_recursive($_SESSION, $this->config["config"]);

        //FORCE INSTALLATION?
        $_SESSION["FORCE_INSTALLATION"] = $this->cmdInput->getOption('force');

        $this->log("SESSION VARIABLES: " . print_r($_SESSION, TRUE), 'info');
    }

    /**
     * Setup Globals prior to requiring Sugar application files
     */
    protected function setupSugarGlobals()
    {
        $GLOBALS['installing'] = TRUE;
        define('SUGARCRM_IS_INSTALLING', $GLOBALS['installing']);
        $GLOBALS['sql_queries'] = 0;
    }

    /**
     * Mostly for avoiding undefined index notices
     */
    protected function setupSugarServerValues()
    {
        $_SERVER['SERVER_SOFTWARE'] = NULL;
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
     * Set up our own LoggerManager for the installation
     */
    protected function setupSugarLogger()
    {
        $GLOBALS['log'] = $this->loggerManager;
    }

    /**
     * Reads in the installer default parameters
     */
    protected function readConfig()
    {
        $defaultsPath = dirname(__FILE__) . '/assets/install_defaults.yml';
        if (!file_exists($defaultsPath)) {
            throw new \Exception("Installation defaults file not found!");
        }
        $parser = new Parser();
        $this->config = $parser->parse(file_get_contents($defaultsPath));
        foreach (['database', 'install', 'config'] as $section) {
            if (!isset($this->config[$section])) {
                throw new \Exception("Missing '" . $section . "' section from installation defaults file!");
            }
        }
    }
}