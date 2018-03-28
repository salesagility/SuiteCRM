<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

global $mod_strings;

$focus = new User();

// Add in defensive code here.
$focus->user_name = $_REQUEST['user_name'];
$username_password = $_REQUEST['username_password'];

$focus->load_user($username_password);

if ($focus->is_authenticated()) {
    // save the user information into the session
    // go to the home screen
    header("Location: ".$GLOBALS['app']->getLoginRedirect());
    unset($_SESSION['login_password']);
    unset($_SESSION['login_error']);
    unset($_SESSION['login_user_name']);

    $_SESSION['authenticated_user_id'] = $focus->id;

    // store the user's theme in the session
    if (isset($_REQUEST['login_theme'])) {
        $authenticated_user_theme = $_REQUEST['login_theme'];
    } elseif (isset($_REQUEST['ck_login_theme_20'])) {
        $authenticated_user_theme = $_REQUEST['ck_login_theme_20'];
    } else {
        $authenticated_user_theme = $sugar_config['default_theme'];
    }

    // store the user's language in the session
    if (isset($_REQUEST['login_language'])) {
        $authenticated_user_language = $_REQUEST['login_language'];
    } elseif (isset($_REQUEST['ck_login_language_20'])) {
        $authenticated_user_language = $_REQUEST['ck_login_language_20'];
    } else {
        $authenticated_user_language = $sugar_config['default_language'];
    }

    // If this is the default user and the default user theme is set to reset, reset it to the default theme value on each login
    if ($reset_theme_on_default_user && $focus->user_name == $sugar_config['default_user_name']) {
        $authenticated_user_theme = $sugar_config['default_theme'];
    }
    if (isset($reset_language_on_default_user) && $reset_language_on_default_user &&
         $focus->user_name == $sugar_config['default_user_name']) {
            $authenticated_user_language = $sugar_config['default_language'];
    }

    $_SESSION['authenticated_user_theme'] = $authenticated_user_theme;
    $_SESSION['authenticated_user_language'] = $authenticated_user_language;

    $GLOBALS['log']->debug("authenticated_user_theme is $authenticated_user_theme");
    $GLOBALS['log']->debug("authenticated_user_language is $authenticated_user_language");

    // Clear all uploaded import files for this user if it exists

    require_once('modules/Import/ImportCacheFiles.php');
    $tmp_file_name = ImportCacheFiles::getImportDir()."/IMPORT_" . $focus->id;

    if (file_exists($tmp_file_name)) {
        unlink($tmp_file_name);
    }

} else {
    $_SESSION['login_user_name'] = $focus->user_name;
    $_SESSION['login_password'] = $username_password;
    $_SESSION['login_error'] = $mod_strings['ERR_INVALID_PASSWORD'];

    // go back to the login screen.
    // create an error message for the user.
    header("Location: index.php");
}
