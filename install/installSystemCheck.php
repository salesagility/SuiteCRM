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


$_SESSION['setup_license_accept'] = true;

function runCheck($install_script = false, $mod_strings){
installLog("Begin System Check Process *************");

if( !isset( $install_script ) || !$install_script ){
    installLog("Error:: ".$mod_strings['ERR_NO_DIRECT_SCRIPT']);
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}

if(!defined('SUGARCRM_MIN_MEM')) {
    define('SUGARCRM_MIN_MEM', 40);
}



// for keeping track of whether to enable/disable the 'Next' button
$error_found = false;
$error_txt = '';


// check IIS and FastCGI
$server_software = $_SERVER["SERVER_SOFTWARE"];
if ((strpos($_SERVER["SERVER_SOFTWARE"],'Microsoft-IIS') !== false)
    && php_sapi_name() == 'cgi-fcgi'
    && ini_get('fastcgi.logging') != '0')
{
    installLog($mod_strings['ERR_CHECKSYS_FASTCGI_LOGGING']);
    $iisVersion = "<b><span class=stop>{$mod_strings['ERR_CHECKSYS_FASTCGI_LOGGING']}</span></b>";
    $error_found = true;
    $error_txt .= '
          <tr>
            <td><b>'.$mod_strings['LBL_CHECKSYS_FASTCGI'].'</b></td>
            <td ><span class="error">'.$iisVersion.'</span></td>
          </tr>';
}

if(strpos($server_software,'Microsoft-IIS') !== false)
{
	$iis_version = '';
	if(preg_match_all("/^.*\/(\d+\.?\d*)$/",  $server_software, $out))
	$iis_version = $out[1][0];

	$check_iis_version_result = check_iis_version($iis_version);
	if($check_iis_version_result == -1) {
		installLog($mod_strings['ERR_CHECKSYS_IIS_INVALID_VER'].' '.$iis_version);
        $iisVersion = "<b><span class=stop>{$mod_strings['ERR_CHECKSYS_IIS_INVALID_VER']} {$iis_version}</span></b>";
		$error_found = true;
        $error_txt .= '
          <tr>
            <td><b>'.$mod_strings['LBL_CHECKSYS_IISVER'].'</b></td>
            <td ><span class="error">'.$iisVersion.'</span></td>
          </tr>';
	} else if(php_sapi_name() != 'cgi-fcgi')
	{
		installLog($mod_strings['ERR_CHECKSYS_FASTCGI'].' '.$iis_version);
		$iisVersion = "<b><span class=stop>{$mod_strings['ERR_CHECKSYS_FASTCGI']}</span></b>";
		$error_found = true;
        $error_txt .= '
          <tr>
            <td><b>'.$mod_strings['LBL_CHECKSYS_FASTCGI'].'</b></td>
            <td ><span class="error">'.$iisVersion.'</span></td>
          </tr>';
	} else if(ini_get('fastcgi.logging') != '0')
    {
        installLog($mod_strings['ERR_CHECKSYS_FASTCGI_LOGGING'].' '.$iis_version);
		$iisVersion = "<b><span class=stop>{$mod_strings['ERR_CHECKSYS_FASTCGI_LOGGING']}</span></b>";
		$error_found = true;
        $error_txt .= '
          <tr>
            <td><b>'.$mod_strings['LBL_CHECKSYS_FASTCGI'].'</b></td>
            <td ><span class="error">'.$iisVersion.'</span></td>
          </tr>';
    }
}

// PHP VERSION
$php_version = constant('PHP_VERSION');
$check_php_version_result = check_php_version($php_version);

if($check_php_version_result == -1) {
        installLog($mod_strings['ERR_CHECKSYS_PHP_INVALID_VER'].'  '.$php_version);
        $phpVersion = "<b><span class=stop>{$mod_strings['ERR_CHECKSYS_PHP_INVALID_VER']} {$php_version} )</span></b>";
        $error_found = true;
        $error_txt .= '
          <tr>
            <td><b>'.$mod_strings['LBL_CHECKSYS_PHPVER'].'</b></td>
            <td ><span class="error">'.$phpVersion.'</span></td>
          </tr>';

}

//Php Backward compatibility checks
if(ini_get("zend.ze1_compatibility_mode")) {
    installLog($mod_strings['LBL_BACKWARD_COMPATIBILITY_ON'].'  '.'Php Backward Compatibility');
    $phpCompatibility = "<b><span class=stop>{$mod_strings['LBL_BACKWARD_COMPATIBILITY_ON']}</span></b>";
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><b>Php Backward Compatibility</b></td>
        <td ><span class="error">'.$phpCompatibility.'</span></td>
      </tr>';

}

// database and connect

if (!empty($_REQUEST['setup_db_type']))
    $_SESSION['setup_db_type'] = $_REQUEST['setup_db_type'];

$drivers = DBManagerFactory::getDbDrivers();

if( empty($drivers) ){
    $db_name = $mod_strings['LBL_DB_UNAVAILABLE'];
    installLog("ERROR:: {$mod_strings['LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE']}");
    $dbStatus = "<b><span class=stop>{$mod_strings['LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE']}</span></b>";
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><strong>'.$db_name.'</strong></td>
        <td class="error">'.$dbStatus.'</td>
      </tr>';
}

// XML Parsing
if(!function_exists('xml_parser_create')) {
    $xmlStatus = "<b><span class=stop>{$mod_strings['LBL_CHECKSYS_XML_NOT_AVAILABLE']}</span></b>";
    installLog("ERROR:: {$mod_strings['LBL_CHECKSYS_XML_NOT_AVAILABLE']}");
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_XML'].'</strong></td>
        <td class="error">'.$xmlStatus.'</td>
      </tr>';
}else{
    installLog("XML Parsing Support Found");
}


// mbstrings
if(!function_exists('mb_strlen')) {
    $mbstringStatus = "<b><span class=stop>{$mod_strings['ERR_CHECKSYS_MBSTRING']}</font></b>";
    installLog("ERROR:: {$mod_strings['ERR_CHECKSYS_MBSTRING']}");
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_MBSTRING'].'</strong></td>
        <td class="error">'.$mbstringStatus.'</td>
      </tr>';
}else{
    installLog("MBString Support Found");
}

// zip
if(!class_exists('ZipArchive')) {
    $zipStatus = "<b><span class=stop>{$mod_strings['ERR_CHECKSYS_ZIP']}</font></b>";
    installLog("ERROR:: {$mod_strings['ERR_CHECKSYS_ZIP']}");
}else{
    installLog("ZIP Support Found");
}

// config.php
if(file_exists('./config.php') && (!(make_writable('./config.php')) ||  !(is_writable('./config.php')))) {
    installLog("ERROR:: {$mod_strings['ERR_CHECKSYS_CONFIG_NOT_WRITABLE']}");
    $configStatus = "<b><span class='stop'>{$mod_strings['ERR_CHECKSYS_CONFIG_NOT_WRITABLE']}</span></b>";
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_CONFIG'].'</strong></td>
        <td class="error">'.$configStatus.'</td>
      </tr>';
}

// config_override.php
if(file_exists('./config_override.php') && (!(make_writable('./config_override.php')) ||  !(is_writable('./config_override.php')))) {
    installLog("ERROR:: {$mod_strings['ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE']}");
    $configStatus = "<b><span class='stop'>{$mod_strings['ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE']}</span></b>";
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_OVERRIDE_CONFIG'].'</strong></td>
        <td class="error">'.$configStatus.'</td>
      </tr>';
}

// custom dir
if(!make_writable('./custom')) {
    $customStatus = "<b><span class='stop'>{$mod_strings['ERR_CHECKSYS_CUSTOM_NOT_WRITABLE']}</font></b>";
    installLog("ERROR:: {$mod_strings['ERR_CHECKSYS_CUSTOM_NOT_WRITABLE']}");
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_CUSTOM'].'</strong></td>
        <td class="error">'.$customStatus.'</td>
      </tr>';
}else{
 installLog("/custom directory and subdirectory check passed");
}


// cache dir
    $cache_files[] = '';
    $cache_files[] = 'images';
    $cache_files[] = 'layout';
    $cache_files[] = 'pdf';
    $cache_files[] = 'xml';
    $cache_files[] = 'include/javascript';
    $filelist = '';

	foreach($cache_files as $c_file)
	{
		$dirname = sugar_cached($c_file);
		$ok = false;
		if ((is_dir($dirname)) || @sugar_mkdir($dirname,0555)) // set permissions to restrictive - use make_writable to change in a standard way to the required permissions
		{
			$ok = make_writable($dirname);
		}
		if (!$ok)
		{
			$filelist .= '<br>'.getcwd()."/$dirname";

		}
	}
	if (strlen($filelist)>0)
	{
	    $error_found = true;
        installLog("ERROR:: Some subdirectories in cache subfolder were not read/writeable:");
        installLog($filelist);
	    $error_txt .= '
		<tr>
        	<td><strong>'.$mod_strings['LBL_CHECKSYS_CACHE'].'</strong></td>
        	<td align="right" class="error" class="error"><b><span class="stop">'.$mod_strings['ERR_CHECKSYS_FILES_NOT_WRITABLE'].'</span></b></td>
		</tr>
		<tr>
        	<td colspan="2"><b>'.$mod_strings['LBL_CHECKSYS_FIX_FILES'].'</b>'.$filelist. '</td>
		</tr>';
	}else{
     installLog("cache directory and subdirectory check passed");
    }


// check modules dir
$_SESSION['unwriteable_module_files'] = array();
//if(!$writeableFiles['ret_val']) {
$passed_write = recursive_make_writable('./modules');
if (isset($_SESSION['unwriteable_module_files']['failed']) && $_SESSION['unwriteable_module_files']['failed']){
    $passed_write = false;
}

if(!$passed_write) {

    $moduleStatus = "<b><span class='stop'>{$mod_strings['ERR_CHECKSYS_NOT_WRITABLE']}</span></b>";
    installLog("ERROR:: Module directories and the files under them are not writeable.");
    $error_found = true;
    $error_txt .= '
      <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_MODULE'].'</strong></td>
        <td align="right" class="error">'.$moduleStatus.'</td>
      </tr>';

        //list which module directories are not writeable, if there are less than 10
        $error_txt .= '
          <tr>
            <td colspan="2">
            <b>'.$mod_strings['LBL_CHECKSYS_FIX_MODULE_FILES'].'</b>';
        foreach($_SESSION['unwriteable_module_files'] as $key=>$file){
            if($key !='.' && $key != 'failed'){
                $error_txt .='<br>'.$file;
            }
        }
        $error_txt .= '
            </td>
          </tr>';

}else{
 installLog("/module  directory and subdirectory check passed");
}

// check upload dir
if (!make_writable('./upload'))
{
    $uploadStatus = "<b><span class='stop'>{$mod_strings['ERR_CHECKSYS_NOT_WRITABLE']}</span></b>";
    installLog("ERROR: Upload directory is not writable.");
    $error_found = true;
    $error_txt .= '
    <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_UPLOAD'].'</strong></td>
        <td align="right" class="error">'.$uploadStatus.'</td>
    </tr>';
} else {
    installLog("/upload directory check passed");
}

// check zip file support
if (!class_exists("ZipArchive"))
{
        $zipStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_ZIP']}</b></span>";

    installLog("ERROR: Zip support not found.");
    $error_found = true;
    $error_txt .= '
          <tr>
            <td><strong>'.$mod_strings['LBL_CHECKSYS_ZIP'].'</strong></td>
            <td  align="right" class="error">'.$zipStatus.'</td>
          </tr>';
} else {
    installLog("/zip check passed");

}


// check PCRE version
if (defined('PCRE_VERSION'))
{
    if (version_compare(PCRE_VERSION, '7.0') < 0) {
        installLog("ERROR: PCRE Version is less than 7.0.");
        $error_found = true;
        $pcreStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_PCRE_VER']}</b></span>";
        $error_txt .= '
          <tr>
            <td><strong>'.$mod_strings['LBL_CHECKSYS_PCRE'].'</strong></td>
            <td  align="right" class="error">'.$pcreStatus.'</td>
          </tr>';
    }
    else {
        installLog("PCRE version check passed");
    }
}
else {
    installLog("ERROR: PCRE not found.");
    $error_found = true;
    $pcreStatus = "<span class='stop'><b>{$mod_strings['ERR_CHECKSYS_PCRE']}</b></span>";
    $error_txt .= '
      <tr>
        <td><strong>'.$mod_strings['LBL_CHECKSYS_PCRE'].'</strong></td>
        <td  align="right" class="error">'.$pcreStatus.'</td>
      </tr>';
}


$customSystemChecks = installerHook('additionalCustomSystemChecks');
if($customSystemChecks != 'undefined'){
	if($customSystemChecks['error_found'] == true){
		$error_found = true;
	}
	if(!empty($customSystemChecks['error_txt'])){
		$error_txt .= $customSystemChecks['error_txt'];
	}
}

// PHP.ini
$phpIniLocation = get_cfg_var("cfg_file_path");
installLog("php.ini location found. {$phpIniLocation}");
// disable form if error found

if($error_found){
    installLog("Outputting HTML for System check");
    installLog("Errors were found *************");
    $disabled = $error_found ? 'disabled="disabled"' : '';

    $help_url = get_help_button_url();
///////////////////////////////////////////////////////////////////////////////
////    BEGIN PAGE OUTPUT
    $out =<<<EOQ

  <table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
    <tr>
      <th width="400">{$mod_strings['LBL_CHECKSYS_TITLE']}</th>
      <th width="200" height="30" style="text-align: right;"><a href="http://www.sugarcrm.com" target=
      "_blank"><IMG src="include/images/sugarcrm_login.png" alt="SugarCRM" border="0"></a>
       <br><a href="{$help_url}" target='_blank'>{$mod_strings['LBL_HELP']} </a>
       </th>
    </tr>

    <tr>
      <td colspan="2" width="600">
        <p>{$mod_strings['ERR_CHECKSYS']}</p>

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="StyleDottedHr">
          <tr>
            <th align="left">{$mod_strings['LBL_CHECKSYS_COMPONENT']}</th>
            <th style="text-align: right;">{$mod_strings['LBL_CHECKSYS_STATUS']}</th>
          </tr>
            $error_txt

        </table>

        <div align="center" style="margin: 5px;">
          <i>{$mod_strings['LBL_CHECKSYS_PHP_INI']}<br>{$phpIniLocation}</i>
        </div>
      </td>
    </tr>

    <tr>
      <td align="right" colspan="2">
        <hr>
        <form action="install3.php" method="post" name="theForm" id="theForm">

        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
          <tr>
            <td><input class="button" type="button" onclick="window.open('http://www.sugarcrm.com/forums/');" value="{$mod_strings['LBL_HELP']}" /></td>
            <td>
                <input class="button" type="button" name="Re-check" value="{$mod_strings['LBL_CHECKSYS_RECHECK']}" onclick="callSysCheck();" id="button_next2"/>
            </td>
          </tr>
        </table>
        </form>
      </td>
    </tr>
  </table><br>
EOQ;
return $out;
}else{
    installLog("Outputting HTML for System check");
    installLog("No Errors were found *************");
 return 'passed';
}

}
////    END PAGEOUTPUT
///////////////////////////////////////////////////////////////////////////////
?>
