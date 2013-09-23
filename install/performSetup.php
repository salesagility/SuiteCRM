<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/



// This file will load the configuration settings from session data,
// write to the config file, and execute any necessary database steps.
$GLOBALS['installing'] = true;
if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}
ini_set("output_buffering","0");
set_time_limit(3600);
// flush after each output so the user can see the progress in real-time
ob_implicit_flush();





require_once('install/install_utils.php');

require_once('modules/TableDictionary.php');


$trackerManager = TrackerManager::getInstance();
$trackerManager->pause();


$cache_dir                          = sugar_cached("");
$line_entry_format                  = "&nbsp&nbsp&nbsp&nbsp&nbsp<b>";
$line_exit_format                   = "... &nbsp&nbsp</b>";
$rel_dictionary                 = $dictionary; // sourced by modules/TableDictionary.php
$render_table_close             = "";
$render_table_open                  = "";
$setup_db_admin_password            = $_SESSION['setup_db_admin_password'];
$setup_db_admin_user_name           = $_SESSION['setup_db_admin_user_name'];
$setup_db_create_database           = $_SESSION['setup_db_create_database'];
$setup_db_create_sugarsales_user    = $_SESSION['setup_db_create_sugarsales_user'];
$setup_db_database_name             = $_SESSION['setup_db_database_name'];
$setup_db_drop_tables               = $_SESSION['setup_db_drop_tables'];
$setup_db_host_instance             = $_SESSION['setup_db_host_instance'];
$setup_db_port_num                  = $_SESSION['setup_db_port_num'];
$setup_db_host_name                 = $_SESSION['setup_db_host_name'];
$demoData                           = $_SESSION['demoData'];
$setup_db_sugarsales_password       = $_SESSION['setup_db_sugarsales_password'];
$setup_db_sugarsales_user           = $_SESSION['setup_db_sugarsales_user'];
$setup_site_admin_user_name         = $_SESSION['setup_site_admin_user_name'];
$setup_site_admin_password          = $_SESSION['setup_site_admin_password'];
$setup_site_guid                    = (isset($_SESSION['setup_site_specify_guid']) && $_SESSION['setup_site_specify_guid'] != '') ? $_SESSION['setup_site_guid'] : '';
$setup_site_url                     = $_SESSION['setup_site_url'];
$parsed_url                         = parse_url($setup_site_url);
$setup_site_host_name               = $parsed_url['host'];
$setup_site_log_dir                 = isset($_SESSION['setup_site_custom_log_dir']) ? $_SESSION['setup_site_log_dir'] : '.';
$setup_site_log_file                = 'sugarcrm.log';  // may be an option later
$setup_site_session_path            = isset($_SESSION['setup_site_custom_session_path']) ? $_SESSION['setup_site_session_path'] : '';
$setup_site_log_level				='fatal';

sugar_cache_clear('TeamSetsCache');
if ( file_exists($cache_dir .'modules/Teams/TeamSetCache.php') ) {
	unlink($cache_dir.'modules/Teams/TeamSetCache.php');
}

sugar_cache_clear('TeamSetsMD5Cache');
if ( file_exists($cache_dir.'modules/Teams/TeamSetMD5Cache.php') ) {
	unlink($cache_dir.'modules/Teams/TeamSetMD5Cache.php');
}
$langHeader = get_language_header();
$out =<<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Script-Type" content="text/javascript">
   <meta http-equiv="Content-Style-Type" content="text/css">
    <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_PERFORM_TITLE']}</title>
   <link REL="SHORTCUT ICON" HREF="$icon">
   <link rel="stylesheet" href="$css" type="text/css" />
   <script type="text/javascript" src="$common"></script>
</head>
<body onload="javascript:document.getElementById('button_next2').focus();">
<table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
      <tr><td colspan="2" id="help"><a href="{$help_url}" target='_blank'>{$mod_strings['LBL_HELP']} </a></td></tr>
    <tr>
      <th width="500">
		<p>
		<img src="{$sugar_md}" alt="SugarCRM" border="0">
		</p>
		{$mod_strings['LBL_PERFORM_TITLE']}</th>
    <th width="200" style="text-align: right;"><a href="http://www.sugarcrm.com" target="_blank">
    <IMG src="$loginImage" alt="SugarCRM" border="0"></a></th>
</tr>
<tr>
   <td colspan="2">
EOQ;
echo $out;
installLog("calling handleSugarConfig()");
$bottle = handleSugarConfig();
installLog("calling handleLog4Php()");
handleLog4Php();

