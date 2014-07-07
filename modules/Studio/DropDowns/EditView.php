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




global $app_list_strings, $app_strings, $mod_strings;

require_once('modules/Studio/DropDowns/DropDownHelper.php');
require_once('modules/Studio/parsers/StudioParser.php');
$dh = new DropDownHelper();
$dh->getDropDownModules();
$smarty = new Sugar_Smarty();
$smarty->assign('MOD', $GLOBALS['mod_strings']);
$title=getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_RENAME_TABS']), false);
$smarty->assign('title', $title);
$selected_lang = (!empty($_REQUEST['dropdown_lang'])?$_REQUEST['dropdown_lang']:$_SESSION['authenticated_user_language']);
if(empty($selected_lang)){

    $selected_lang = $GLOBALS['sugar_config']['default_language'];
}
if($selected_lang == $GLOBALS['current_language']){
	$my_list_strings = $GLOBALS['app_list_strings'];
}else{
	$my_list_strings = return_app_list_strings_language($selected_lang);
}
foreach($my_list_strings as $key=>$value){
	if(!is_array($value)){
		unset($my_list_strings[$key]);
	}
}
$modules = array_keys($dh->modules);
$dropdown_modules = array(''=>$GLOBALS['mod_strings']['LBL_DD_ALL']);
foreach($modules as $module){
    $dropdown_modules[$module] = (!empty($app_list_strings['moduleList'][$module]))?$app_list_strings['moduleList'][$module]: $module;
}
$smarty->assign('dropdown_modules',$dropdown_modules);
if(!empty($_REQUEST['dropdown_module']) &&  !empty($dropdown_modules[$_REQUEST['dropdown_module']]) ){

    $smarty->assign('dropdown_module',$_REQUEST['dropdown_module']);
    $dropdowns = (!empty($dh->modules[$_REQUEST['dropdown_module']]))?$dh->modules[$_REQUEST['dropdown_module']]: array();
    foreach($dropdowns as $ok=>$dk){
        if(!isset($my_list_strings[$dk]) || !is_array($my_list_strings[$dk])){
            unset($dropdowns[$ok]);

        }

    }


}else{
     if(!empty($_REQUEST['dropdown_module'])){
        $smarty->assign('error', 'Module does not have any known dropdowns');
    }
    $dropdowns = array_keys($my_list_strings);
}
asort($dropdowns);
if(!empty($_REQUEST['newDropdown'])){
    $smarty->assign('newDropDown',true);
}else{
$keys = array_keys($dropdowns);
$first_string = $dropdowns[$keys[0]];
$smarty->assign('dropdowns',$dropdowns);
if(empty($_REQUEST['dropdown_name']) || !in_array($_REQUEST['dropdown_name'], $dropdowns)){
    $_REQUEST['dropdown_name'] = $first_string;
}
$selected_dropdown = $my_list_strings[$_REQUEST['dropdown_name']];

foreach($selected_dropdown as $key=>$value){
   if($selected_lang != $_SESSION['authenticated_user_language'] && !empty($app_list_strings[$_REQUEST['dropdown_name']]) && isset($app_list_strings[$_REQUEST['dropdown_name']][$key])){
        $selected_dropdown[$key]=array('lang'=>$value, 'user_lang'=> '['.$app_list_strings[$_REQUEST['dropdown_name']][$key] . ']');
   }else{
       $selected_dropdown[$key]=array('lang'=>$value);
   }
}

$selected_dropdown = $dh->filterDropDown($_REQUEST['dropdown_name'], $selected_dropdown);

$smarty->assign('dropdown', $selected_dropdown);
$smarty->assign('dropdown_name',$_REQUEST['dropdown_name']);

}

$smarty->assign('dropdown_languages', get_languages());
if(strcmp($_REQUEST['dropdown_name'], 'moduleList') == 0){
	$smarty->assign('disable_remove', true);
	$smarty->assign('disable_add', true);
	$smarty->assign('use_push', 1);
}else{
	$smarty->assign('use_push', 0);
}

$imageSave = SugarThemeRegistry::current()->getImage( 'studio_save', '',null,null,'.gif',$mod_strings['LBL_SAVE']);
$imageUndo = SugarThemeRegistry::current()->getImage('studio_undo', '',null,null,'.gif',$mod_strings['LBL_UNDO']);
$imageRedo = SugarThemeRegistry::current()->getImage('studio_redo', '',null,null,'.gif',$mod_strings['LBL_REDO']);
$buttons = array();
$buttons[] = array('text'=>$mod_strings['LBL_BTN_UNDO'],'actionScript'=>"onclick='jstransaction.undo()'" );
$buttons[] = array('text'=>$mod_strings['LBL_BTN_REDO'],'actionScript'=>"onclick='jstransaction.redo()'" );
$buttons[] = array('text'=>$mod_strings['LBL_BTN_SAVE'],'actionScript'=>"onclick='if(check_form(\"editdropdown\")){document.editdropdown.submit();}'");
$buttonTxt = StudioParser::buildImageButtons($buttons);
$smarty->assign('buttons', $buttonTxt);
$smarty->assign('dropdown_lang', $selected_lang);

$editImage = SugarThemeRegistry::current()->getImage( 'edit_inline', '',null,null,'.gif',$mod_strings['LBL_INLINE']);
$smarty->assign('editImage',$editImage);
$deleteImage = SugarThemeRegistry::current()->getImage( 'delete_inline', '',null,null,'.gif',$mod_strings['LBL_DELETE']);
$smarty->assign('deleteImage',$deleteImage);
$smarty->display("modules/Studio/DropDowns/EditView.tpl");
?>
