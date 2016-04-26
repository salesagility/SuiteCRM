<?php
/**
 * Created by Adam Jakab.
 * Date: 21/04/16
 * Time: 14.09
 */

namespace SuiteCrm\Install;
use SuiteCrm\Install\Extra\ExtraInterface;

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
    public static function executeExtraInstallation($config) {
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

        if(count($classes)) {
            foreach($classes as $class) {
                //echo "\nExecuting Extra: " . $class;
                /** @var ExtraInterface $instance */
                $instance = new $class();
                $instance->execute($config);
            }
        }

        //echo "\nQuickRepairAndRebuild...";
        require_once(PROJECT_ROOT . '/modules/Administration/QuickRepairAndRebuild.php');
        $actions = array('clearAll');
        $RAC = new \RepairAndClear();
        $RAC->repairAndClearAll($actions, array('All Modules'), true, false);
    }

    /**
     * @param array $config
     */
    public static function registerSuiteCrmConfiguration($config) {
        global $sugar_config;
        require(PROJECT_ROOT . '/sugar_version.php');
        require(PROJECT_ROOT . '/suitecrm_version.php');

        $sugar_config['default_max_tabs'] = 10;
        $sugar_config['sugar_version'] = $config['setup_sugar_version'];
        $sugar_config['suitecrm_version'] = $config['setup_suitecrm_version'];
        $sugar_config['sugarbeet'] = false;
        ksort($sugar_config);
        write_array_to_file('sugar_config', $sugar_config, 'config.php');
    }

    /**
     * @todo: list of modules must be moved out to $config
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
        $type = $config['setup_site_sugarbeet_automatic_checks'] ? 'automatic' : 'manual';
        set_CheckUpdates_config_setting($type);

        $admin = new \Administration();
        $admin->saveSetting('system', 'name', $config['setup_system_name']);
    }

    /**
     * @todo: all other default settings should be coming from $config
     * @todo - missing lang data!!!
     * @param array $config
     * @param array $lang - this is to be created
     */
    public static function registerAdvancedPasswordConfiguration($config, $lang=[])
    {
        /** @var array $sugar_config */
        global $sugar_config;

        $lang = [
            'advanced_password_new_account_email' =>  [
                'name' => 'System-generated password email',
                'description' => 'This template is used when the System Administrator sends a new password to a user.',
                'subject' => 'New account information',
                'txt_body' => '',
                'body' => '',
            ],
            'advanced_password_forgot_password_email' =>  [
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
        $id =$EmailTemp->save();
        $sugar_config['passwordsetting']['lostpasswordtmpl'] = $id;

        // set all other default settings
        $sugar_config['passwordsetting']['forgotpasswordON'] = true;
        $sugar_config['passwordsetting']['SystemGeneratedPasswordON'] = true;
        $sugar_config['passwordsetting']['systexpirationtime'] = 7;
        $sugar_config['passwordsetting']['systexpiration'] = 1;
        $sugar_config['passwordsetting']['linkexpiration'] = true;
        $sugar_config['passwordsetting']['linkexpirationtime'] = 24;
        $sugar_config['passwordsetting']['linkexpirationtype'] = 60;
        $sugar_config['passwordsetting']['minpwdlength'] = 6;
        $sugar_config['passwordsetting']['oneupper'] = false;
        $sugar_config['passwordsetting']['onelower'] = false;
        $sugar_config['passwordsetting']['onenumber'] = false;

        write_array_to_file("sugar_config", $sugar_config, "config.php");
    }

    /**
     * Fully enable SugarFeeds, enabling the user feed and all available modules that have SugarFeed data.
     */
    public static function enableSugarFeeds()
    {
        $admin = new \Administration();
        $admin->saveSetting('sugarfeed','enabled','1');

        foreach ( \SugarFeed::getAllFeedModules() as $module ) {
            \SugarFeed::activateModuleFeed($module);
        }

        check_logic_hook_file('Users','after_login', array(1, 'SugarFeed old feed entry remover', 'modules/SugarFeed/SugarFeedFlush.php', 'SugarFeedFlush', 'flushStaleEntries'));
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
    public static function registerLanguagePacks($config) {
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
    public static function createDate($year=null,$month=null,$day=null)
    {
        $timedate = \TimeDate::getInstance();
        $now = $timedate->getNow();
        if ($day==null) $day=$now->day+mt_rand(0,365);
        return $timedate->asDbDate($now->get_day_begin($day, $month, $year));
    }

    /**
     * @param int $hour
     * @param int $min
     * @param int $sec
     * @return string
     */
    public static function createTime($hour=null,$min=null,$sec=null)
    {
        $timedate = \TimeDate::getInstance();
        $date = $timedate->fromTimestamp(0);
        if ($hour==null) $hour=mt_rand(6,19);
        if ($min==null) $min=(mt_rand(0,3)*15);
        if ($sec==null) $sec=0;
        return $timedate->asDbTime($date->setDate(2007, 10, 7)->setTime($hour, $min, $sec));
    }

    /**
     * Remove all schedulers and create the new ones
     *
     * @param \DBManager $db
     * @param array $config
     */
    public static function rebuildDefaultSchedulers($db, $config) {
        $mod_strings = return_module_language($config["language"], 'Schedulers');

        // truncate scheduler-related tables - @todo: shouldn't be needed
        $db->query('DELETE FROM schedulers');

        $sched1 = new \Scheduler();
        $sched1->name               = $mod_strings['LBL_OOTB_WORKFLOW'];
        $sched1->job                = 'function::processAOW_Workflow';
        $sched1->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched1->date_time_end      = null;
        $sched1->job_interval       = '*::*::*::*::*';
        $sched1->status             = 'Active';
        $sched1->created_by         = '1';
        $sched1->modified_user_id   = '1';
        $sched1->catch_up           = '1';
        $sched1->save();

        $sched2 = new \Scheduler();
        $sched2->name               = $mod_strings['LBL_OOTB_REPORTS'];
        $sched2->job                = 'function::aorRunScheduledReports';
        $sched2->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched2->date_time_end      = null;
        $sched2->job_interval       = '*::*::*::*::*';
        $sched2->status             = 'Active';
        $sched2->created_by         = '1';
        $sched2->modified_user_id   = '1';
        $sched2->catch_up           = '1';
        $sched2->save();

        $sched3 = new \Scheduler();
        $sched3->name               = $mod_strings['LBL_OOTB_TRACKER'];
        $sched3->job                = 'function::trimTracker';
        $sched3->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched3->date_time_end      = null;
        $sched3->job_interval       = '0::2::1::*::*';
        $sched3->status             = 'Active';
        $sched3->created_by         = '1';
        $sched3->modified_user_id   = '1';
        $sched3->catch_up           = '1';
        $sched3->save();

        $sched4 = new \Scheduler();
        $sched4->name				= $mod_strings['LBL_OOTB_IE'];
        $sched4->job				= 'function::pollMonitoredInboxesAOP';
        $sched4->date_time_start	= self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched4->date_time_end		= null;
        $sched4->job_interval		= '*::*::*::*::*';
        $sched4->status				= 'Active';
        $sched4->created_by			= '1';
        $sched4->modified_user_id	= '1';
        $sched4->catch_up			= '0';
        $sched4->save();

        $sched5 = new \Scheduler();
        $sched5->name				= $mod_strings['LBL_OOTB_BOUNCE'];
        $sched5->job				= 'function::pollMonitoredInboxesForBouncedCampaignEmails';
        $sched5->date_time_start	= self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched5->date_time_end		= null;
        $sched5->job_interval		= '0::2-6::*::*::*';
        $sched5->status				= 'Active';
        $sched5->created_by			= '1';
        $sched5->modified_user_id	= '1';
        $sched5->catch_up			= '1';
        $sched5->save();

        $sched6 = new \Scheduler();
        $sched6->name				= $mod_strings['LBL_OOTB_CAMPAIGN'];
        $sched6->job				= 'function::runMassEmailCampaign';
        $sched6->date_time_start	= self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched6->date_time_end		= null;
        $sched6->job_interval		= '0::2-6::*::*::*';
        $sched6->status				= 'Active';
        $sched6->created_by			= '1';
        $sched6->modified_user_id	= '1';
        $sched6->catch_up			= '1';
        $sched6->save();

        $sched7 = new \Scheduler();
        $sched7->name               = $mod_strings['LBL_OOTB_PRUNE'];
        $sched7->job                = 'function::pruneDatabase';
        $sched7->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched7->date_time_end      = null;
        $sched7->job_interval       = '0::4::1::*::*';
        $sched7->status             = 'Inactive';
        $sched7->created_by         = '1';
        $sched7->modified_user_id   = '1';
        $sched7->catch_up           = '0';
        $sched7->save();

        $sched8 = new \Scheduler();
        $sched8->name               = $mod_strings['LBL_OOTB_LUCENE_INDEX'];
        $sched8->job                = 'function::aodIndexUnindexed';
        $sched8->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched8->date_time_end      = null;
        $sched8->job_interval       = "0::0::*::*::*";
        $sched8->status             = 'Active';
        $sched8->created_by         = '1';
        $sched8->modified_user_id   = '1';
        $sched8->catch_up           = '0';
        $sched8->save();

        $sched9 = new \Scheduler();
        $sched9->name               = $mod_strings['LBL_OOTB_OPTIMISE_INDEX'];
        $sched9->job                = 'function::aodOptimiseIndex';
        $sched9->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched9->date_time_end      = null;
        $sched9->job_interval       = "0::*/3::*::*::*";
        $sched9->status             = 'Active';
        $sched9->created_by         = '1';
        $sched9->modified_user_id   = '1';
        $sched9->catch_up           = '0';
        $sched9->save();

        $sched12 = new \Scheduler();
        $sched12->name               = $mod_strings['LBL_OOTB_SEND_EMAIL_REMINDERS'];
        $sched12->job                = 'function::sendEmailReminders';
        $sched12->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched12->date_time_end      = null;
        $sched12->job_interval       = '*::*::*::*::*';
        $sched12->status             = 'Active';
        $sched12->created_by         = '1';
        $sched12->modified_user_id   = '1';
        $sched12->catch_up           = '0';
        $sched12->save();

        $sched13 = new \Scheduler();
        $sched13->name               = $mod_strings['LBL_OOTB_CLEANUP_QUEUE'];
        $sched13->job                = 'function::cleanJobQueue';
        $sched13->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched13->date_time_end      = null;
        $sched13->job_interval       = '0::5::*::*::*';
        $sched13->status             = 'Active';
        $sched13->created_by         = '1';
        $sched13->modified_user_id   = '1';
        $sched13->catch_up           = '0';
        $sched13->save();

        $sched14 = new \Scheduler();
        $sched14->name              = $mod_strings['LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS'];
        $sched14->job               = 'function::removeDocumentsFromFS';
        $sched14->date_time_start   = self::createDate(2015, 1, 1) . ' ' . self::createTime(0, 0, 1);
        $sched14->date_time_end     = null;
        $sched14->job_interval      = '0::3::1::*::*';
        $sched14->status            = 'Active';
        $sched14->created_by        = '1';
        $sched14->modified_user_id  = '1';
        $sched14->catch_up          = '0';
        $sched14->save();

        $sched15 = new \Scheduler();
        $sched15->name               = $mod_strings['LBL_OOTB_SUGARFEEDS'];
        $sched15->job                = 'function::trimSugarFeeds';
        $sched15->date_time_start    = self::createDate(2015,1,1) . ' ' . self::createTime(0,0,1);
        $sched15->date_time_end      = null;
        $sched15->job_interval       = '0::2::1::*::*';
        $sched15->status             = 'Active';
        $sched15->created_by         = '1';
        $sched15->modified_user_id   = '1';
        $sched15->catch_up           = '1';
        $sched15->save();
    }

    /**
     * Create Admin user
     *
     * @param array $config
     * @return \User
     */
    public static function createAdministratorUser($config)
    {
        //Create default admin user
        $user = new \User();
        $user->id = 1;
        $user->new_with_id = true;
        $user->last_name = 'Administrator';
        $user->user_name = $config["setup_site_admin_user_name"];
        $user->title = "Administrator";
        $user->status = 'Active';
        $user->is_admin = true;
        $user->employee_status = 'Active';
        $user->user_hash = \User::getPasswordHash($config["setup_site_admin_password"]);
        $user->email = '';//@todo: a config for this would be good
        //$user->picture = UserDemoData::_copy_user_image($user->id);
        $user->save();

        //I'd get rid of this - let Administrator create users after login
        /*
        if( $create_default_user ){
            $default_user = new User();
            $default_user->last_name = $sugar_config['default_user_name'];
            $default_user->user_name = $sugar_config['default_user_name'];
            $default_user->status = 'Active';
            if( isset($sugar_config['default_user_is_admin']) && $sugar_config['default_user_is_admin'] ){
                $default_user->is_admin = true;
            }
            $default_user->user_hash = User::getPasswordHash($sugar_config['default_password']);
            $default_user->save();
        }
        */
        return $user;
    }

    /**
     * @todo: resolve and remove $sugar_db_version parameter from here (put it to $config)
     * @param \DBManager $db
     * @param array $config
     */
    public static function insertDefaultConfigSettings($db, $config, $sugar_db_version = null)
    {
        $sugar_db_version = $sugar_db_version ? $sugar_db_version : $config['setup_sugar_version'];

        $db->query("INSERT INTO config (category, name, value) VALUES ('notify', 'fromaddress', 'do_not_reply@example.com')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('notify', 'fromname', 'SuiteCRM')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('notify', 'send_by_default', '1')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('notify', 'on', '1')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('notify', 'send_from_assigning_user', '0')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('info', 'sugar_version', '" . $sugar_db_version . "')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('MySettings', 'tab', '')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('portal', 'on', '0')");
        $db->query("INSERT INTO config (category, name, value) VALUES ('tracker', 'Tracker', '1')");
        $db->query( "INSERT INTO config (category, name, value) VALUES ( 'system', 'skypeout_on', '1')" );
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
     * @param array $config
     * @throws \Exception
     */
    public static function handleSugarConfig($config)
    {
        /*
        global $bottle;
        global $cache_dir;
        global $mod_strings;
        global $setup_db_host_name;
        global $setup_db_host_instance;
        global $setup_db_port_num;
        global $setup_db_sugarsales_user;
        global $setup_db_sugarsales_password;
        global $setup_db_database_name;
        global $setup_site_host_name;
        global $setup_site_log_dir;
        global $setup_site_log_file;
        global $setup_site_session_path;
        global $setup_site_guid;
        global $setup_site_url;
        global $setup_sugar_version;
        global $setup_site_log_level;
        */

        /** @var array $sugar_config */
        global $sugar_config;

        // build default sugar_config
        $sugar_config = get_sugar_config_defaults();

        // always lock the installer
        $sugar_config['installer_locked'] = TRUE;

        // DATABASE
        $sugar_config['dbconfig']['db_host_name'] = $config["setup_db_host_name"];
        $sugar_config['dbconfig']['db_host_instance'] = $config["setup_db_host_instance"];
        $sugar_config['dbconfig']['db_user_name'] = $config["setup_db_admin_user_name"];
        $sugar_config['dbconfig']['db_password'] = $config["setup_db_admin_password"];
        $sugar_config['dbconfig']['db_name'] = $config["setup_db_database_name"];
        $sugar_config['dbconfig']['db_type'] = $config["setup_db_type"];
        $sugar_config['dbconfig']['db_port'] = $config["setup_db_port_num"];
        $sugar_config['dbconfig']['db_manager'] = $config["setup_db_manager"];
        if (!empty($config['setup_db_options'])) {
            $sugar_config['dbconfigoption'] = array_merge($sugar_config['dbconfigoption'], $config['setup_db_options']);
        }

        // GENERIC
        $sugar_config['cache_dir'] = sugar_cached("");
        $sugar_config['default_charset'] = $config['default_charset'];
        $sugar_config['default_email_client'] = 'sugar';
        $sugar_config['default_email_editor'] = 'html';
        $sugar_config['host_name'] = $config['setup_site_host_name'];
        $sugar_config['js_custom_version'] = '';
        $sugar_config['use_real_names'] = TRUE;
        $sugar_config['disable_convert_lead'] = FALSE;
        $sugar_config['log_dir'] = '.';
        $sugar_config['log_file'] = 'suitecrm.log';
        $sugar_config['enable_line_editing_detail'] = TRUE;
        $sugar_config['enable_line_editing_list'] = TRUE;

        $sugar_config['session_dir'] = $config['session_dir'];
        $sugar_config['site_url'] = $config['setup_site_url'];
        $sugar_config['sugar_version'] = $config['setup_sugar_version'];
        $sugar_config['tmp_dir'] = $sugar_config['cache_dir'] . 'xml/';//why 'xml'?
        $sugar_config['upload_dir'] = 'upload/';

        // FTS - @todo: check me!
        /*
        if (!empty($_SESSION['setup_fts_type'])) {
            $sugar_config['full_text_engine'] = array(
                $_SESSION['setup_fts_type'] => getFtsSettings()
            );
            if (isset($_SESSION['setup_fts_hide_config'])) {
                $sugar_config['hide_full_text_engine_config'] = $_SESSION['setup_fts_hide_config'];
            }
        }*/

        // Logger
        $sugar_config['logger'] = [
            'level' => $config['setup_site_log_level'],
            'file' => [
                'ext' => '.log',
                'name' => 'suitecrm',
                'dateFormat' => '%c',
                'maxSize' => '10MB',
                'maxLogs' => 10,
                'suffix' => ''
            ],
        ];

        //isn't this misspelled?
        $sugar_config['sugarbeet'] = FALSE;


        $sugar_config['unique_key'] = !empty($config['setup_site_guid'])
            ? $config['setup_site_guid']
            : md5(create_guid());


        // LANGUAGES
        // entry in upgrade_history comes AFTER table creation
        if (!empty($config['setup_installed_lang_packs'])) {
            foreach ($config['setup_installed_lang_packs'] as $langZip) {
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
        $table_created = false;
        if(!$db->tableExists($focus->table_name))
        {
            $focus->create_tables();
            $table_created = true;
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
        if( $result ){
            $focus->drop_tables();
            return 1;
        } else {
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
        if ($config['setup_db_type'] == 'mysql') {
            $db = self::getDatabaseConnection($config);
            $db->query("ALTER DATABASE `" . $config['setup_db_database_name'] . "` DEFAULT CHARACTER SET utf8", TRUE);
            $db->query(
                "ALTER DATABASE `" . $config['setup_db_database_name'] . "` DEFAULT COLLATE utf8_general_ci", TRUE
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
        if(
            !isset($config['setup_db_host_name']) ||
            !isset($config['setup_db_admin_user_name']) ||
            !isset($config['setup_db_admin_password']) ||
            !isset($config['setup_db_host_instance']) ||
            !isset($config['setup_db_port_num'])
        ) {
            throw new \Exception("Missing database configuration data!");
        }
        $dbconfig = array(
            "db_host_name" => $config['setup_db_host_name'],
            "db_user_name" => $config['setup_db_admin_user_name'],
            "db_password" => $config['setup_db_admin_password'],
            "db_host_instance" => $config['setup_db_host_instance'],
            "db_port" => $config['setup_db_port_num'],
        );
        if (empty($config['setup_db_database_name'])) {
            $dbconfig["db_name"] = $config['setup_db_database_name'];
        }

        $db = InstallUtils::getInstallDatabaseInstance(
            $config['setup_db_type'],
            ["db_manager" => $config['setup_db_manager']]
        );

        if (!empty($config['setup_db_options'])) {
            $db->setOptions($config['setup_db_options']);
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
            } else {
                return FALSE;
            }
        }
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

}
