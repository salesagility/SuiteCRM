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
if(!isset($_SESSION['setup_db_type']) || $_SESSION['setup_db_type'] ==''){
 $_SESSION['setup_db_type'] = 'mysql';
}
$setup_db_type = $_SESSION['setup_db_type'];

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

$drivers = DBManagerFactory::getDbDrivers();
foreach(array_keys($drivers) as $dname) {
    $checked[$dname] = '';
}
$checked[$setup_db_type] = 'checked="checked"';
$langHeader = get_language_header();
$out=<<<EOQ
<!DOCTYPE HTML>
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_SYSOPTS_DB_TITLE']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css">
   <link rel="stylesheet" href="themes/SuiteP/css/fontello.css">
   <link rel="stylesheet" href="themes/SuiteP/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
   <link rel='stylesheet' type='text/css' href='include/javascript/yui/build/container/assets/container.css' />
   <script src="cache/include/javascript/sugar_grp1_yui.js?s={$sugar_version}&c={$js_custom_version}"></script>
</head>

<body onload="javascript:toggleNextButton();document.getElementById('button_next2').focus();">
<!--SuiteCRM installer-->
<div id="install_container">
    <div id="install_box">
        <div id='licenseDiv'>
        </div>
        <header id="install_header">
            <div class="install_img"><a href="https://suitecrm.com" target="_blank"><img src="{$sugar_md}" alt="SuiteCRM"></a></div>
            <div id="steps"><p>{$mod_strings['LBL_STEP4']}</p><i class="icon-progress-0" id="complete"></i><i class="icon-progress-1" id="complete"></i><i class="icon-progress-2" id="complete"></i><i class="icon-progress-3"></i><i class="icon-progress-4"></i><i class="icon-progress-5"></i><i class="icon-progress-6"></i><i class="icon-progress-7"></i>
        </header>
        <form action="install.php" method="post" name="systemOptions" id="form">
        <div id="install_content">
        <div id="installoptions">
		{$errs}
        <h2>{$mod_strings['LBL_SYSOPTS_DB']}</h2>
        {$mod_strings['LBL_SYSOPTS_2']}
        <br>
        <br>
EOQ;
foreach($drivers as $type => $driver) {
    $oci = ($type == "oci8")?"":'none'; // hack for special oracle message
    $out.=<<<EOQ
        <input type="radio" class="checkbox" name="setup_db_type" id="setup_db_type" value="$type" {$checked[$type]} onclick="document.getElementById('ociMsg').style.display='$oci'"/>{$mod_strings[$driver->label]}
EOQ;
}

$out.=<<<EOQ
    <div name="ociMsg" id="ociMsg" style="display:none"></div>
EOQ;

$out.=<<<EOQ
</div>

<hr>
    <div id="installcontrols">
        <input type="hidden" name="current_step" value=" $next_step ">
        <input class="button" type="button" value="{$mod_strings['LBL_BACK']}" id="button_back_systemOptions" onclick="document.getElementById('form').submit();" />
        <input type="hidden" name="goto" value="{$mod_strings['LBL_BACK']}" />
        <input class="button" type="submit" id="button_next2" name="goto" value="{$mod_strings['LBL_NEXT']}" />
    </div>
</form>
</div>
</div>
<footer id="install_footer">
    <p id="footer_links"><a href="https://suitecrm.com" target="_blank">Visit suitecrm.com</a> | <a href="https://suitecrm.com/index.php?option=com_kunena&view=category&Itemid=1137&layout=list" target="_blank">Support Forums</a> | <a href="https://suitecrm.com/wiki/index.php/Installation" target="_blank">Installation Guide</a> | <a href="LICENSE.txt" target="_blank">License</a>
</footer>
</div>
<script type="text/javascript">
    <!--
    if ( YAHOO.env.ua )
        UA = YAHOO.env.ua;
    -->
    </script>
</body>
</html>
EOQ;
echo $out;
?>
