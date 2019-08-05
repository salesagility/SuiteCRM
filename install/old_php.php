<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

if (!isset($install_script) || !$install_script) {
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}

$langDropDown = get_select_options_with_id($supportedLanguages, $current_language);

$_SESSION['setup_old_php'] = get_boolean_from_request('setup_old_php');

$checked = (isset($_SESSION['setup_old_php']) && !empty($_SESSION['setup_old_php'])) ? 'checked="on"' : '';

$langHeader = get_language_header();

// load javascripts
include('jssource/JSGroupings.php');
$jsSrc = '';
foreach ($sugar_grp1_yui as $jsFile => $grp) {
    $jsSrc .= "\t<script src=\"$jsFile\"></script>\n";
}

////	START OUTPUT

$msg = sprintf(
    $mod_strings['LBL_OLD_PHP_MSG'],
    constant('SUITECRM_PHP_REC_VERSION'),
    constant('SUITECRM_PHP_MIN_VERSION'),
    constant('PHP_VERSION')
);

$out = <<<EOQ
<!DOCTYPE HTML>
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}, {$mod_strings['LBL_LICENSE_ACCEPTANCE']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install2.css" type="text/css">
   <link rel="stylesheet" href="themes/SuiteP/css/themes.css" type="text/css">
   <script src="include/javascript/jquery/jquery-min.js"></script>
    $jsSrc
   <script type="text/javascript">
    <!--
    if ( YAHOO.env.ua )
        UA = YAHOO.env.ua;
    -->
    </script>
    <link rel='stylesheet' type='text/css' href='include/javascript/yui/build/container/assets/container.css' />
    <script type="text/javascript" src="install/old_php.js"></script>
    <link rel="stylesheet" href="themes/SuiteP/css/fontello.css">
    <link rel="stylesheet" href="themes/SuiteP/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
</head>
<body onload="javascript:toggleNextButton();document.getElementById('button_next2').focus();">
    <!--SuiteCRM installer-->
    <div id="install_container">
    <div id="install_box">
        <form action="install.php" method="post" name="setConfig" id="form">
            <header id="install_header">
                <h1 id="welcomelink">{$mod_strings['LBL_TITLE_WELCOME']} {$setup_sugar_version} {$mod_strings['LBL_WELCOME_SETUP_WIZARD']}</h1>
                <div class="install_img"><a href="https://suitecrm.com" target="_blank"><img src="{$sugar_md}" alt="SuiteCRM"></a></div>
            </header>
		<div id="content">
			<h2>{$mod_strings['LBL_OLD_PHP']}</h2>
			<div class="floatbox full">{$msg}
            <div id="licenseaccept">
                <input type="checkbox" class="checkbox" name="setup_old_php" id="button_next2" onClick='toggleNextButton();' {$checked} />
                <a href='javascript:void(0)' onClick='toggleOldPHP();toggleNextButton();'>{$mod_strings['LBL_OLD_PHP_OK']}</a>
            </div>
            </div>
		</div>
            <hr>
            <div id="installcontrols">

                <input type="hidden" name="current_step" value="{$next_step}">
                {$mod_strings['LBL_WELCOME_CHOOSE_LANGUAGE']}: <select name="language" onchange='onLangSelect(this);';>{$langDropDown}</select>
                <input class="acceptButton" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next" disabled="disabled" title="{$mod_strings['LBL_LICENCE_TOOLTIP']}" />
                <input type="hidden" name="goto" id='hidden_goto' value="{$mod_strings['LBL_NEXT']}" />
            </div>

	    </form>
	    <div style="clear:both;"></div>
	    <div id='sysCheckMsg'></div>
	    <div style="clear:both;"></div>
	</div>
	<div id="checkingDiv" style="display:none">
            <p><img src='install/processing.gif' alt="{$mod_strings['LBL_LICENSE_CHECKING']}"> <br>{$mod_strings['LBL_LICENSE_CHECKING']}</p>
    </div>
	<footer id="install_footer">
        <p id="footer_links"><a href="https://suitecrm.com" target="_blank">Visit suitecrm.com</a> | <a href="https://suitecrm.com/index.php?option=com_kunena&view=category&Itemid=1137&layout=list" target="_blank">Support Forums</a> | <a href="https://docs.suitecrm.com/admin/installation-guide/" target="_blank">Installation Guide</a> | <a href="LICENSE.txt" target="_blank">License</a>
    </footer>
    </div>
<script>

function onLangSelect(e) {
    $("input[name=current_step]").attr('name', '_current_step');
    $("input[name=goto]").attr('name', '_goto');
    e.form.submit();
}
</script>

</body>
</html>
EOQ;

echo $out;
