<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/



global $sugar_config, $db, $app_strings;
if (isset($sugar_config['default_language']) == false)
{
    $sugar_config['default_language'] = $GLOBALS['current_language'];
}
$app_strings = return_application_language($GLOBALS['current_language']);

if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}

$db = getDbConnection();

$dbCreate = "({$mod_strings['LBL_CONFIRM_WILL']} ";
if(!$_SESSION['setup_db_create_database']){
	$dbCreate .= $mod_strings['LBL_CONFIRM_NOT'];
}
$dbCreate .= " {$mod_strings['LBL_CONFIRM_BE_CREATED']})";

$dbUser = "{$_SESSION['setup_db_sugarsales_user']} ({$mod_strings['LBL_CONFIRM_WILL']} ";
if( $_SESSION['setup_db_create_sugarsales_user'] != 1 ){
	$dbUser .= $mod_strings['LBL_CONFIRM_NOT'];
}
$dbUser .= " {$mod_strings['LBL_CONFIRM_BE_CREATED']})";
$yesNoDropCreate = $mod_strings['LBL_NO'];
if ($_SESSION['setup_db_drop_tables']===true ||$_SESSION['setup_db_drop_tables'] == 'true'){
    $yesNoDropCreate = $mod_strings['LBL_YES'];
}
$_SESSION['setup_site_sugarbeet'] = false;
$yesNoSugarUpdates = ($_SESSION['setup_site_sugarbeet']) ? $mod_strings['LBL_YES'] : $mod_strings['LBL_NO'];
$yesNoCustomSession = ($_SESSION['setup_site_custom_session_path']) ? $mod_strings['LBL_YES'] : $mod_strings['LBL_NO'];
$yesNoCustomLog = ($_SESSION['setup_site_custom_log_dir']) ? $mod_strings['LBL_YES'] : $mod_strings['LBL_NO'];
$yesNoCustomId = ($_SESSION['setup_site_specify_guid']) ? $mod_strings['LBL_YES'] : $mod_strings['LBL_NO'];
$demoData = ($_SESSION['demoData'] == 'en_us') ? ($mod_strings['LBL_YES']) : ($_SESSION['demoData']);
// Populate the default date format, time format, and language for the system
$defaultDateFormat = "";
$defaultTimeFormat = "";
$defaultLanguages = "";

	$sugar_config_defaults = get_sugar_config_defaults();
	if(isset($_REQUEST['default_language'])){
		$defaultLanguages = $sugar_config_defaults['languages'][$_REQUEST['default_language']];
	}

///////////////////////////////////////////////////////////////////////////////
////	START OUTPUT
$langHeader = get_language_header();

$out =<<<EOQ
<!DOCTYPE HTML>
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Script-Type" content="text/javascript">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_CONFIRM_TITLE']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css" />
   <link rel="stylesheet" href="themes/SuiteP/css/fontello.css">
   <link rel="stylesheet" href="themes/SuiteP/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
   <link rel='stylesheet' type='text/css' href='include/javascript/yui/build/container/assets/container.css' />
   <script type="text/javascript" src="install/installCommon.js"></script>
   <script type="text/javascript" src="install/siteConfig.js"></script>
