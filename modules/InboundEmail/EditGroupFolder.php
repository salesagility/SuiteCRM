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

$_REQUEST['edit']='true';

require_once('include/SugarFolders/SugarFolders.php');

// GLOBALS
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $sugar_config;

$ie = new InboundEmail();
$focus = new SugarFolder();
$javascript = new Javascript();
/* Start standard EditView setup logic */

if (isset($_REQUEST['record'])) {
    $GLOBALS['log']->debug("In EditGroupFolder view, about to retrieve record: ".$_REQUEST['record']);
    $result = $focus->retrieve($_REQUEST['record']);
    if ($result == null) {
        sugar_die($app_strings['ERROR_NO_RECORD']);
    }
}

$GLOBALS['log']->info("SugarFolder Edit View");
/* End standard EditView setup logic */

// TEMPLATE ASSIGNMENTS
$smarty = new Sugar_Smarty();
// standard assigns
$smarty->assign('mod_strings', $mod_strings);
$smarty->assign('app_strings', $app_strings);
$smarty->assign('theme', $theme);
$smarty->assign('sugar_version', $sugar_version);
$smarty->assign('GRIDLINE', $gridline);
$smarty->assign('MODULE', 'InboundEmail');
$smarty->assign('RETURN_MODULE', 'InboundEmail');
$smarty->assign('RETURN_ID', $focus->id);
$smarty->assign('RETURN_ACTION', "");
$smarty->assign('ID', $focus->id);
// module specific

$ret = $focus->getFoldersForSettings($current_user);
$groupFolders = array();
$groupFoldersOrig = array();
foreach ($ret['groupFolders'] as $key => $value) {
    if (!empty($focus->id)) {
        if ($value['id'] == $focus->id) {
            continue;
        }
    } // if
    $groupFolders[$value['id']] = $value['name'];
    $groupFoldersOrig[] = $value['origName'];
} // foreach
$groupFolderName = "";
$addToGroupFolder = "";
$createGroupFolderStyle = "display:''";
$editGroupFolderStyle = "display:''";
if (!empty($focus->id)) {
    $groupFolderName = 	$focus->name;
}
if (!empty($focus->id)) {
    $addToGroupFolder = $focus->parent_folder;
}
if (!empty($focus->id)) {
    $createGroupFolderStyle = "display:none;";
} else {
    $editGroupFolderStyle = "display:none;";
} // else
$smarty->assign('createGroupFolderStyle', $createGroupFolderStyle);
$smarty->assign('editGroupFolderStyle', $editGroupFolderStyle);

$smarty->assign('groupFolderName', $groupFolderName);
$json = getJSONobj();
$smarty->assign('group_folder_array', $json->encode($groupFoldersOrig));
$smarty->assign('group_folder_options', get_select_options_with_id($groupFolders, $addToGroupFolder));


$smarty->assign('CSS', SugarThemeRegistry::current()->getCSS());


$smarty->assign('languageStrings', getVersionedScript("cache/jsLanguage/{$GLOBALS['current_language']}.js", $GLOBALS['sugar_config']['js_lang_version']));
echo $smarty->fetch("modules/Emails/templates/_createGroupFolder.tpl");
