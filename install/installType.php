<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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




if (!isset($install_script) || !$install_script) {
    die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}
// $mod_strings come from calling page.

$langDropDown = get_select_options_with_id($supportedLanguages, $current_language);



if (!isset($_SESSION['licenseKey_submitted']) || !$_SESSION['licenseKey_submitted']) {
    $_SESSION['setup_license_key_users']        = 0;
    $_SESSION['setup_license_key_expire_date']  = "";
    $_SESSION['setup_license_key']              = "";
    $_SESSION['setup_num_lic_oc']              = 0;
}


//php version suggestion
$php_suggested_ver = '';
if (check_php_version() === -1) {
    $php_suggested_ver=$mod_strings['LBL_YOUR_PHP_VERSION'].phpversion().$mod_strings['LBL_RECOMMENDED_PHP_VERSION'];
}

///////////////////////////////////////////////////////////////////////////////
////    START OUTPUT

$langHeader = get_language_header();
$out = <<<EOQ
<!doctype html>
<html {$langHeader}>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_INSTALL_TYPE_TITLE']}</title>   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
    <link rel="stylesheet" href="install/install.css" type="text/css">
    <link rel="stylesheet" href="themes/SuiteP/css/responsiveslides.css" type="text/css">
    <link rel="stylesheet" href="themes/SuiteP/css/themes.css" type="text/css">
    <link rel="stylesheet" href="themes/SuiteP/css/fontello.css">
    <link rel="stylesheet" href="themes/SuiteP/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
    <script src="include/javascript/jquery/jquery-min.js"></script>
</head>
<body onload="javascript:document.getElementById('button_next').focus();">
    <!--SuiteCRM installer-->
    <div id="install_container">
        <div id="install_box">
            <header id="install_header">
                <div id="steps"><p>{$mod_strings['LBL_STEP3']}</p><i class="icon-progress-0" id="complete"></i><i class="icon-progress-1" id="complete"></i><i class="icon-progress-2"></i><i class="icon-progress-3"></i><i class="icon-progress-4"></i><i class="icon-progress-5"></i><i class="icon-progress-6"></i><i class="icon-progress-7"></i></div>
                <div class="install_img"><a href="https://suitecrm.com"><img src="{$sugar_md}" alt="SuiteCRM"></a></div>
            </header>
            <form action="install.php" method="post" name="form" id="form">
            <div id="install_content">
EOQ;

$typical_checked ='checked';
$custom_checked ='';
if (isset($_SESSION['install_type']) && $_SESSION['install_type']=='custom') {
    $typical_checked ='';
    $custom_checked ='checked';
}
    //do nothing because defaults handle this condition


$out .= <<<EOQ2
                <div id="installoptions">
                    <h2>{$mod_strings['LBL_INSTALL_TYPE_SUBTITLE']}</h2>
                    <input name="install_type" type="radio" value="Typical" {$typical_checked}>{$mod_strings['LBL_INSTALL_TYPE_TYPICAL']}
                    {$mod_strings['LBL_INSTALL_TYPE_MSG2']}
                    <br>
                    <input type="radio" name="install_type" value="custom" {$custom_checked}>{$mod_strings['LBL_INSTALL_TYPE_CUSTOM']}
                    {$mod_strings['LBL_INSTALL_TYPE_MSG3']}
                    <br>
                    <b><i>{$php_suggested_ver}</i></b>
                    <br>
                    <hr>
                </div>
                </div>
                <div id="installcontrols">
                    <input type="hidden" name="current_step" value="{$next_step}">
                    <input class="button" type="button" value="{$mod_strings['LBL_BACK']}" id="button_back_installType" onclick="document.getElementById('form').submit();" />
                    <input type="hidden" name="goto" value="{$mod_strings['LBL_BACK']}" />
                    <input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next" />
                </div>
            </form>
        </div>
        <footer id="install_footer">
    <p id="footer_links"><a href="https://suitecrm.com" target="_blank">Visit suitecrm.com</a> | <a href="https://suitecrm.com/suitecrm/forum" target="_blank">Support Forums</a> | <a href="https://docs.suitecrm.com/admin/installation-guide/" target="_blank">Installation Guide</a> | <a href="LICENSE.txt" target="_blank">License</a>
</footer>
</div>
</body>
</html>
EOQ2;
echo $out;