$server_software = $_SERVER["SERVER_SOFTWARE"];
if(strpos($server_software,'Microsoft-IIS') !== false)
{
    installLog("calling handleWebConfig()");
	handleWebConfig();
} else {
	installLog("calling handleHtaccess()");
    handleHtaccess();
}

///////////////////////////////////////////////////////////////////////////////
////    START TABLE STUFF
echo "<br>";
echo "<b>{$mod_strings['LBL_PERFORM_TABLES']}</b>";
echo "<br>";

// create the SugarCRM database
if($setup_db_create_database) {
    installLog("calling handleDbCreateDatabase()");
    installerHook('pre_handleDbCreateDatabase');
    handleDbCreateDatabase();
    installerHook('post_handleDbCreateDatabase');
} else {

// ensure the charset and collation are utf8
    installLog("calling handleDbCharsetCollation()");
    installerHook('pre_handleDbCharsetCollation');
    handleDbCharsetCollation();
    installerHook('post_handleDbCharsetCollation');
}

// create the SugarCRM database user
if($setup_db_create_sugarsales_user){
    installerHook('pre_handleDbCreateSugarUser');
    handleDbCreateSugarUser();
    installerHook('post_handleDbCreateSugarUser');
}

foreach( $beanFiles as $bean => $file ){
    require_once( $file );
}

// load up the config_override.php file.
// This is used to provide default user settings
if( is_file("config_override.php") ){
    require_once("config_override.php");
}

$db                 = DBManagerFactory::getInstance();
$startTime          = microtime(true);
$focus              = 0;
$processed_tables   = array(); // for keeping track of the tables we have worked on
$empty              = '';
$new_tables     = 1; // is there ever a scenario where we DON'T create the admin user?
$new_config         = 1;
$new_report     = 1;

// add non-module Beans to this array to keep the installer from erroring.
$nonStandardModules = array (
    //'Tracker',
);


/**
 * loop through all the Beans and create their tables
 */
 installLog("looping through all the Beans and create their tables");
 //start by clearing out the vardefs
 VardefManager::clearVardef();
installerHook('pre_createAllModuleTables');
foreach( $beanFiles as $bean => $file ) {
	$doNotInit = array('Scheduler', 'SchedulersJob', 'ProjectTask');

	if(in_array($bean, $doNotInit)) {
		$focus = new $bean(false);
	} else {
	    $focus = new $bean();
	}

	if ( $bean == 'Configurator' )
	    continue;

    $table_name = $focus->table_name;
     installLog("processing table ".$focus->table_name);
    // check to see if we have already setup this table
    if(!in_array($table_name, $processed_tables)) {
        if(!file_exists("modules/".$focus->module_dir."/vardefs.php")){
            continue;
        }
        if(!in_array($bean, $nonStandardModules)) {
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
            installLog("dropping table ".$focus->table_name);
        }

        if(create_table_if_not_exist($focus)) {
            installLog("creating table ".$focus->table_name);
            if( $bean == "User" ){
                $new_tables = 1;
            }
            if($bean == "Administration")
                $new_config = 1;


        }

        installLog("creating Relationship Meta for ".$focus->getObjectName());
        installerHook('pre_createModuleTable', array('module' => $focus->getObjectName()));
        SugarBean::createRelationshipMeta($focus->getObjectName(), $db, $table_name, $empty, $focus->module_dir);
        installerHook('post_createModuleTable', array('module' => $focus->getObjectName()));
		echo ".";

    } // end if()
}
installerHook('post_createAllModuleTables');

echo "<br>";
////    END TABLE STUFF

///////////////////////////////////////////////////////////////////////////////
////    START RELATIONSHIP CREATION

    ksort($rel_dictionary);
    foreach( $rel_dictionary as $rel_name => $rel_data ){
        $table = $rel_data['table'];

        if( $setup_db_drop_tables ){
            if( $db->tableExists($table) ){
                $db->dropTableName($table);
            }
        }

        if( !$db->tableExists($table) ){
            $db->createTableParams($table, $rel_data['fields'], $rel_data['indices']);
        }

        SugarBean::createRelationshipMeta($rel_name,$db,$table,$rel_dictionary,'');
    }

