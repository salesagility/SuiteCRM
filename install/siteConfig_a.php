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

if (is_file("config.php")) {
    if (!empty($sugar_config['default_theme'])) {
        $_SESSION['site_default_theme'] = $sugar_config['default_theme'];
    }

    if (!empty($sugar_config['disable_persistent_connections'])) {
        $_SESSION['disable_persistent_connections'] =
        $sugar_config['disable_persistent_connections'];
    }
    if (!empty($sugar_config['default_language'])) {
        $_SESSION['default_language'] = $sugar_config['default_language'];
    }
    if (!empty($sugar_config['translation_string_prefix'])) {
        $_SESSION['translation_string_prefix'] = $sugar_config['translation_string_prefix'];
    }
    if (!empty($sugar_config['default_charset'])) {
        $_SESSION['default_charset'] = $sugar_config['default_charset'];
    }

    if (!empty($sugar_config['default_currency_name'])) {
        $_SESSION['default_currency_name'] = $sugar_config['default_currency_name'];
    }
    if (!empty($sugar_config['default_currency_symbol'])) {
        $_SESSION['default_currency_symbol'] = $sugar_config['default_currency_symbol'];
    }
    if (!empty($sugar_config['default_currency_iso4217'])) {
        $_SESSION['default_currency_iso4217'] = $sugar_config['default_currency_iso4217'];
    }

    if (!empty($sugar_config['rss_cache_time'])) {
        $_SESSION['rss_cache_time'] = $sugar_config['rss_cache_time'];
    }
    if (!empty($sugar_config['languages'])) {
        // We need to encode the languages in a way that can be retrieved later.
        $language_keys = array();
        $language_values = array();

        foreach ($sugar_config['languages'] as $key=>$value) {
            $language_keys[] = $key;
            $language_values[] = $value;
        }

        $_SESSION['language_keys'] = urlencode(implode(",", $language_keys));
        $_SESSION['language_values'] = urlencode(implode(",", $language_values));
    }
}

////	errors
$errors = '';
if (isset($validation_errors) && is_array($validation_errors)) {
    if (count($validation_errors) > 0) {
        $errors  = '<div id="errorMsgs">';
        $errors .= '<p>'.$mod_strings['LBL_SITECFG_FIX_ERRORS'].'</p><ul>';
        foreach ($validation_errors as $error) {
            $errors .= '<li>' . $error . '</li>';
        }
        $errors .= '</ul></div>';
    }
}


////	ternaries
$sugarUpdates = (isset($_SESSION['setup_site_sugarbeet']) && !empty($_SESSION['setup_site_sugarbeet'])) ? 'checked="checked"' : '';
$siteSecurity = (isset($_SESSION['setup_site_defaults']) && !empty($_SESSION['setup_site_defaults'])) ? 'checked="checked"' : '';
$customSession = (isset($_SESSION['setup_site_custom_session_path']) && !empty($_SESSION['setup_site_custom_session_path'])) ? 'checked="checked"' : '';
$customLog = (isset($_SESSION['setup_site_custom_log_dir']) && !empty($_SESSION['setup_site_custom_log_dir'])) ? 'checked="checked"' : '';
$customId = (isset($_SESSION['setup_site_specify_guid']) && !empty($_SESSION['setup_site_specify_guid'])) ? 'checked="checked"' : '';

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
   <title>{$mod_strings['LBL_WIZARD_TITLE']}  {$mod_strings['LBL_SITECFG_TITLE']}</title>
   <link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
   <link rel="stylesheet" href="install/install.css" type="text/css" />
   <link rel="stylesheet" href="themes/suite8/css/fontello.css">
   <link rel="stylesheet" href="themes/suite8/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="css/fontello-ie7.css"><![endif]-->
   <link rel='stylesheet' type='text/css' href='include/javascript/yui/build/container/assets/container.css' />
   <script type="text/javascript" src="install/installCommon.js"></script>
   <script type="text/javascript" src="install/siteConfig.js"></script>
