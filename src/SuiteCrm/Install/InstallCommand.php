<?php
/**
 * Created by Adam Jakab.
 * Date: 08/03/16
 * Time: 9.03
 */

namespace SuiteCrm\Install;

use SuiteCrm\Console\Command\Command;
use SuiteCrm\Console\Command\CommandInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand
 * @package SuiteCrm\Install
 */
class InstallCommand extends Command implements CommandInterface
{
    const COMMAND_NAME = 'app:install';
    const COMMAND_DESCRIPTION = 'Install the SuiteCrm application';

    /** @var bool */
    private $logToConsole = TRUE;

    /**
     * Constructor
     */
    public function __construct() {
        $this->enableConsoleLogging($this->logToConsole);
        parent::__construct(NULL);
    }

    /**
     * Configure command
     */
    protected function configure() {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::COMMAND_DESCRIPTION);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        parent::_execute($input, $output);
        $this->log("Starting command " . static::COMMAND_NAME . "...");
        $this->doPhpVersionCheck();
        $this->setupSugarGlobals();
        $this->setupSugarSessionVars([]);
        $this->setupSugarLogger();
        $this->performInstallation();



        $this->log("Command " . static::COMMAND_NAME . " done.");
    }


    /**
     *
     */
    protected function performInstallation() {
        define('sugarEntry', true);
        global $beanList;
        global $app_list_strings;
        global $timedate;
        //require_once(PROJECT_ROOT . '/include/SugarLogger/LoggerManager.php');
        require_once(PROJECT_ROOT . '/sugar_version.php');
        require_once(PROJECT_ROOT . '/suitecrm_version.php');
        require_once(PROJECT_ROOT . '/include/utils.php');
        require_once(PROJECT_ROOT . '/install/install_utils.php');
        require_once(PROJECT_ROOT . '/install/install_defaults.php');
        require_once(PROJECT_ROOT . '/include/TimeDate.php');
        require_once(PROJECT_ROOT . '/include/Localization/Localization.php');
        require_once(PROJECT_ROOT . '/include/SugarTheme/SugarTheme.php');
        require_once(PROJECT_ROOT . '/include/utils/LogicHook.php');
        require_once(PROJECT_ROOT . '/data/SugarBean.php');
        require_once(PROJECT_ROOT . '/include/entryPoint.php');
        require_once(PROJECT_ROOT . '/modules/TableDictionary.php');
        //
        $timedate = \TimeDate::getInstance();
        setPhpIniSettings();
        $locale = new \Localization();
        /** @var  string $suitecrm_version */
        $setup_sugar_version = $suitecrm_version;
        $install_script = true;
        $current_language = 'en_us';

        $mod_strings = [];
        @include(PROJECT_ROOT . '/install/language/en_us.lang.php');

        $app_list_strings = return_app_list_strings_language($current_language);

        SystemChecker::runChecks();
        DatabaseChecker::runChecks();

        ini_set("output_buffering","0");
        set_time_limit(3600);

        $this->log(str_repeat("-", 120));

        $trackerManager = \TrackerManager::getInstance();
        $trackerManager->pause();

        make_writable(PROJECT_ROOT . '/config.php');
        make_writable(PROJECT_ROOT . '/custom');
        recursive_make_writable(PROJECT_ROOT . '/modules');
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('custom_fields'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('dyn_lay'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('images'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('modules'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('layout'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('pdf'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('upload'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('upload/import'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('xml'));
        create_writable_dir(PROJECT_ROOT . '/' . sugar_cached('include/javascript'));
        recursive_make_writable(PROJECT_ROOT . '/' . sugar_cached('modules'));

        $cache_dir                          = sugar_cached("");
        $line_entry_format                  = "&nbsp&nbsp&nbsp&nbsp&nbsp<b>";
        $line_exit_format                   = "... &nbsp&nbsp</b>";
        /** @var  array $dictionary */
        $rel_dictionary                     = $dictionary; // sourced by modules/TableDictionary.php
        $render_table_close                 = "";
        $render_table_open                  = "";

        $setup_db_admin_password            = $_SESSION['setup_db_admin_password'];
        $setup_db_admin_user_name           = $_SESSION['setup_db_admin_user_name'];
        $setup_db_sugarsales_password       = $setup_db_admin_password;
        $setup_db_sugarsales_user           = $setup_db_admin_user_name;

        $setup_db_create_database           = $_SESSION['setup_db_create_database'];
        $setup_db_create_sugarsales_user    = $_SESSION['setup_db_create_sugarsales_user'];
        $setup_db_database_name             = $_SESSION['setup_db_database_name'];
        $setup_db_drop_tables               = $_SESSION['setup_db_drop_tables'];
        $setup_db_host_instance             = $_SESSION['setup_db_host_instance'];
        $setup_db_port_num                  = $_SESSION['setup_db_port_num'];
        $setup_db_host_name                 = $_SESSION['setup_db_host_name'];
        $demoData                           = $_SESSION['demoData'];
        $setup_site_admin_user_name         = $_SESSION['setup_site_admin_user_name'];
        $setup_site_admin_password          = $_SESSION['setup_site_admin_password'];
        $setup_site_guid                    = (isset($_SESSION['setup_site_specify_guid']) && $_SESSION['setup_site_specify_guid'] != '') ? $_SESSION['setup_site_guid'] : '';
        $setup_site_url                     = $_SESSION['setup_site_url'];
        $parsed_url                         = parse_url($setup_site_url);
        $setup_site_host_name               = $parsed_url['host'];
        $setup_site_log_dir                 = isset($_SESSION['setup_site_custom_log_dir']) ? $_SESSION['setup_site_log_dir'] : '.';
        $setup_site_log_file                = 'suitecrm.log';  // may be an option later
        $setup_site_session_path            = isset($_SESSION['setup_site_custom_session_path']) ? $_SESSION['setup_site_session_path'] : '';
        $setup_site_log_level				='fatal';


        $GLOBALS['cache_dir'] = $cache_dir;
        $GLOBALS['mod_strings'] = $mod_strings;
        $GLOBALS['setup_site_log_level'] = $setup_site_log_level;

        $GLOBALS['setup_db_host_name'] = $setup_db_host_name;
        $GLOBALS['setup_db_host_instance'] = $setup_db_host_instance;
        $GLOBALS['setup_db_port_num'] = $setup_db_port_num;

        $GLOBALS['setup_db_admin_user_name'] = $setup_db_admin_user_name;
        $GLOBALS['setup_db_admin_password'] = $setup_db_admin_password;

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

        //global $sugar_config;

        //install/install_utils.php:724
        $this->log("Calling: handleSugarConfig()");
        $bottle = handleSugarConfig();

        $this->log("Calling: handleWebConfig()");
        handleWebConfig();

        $this->log("Calling: handleHtaccess()");
        handleHtaccess();


        //We are NOT creating database (nor db user) - do that yourself!
        $this->log("Calling: handleDbCharsetCollation()");
        installerHook('pre_handleDbCharsetCollation');
        handleDbCharsetCollation();
        installerHook('post_handleDbCharsetCollation');

        /**
         * @var array $beanFiles
         * @var string $beanName
         * @var string $beanFile
         */
        foreach($beanFiles as $beanName => $beanFile )
        {
            //$this->log("Requiring bean[$beanName] file: $beanFile");
            require_once($beanFile);
        }


        global $db;
        $db                 = \DBManagerFactory::getInstance();
        $startTime          = microtime(true);
        $focus              = 0;
        $processed_tables   = []; // for keeping track of the tables we have worked on
        $empty              = '';
        $new_tables         = 1; // is there ever a scenario where we DON'T create the admin user?
        $new_config         = 1;
        $new_report         = 1;
        $nonStandardModules = [];


        $this->log("cleaning bean vardefs");
        //$this->log("BEAN-LIST: " . json_encode($beanList));
        \VardefManager::clearVardef();


        /**
         * loop through all the Beans and create their tables
         */
        $this->log("Creating database tables");
        installerHook('pre_createAllModuleTables');
        foreach( $beanFiles as $beanName => $beanFile ) {

            $doNotInitModules = ['Scheduler', 'SchedulersJob', 'ProjectTask','jjwg_Maps','jjwg_Address_Cache','jjwg_Areas','jjwg_Markers'];

            /** @var \SugarBean $focus */
            if(in_array($beanName, $doNotInitModules)) {
                $focus = new $beanName(false);
            } else {
                $focus = new $beanName();
            }

            if ( $beanName == 'Configurator' ) {
                continue;
            }

            $table_name = $focus->table_name;

            $this->log("processing table: ".$focus->table_name);

            // check to see if we have already setup this table
            if(!in_array($table_name, $processed_tables)) {
                if(!file_exists("modules/".$focus->module_dir."/vardefs.php")){
                    continue;
                }
                if(!in_array($beanName, $nonStandardModules)) {
                    require_once("modules/".$focus->module_dir."/vardefs.php"); // load up $dictionary
                    if($dictionary[$focus->object_name]['table'] == 'does_not_exist') {
                        continue; // support new vardef definitions
                    }
                } else {
                    continue; //no further processing needed for ignored beans.
                }

                // table has not been setup...we will do it now and remember that
                $processed_tables[] = $table_name;

                $focus->db->database = $db->database; // set db connection so we do not need to reconnect

                if($setup_db_drop_tables) {
                    drop_table_install($focus);
                    //$this->log("dropping table: ".$focus->table_name);
                }

                if(create_table_if_not_exist($focus)) {
                    //$this->log("creating table: ". $focus->table_name );
                    if( $beanName == "User" ){
                        $new_tables = 1;
                    }
                    if($beanName == "Administration") {
                        $new_config = 1;
                    }
                }
                //$this->log("creating Relationship Meta for ".$focus->getObjectName());
                installerHook('pre_createModuleTable', array('module' => $focus->getObjectName()));
                \SugarBean::createRelationshipMeta($focus->getObjectName(), $db, $table_name, $empty, $focus->module_dir);
                installerHook('post_createModuleTable', array('module' => $focus->getObjectName()));
            }
        }
        installerHook('post_createAllModuleTables');



        $this->log("");
        $this->log(str_repeat("-", 120));



        $this->log("SESSION VARS: " . json_encode($_SESSION));

    }


    /**
     * Set up a custom logger for the installation
     * use one of: 'debug', 'info', 'warn', 'deprecated', 'error', 'fatal', 'security', 'off'
     */
    protected function setupSugarLogger() {
        $GLOBALS['log'] = new LoggerManager($this->cmdOutput, 'error');
    }

    /**
     * Setup Session variables prior to executing installation
     *
     * @param array $data
     */
    protected function setupSugarSessionVars($data) {
        if((function_exists('session_status') && session_status() == PHP_SESSION_NONE) || session_id() == '') {
            session_start();
        }

        $databaseConfigData = [
            /*BASIC*/
            'setup_db_type' => 'mysql',
            'setup_db_admin_user_name' => 'jack',
            'setup_db_admin_password' => '02203505',
            'setup_db_database_name' => 'suitecrm_bradipo_tests',
            'setup_db_host_name' => 'localhost',
            'setup_db_port_num' => '3306',
            'setup_db_host_instance' => '',//SQLEXPRESS
            'setup_db_manager' => '',//'MysqliManager',
            /*SITE DEFAULT ADMIN USER*/
            'setup_site_admin_user_name' => 'admin',
            'setup_site_admin_password' => 'admin',
            /*FTS SUPPORT*/
            'setup_fts_type' => '',
            'setup_fts_host' => '',
            'setup_fts_port' => '',
            /* INTERNAL */
            'setup_db_create_sugarsales_user' => false,
            'setup_db_create_database' => false,
            'setup_db_drop_tables' => true,
            'setup_site_url' => 'http://localhost',
            'host' => 'localhost',
            'demoData' => 'no',
        ];

        $data = array_merge_recursive($data, $databaseConfigData);
        $_SESSION = array_merge_recursive($_SESSION, $data);
    }

    /**
     * Setup Globals prior to requiring Sugar application files
     */
    protected function setupSugarGlobals() {
        $GLOBALS['installing'] = true;
        define('SUGARCRM_IS_INSTALLING', $GLOBALS['installing']);

        $GLOBALS['sql_queries'] = 0;

    }

    /**
     * @throws \Exception
     */
    protected function doPhpVersionCheck() {
        if (version_compare(phpversion(),'5.2.0') < 0) {
            throw new \Exception('Minimum PHP version required is 5.2.0.  You are using PHP version  '. phpversion());
        }
    }
}