///////////////////////////////////////////////////////////////////////////////
////    START CREATE DEFAULTS
    echo "<br>";
    echo "<b>{$mod_strings['LBL_PERFORM_CREATE_DEFAULT']}</b><br>";
    echo "<br>";
    installLog("Begin creating Defaults");
    installerHook('pre_createDefaultSettings');
    if ($new_config) {
        installLog("insert defaults into config table");
        insert_default_settings();
    }
    installerHook('post_createDefaultSettings');





    installerHook('pre_createUsers');
    if ($new_tables) {
        echo $line_entry_format.$mod_strings['LBL_PERFORM_DEFAULT_USERS'].$line_exit_format;
        installLog($mod_strings['LBL_PERFORM_DEFAULT_USERS']);
        create_default_users();
        echo $mod_strings['LBL_PERFORM_DONE'];
    } else {
        echo $line_entry_format.$mod_strings['LBL_PERFORM_ADMIN_PASSWORD'].$line_exit_format;
        installLog($mod_strings['LBL_PERFORM_ADMIN_PASSWORD']);
        $db->setUserName($setup_db_sugarsales_user);
        $db->setUserPassword($setup_db_sugarsales_password);
        set_admin_password($setup_site_admin_password);
        echo $mod_strings['LBL_PERFORM_DONE'];
    }
    installerHook('post_createUsers');




    // default OOB schedulers

    echo $line_entry_format.$mod_strings['LBL_PERFORM_DEFAULT_SCHEDULER'].$line_exit_format;
    installLog($mod_strings['LBL_PERFORM_DEFAULT_SCHEDULER']);
    $scheduler = new Scheduler();
    installerHook('pre_createDefaultSchedulers');
    $scheduler->rebuildDefaultSchedulers();
    installerHook('post_createDefaultSchedulers');


    echo $mod_strings['LBL_PERFORM_DONE'];



// Enable Sugar Feeds and add all feeds by default
installLog("Enable SugarFeeds");
enableSugarFeeds();


// Enable the InsideView connector and add all modules
installLog("Enable InsideView Connector");
enableInsideViewConnector();

// Install the logic hook for FTS
installLog("Creating FTS logic hook");
if (!function_exists('createFTSLogicHook')) {
    function createFTSLogicHook($filePath = 'application/Ext/LogicHooks/logichooks.ext.php')
    {
        $customFileLoc = create_custom_directory($filePath);
        $fp = sugar_fopen($customFileLoc, 'wb');
        $contents = <<<CIA
<?php
if (!isset(\$hook_array) || !is_array(\$hook_array)) {
    \$hook_array = array();
}
if (!isset(\$hook_array['after_save']) || !is_array(\$hook_array['after_save'])) {
    \$hook_array['after_save'] = array();
}
\$hook_array['after_save'][] = array(1, 'fts', 'include/SugarSearchEngine/SugarSearchEngineQueueManager.php', 'SugarSearchEngineQueueManager', 'populateIndexQueue');
CIA;

        fwrite($fp,$contents);
        fclose($fp);

    }
}
createFTSLogicHook();
// also write it to Extension directory so it won't be lost when rebuilding extensions
createFTSLogicHook('Extension/application/Ext/LogicHooks/SugarFTSHooks.php');

///////////////////////////////////////////////////////////////////////////////
////    START DEMO DATA

    // populating the db with seed data
    installLog("populating the db with seed data");
    if( $_SESSION['demoData'] != 'no' ){
        installerHook('pre_installDemoData');
        set_time_limit( 301 );

      echo "<br>";
        echo "<b>{$mod_strings['LBL_PERFORM_DEMO_DATA']}</b>";
        echo "<br><br>";

        print( $render_table_close );
        print( $render_table_open );

        global $current_user;
        $current_user = new User();
        $current_user->retrieve(1);
        include("install/populateSeedData.php");
        installerHook('post_installDemoData');
    }

    $endTime = microtime(true);
    $deltaTime = $endTime - $startTime;



///////////////////////////////////////////////////////////////////////////
////    FINALIZE LANG PACK INSTALL
    if(isset($_SESSION['INSTALLED_LANG_PACKS']) && is_array($_SESSION['INSTALLED_LANG_PACKS']) && !empty($_SESSION['INSTALLED_LANG_PACKS'])) {
        updateUpgradeHistory();
    }

    ///////////////////////////////////////////////////////////////////////////
    ////    HANDLE SUGAR VERSIONS
    require_once('modules/Versions/InstallDefaultVersions.php');



    require_once('modules/Connectors/InstallDefaultConnectors.php');

	///////////////////////////////////////////////////////////////////////////////
	////    INSTALL PASSWORD TEMPLATES
    include('install/seed_data/Advanced_Password_SeedData.php');

