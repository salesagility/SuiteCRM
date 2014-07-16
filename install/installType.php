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




if( !isset( $install_script ) || !$install_script ){
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}
// $mod_strings come from calling page.

$langDropDown = get_select_options_with_id($supportedLanguages, $current_language);



if( !isset($_SESSION['licenseKey_submitted']) || !$_SESSION['licenseKey_submitted'] ) {
    $_SESSION['setup_license_key_users']        = 0;
    $_SESSION['setup_license_key_expire_date']  = "";
    $_SESSION['setup_license_key']              = "";
    $_SESSION['setup_num_lic_oc']              = 0;

} else {

}

//php version suggestion
$php_suggested_ver = '';
if(version_compare(phpversion(),'5.2.2') < 0){
    $php_suggested_ver=$mod_strings['LBL_YOUR_PHP_VERSION'].phpversion().$mod_strings['LBL_RECOMMENDED_PHP_VERSION'];
}

///////////////////////////////////////////////////////////////////////////////
////    START OUTPUT

$langHeader = get_language_header();
$out = <<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_INSTALL_TYPE_TITLE']}</title>
   <link REL="SHORTCUT ICON" HREF="$icon">
   <link rel="stylesheet" href="$css" type="text/css">
</head>

<body onload="javascript:document.getElementById('button_next').focus();">
    <form action="install.php" method="post" name="form" id="form">
  <table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
      <tr><td colspan="2" id="help"><a href="{$help_url}" target='_blank'>{$mod_strings['LBL_HELP']} </a></td></tr>
    <tr>
      <th width="500">
		<p>
		<img src="{$sugar_md}" alt="SugarCRM" border="0">
		</p>
		{$mod_strings['LBL_INSTALL_TYPE_TITLE']}</th>

    <th width="200" height="30" style="text-align: right;">&nbsp;
        </th>
    </tr>

    <tr><td colspan="2">
        <table width="100%" class="StyleDottedHr">
EOQ;




$typical_checked ='checked';
$custom_checked ='';
if(isset($_SESSION['install_type']) && $_SESSION['install_type']=='custom'){
    $typical_checked ='';
    $custom_checked ='checked';

}else{
//do nothing because defaults handle this condition
}


$out .= <<<EOQ2
<tr><th colspan='2' align="left">{$mod_strings['LBL_INSTALL_TYPE_SUBTITLE']}</th></tr>
        <tr><td width='200'>
          <input name="install_type" type="radio" value="Typical" {$typical_checked}>{$mod_strings['LBL_INSTALL_TYPE_TYPICAL']}
        </td><td width='500'>
            {$mod_strings['LBL_INSTALL_TYPE_MSG2']}
        <td></tr>
        <tr><td width='200'>
          <input type="radio" name="install_type" value="custom" {$custom_checked}>{$mod_strings['LBL_INSTALL_TYPE_CUSTOM']}
        </td><td width='500'>
            {$mod_strings['LBL_INSTALL_TYPE_MSG3']}
        <td></tr>
        </table>


      </td>
    </tr>
	<tr><td width='1000'><b><i>{$php_suggested_ver}</i></b></td></tr>
    <tr>
      <td align="right" colspan="2" height="20">
        <hr>
                <input type="hidden" name="current_step" value="{$next_step}">

        <table cellspacing="0" cellpadding="0" border="0" class="stdTable">
          <tr>

            <td><input class="button" type="button" value="{$mod_strings['LBL_BACK']}" id="button_back_installType" onclick="document.getElementById('form').submit();" />
                <input type="hidden" name="goto" value="{$mod_strings['LBL_BACK']}" /></td>
                <td><input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next" /></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
    </form>
</body>
</html>
EOQ2;
echo $out;
?>
