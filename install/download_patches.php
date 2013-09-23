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

global $sugar_version, $js_custom_version;
require_once('ModuleInstall/PackageManager/PackageManagerDisplay.php');
if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}
///////////////////////////////////////////////////////////////////////////////
////    PREFILL $sugar_config VARS
if(empty($sugar_config['upload_dir'])) {
    $sugar_config['upload_dir'] = 'upload/';
}
if(empty($sugar_config['upload_maxsize'])) {
    $sugar_config['upload_maxsize'] = 8192000;
}
if(empty($sugar_config['upload_badext'])) {
    $sugar_config['upload_badext'] = array('php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py', 'asp', 'cfm', 'js', 'vbs', 'html', 'htm');
}
////    END PREFILL $sugar_config VARS
///////////////////////////////////////////////////////////////////////////////
require_once('include/utils/zip_utils.php');

require_once('include/upload_file.php');


///////////////////////////////////////////////////////////////////////////////
////    PREP VARS FOR LANG PACK
    $base_upgrade_dir       = "upload://upgrades";
    $base_tmp_upgrade_dir   = sugar_cached("upgrades/temp");
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
////    HANDLE FILE UPLOAD AND PROCESSING
$errors = array();
$uploadResult = '';
if(isset($_REQUEST['languagePackAction']) && !empty($_REQUEST['languagePackAction'])) {
    switch($_REQUEST['languagePackAction']) {
        case 'upload':
        $perform = false;
        $tempFile = '';
        if(isset($_REQUEST['release_id']) && $_REQUEST['release_id'] != ""){
            require_once('ModuleInstall/PackageManager/PackageManager.php');
            $pm = new PackageManager();
            $tempFile = $pm->download('3', '3', $_REQUEST['release_id'], $sugar_config['upload_dir']);
            $perform = true;
            //$base_filename = urldecode($tempFile);
        }else{
            $file = new UploadFile('language_pack');
            if($file->confirm_upload())
            $perform = true;
             if(strpos($file->mime_type, 'zip') !== false) { // only .zip files
                    if(langPackFinalMove($file)) {
                        $perform = true;
                    }
                    else {
                        $errors[] = $mod_strings['ERR_LANG_UPLOAD_3'];
                    }
                } else {
                    $errors[] = $mod_strings['ERR_LANG_UPLOAD_2'];
                }
        }


            if($perform) { // check for a real file
                        $uploadResult = $mod_strings['LBL_LANG_SUCCESS'];
                        $result = langPackUnpack('patch', $tempFile);
            } else {
                $errors[] = $mod_strings['ERR_LANG_UPLOAD_1'];
            }

            if(count($errors) > 0) {
                foreach($errors as $error) {
                    $uploadResult .= $error."<br />";
                }
            }
            break; // end 'validate'
        case 'commit':
            $sugar_config = commitPatch();
            break;
        case 'remove':
            removeLanguagePack();
            break;
        default:
            break;
    }
}
////    END HANDLE FILE UPLOAD AND PROCESSING
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////    PRELOAD DISPLAY DATA
$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_bytes = return_bytes($upload_max_filesize);
$fileMaxSize ='';
if(!defined('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES')){
    define('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES', 6 * 1024 * 1024);
}
if($upload_max_filesize_bytes < constant('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES')) {
    $GLOBALS['log']->debug("detected upload_max_filesize: $upload_max_filesize");
    $fileMaxSize = '<p class="error">'.$mod_strings['ERR_UPLOAD_MAX_FILESIZE']."</p>\n";
}
$availablePatches = getLangPacks(false, array('patch'), $mod_strings['LBL_PATCH_READY']);

$errs = '';
if(isset($validation_errors)) {
    if(count($validation_errors) > 0) {
        $errs  = '<div id="errorMsgs">';
        $errs .= "<p>{$mod_strings['LBL_SYSOPTS_ERRS_TITLE']}</p>";
        $errs .= '<ul>';

        foreach($validation_errors as $error) {
            $errs .= '<li>' . $error . '</li>';
        }

        $errs .= '</ul>';
        $errs .= '</div>';
    }
}