</head>
<body onload="javascript:document.getElementById('button_next2').focus();">
    <!--SuiteCRM installer-->
    <div id="install_container">
    <div id="install_box">
    <header id="install_header">
                <div id="steps"><p>{$mod_strings['LBL_STEP7']}</p><i class="icon-progress-0" id="complete"></i><i class="icon-progress-1" id="complete"></i><i class="icon-progress-2" id="complete"></i><i class="icon-progress-3" id="complete"></i><i class="icon-progress-4" id="complete"></i><i class="icon-progress-5" id="complete"></i><i class="icon-progress-6" id="complete"></i><i class="icon-progress-7"></i></div>
                <div class="install_img"><a href="https://suitecrm.com"><img src="{$sugar_md}" alt="SuiteCRM"></a></div>
    </header>
        <form action="install.php" method="post" name="setConfig" id="form">
        <div id="install_content">
            <input type="hidden" name="current_step" value="{$next_step}">
            <input type="hidden" name="current_step" value="{$next_step}">
		    <h2>{$mod_strings['LBL_CONFIRM_TITLE']}</h2>
            <hr>
            <div id="confsettings">
                <div class="dbcred">
                    <h3>{$mod_strings['LBL_DBCONF_TITLE']}</h3>
                    <p><b>{$mod_strings['LBL_CONFIRM_DB_TYPE']}</b> {$_SESSION['setup_db_type']}</p>
                    <p><b>{$mod_strings['LBL_DBCONF_HOST_NAME']}</b> {$_SESSION['setup_db_host_name']}</p>
                    <p><b>{$mod_strings['LBL_DBCONF_DB_NAME']}</b> {$_SESSION['setup_db_database_name']} {$dbCreate}</p>
                    <p><b>{$mod_strings['LBL_DBCONF_DB_ADMIN_USER']}</b> {$_SESSION['setup_db_admin_user_name']}</p>
                    <p><b>{$mod_strings['LBL_DBCONF_DEMO_DATA']}</b> {$demoData}</p>

EOQ;

if($yesNoDropCreate){

$out .=<<<EOQ
            <p><b>{$mod_strings['LBL_DBCONF_DB_DROP']}</b> {$yesNoDropCreate}</p>
            </div>

EOQ;

}


if(isset($_SESSION['install_type'])  && !empty($_SESSION['install_type'])  && $_SESSION['install_type']=='custom'){
$out .=<<<EOQ

	        <div class="sitecred">
	            <h3>{$mod_strings['LBL_SITECFG_TITLE']}</h3>
                <p><b>{$mod_strings['LBL_SITECFG_URL']}</b> {$_SESSION['setup_site_url']}</p>
                <h3 style='display:none'>{$mod_strings['LBL_SITECFG_SUGAR_UPDATES']}</h3>
                <p style='display:none'><b>{$mod_strings['LBL_SITECFG_SUGAR_UP']}</b> {$yesNoSugarUpdates}</p>
	            <h3>{$mod_strings['LBL_SITECFG_SITE_SECURITY']}</h3>
                <p><b>{$mod_strings['LBL_SITECFG_CUSTOM_SESSION']}?</b> {$yesNoCustomSession}</p>
                <p><b>{$mod_strings['LBL_SITECFG_CUSTOM_LOG']}?</b> {$yesNoCustomLog}</p>
                <p><b>{$mod_strings['LBL_SITECFG_CUSTOM_ID']}?</b> {$yesNoCustomId}</p>
            </div>
EOQ;
}

$out .=<<<EOQ

	            <div class="sitecred">
	                <h3>{$mod_strings['LBL_SYSTEM_CREDS']}</h3>
                    <p><b>{$mod_strings['LBL_DBCONF_DB_USER']}</b> {$_SESSION['setup_db_sugarsales_user']}</p>
                    <p><b>{$mod_strings['LBL_DBCONF_DB_PASSWORD']}</b> <span id='hide_db_admin_pass'>{$mod_strings['LBL_HIDDEN']}</span></p>
                    <p><span style='display:none' id='show_db_admin_pass'>{$_SESSION['setup_db_sugarsales_password']}</span></p>
                    <p><b>{$mod_strings['LBL_SITECFG_ADMIN_Name']}</b> Admin</p>
                    <p><b>{$mod_strings['LBL_SITECFG_ADMIN_PASS']}</b> <span id='hide_site_admin_pass'>{$mod_strings['LBL_HIDDEN']}</span></p>
                    <p><span style='display:none' id='show_site_admin_pass'>{$_SESSION['setup_site_admin_password']}</span></p>
                </div>

EOQ;

$envString = '

	   <h3>'.$mod_strings['LBL_SYSTEM_ENV'].'</h3>';

    // PHP VERSION
        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_PHPVER'].'</b> '.constant('PHP_VERSION').'</p>';