///////////////////////////////////////////////////////////////////////////////
////    SETUP DONE
installLog("Installation has completed *********");
$memoryUsed = '';
    if(function_exists('memory_get_usage')) {
    $memoryUsed = $mod_strings['LBL_PERFORM_OUTRO_5'].memory_get_usage().$mod_strings['LBL_PERFORM_OUTRO_6'];
    }


$errTcpip = '';
    $fp = @fsockopen("www.sugarcrm.com", 80, $errno, $errstr, 3);
    if (!$fp) {
    $errTcpip = "<p>{$mod_strings['ERR_PERFORM_NO_TCPIP']}</p>";
    }
   if ($fp && (!isset( $_SESSION['oc_install']) ||  $_SESSION['oc_install'] == false)) {
      @fclose($fp);
      if ( $next_step == 9999 )
          $next_step = 8;
    $fpResult =<<<FP
     <form action="install.php" method="post" name="form" id="form">
     <input type="hidden" name="current_step" value="{$next_step}">
     <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
       <tr>
         <td>
            &nbsp;
         </td>
         <td><input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next2"/></td>
       </tr>
     </table>
     </form>
FP;
   } else {
        $fpResult =<<<FP
     <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
       <tr>
         <td>&nbsp;</td>
         <td>
            <form action="index.php" method="post" name="formFinish" id="formFinish">
                <input type="hidden" name="default_user_name" value="admin" />
                <input class="button" type="submit" name="next" value="{$mod_strings['LBL_PERFORM_FINISH']}" id="button_next2"/>
            </form>
         </td>
       </tr>
     </table>
FP;
   }

    if( isset($_SESSION['setup_site_sugarbeet_automatic_checks']) && $_SESSION['setup_site_sugarbeet_automatic_checks'] == true){
        set_CheckUpdates_config_setting('automatic');
    }else{
        set_CheckUpdates_config_setting('manual');
    }
    if(!empty($_SESSION['setup_system_name'])){
        $admin=new Administration();
        $admin->saveSetting('system','name',$_SESSION['setup_system_name']);
    }


    // Bug 28601 - Set the default list of tabs to show
    $enabled_tabs = array();
    $enabled_tabs[] = 'Home';

    $enabled_tabs[] = 'Accounts';
    $enabled_tabs[] = 'Contacts';
    $enabled_tabs[] = 'Opportunities';
    $enabled_tabs[] = 'Leads';
    $enabled_tabs[] = 'Calendar';
    $enabled_tabs[] = 'Documents';
    $enabled_tabs[] = 'Emails';
    $enabled_tabs[] = 'Campaigns';
    $enabled_tabs[] = 'Calls';
    $enabled_tabs[] = 'Meetings';
    $enabled_tabs[] = 'Tasks';
    $enabled_tabs[] = 'Notes';
    $enabled_tabs[] = 'Cases';
    $enabled_tabs[] = 'Prospects';
    $enabled_tabs[] = 'ProspectLists';


    installerHook('pre_setSystemTabs');
    require_once('modules/MySettings/TabController.php');
    $tabs = new TabController();
    $tabs->set_system_tabs($enabled_tabs);
    installerHook('post_setSystemTabs');

post_install_modules();

//Call rebuildSprites
if(function_exists('imagecreatetruecolor'))
{
    require_once('modules/UpgradeWizard/uw_utils.php');
    rebuildSprites(true);
}

if( count( $bottle ) > 0 ){
    foreach( $bottle as $bottle_message ){
        $bottleMsg .= "{$bottle_message}\n";
    }
} else {
    $bottleMsg = $mod_strings['LBL_PERFORM_SUCCESS'];
}
installerHook('post_installModules');



$out =<<<EOQ
<br><p><b>{$mod_strings['LBL_PERFORM_OUTRO_1']} {$setup_sugar_version} {$mod_strings['LBL_PERFORM_OUTRO_2']}</b></p>

{$mod_strings['LBL_PERFORM_OUTRO_3']} {$deltaTime} {$mod_strings['LBL_PERFORM_OUTRO_4']}<br />
{$memoryUsed}
{$errTcpip}
    </td>
</tr>
<tr>
<td align="right" colspan="2">
<hr>
<table cellspacing="0" cellpadding="0" border="0" class="stdTable">
<tr>
<td>
{$fpResult}
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
<!--
<bottle>{$bottleMsg}</bottle>
-->
EOQ;

echo $out;


?>