////    PRELOAD DISPLAY DATA
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////    BEING PAGE OUTPUT
$disabled = "";
$result = "";
$langHeader = get_language_header();
$out =<<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Script-Type" content="text/javascript">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$next_step}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css">
   <script type="text/javascript" src="install/installCommon.js"></script>
   <link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css?s={$sugar_version}&c={$js_custom_version}">
   <script>jscal_today = 1161698116000; if(typeof app_strings == "undefined") app_strings = new Array();</script>
   <script type="text/javascript" src="cache/include/javascript/sugar_grp1.js?s={$sugar_version}&c={$js_custom_version}"></script>
   <script type="text/javascript" src="cache/include/javascript/sugar_grp1_yui.js?s={$sugar_version}&c={$js_custom_version}"></script>
   <script type="text/javascript">
    <!--
    if ( YAHOO.env.ua )
        UA = YAHOO.env.ua;
    -->
    </script>
</head>

<body onLoad="document.getElementById('button_next2').focus();">
{$fileMaxSize}
  <table cellspacing="0" width="100%" cellpadding="0" border="0" align="center" class="shell">
      <tr><td colspan="2" id="help"><a href="{$help_url}" target='_blank'>{$mod_strings['LBL_HELP']} </a></td></tr>
    <tr>
      <th width="500">
		<p>
		<img src="{$sugar_md}" alt="SugarCRM" border="0">
		</p>
      {$mod_strings['LBL_PATCHES_TITLE']}</th>
      <th width="200" style="text-align: right;"><a href="http://www.sugarcrm.com" target=
      "_blank"><IMG src="include/images/sugarcrm_login.png" alt="SugarCRM" border="0"></a>
        </th>
    </tr>

    <tr>
        <td colspan="2">
            <p>{$mod_strings['LBL_PATCH_1']}</p>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="StyleDottedHr">
                <tr>
                    <th colspan="2" align="left">{$mod_strings['LBL_PATCH_TITLE']}</th>
                </tr>
                <tr>
                    <td colspan="2">
EOQ;
$form =<<<EOQ1
                    <form name="the_form" enctype="multipart/form-data"
                        action="install.php" method="post">
                        <input type="hidden" name="current_step" value="{$next_step}">
                        <input type="hidden" name="goto" value="{$mod_strings['LBL_CHECKSYS_RECHECK']}">
                        <input type="hidden" name="languagePackAction" value="upload">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
                        <tr>
                            <td>
                                <table width="450" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
										<td colspan='2'>
											{$mod_strings['LBL_PATCH_UPLOAD']}:
										</td>
									</tr><tr>
                                        <td>

                                            <input type="file" name="language_pack" size="40" />
                                        </td>
                                        <td valign="bottom">
                                            <input class='button' type=button value="{$mod_strings['LBL_LANG_BUTTON_UPLOAD']}"  onClick="document.the_form.language_pack_escaped.value = escape( document.the_form.language_pack.value ); document.the_form.submit();"/>
                                            <input type=hidden name="language_pack_escaped" value="" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {$uploadResult}
                            </td>
                        </tr>
                    </table>
                    </form>
EOQ1;
$out1 =<<<EOQ2
                  </td>
                </tr>
                <tr>
                    <td colspan=2>
                        {$result}
                    </td>
                </tr>

                <!--// Available Upgrades //-->
                <tr>
                    <td align="left" colspan="2">
                        <hr>
                        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
                            {$availablePatches}
                        </table>
                    </td>
                </tr>
                 <tr>
                    <td align="right" colspan="2">
                        <hr>
                        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
                        <tr><td><form action='install.php' method='POST'>
                                <input type='hidden' name='current_step' value="{$next_step}">
                                <input type='hidden' name='goto' value="{$mod_strings['LBL_CHECKSYS_RECHECK']}">
                                <input type='hidden' name='languagePackAction' value='commit'>
                                <input type='submit' value="{$mod_strings['LBL_INSTALL']}" class='button'>
                                </form>
                        </td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right" colspan="2">
                        <hr>
                        <form name="the_form1" action="install.php" method="post">
                        <input type="hidden" name="current_step" value="{$next_step}">
                        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
                            <tr>
                                <td>

                                </td>
                                <td>
                                    <input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next2" {$disabled} />
                                </td>
                            </tr>
                        </table>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
EOQ2;
$hidden_fields =  "<input type=\"hidden\" name=\"current_step\" value=\"{$next_step}\">";
$hidden_fields .=  "<input type=\"hidden\" name=\"goto\" value=\"{$mod_strings['LBL_CHECKSYS_RECHECK']}\">";
$hidden_fields .=  "<input type=\"hidden\" name=\"languagePackAction\" value=\"upload\">";
$form2 = PackageManagerDisplay::buildPatchDisplay($form, $hidden_fields, 'install.php', array('patch'));

echo $out.$form2.$out1;

//unlinkTempFiles('','');
////    END PAGEOUTPUT
///////////////////////////////////////////////////////////////////////////////
?>