//Begin List of already known good variables.  These were checked during the initial sys check
// XML Parsing
        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_XML'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p>';



// mbstrings

        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_MBSTRING'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p>';

// config.php
        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_CONFIG'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p>';

// custom dir


        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_CUSTOM'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p>';


// modules dir
        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_MODULE'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p';

// upload dir
        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_UPLOAD'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p>';

// data dir

        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_DATA'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p>';

// cache dir
    $error_found = true;
        $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_CACHE'].'</b> '.$mod_strings['LBL_CHECKSYS_OK'].'</p>';
// End already known to be good

// memory limit
$memory_msg     = "";
// CL - fix for 9183 (if memory_limit is enabled we will honor it and check it; otherwise use unlimited)
$memory_limit = ini_get('memory_limit');
if(empty($memory_limit)){
    $memory_limit = "-1";
}
if(!defined('SUGARCRM_MIN_MEM')) {
    define('SUGARCRM_MIN_MEM', 40*1024*1024);
}
$sugarMinMem = constant('SUGARCRM_MIN_MEM');
// logic based on: http://us2.php.net/manual/en/ini.core.php#ini.memory-limit
if( $memory_limit == "" ){          // memory_limit disabled at compile time, no memory limit
    $memory_msg = "<b>{$mod_strings['LBL_CHECKSYS_MEM_OK']}</b>";
} elseif( $memory_limit == "-1" ){   // memory_limit enabled, but set to unlimited
    $memory_msg = "{$mod_strings['LBL_CHECKSYS_MEM_UNLIMITED']}";
} else {
    $mem_display = $memory_limit;
    preg_match('/^\s*([0-9.]+)\s*([KMGTPE])B?\s*$/i', $memory_limit, $matches);
    $num = (float)$matches[1];
    // Don't break so that it falls through to the next case.
    switch (strtoupper($matches[2])) {
        case 'G':
            $num = $num * 1024;
        case 'M':
            $num = $num * 1024;
        case 'K':
            $num = $num * 1024;
    }
    $memory_limit_int = intval($num);
    $SUGARCRM_MIN_MEM = (int) constant('SUGARCRM_MIN_MEM');
    if( $memory_limit_int < constant('SUGARCRM_MIN_MEM') ){
        // Bug59667: The string ERR_CHECKSYS_MEM_LIMIT_2 already has 'M' in it,
        // so we divide the constant by 1024*1024.
        $min_mem_in_megs = constant('SUGARCRM_MIN_MEM')/(1024*1024);
        $memory_msg = "<span class='stop'><b>$memory_limit{$mod_strings['ERR_CHECKSYS_MEM_LIMIT_1']}" . $min_mem_in_megs . "{$mod_strings['ERR_CHECKSYS_MEM_LIMIT_2']}</b></span>";
        $memory_msg = str_replace('$memory_limit', $mem_display, $memory_msg);
    } else {
        $memory_msg = "{$mod_strings['LBL_CHECKSYS_OK']} ({$memory_limit})";
    }
}

          $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_MEM'].'</strong></b> '.$memory_msg.'</p>';

    // zlib
    if(function_exists('gzclose')) {
        $zlibStatus = "{$mod_strings['LBL_CHECKSYS_OK']}";
    } else {
        $zlibStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_ZLIB']}</b></span>";
    }
            $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_ZLIB'].'</b> '.$zlibStatus.'</p>';

    // zip
    if(class_exists("ZipArchive")) {
        $zipStatus = "{$mod_strings['LBL_CHECKSYS_OK']}";
    } else {
        $zipStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_ZIP']}</b></span>";
    }
            $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_ZIP'].'</b> '.$zipStatus.'</p>';

    // PCRE
    if(defined('PCRE_VERSION')) {
        if (version_compare(PCRE_VERSION, '7.0') < 0) {
            $pcreStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_PCRE_VER']}</b></span>";
        }
        else {
            $pcreStatus = "{$mod_strings['LBL_CHECKSYS_OK']}";
        }
    } else {
        $pcreStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_PCRE']}</b></span>";
    }
            $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_PCRE'].'</b> '.$pcreStatus.'</p>';

    // imap
    if(function_exists('imap_open')) {
        $imapStatus = "{$mod_strings['LBL_CHECKSYS_OK']}";
    } else {
        $imapStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_IMAP']}</b></span>";
    }

            $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_IMAP'].'</b> '.$imapStatus.'</p>';


    // cURL
    if(function_exists('curl_init')) {
        $curlStatus = "{$mod_strings['LBL_CHECKSYS_OK']}";
    } else {
        $curlStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_CURL']}</b></span>";
    }

            $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_CURL'].'</b> '.$curlStatus.'</p>';


      //CHECK UPLOAD FILE SIZE
        $upload_max_filesize = ini_get('upload_max_filesize');
        $upload_max_filesize_bytes = return_bytes($upload_max_filesize);
        if(!defined('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES')){
            define('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES', 6 * 1024 * 1024);
        }

        if($upload_max_filesize_bytes > constant('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES')) {
            $fileMaxStatus = "{$mod_strings['LBL_CHECKSYS_OK']}</font>";
        } else {
            $fileMaxStatus = "<span class='stop'><b>{$mod_strings['ERR_UPLOAD_MAX_FILESIZE']}</font></b></span>";
        }

            $envString .='<p><b>'.$mod_strings['LBL_UPLOAD_MAX_FILESIZE_TITLE'].'</b> '.$fileMaxStatus.'</p>';

      //CHECK Sprite support
        if(function_exists('imagecreatetruecolor'))
        {
            $spriteSupportStatus = "{$mod_strings['LBL_CHECKSYS_OK']}</font>";
        }else{
            $spriteSupportStatus = "<span class='stop'><b>{$mod_strings['ERROR_SPRITE_SUPPORT']}</b></span>";
        }
            $envString .='<p><b>'.$mod_strings['LBL_SPRITE_SUPPORT'].'</b> '.$spriteSupportStatus.'</p>';

        // Suhosin allow to use upload://
        if (UploadStream::getSuhosinStatus() == true || (strpos(ini_get('suhosin.perdir'), 'e') !== false && strpos($_SERVER["SERVER_SOFTWARE"],'Microsoft-IIS') === false))
        {
            $suhosinStatus = "{$mod_strings['LBL_CHECKSYS_OK']}";
        }
        else
        {
            $suhosinStatus = "<span class='stop'><b>{$app_strings['ERR_SUHOSIN']}</b></span>";
        }
        $envString .= "<p><b>{$mod_strings['LBL_STREAM']} (" . UploadStream::STREAM_NAME . "://)</b> " . $suhosinStatus . "</p>";

    // PHP.ini
    $phpIniLocation = get_cfg_var("cfg_file_path");
    $envString .='<p><b>'.$mod_strings['LBL_CHECKSYS_PHP_INI'].'</b> '.$phpIniLocation.'</p>';

