<?php
/**
 * Created by Adam Jakab.
 * Date: 21/04/16
 * Time: 14.09
 */

namespace SuiteCrm\Install;

use SuiteCrm\Install\Extra\ExtraInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * Class InstallUtils
 * @package SuiteCrm\Install
 */
class InstallUtils
{
    /**
     * Start from here: /install/populateSeedData.php
     * and redo all of it
     */
    public static function installDemoData()
    {

    }

    /**
     * original function: post_install_modules in: install/install_utils.php:2053
     * "This method will look for a file modules_post_install.php in the root directory and based on the
     * contents of this file, it will silently install any modules as specified in this array."...
     *
     * Let's not do this... now we can use Extra classes to be pulled into installation automatically
     */
    public static function modulesPostInstall()
    {
        /*
        if(is_file('modules_post_install.php')){
            global $current_user, $mod_strings;
            $current_user = new User();
            $current_user->is_admin = '1';
            require_once('ModuleInstall/PackageManager/PackageManager.php');
            require_once('modules_post_install.php');
            //we now have the $modules_to_install array in memory
            $pm = new PackageManager();
            $old_mod_strings = $mod_strings;
            foreach($modules_to_install as $module_to_install){
                if(is_file($module_to_install)){
                    $pm->performSetup($module_to_install, 'module', false);
                    $file_to_install = sugar_cached('upload/upgrades/module/').basename($module_to_install);
                    $_REQUEST['install_file'] = $file_to_install;
                    $pm->performInstall($file_to_install);
                }
            }
            $mod_strings = $old_mod_strings;
        }
        */
    }

    /**
     * @todo: how do we ensure correct execution order?
     * @param array $config
     */
    public static function executeExtraInstallation($config)
    {
        $classes = [];
        $searchPath = realpath(PROJECT_ROOT . '/src/SuiteCrm/Install/Extra');
        $iterator = new \RecursiveDirectoryIterator($searchPath);
        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            if (strpos($file, '.php') !== FALSE) {
                if (is_file($file)) {
                    $extraClassPath = str_replace(PROJECT_ROOT . '/src/', '', $file);
                    $extraClassPath = str_replace('.php', '', $extraClassPath);
                    $extraClassPath = str_replace('/', '\\', $extraClassPath);
                    if (in_array('SuiteCrm\Install\Extra\ExtraInterface', class_implements($extraClassPath))) {
                        $classes[] = $extraClassPath;
                    }
                }
            }
        }

        if (count($classes)) {
            foreach ($classes as $class) {
                //echo "\nExecuting Extra: " . $class;
                /** @var ExtraInterface $instance */
                $instance = new $class();
                $instance->execute($config);
            }
        }