</head>
<body onload="javascript:document.getElementById('button_next2').focus();">
    <!--SuiteCRM installer-->
        <div id="install_container">
            <div id="install_box">
                <form action="install.php" method="post" name="setConfig" id="form">
                <div id="install_content">
                    <header id="install_header">
                        <div id="steps"><p>{$mod_strings['LBL_STEP6']}</p><i class="icon-progress-0" id="complete"></i><i class="icon-progress-1" id="complete"></i><i class="icon-progress-2" id="complete"></i><i class="icon-progress-3" id="complete"></i><i class="icon-progress-4" id="complete"></i><i class="icon-progress-5" id="complete"></i><i class="icon-progress-6"></i><i class="icon-progress-7"></i></div>
                        <div class="install_img"><a href="https://suitecrm.com" target="_blank"><img src="{$sugar_md}" alt="SuiteCRM"></a></div>
                    </header>
                    <input type="hidden" name="current_step" value="{$next_step}">
                    <h2>{$mod_strings['LBL_SITECFG_TITLE']}</h2>
                    <p>{$errors}</p>
                    <div class="required">{$mod_strings['LBL_REQUIRED']}</div>
                    <hr>
                    <h3>{$mod_strings['LBL_SITECFG_TITLE2']}</h3>
EOQ;

//hide this in typical mode
if (!empty($_SESSION['install_type'])  && strtolower($_SESSION['install_type'])=='custom') {
    $out .=<<<EOQ
<div class='install_block'>
    {$mod_strings['LBL_SITECFG_URL_MSG']}
    <span class="required">*</span>
    <label><b>{$mod_strings['LBL_SITECFG_URL']}</b></label>
    <input type="text" name="setup_site_url" id="button_next2" value="{$_SESSION['setup_site_url']}" size="40" />
    <br>{$mod_strings['LBL_SITECFG_SYS_NAME_MSG']}
    <span class="required">*</span>
    <label><b>{$mod_strings['LBL_SYSTEM_NAME']}</b></label>
    <input type="text" name="setup_system_name" value="{$_SESSION['setup_system_name']}" size="40" /><br>
</div>
EOQ;
    $db = getDbConnection();
    if ($db->supports("collation")) {
        $collationOptions = $db->getCollationList();
    }
    if (!empty($collationOptions)) {
        if (isset($_SESSION['setup_db_options']['collation'])) {
            $default = $_SESSION['setup_db_options']['collation'];
        } else {
            $default = $db->getDefaultCollation();
        }
        $options = get_select_options_with_id(array_combine($collationOptions, $collationOptions), $default);
        $out .=<<<EOQ
     <div class='install_block'>
        <br>{$mod_strings['LBL_SITECFG_COLLATION_MSG']}
        <span class="required">*</span>
        <label><b>{$mod_strings['LBL_COLLATION']}</b></label>
        <select name="setup_db_collation" id="setup_db_collation">$options</select><br>
     </div>
EOQ;
    }
}

$out .=<<<EOQ
<div class='install_block'>
    <p>{$mod_strings['LBL_SITECFG_PASSWORD_MSG']}</p>
    <label><b>{$mod_strings['LBL_SITECFG_ADMIN_Name']} <span class="required">*</span></b></label>
    <input type="text" name="setup_site_admin_user_name" value="{$_SESSION['setup_site_admin_user_name']}" size="20" maxlength="60" /><br>
    <label><b>{$mod_strings['LBL_SITECFG_ADMIN_PASS']} <span class="required">*</span></b></label>
    <input type="password" name="setup_site_admin_password" value="{$_SESSION['setup_site_admin_password']}" size="20" /><br>
    <label><b>{$mod_strings['LBL_SITECFG_ADMIN_PASS_2']} <span class="required">*</span></b></label>
    <input type="password" name="setup_site_admin_password_retype" value="{$_SESSION['setup_site_admin_password_retype']}" size="20" />
</div>
EOQ;

$out .= <<<EOQ
<hr>
</div>
<div id="installcontrols">
    <input class="button" type="button" name="goto" value="{$mod_strings['LBL_BACK']}" id="button_back_siteConfig_a" onclick="document.getElementById('form').submit();" />
    <input type="hidden" name="goto" value="{$mod_strings['LBL_BACK']}" />
    <input class="button" type="submit" name="goto" id="button_next2" value="{$mod_strings['LBL_NEXT']}" />
</div>
</form>
<br>
</div>
<footer id="install_footer">
    <p id="footer_links"><a href="https://suitecrm.com" target="_blank">Visit suitecrm.com</a> | <a href="https://suitecrm.com/suitecrm/forum" target="_blank">Support Forums</a> | <a href="https://docs.suitecrm.com/admin/installation-guide/" target="_blank">Installation Guide</a> | <a href="LICENSE.txt" target="_blank">License</a>
</footer>
</div>
</div>
</body>
</html>

EOQ;
echo $out;