$out .=<<<EOQ

<div id="syscred">

EOQ;

$out .= $envString;

$out .=<<<EOQ

</div>
EOQ;


// CRON Settings
if ( !isset($sugar_config['default_language']) )
    $sugar_config['default_language'] = $_SESSION['default_language'];
if ( !isset($sugar_config['cache_dir']) )
    $sugar_config['cache_dir'] = $sugar_config_defaults['cache_dir'];
if ( !isset($sugar_config['site_url']) )
    $sugar_config['site_url'] = $_SESSION['setup_site_url'];
if ( !isset($sugar_config['translation_string_prefix']) )
    $sugar_config['translation_string_prefix'] = $sugar_config_defaults['translation_string_prefix'];
$mod_strings_scheduler = return_module_language($GLOBALS['current_language'], 'Schedulers');
$error = '';

if (!isset($_SERVER['Path'])) {
    $_SERVER['Path'] = getenv('Path');
}
if(is_windows()) {
if(isset($_SERVER['Path']) && !empty($_SERVER['Path'])) { // IIS IUSR_xxx may not have access to Path or it is not set
    if(!strpos($_SERVER['Path'], 'php')) {
//        $error = '<em>'.$mod_strings_scheduler['LBL_NO_PHP_CLI'].'</em>';
    }
}
$cronString = '<p><b>'.$mod_strings_scheduler['LBL_CRON_WINDOWS_DESC'].'</b><br>
						cd '.realpath('./').'<br>
						php.exe -f cron.php
						<br>'.$error.'</p>
			   ';
} else {
if(isset($_SERVER['Path']) && !empty($_SERVER['Path'])) { // some Linux servers do not make this available
    if(!strpos($_SERVER['PATH'], 'php')) {
//        $error = '<em>'.$mod_strings_scheduler['LBL_NO_PHP_CLI'].'</em>';
    }
}
$cronString = '<p><b>'.$mod_strings_scheduler['LBL_CRON_INSTRUCTIONS_LINUX'].'</b><br> '.$mod_strings_scheduler['LBL_CRON_LINUX_DESC'].'<br>
						*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;
						cd '.realpath('./').'; php -f cron.php > /dev/null 2>&1
						<br><br><hr><br>'.$error.'</p>
              ';
}