        require_once(PROJECT_ROOT . '/modules/Administration/QuickRepairAndRebuild.php');
        $actions = array('clearAll');
        $RAC = new \RepairAndClear();
        $RAC->repairAndClearAll($actions, array('All Modules'), TRUE, FALSE);
    }

    /**
     * @param array $config
     */
    public static function registerSuiteCrmConfiguration($config)
    {
        global $sugar_config;
        $sugar_config['default_max_tabs'] = 10;
        $sugar_config['sugar_version'] = $config['sugar_version'];
        $sugar_config['suitecrm_version'] = $config['suitecrm_version'];
        $sugar_config['sugarbeet'] = FALSE;
        ksort($sugar_config);
        write_array_to_file('sugar_config', $sugar_config, 'config.php');
    }

    /**
     * @todo: list of modules should be moved out to yml
     * @param array $config
     */
    public static function configureDefaultTabs($config)
    {
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

        require_once(PROJECT_ROOT . '/modules/MySettings/TabController.php');
        $tabs = new \TabController();
        $tabs->set_system_tabs($enabled_tabs);
    }

    /**
     * @param array $config
     */
    public static function registerAdministrationVariables($config)
    {
        $type = $config['install-check-updates'] ? 'automatic' : 'manual';
        set_CheckUpdates_config_setting($type);
        $admin = new \Administration();
        $admin->saveSetting('system', 'name', $config['install-system-name']);
        $admin->saveSetting('system', 'adminwizard', 1);
        $admin->saveConfig();
    }

    /**
     * @todo: all other default settings should be coming from $config
     * @todo - missing lang data!!!
     * @param array $config
     * @param array $lang - this is to be created
     */
    public static function registerAdvancedPasswordConfiguration($config, $lang = [])
    {
        /** @var array $sugar_config */
        global $sugar_config;

        $lang = [
            'advanced_password_new_account_email' => [
                'name' => 'System-generated password email',
                'description' => 'This template is used when the System Administrator sends a new password to a user.',
                'subject' => 'New account information',
                'txt_body' => '',
                'body' => '',
            ],
            'advanced_password_forgot_password_email' => [
                'name' => 'Forgot Password email',
                'description' => 'This template is used to send a user a link to click to reset the user\'s account password.',
                'subject' => 'Reset your account password',
                'txt_body' => '',
                'body' => '',
            ],
        ];


        //Sent when the admin generate a new password
        $EmailTemp = new \EmailTemplate();
        $EmailTemp->name = $lang['advanced_password_new_account_email']['name'];
        $EmailTemp->description = $lang['advanced_password_new_account_email']['description'];
        $EmailTemp->subject = $lang['advanced_password_new_account_email']['subject'];
        $EmailTemp->body = $lang['advanced_password_new_account_email']['txt_body'];
        $EmailTemp->body_html = $lang['advanced_password_new_account_email']['body'];
        $EmailTemp->deleted = 0;
        $EmailTemp->published = 'off';
        $EmailTemp->text_only = 0;
        $id = $EmailTemp->save();
        $sugar_config['passwordsetting']['generatepasswordtmpl'] = $id;

        //User generate a link to set a new password
        $EmailTemp = new \EmailTemplate();
        $EmailTemp->name = $lang['advanced_password_forgot_password_email']['name'];
        $EmailTemp->description = $lang['advanced_password_forgot_password_email']['description'];
        $EmailTemp->subject = $lang['advanced_password_forgot_password_email']['subject'];
        $EmailTemp->body = $lang['advanced_password_forgot_password_email']['txt_body'];
        $EmailTemp->body_html = $lang['advanced_password_forgot_password_email']['body'];
        $EmailTemp->deleted = 0;
        $EmailTemp->published = 'off';
        $EmailTemp->text_only = 0;
        $id = $EmailTemp->save();
        $sugar_config['passwordsetting']['lostpasswordtmpl'] = $id;

        // set all other default settings
        $sugar_config['passwordsetting']['forgotpasswordON'] = TRUE;
        $sugar_config['passwordsetting']['SystemGeneratedPasswordON'] = TRUE;
        $sugar_config['passwordsetting']['systexpirationtime'] = 7;
        $sugar_config['passwordsetting']['systexpiration'] = 1;
        $sugar_config['passwordsetting']['linkexpiration'] = TRUE;
        $sugar_config['passwordsetting']['linkexpirationtime'] = 24;
        $sugar_config['passwordsetting']['linkexpirationtype'] = 60;
        $sugar_config['passwordsetting']['minpwdlength'] = 6;
        $sugar_config['passwordsetting']['oneupper'] = FALSE;
        $sugar_config['passwordsetting']['onelower'] = FALSE;
        $sugar_config['passwordsetting']['onenumber'] = FALSE;

        write_array_to_file("sugar_config", $sugar_config, "config.php");
    }

    /**
     * Fully enable SugarFeeds, enabling the user feed and all available modules that have SugarFeed data.
     */
    public static function enableSugarFeeds()
    {
        $admin = new \Administration();
        $admin->saveSetting('sugarfeed', 'enabled', '1');

        foreach (\SugarFeed::getAllFeedModules() as $module) {
            \SugarFeed::activateModuleFeed($module);
        }

        check_logic_hook_file(
            'Users',
            'after_login',
            array(
                1,
                'SugarFeed old feed entry remover',
                'modules/SugarFeed/SugarFeedFlush.php',
                'SugarFeedFlush',
                'flushStaleEntries'
            )
        );
    }

    /**
     * Registers Language packs
     *
     * @todo: make me work! DISABLED
     * this is messy: install/install_utils.php:118
     *
     *
     * @param array $config
     */
    public static function registerLanguagePacks($config)
    {
        /*
        if(count($config['setup_installed_lang_packs']) > 0) {
            foreach($config['setup_installed_lang_packs'] as $k => $zipFile) {
                $new_upgrade = new \UpgradeHistory();
                $new_upgrade->filename      = $zipFile;
                $new_upgrade->md5sum        = md5_file($zipFile);
                $new_upgrade->type          = 'langpack';
                $new_upgrade->version       = $_SESSION['INSTALLED_LANG_PACKS_VERSION'][$k];
                $new_upgrade->status        = "installed";
                $new_upgrade->manifest      = $_SESSION['INSTALLED_LANG_PACKS_MANIFEST'][$k];
                $new_upgrade->save();
            }
        }
        */
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     * @return string
     */
    public static function createDate($year = NULL, $month = NULL, $day = NULL)
    {
        $timedate = \TimeDate::getInstance();
        $now = $timedate->getNow();
        if ($day == NULL) {
            $day = $now->day + mt_rand(0, 365);
        }
        return $timedate->asDbDate($now->get_day_begin($day, $month, $year));
    }

    /**
     * @param int $hour
     * @param int $min
     * @param int $sec
     * @return string
     */
    public static function createTime($hour = NULL, $min = NULL, $sec = NULL)
    {
        $timedate = \TimeDate::getInstance();
        $date = $timedate->fromTimestamp(0);
        if ($hour == NULL) {
            $hour = mt_rand(6, 19);
        }
        if ($min == NULL) {
            $min = (mt_rand(0, 3) * 15);
        }
        if ($sec == NULL) {
            $sec = 0;
        }
        return $timedate->asDbTime($date->setDate(2007, 10, 7)->setTime($hour, $min, $sec));
    }

    /**
     * Create Admin user
     *
     * @param \DBManager $db
     * @param array $config
     * @return \User
     */
    public static function createAdministratorUser($db, $config)
    {
        $res = $db->fetchOne('SELECT COUNT(*) AS C FROM users WHERE id = 1');
        $exists = ($res["C"] == 1);
        $user = new \User();
        if(!$exists) {
            $user->id = 1;
            $user->new_with_id = TRUE;
            $user->last_name = 'Administrator';
            $user->user_name = $config["install-admin-username"];
            $user->title = "Administrator";
            $user->status = 'Active';
            $user->is_admin = TRUE;
            $user->employee_status = 'Active';
            $user->user_hash = \User::getPasswordHash($config["install-admin-password"]);
            $user->email = '';//@todo: a config for this would be good
            $user->save();
        } else {
            $user->retrieve(1);
        }
        return $user;
    }

    /**
     * Inserts data fixtures into database from a specific fixture file
     * File Format:
     *   module_name:  [name of the module used to get the correct language file]
     *   bean_name:    [name of the bean to user for fixture registration]
     *   table_name:   [name of the database table]
     *   check_props:  [array of columns/props to use to check if fixture exists]
     *   fixtures:
     *      -
     *          [column1]:      [value1]
     *          [column2]:      [value2]
     *          [column3]:      [value3]
     *      -
     *          [column1]:      [value1]
     *          [column2]:      [value2]
     *          [column3]:      [value3]
     *      ...
     *
     *  Substitutions:
     *      Any value in the format of '%key%' will be checked and if found substituted with the
     *      value found in the $config array
     *      Any value in the format of 'LBL_.....' will be checked and if found substituted with the
     *      value found in the loaded $mod_strings for the specific module_name key
     *
     *  Dupe Checks:
     *      With check_props you can provide an array of columns/props to use to check if a fixture exists
     *
     * @param \DBManager $db
     * @param array      $config
     * @param string     $dataFile
     * @throws \Exception
     */
    public static function loadFixtures($db, $config, $dataFile)
    {
        $data = self::getYamlData($dataFile);
        if(!isset($data['module_name'])) {
            throw new \Exception("Key 'module_name' is missing from fixture definition!");
        }
        if(!isset($data['bean_name'])) {
            throw new \Exception("Key 'bean_name' is missing from fixture definition!");
        }
        if(!isset($data['table_name'])) {
            throw new \Exception("Key 'table_name' is missing from fixture definition!");
        }
        if(!isset($data['fixtures'])) {
            throw new \Exception("Key 'fixtures' is missing from fixture definition!");
        }

        $moduleName = $data['module_name'];
        $beanName = $data['bean_name'];
        $tableName = $data['table_name'];

        if(empty($beanName) && empty($tableName)) {
            throw new \Exception("Both 'bean_name' and 'table_name' keys are empty!");
        }

        //load language for module
        $mod_strings = [];
        if(!empty($moduleName)) {
            $mod_strings = return_module_language($config["language"], $moduleName);
        }

        //substitutions
        foreach ($data["fixtures"] as &$fixture) {
            $fixture = self::doFixtureVariableSubstitutions($fixture, $config);
            $fixture = self::doFixtureLanguageSubstitutions($fixture, $mod_strings);
        }

        //execute the proper fixture loader
        if(!empty($beanName)) {
            self::loadFixturesBean($db, $data);
        } else {
            self::loadFixturesDatabase($db, $data);
        }
    }

    /**
     * @param \DBManager $db
     * @param array      $data
     */
    protected static function loadFixturesDatabase($db, $data)
    {
        $checkProps = false;
        $checkSql = false;
        if(isset($data['check_props']) && is_array($data['check_props']) && count($data['check_props'])) {
            $checkProps = $data['check_props'];
            $checkSql = 'SELECT COUNT(*) CNT FROM `' . $data["table_name"] . '` WHERE {WHERE}';
        }
        foreach ($data["fixtures"] as $fixture) {
            $doInsert = true;

            //check if record exists
            if(is_array($checkProps)) {
                $where = '';
                foreach ($checkProps as $prop) {
                    if(isset($fixture[$prop])) {
                        $where .= $prop . '=' . '\''  . $fixture[$prop] . '\'' . ' AND ';
                    }
                }
                $where = substr($where, 0, -5);//remove trailing ' AND '
                $sql = str_replace('{WHERE}', $where, $checkSql);
                $res = $db->getOne($sql);
                $doInsert = ($res == 0);
            }

            $sql = false;
            if($doInsert) {
                //insert fixture
                $sql = 'INSERT INTO `' . $data["table_name"] . '`'
                             . ' (' . implode(', ', array_keys($fixture)) . ')'
                             . ' VALUES ('
                             . '\'' . implode('\', \'', array_values($fixture)) . '\''
                             . ')';
            } else {
                //we can only do this if we have $checkProps
                if(is_array($checkProps)) {
                    //update fixture
                    $sql = 'UPDATE `' . $data["table_name"] . '` SET {SET} WHERE {WHERE}';
                    $updateFields = array_diff(array_keys($fixture), $checkProps);

                    $set = '';
                    foreach ($updateFields as $prop) {
                        if(isset($fixture[$prop])) {
                            $set .= $prop . '=' . '\''  . $fixture[$prop] . '\'' . ', ';
                        }
                    }
                    $set = substr($set, 0, -2);//remove trailing ', '

                    $where = '';
                    foreach ($checkProps as $prop) {
                        if(isset($fixture[$prop])) {
                            $where .= $prop . '=' . '\''  . $fixture[$prop] . '\'' . ' AND ';
                        }
                    }
                    $where = substr($where, 0, -5);//remove trailing ' AND '
                    $sql = str_replace(['{SET}', '{WHERE}'], [$set, $where], $sql);
                }
            }
            if($sql) {
                $db->query($sql);
            }
        }
    }

    /**
     * @param \DBManager $db
     * @param array      $data
     */
    protected static function loadFixturesBean($db, $data)
    {
        $beanName = $data['bean_name'];
        $checkProps = false;
        if(isset($data['check_props']) && is_array($data['check_props']) && count($data['check_props'])) {
            $checkProps = $data['check_props'];
        }

        foreach ($data["fixtures"] as $fixture) {
            /** @var \SugarBean $bean */
            $bean = new $beanName();

            //check if record exists
            if(is_array($checkProps)) {
                $checkFields = [];
                foreach ($checkProps as $k) {
                    if(isset($fixture[$k])) {
                        $checkFields[$k] = $fixture[$k];
                    }
                }
                $res = $bean->retrieve_by_string_fields($checkFields);
                if(!is_null($res)) {
                    $bean = $res;
                }
            }

            //set fixture data and save Bean
            foreach ($fixture as $k => $v) {
                $bean->$k = $v;
            }
            $bean->save();
        }
    }

    /**
     * @param array $fixture
     * @param array $substitutes
     * @return array
     */
    protected static function doFixtureVariableSubstitutions($fixture, $substitutes) {
        if (count($substitutes)) {
            foreach ($fixture as $k => $v) {
                if (preg_match('#^%.*%$#', $v)) {
                    $substKey = substr($v, 1, -1);
                    if (array_key_exists($substKey, $substitutes)) {
                        $fixture[$k] = $substitutes[$substKey];
                    }
                }
            }
        }
        return $fixture;
    }

    /**
     * @param array $fixture
     * @param array $substitutes
     * @return array
     */
    protected static function doFixtureLanguageSubstitutions($fixture, $substitutes) {
        if (count($substitutes)) {
            foreach ($fixture as $k => $v) {
                if (preg_match('#^LBL_#', $v)) {
                    $substKey = $v;
                    if (array_key_exists($substKey, $substitutes)) {
                        $fixture[$k] = $substitutes[$substKey];
                    }
                }
            }
        }
        return $fixture;
    }

    /**
     * @todo: write template file for this: load, substitute, save
     * Overwrite the .htaccess file to prevent browser access to the log file
     */
    public static function handleHtaccess()
    {
        /** @var array $sugar_config */
        global $sugar_config;

        $htaccess_file = ".htaccess";

        //@todo: we don't know about SERVER_SOFTWARE
        //$ignoreCase = (substr_count(strtolower($_SERVER['SERVER_SOFTWARE']), 'apache/2') > 0) ? '(?i)' : '';
        $ignoreCase = '';

        $basePath = parse_url($sugar_config['site_url'], PHP_URL_PATH);
        if (empty($basePath)) {
            $basePath = '/';
        }

        $tab = "\t";

        $restrict = [];
        $restrict[] = '# BEGIN SUGARCRM RESTRICTIONS';
        if (ini_get('suhosin.perdir') !== FALSE && strpos(ini_get('suhosin.perdir'), 'e') !== FALSE) {
            $restrict[] = "php_value suhosin.executor.include.whitelist upload";
        }
        $restrict[] = "RedirectMatch 403 {$ignoreCase}.*\\.log$";
        $restrict[] = "RedirectMatch 403 {$ignoreCase}/+not_imported_.*\\.txt";
        $restrict[] = "RedirectMatch 403 {$ignoreCase}/+(soap|cache|xtemplate|data|examples|include|log4php|metadata|modules)/+.*\\.(php|tpl)";
        $restrict[] = "RedirectMatch 403 {$ignoreCase}/+emailmandelivery\\.php";
        $restrict[] = "RedirectMatch 403 {$ignoreCase}/+upload";
        $restrict[] = "RedirectMatch 403 {$ignoreCase}/+custom/+blowfish";
        $restrict[] = "RedirectMatch 403 {$ignoreCase}/+cache/+diagnostic";
        $restrict[] = "RedirectMatch 403 {$ignoreCase}/+files\\.md5$";
        $restrict[] = "# END SUGARCRM RESTRICTIONS";
        $restrict[] = "";


        $cache = [];
        $cache[] = "<IfModule mod_rewrite.c>";
        $cache[] = $tab . "Options +FollowSymLinks";
        $cache[] = $tab . "RewriteEngine On";
        $cache[] = $tab . "RewriteBase {$basePath}";
        $cache[] = $tab
                   . "RewriteRule ^cache/jsLanguage/(.._..).js$ index.php?entryPoint=jslang&module=app_strings&lang=$1 [L,QSA]";
        $cache[] = $tab
                   . "RewriteRule ^cache/jsLanguage/(\\w*)/(.._..).js$ index.php?entryPoint=jslang&module=$1&lang=$2 [L,QSA]";
        $cache[] = "</IfModule>";
        $cache[] = "";
        $cache[] = "<FilesMatch \"\\.(jpg|png|gif|js|css|ico)$\">";
        $cache[] = $tab . "<IfModule mod_headers.c>";
        $cache[] = $tab . $tab . "Header set ETag \"\"";
        $cache[] = $tab . $tab . "Header set Cache-Control \"max-age=2592000\"";
        $cache[] = $tab . $tab . "Header set Expires \"01 Jan 2112 00:00:00 GMT\"";
        $cache[] = $tab . "</IfModule>";
        $cache[] = "</FilesMatch>";
        $cache[] = "";
        $cache[] = "<IfModule mod_expires.c>";
        $cache[] = $tab . "ExpiresByType text/css \"access plus 1 month\"";
        $cache[] = $tab . "ExpiresByType text/javascript \"access plus 1 month\"";
        $cache[] = $tab . "ExpiresByType application/x-javascript \"access plus 1 month\"";
        $cache[] = $tab . "ExpiresByType image/gif \"access plus 1 month\"";
        $cache[] = $tab . "ExpiresByType image/jpg \"access plus 1 month\"";
        $cache[] = $tab . "ExpiresByType image/png \"access plus 1 month\"";
        $cache[] = "</IfModule>";
        $cache[] = "";

        $contents = implode("\n", $restrict);
        $contents .= implode("\n", $cache);
        file_put_contents($htaccess_file, $contents);
    }

    /**
     * @todo: write template file for this: load, substitute, save
     * Overwrite the web.config file to prevent browser access to the log file
     */
    public static function handleWebConfig()
    {
        /** @var array $sugar_config */
        global $sugar_config;

        $setup_site_log_file = $sugar_config['log_file'];
        $setup_site_log_dir = $sugar_config['log_dir'];
        $prefix = $setup_site_log_dir . empty($setup_site_log_dir) ? '' : '/';

        $config_array = array(
            array(
                '1' => $prefix . str_replace('.', '\\.', $setup_site_log_file) . '\\.*',
                '2' => 'log_file_restricted.html'
            ),
            array('1' => $prefix . 'install.log', '2' => 'log_file_restricted.html'),
            array('1' => $prefix . 'upgradeWizard.log', '2' => 'log_file_restricted.html'),
            array('1' => $prefix . 'emailman.log', '2' => 'log_file_restricted.html'),
            array('1' => 'not_imported_.*.txt', '2' => 'log_file_restricted.html'),
            array('1' => 'XTemplate/(.*)/(.*).php', '2' => 'index.php'),
            array('1' => 'data/(.*).php', '2' => 'index.php'),
            array('1' => 'examples/(.*).php', '2' => 'index.php'),
            array('1' => 'include/(.*).php', '2' => 'index.php'),
            array('1' => 'include/(.*)/(.*).php', '2' => 'index.php'),
            array('1' => 'log4php/(.*).php', '2' => 'index.php'),
            array('1' => 'log4php/(.*)/(.*)', '2' => 'index.php'),
            array('1' => 'metadata/(.*)/(.*).php', '2' => 'index.php'),
            array('1' => 'modules/(.*)/(.*).php', '2' => 'index.php'),
            array('1' => 'soap/(.*).php', '2' => 'index.php'),
            array('1' => 'emailmandelivery.php', '2' => 'index.php'),
            array('1' => 'cron.php', '2' => 'index.php'),
            array('1' => $sugar_config['upload_dir'] . '.*', '2' => 'index.php'),
        );


        $xmldoc = new \XMLWriter();
        $xmldoc->openURI('web.config');
        $xmldoc->setIndent(TRUE);
        $xmldoc->setIndentString(' ');
        $xmldoc->startDocument('1.0', 'UTF-8');
        $xmldoc->startElement('configuration');
        $xmldoc->startElement('system.webServer');
        $xmldoc->startElement('rewrite');
        $xmldoc->startElement('rules');
        for ($i = 0; $i < count($config_array); $i++) {
            $xmldoc->startElement('rule');
            $xmldoc->writeAttribute('name', "redirect$i");
            $xmldoc->writeAttribute('stopProcessing', 'true');
            $xmldoc->startElement('match');
            $xmldoc->writeAttribute('url', $config_array[$i]['1']);
            $xmldoc->endElement();
            $xmldoc->startElement('action');
            $xmldoc->writeAttribute('type', 'Redirect');
            $xmldoc->writeAttribute('url', $config_array[$i]['2']);
            $xmldoc->writeAttribute('redirectType', 'Found');
            $xmldoc->endElement();
            $xmldoc->endElement();
        }
        $xmldoc->endElement();
        $xmldoc->endElement();
        $xmldoc->startElement('caching');
        $xmldoc->startElement('profiles');
        $xmldoc->startElement('remove');
        $xmldoc->writeAttribute('extension', ".php");
        $xmldoc->endElement();
        $xmldoc->endElement();
        $xmldoc->endElement();
        $xmldoc->startElement('staticContent');
        $xmldoc->startElement("clientCache");
        $xmldoc->writeAttribute('cacheControlMode', 'UseMaxAge');
        $xmldoc->writeAttribute('cacheControlMaxAge', '30.00:00:00');
        $xmldoc->endElement();
        $xmldoc->endElement();
        $xmldoc->endElement();
        $xmldoc->endElement();
        $xmldoc->endDocument();
        $xmldoc->flush();
    }


    /**
     * @todo: quite weak - we need $sugar_config compliant $config from install_defaults.yml so we can map it over
     * @todo: all that is hardcoded here must be moved out to install_defaults.yml config section
     *
     * Generates config.php
     *
     * @param array $configOverride
     * @throws \Exception
     */
    public static function createDefaultSugarConfig($configOverride)
    {

        /** @var array $sugar_config */
        global $sugar_config;

        // load the default configuration
        //$sugar_config = get_sugar_config_defaults();
        $sugar_config = self::getYamlData("default_sugar_config.yml");

        // always lock the installer
        $sugar_config['installer_locked'] = TRUE;

        //MERGE WITH OVERRIDE - (ONLY KEYS THAT EXIST IN $sugar_config)
        $sugar_config = array_merge($sugar_config, array_intersect_key($configOverride, $sugar_config));

        // SET DATABASE RELATED OPTIONS
        $sugar_config['dbconfig']['db_host_name'] = $configOverride["database-host"];
        $sugar_config['dbconfig']['db_host_instance'] = $configOverride["database-host-instance"];
        $sugar_config['dbconfig']['db_user_name'] = $configOverride["database-username"];
        $sugar_config['dbconfig']['db_password'] = $configOverride["database-password"];
        $sugar_config['dbconfig']['db_name'] = $configOverride["database-name"];
        $sugar_config['dbconfig']['db_type'] = $configOverride["database-type"];
        $sugar_config['dbconfig']['db_port'] = $configOverride["database-port"];
        $sugar_config['dbconfig']['db_manager'] = $configOverride["database-manager"];
        if (!empty($configOverride['database-options'])) {
            $sugar_config['dbconfigoption'] = array_merge(
                $sugar_config['dbconfigoption'], $configOverride['database-options']
            );
        }


        // SET INSTALLER RELATED OPTIONS
        $sugar_config['host_name'] = $configOverride['install-host-name'];
        $sugar_config['site_url'] = 'http://' . $configOverride['install-host-name'];


        // SET DYNAMIC OPTIONS
        $sugar_config['unique_key'] = isset($configOverride['setup_site_guid'])
            ? $configOverride['setup_site_guid']
            : md5(create_guid());

        // LANGUAGES
        // entry in upgrade_history comes AFTER table creation
        if (!empty($configOverride['setup_installed_lang_packs'])) {
            foreach ($configOverride['setup_installed_lang_packs'] as $langZip) {
                $lang = self::getSugarConfigLanguageArray($langZip);
                if (!empty($lang)) {
                    $exLang = explode('::', $lang);
                    if (is_array($exLang) && count($exLang) == 3) {
                        $sugar_config['languages'][$exLang[0]] = $exLang[1];
                    }
                }
            }
        }

        ksort($sugar_config);
        write_array_to_file("sugar_config", $sugar_config, "config.php");
        if (!file_exists('config.php')) {
            throw new \Exception("Unable to write Config.php file!");
        }
    }

    /**
     * @param string $langZip
     * @return string
     */
    public static function getSugarConfigLanguageArray($langZip)
    {
        $answer = '';
        $manifestFilePath = remove_file_extension($langZip) . "-manifest.php";
        if (is_file($manifestFilePath)) {
            include($manifestFilePath);
            if (isset($installdefs['id']) && isset($manifest['name']) && $manifest['version']) {
                $answer = $installdefs['id'] . "::" . $manifest['name'] . "::" . $manifest['version'];
            }
        }
        return $answer;
    }

    /**
     * Create tables of a bean
     *
     * @param \DBManager $db
     * @param \SugarBean $focus
     * @return bool
     */
    public static function createBeanTables($db, &$focus)
    {
        $table_created = FALSE;
        if (!$db->tableExists($focus->table_name)) {
            $focus->create_tables();
            $table_created = TRUE;
        }
        return $table_created;
    }

    /**
     * Drop tables of a bean
     *
     * @param \DBManager $db
     * @param \SugarBean $focus
     * @return int
     */
    public static function dropBeanTables($db, &$focus)
    {
        $result = $db->tableExists($focus->table_name);
        if ($result) {
            $focus->drop_tables();
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * MYSQL ONLY - Ensures that the charset and collation for a given database is set
     *
     * @param array $config
     */
    public static function handleDbCharsetCollation($config)
    {
        if ($config['database-type'] == 'mysql') {
            $db = self::getDatabaseConnection($config);
            $db->query("ALTER DATABASE `" . $config['database-name'] . "` DEFAULT CHARACTER SET utf8", TRUE);
            $db->query(
                "ALTER DATABASE `" . $config['database-name'] . "` DEFAULT COLLATE utf8_general_ci", TRUE
            );
        }
    }

    /**
     * @param array $config
     * @throws \Exception
     * @return \DBManager
     */
    public static function getDatabaseConnection($config)
    {
        if (
            !isset($config['database-username']) || !isset($config['database-host-instance'])
            || !isset($config['database-port'])
        ) {
            throw new \Exception("Missing database configuration data!");
        }
        $dbconfig = array(
            "db_host_name" => $config['database-host'],
            "db_user_name" => $config['database-username'],
            "db_password" => $config['database-password'],
            "db_host_instance" => $config['database-host-instance'],
            "db_port" => $config['database-port'],
        );

        if (!empty($config['database-name'])) {
            $dbconfig["db_name"] = $config['database-name'];
        }

        $db = InstallUtils::getInstallDatabaseInstance(
            $config['database-type'],
            [
                "db_manager" => isset($config['database-manager']) ? $config['database-manager'] : null
            ]
        );

        if (!empty($config['database-options'])) {
            $db->setOptions($config['database-options']);
        }
        $db->connect($dbconfig, TRUE);
        return $db;
    }

    /**
     * @param string $type
     * @param array  $config
     * @return \DBManager
     */
    public static function getInstallDatabaseInstance($type, $config)
    {
        return \DBManagerFactory::getTypeInstance($type, $config);
    }


    /**
     * check/fix file folder permissions
     */
    public static function ensureFileFolderStates() {
        self::makeWritable(PROJECT_ROOT . '/config.php');
        self::makeWritable(PROJECT_ROOT . '/custom');
        self::makeWritableRecursive(PROJECT_ROOT . '/modules');
        self::createWritableDir(PROJECT_ROOT . '/logs');
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('custom_fields'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('dyn_lay'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('images'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('modules'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('layout'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('pdf'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('upload'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('upload/import'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('xml'));
        self::createWritableDir(PROJECT_ROOT . '/' . sugar_cached('include/javascript'));
        self::makeWritableRecursive(PROJECT_ROOT . '/' . sugar_cached('modules'));
    }


    /**
     * @param string $dirname
     * @throws \Exception
     */
    public static function createWritableDir($dirname)
    {
        if (!is_dir($dirname)) {
            @sugar_mkdir($dirname, 0755);
        }
        self::makeWritable($dirname);
    }

    /**
     * @param string $start_file
     * @throws \Exception
     */
    public static function makeWritableRecursive($start_file)
    {
        self::makeWritable($start_file);

        if (is_dir($start_file)) {
            $files = array();
            $dh = opendir($start_file);
            $filename = readdir($dh);
            while (!empty($filename)) {
                if ($filename != '.' && $filename != '..' && $filename != '.svn') {
                    $files[] = $filename;
                }
                $filename = readdir($dh);
            }

            foreach ($files as $file) {
                self::makeWritableRecursive($start_file . '/' . $file);
            }
        }
    }

    /**
     * Returns true if the given file/dir has been made writable (or is already writable)
     *
     * @param string $file
     * @throws \Exception
     */
    public static function makeWritable($file)
    {
        if (is_file($file) || is_dir($file)) {
            if (!is_writable($file)) {
                $original_fileperms = fileperms($file);
                // add user writable permission
                $new_fileperms = $original_fileperms | 0x0080;
                @sugar_chmod($file, $new_fileperms);
                clearstatcache();
                if (!is_writable($file)) {
                    // add group writable permission
                    $new_fileperms = $original_fileperms | 0x0010;
                    @chmod($file, $new_fileperms);
                    clearstatcache();
                    if (!is_writable($file)) {
                        // add world writable permission
                        $new_fileperms = $original_fileperms | 0x0002;
                        @chmod($file, $new_fileperms);
                        clearstatcache();
                    }
                }
            }
            if (!is_writable($file)) {
                throw new \Exception("Unable to make file writable: " . $file);
            }
        }
    }

    /**
     * Calls a custom function (if it exists) based on the first parameter,
     *   and returns result of function call, or false if the function doesn't exist
     *
     * @param string $function_name - function to call in custom install hooks
     * @param array  $options - function to call in custom install hooks
     * @return mixed function call result, or 'undefined'
     */
    public static function installerHook($function_name, $options = [])
    {
        if (!isset($GLOBALS['customInstallHooksExist'])) {
            if (file_exists(PROJECT_ROOT . '/custom/install/install_hooks.php')) {
                require_once(PROJECT_ROOT - '/custom/install/install_hooks.php');
                $GLOBALS['customInstallHooksExist'] = TRUE;
            }
            else {
                $GLOBALS['customInstallHooksExist'] = FALSE;
            }
        }

        if ($GLOBALS['customInstallHooksExist'] === FALSE) {
            return FALSE;
        }
        else {
            if (function_exists($function_name)) {
                return call_user_func_array($function_name, $options);
            }
            else {
                return FALSE;
            }
        }
    }

    /**
     * Reads in any yml file from the yml directory
     *
     * @param string $fileName
     * @throws \Exception
     * @return array
     */
    public static function getYamlData($fileName)
    {
        $configFilePath = dirname(__FILE__) . '/Resources/yml/' . $fileName;
        if (!file_exists($configFilePath)) {
            throw new \Exception("Config file($fileName) not found!");
        }
        $parser = new Parser();
        return $parser->parse(file_get_contents($configFilePath));
    }
}
