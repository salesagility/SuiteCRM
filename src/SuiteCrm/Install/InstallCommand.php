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

        /** @var array $app_list_strings */
        global $app_list_strings;

        /** @var \TimeDate $timedate */
        global $timedate;

        require_once(PROJECT_ROOT . '/sugar_version.php');
        require_once(PROJECT_ROOT . '/suitecrm_version.php');
        require_once(PROJECT_ROOT . '/include/utils.php');
//        require_once(PROJECT_ROOT . '/install/install_utils.php');
//        require_once(PROJECT_ROOT . '/install/install_defaults.php');
        require_once(PROJECT_ROOT . '/include/TimeDate.php');
        require_once(PROJECT_ROOT . '/include/Localization/Localization.php');
        require_once(PROJECT_ROOT . '/include/SugarTheme/SugarTheme.php');
        require_once(PROJECT_ROOT . '/include/utils/LogicHook.php');
        require_once(PROJECT_ROOT . '/data/SugarBean.php');
        require_once(PROJECT_ROOT . '/include/entryPoint.php');
        require_once(PROJECT_ROOT . '/modules/TableDictionary.php');

        /** @var array $dictionary */

        $timedate = \TimeDate::getInstance();

        $locale = new \Localization();

        /** @var string $suitecrm_version */
        //$setup_sugar_version = $suitecrm_version;
        $this->config['config']['setup_sugar_version'] = $suitecrm_version;

        $install_script = TRUE;
        $current_language = 'en_us';

        $mod_strings = [];
        //@include(PROJECT_ROOT . '/install/language/en_us.lang.php');
        $app_list_strings = return_app_list_strings_language($current_language);

        $this->config["config"] = SystemChecker::runChecks($this->config["config"]);
        $this->config["config"] = DatabaseChecker::runChecks($this->config["config"]);

        //INSTALLATION IS GOOD TO GO
        $this->log(str_repeat("-", 120));
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

        /*
        $cache_dir = sugar_cached("");
        $line_entry_format = "&nbsp&nbsp&nbsp&nbsp&nbsp<b>";
        $line_exit_format = "... &nbsp&nbsp</b>";
        /** @var  array $dictionary * /
        $rel_dictionary = $dictionary; // sourced by modules/TableDictionary.php
        $render_table_close = "";
        $render_table_open = "";

        $setup_db_admin_password = $_SESSION['setup_db_admin_password'];
        $setup_db_admin_user_name = $_SESSION['setup_db_admin_user_name'];

        $setup_db_sugarsales_password = $setup_db_admin_password;
        $setup_db_sugarsales_user = $setup_db_admin_user_name;

        $setup_site_admin_user_name = $_SESSION['setup_site_admin_user_name'];
        $setup_site_admin_password = $_SESSION['setup_site_admin_password'];

        $setup_db_create_database = $_SESSION['setup_db_create_database'];
        $setup_db_drop_tables = $_SESSION['setup_db_drop_tables'];

        $setup_db_create_sugarsales_user = $_SESSION['setup_db_create_sugarsales_user'];


        $setup_db_host_name = $_SESSION['setup_db_host_name'];
        $setup_db_port_num = $_SESSION['setup_db_port_num'];
        $setup_db_database_name = $_SESSION['setup_db_database_name'];
        $setup_db_host_instance = $_SESSION['setup_db_host_instance'];

        $demoData = $_SESSION['demo-data'];
        $_SESSION['demoData'] = $demoData;//@todo: get rid of me!


        $setup_site_guid = (isset($_SESSION['setup_site_specify_guid'])
                            && $_SESSION['setup_site_specify_guid'] != '') ? $_SESSION['setup_site_guid'] : '';
        $setup_site_url = $_SESSION['setup_site_url'];
        $parsed_url = parse_url($setup_site_url);
        $setup_site_host_name = $parsed_url['host'];

        $setup_site_log_dir = isset($_SESSION['setup_site_custom_log_dir']) ? $_SESSION['setup_site_log_dir'] : '.';

        $setup_site_log_file = 'suitecrm.log';  // may be an option later
        $setup_site_session_path = isset($_SESSION['setup_site_custom_session_path']) ? $_SESSION['setup_site_session_path'] : '';
        $setup_site_log_level = 'fatal';


        $GLOBALS['cache_dir'] = $cache_dir;
        $GLOBALS['mod_strings'] = $mod_strings;
        $GLOBALS['setup_site_log_level'] = $setup_site_log_level;
        $GLOBALS['create_default_user'] = FALSE;

        $GLOBALS['setup_db_host_name'] = $setup_db_host_name;
        $GLOBALS['setup_db_host_instance'] = $setup_db_host_instance;
        $GLOBALS['setup_db_port_num'] = $setup_db_port_num;

        //some of these username/pwd pairs must be unused ... but which?
        $GLOBALS['setup_db_admin_user_name'] = $setup_db_admin_user_name;
        $GLOBALS['setup_db_admin_password'] = $setup_db_admin_password;

        $GLOBALS['setup_site_admin_user_name'] = $setup_site_admin_user_name;
        $GLOBALS['setup_site_admin_password'] = $setup_site_admin_password;

        $GLOBALS['setup_db_sugarsales_user'] = $setup_db_sugarsales_user;
        $GLOBALS['setup_db_sugarsales_password'] = $setup_db_sugarsales_password;

        $GLOBALS['setup_db_database_name'] = $setup_db_database_name;

        $GLOBALS['setup_site_host_name'] = $setup_site_host_name;
        $GLOBALS['setup_site_log_dir'] = $setup_site_log_dir;
        $GLOBALS['setup_site_log_file'] = $setup_site_log_file;
        $GLOBALS['setup_site_session_path'] = $setup_site_session_path;

        $GLOBALS['setup_site_guid'] = $setup_site_guid;
        $GLOBALS['setup_site_url'] = $setup_site_url;
        $GLOBALS['setup_sugar_version'] = $setup_sugar_version;
        $GLOBALS['timedate'] = $timedate;
        */



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
        $scheduler = new \Scheduler();
        InstallUtils::installerHook('pre_createDefaultSchedulers');
        InstallUtils::rebuildDefaultSchedulers($db, $this->config["config"]);
        InstallUtils::installerHook('post_createDefaultSchedulers');


        die("---KILLED---\n");

        /**
         * Update upgrade history
         */
        if (isset($_SESSION['INSTALLED_LANG_PACKS']) && is_array($_SESSION['INSTALLED_LANG_PACKS'])
            && !empty($_SESSION['INSTALLED_LANG_PACKS'])
        ) {
            $this->log(str_repeat("-", 120));
            $this->log("Updating upgrade history...");
            updateUpgradeHistory();
        }


        /**
         *  Enable Sugar Feeds
         */
        $this->log(str_repeat("-", 120));
        $this->log("Enabling Sugar Feeds...");
        enableSugarFeeds();


        /**
         * Handle Sugar Versions
         */
        $this->log(str_repeat("-", 120));
        $this->log("Handling Sugar Versions...");
        require_once(PROJECT_ROOT . '/modules/Versions/InstallDefaultVersions.php');


        /**
         * Advanced Password Seeds
         */
        $this->log(str_repeat("-", 120));
        $this->log("Handling Advanced Password Seeds...");
        include(PROJECT_ROOT . '/install/seed_data/Advanced_Password_SeedData.php');

        /**
         * Administration Variables
         */
        $this->log(str_repeat("-", 120));
        $this->log("Handling Administration Variables...");
        if (isset($_SESSION['setup_site_sugarbeet_automatic_checks'])
            && $_SESSION['setup_site_sugarbeet_automatic_checks'] == TRUE
        ) {
            set_CheckUpdates_config_setting('automatic');
        }
        else {
            set_CheckUpdates_config_setting('manual');
        }
        if (!empty($_SESSION['setup_system_name'])) {
            $admin = new \Administration();
            $admin->saveSetting('system', 'name', $_SESSION['setup_system_name']);
        }

        /**
         * Setting Default Tabs
         */
        $this->log(str_repeat("-", 120));
        $this->log("Setting Default Tabs...");
        // Bug 28601 - Set the default list of tabs to show
        $enabled_tabs = array();
        $enabled_tabs[] = 'Home';
        $enabled_tabs[] = 'Accounts';
        $enabled_tabs[] = 'Contacts';
        $enabled_tabs[] = 'Opportunities';
        $enabled_tabs[] = 'Leads';
        $enabled_tabs[] = 'AOS_Quotes';
        $enabled_tabs[] = 'Calendar';
        $enabled_tabs[] = 'Documents';
        $enabled_tabs[] = 'Emails';
        $enabled_tabs[] = 'Campaigns';
        $enabled_tabs[] = 'Calls';
        $enabled_tabs[] = 'Meetings';
        $enabled_tabs[] = 'Tasks';
        $enabled_tabs[] = 'Notes';
        $enabled_tabs[] = 'AOS_Invoices';
        $enabled_tabs[] = 'AOS_Contracts';
        $enabled_tabs[] = 'Cases';
        $enabled_tabs[] = 'Prospects';
        $enabled_tabs[] = 'ProspectLists';
        $enabled_tabs[] = 'Project';
        $enabled_tabs[] = 'AM_ProjectTemplates';
        $enabled_tabs[] = 'AM_TaskTemplates';
        $enabled_tabs[] = 'FP_events';
        $enabled_tabs[] = 'FP_Event_Locations';
        $enabled_tabs[] = 'AOS_Products';
        $enabled_tabs[] = 'AOS_Product_Categories';
        $enabled_tabs[] = 'AOS_PDF_Templates';
        $enabled_tabs[] = 'jjwg_Maps';
        $enabled_tabs[] = 'jjwg_Markers';
        $enabled_tabs[] = 'jjwg_Areas';
        $enabled_tabs[] = 'jjwg_Address_Cache';
        $enabled_tabs[] = 'AOR_Reports';
        $enabled_tabs[] = 'AOW_WorkFlow';
        $enabled_tabs[] = 'AOK_KnowledgeBase';
        $enabled_tabs[] = 'AOK_Knowledge_Base_Categories';

        InstallUtils::installerHook('pre_setSystemTabs');
        require_once(PROJECT_ROOT . '/modules/MySettings/TabController.php');
        $tabs = new \TabController();
        $tabs->set_system_tabs($enabled_tabs);
        InstallUtils::installerHook('post_setSystemTabs');

        /**
         * Modules Post Install
         */
        $this->log(str_repeat("-", 120));
        $this->log("Modules Post Install...");
        include_once(PROJECT_ROOT . '/install/suite_install/suite_install.php');
        post_install_modules();


        /**
         * @todo: 6 million warnings & errors - CHECK ME!
         * Install Demo Data
         */
        if (isset($_SESSION['demoData']) && $_SESSION['demoData'] === TRUE) {
            $this->log(str_repeat("-", 120));
            $this->log("Installing Demo Data...");

            InstallUtils::installerHook('pre_installDemoData');
            global $current_user;
            $current_user = new \User();
            $current_user->retrieve(1);
            include(PROJECT_ROOT . '/install/populateSeedData.php');
            InstallUtils::installerHook('post_installDemoData');
        }


        /**
         * Save Administration Configuration
         */
        $this->log(str_repeat("-", 120));
        $this->log("Saving Administration Configuration...");
        $varStack['GLOBALS'] = $GLOBALS;
        $varStack['defined_vars'] = get_defined_vars();
        $_REQUEST = array_merge($_REQUEST, $_SESSION);
        $_POST = array_merge($_POST, $_SESSION);
        $admin = new \Administration();
        $admin->saveSetting('system', 'adminwizard', 1);
        $admin->saveConfig();


        /**
         * Save Global Configuration
         */
        $this->log(str_repeat("-", 120));
        $this->log("Saving Global Configuration...");
        // add local settings to config overrides
        if (!empty($_SESSION['default_date_format'])) {
            $sugar_config['default_date_format'] = $_SESSION['default_date_format'];
        }
        if (!empty($_SESSION['default_time_format'])) {
            $sugar_config['default_time_format'] = $_SESSION['default_time_format'];
        }
        if (!empty($_SESSION['default_language'])) {
            $sugar_config['default_language'] = $_SESSION['default_language'];
        }
        if (!empty($_SESSION['default_locale_name_format'])) {
            $sugar_config['default_locale_name_format'] = $_SESSION['default_locale_name_format'];
        }


        $configurator = new \Configurator();
        $configurator->saveConfig();
        writeSugarConfig($configurator->config);


        /**
         * @todo: check and remove this
         * Fix Currency - Bug 37310
         */
        if (isset($_REQUEST['default_currency_name']) && !empty($_REQUEST['default_currency_name'])) {
            $this->log(str_repeat("-", 120));
            $this->log("Fix Currency - Bug 37310...");
            $currency = new \Currency();
            $currency->retrieve($currency->retrieve_id_by_name($_REQUEST['default_currency_name']));
            if (!empty($currency->id)
                && isset($_REQUEST['default_currency_symbol'])
                && isset($_REQUEST['default_currency_iso4217'])
                && $currency->symbol == $_REQUEST['default_currency_symbol']
                && $currency->iso4217 == $_REQUEST['default_currency_iso4217']
            ) {
                $currency->deleted = 1;
                $currency->save();
            }
        }

        /**
         * Save User
         * old note: set all of these default parameters since the Users save action
         * will undo the defaults otherwise
         */
        $this->log(str_repeat("-", 120));
        $this->log("Saving Admin User...");
        $current_user = new \User();
        $current_user->retrieve(1);
        $current_user->is_admin = '1';
        //$sugar_config = get_sugar_config_defaults();// - why?


        // set locale settings
        $current_user->setPreference('datef', 'Y-m-d');
        $current_user->setPreference('timef', 'H:i:s');
        $current_user->setPreference('timezone', date_default_timezone_get());//get it from php - default to 'UTC'


        $_POST['dateformat'] = 'Y-m-d';//$sugar_config['default_date_format']
        $_POST['timeformat'] = 'H:i:s';//$sugar_config['default_time_format']
        $_POST['record'] = $current_user->id;
        $_POST['is_admin'] = ($current_user->is_admin ? 'on' : '');
        $_POST['use_real_names'] = TRUE;
        $_POST['reminder_checked'] = '0';
        $_POST['email_reminder_checked'] = '0';
        $_POST['reminder_time'] = 1800;
        $_POST['email_reminder_time'] = 3600;
        $_POST['mailmerge_on'] = 'on';
        $_POST['receive_notifications'] = $current_user->receive_notifications;
        $_POST['user_theme'] = (string) \SugarThemeRegistry::getDefault();
        require(PROJECT_ROOT . '/modules/Users/Save.php');


        // restore superglobals and vars
//        $GLOBALS = $varStack['GLOBALS'];
//        foreach($varStack['defined_vars'] as $__key => $__value) {
//            $$__key = $__value;
//        }

        $endTime = microtime(TRUE);
        $deltaTime = $endTime - $startTime;

        /**
         * Post Install Modules Hook
         */
        $this->log(str_repeat("-", 120));
        $this->log("Calling Post Install Modules Hook...");
        InstallUtils::installerHook('post_installModules');

        /**
         * DONE
         */
        $this->log(str_repeat("-", 120));
        $this->log(str_repeat("-", 120));
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