$out .= $cronString;

$out .=<<<EOQ
            <input type="button" class="button" name="print_summary" id="button_print_summary_settings" value="{$mod_strings['LBL_PRINT_SUMM']}"
            onClick='window.print()' onCluck='window.open("install.php?current_step="+(document.setConfig.current_step.value -1)+"&goto={$mod_strings["LBL_NEXT"]}&print=true");' />
            <input type="button" class="button" id="show_pass_button" value="{$mod_strings['LBL_SHOW_PASS']}"
            onClick='togglePass();' />
            <input type="hidden" name="goto" id="goto">
            </div>
            </div>
            <div id="installcontrols">
                <input class="button" type="button" value="{$mod_strings['LBL_BACK']}" id="button_back_settings" onclick="document.getElementById('goto').value='{$mod_strings['LBL_BACK']}';document.getElementById('form').submit();" />
                <input class="button" type="button" value="{$mod_strings['LBL_LANG_BUTTON_COMMIT']}" onclick="document.getElementById('goto').value='{$mod_strings['LBL_NEXT']}';document.getElementById('form').submit();" id="button_next2"/>
            </div>
        </form>
        <br>
    </div>

<footer id="install_footer">
    <p id="footer_links"><a href="https://suitecrm.com" target="_blank">Visit suitecrm.com</a> | <a href="https://suitecrm.com/index.php?option=com_kunena&view=category&Itemid=1137&layout=list" target="_blank">Support Forums</a> | <a href="https://suitecrm.com/wiki/index.php/Installation" target="_blank">Installation Guide</a> | <a href="LICENSE.txt" target="_blank">License</a>
</footer>
</div>
<script>
function togglePass(){
    if(document.getElementById('show_site_admin_pass').style.display == ''){
        document.getElementById('show_pass_button').value = "{$mod_strings['LBL_SHOW_PASS']}";
        document.getElementById('hide_site_admin_pass').style.display = '';
        document.getElementById('hide_db_admin_pass').style.display = '';
        document.getElementById('show_site_admin_pass').style.display = 'none';
        document.getElementById('show_db_admin_pass').style.display = 'none';

    }else{
        document.getElementById('show_pass_button').value = "{$mod_strings['LBL_HIDE_PASS']}";
        document.getElementById('show_site_admin_pass').style.display = '';
        document.getElementById('show_db_admin_pass').style.display = '';
        document.getElementById('hide_site_admin_pass').style.display = 'none';
        document.getElementById('hide_db_admin_pass').style.display = 'none';

    }
}
</script>
</body>
</html>

EOQ;
echo $out;
