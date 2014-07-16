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

if(isset($_REQUEST['refreshparent'])){
	echo '<SCRIPT> parent.location.reload();</script>';	
}else if(isset($_REQUEST['module_name']) && isset($_REQUEST['showlist'])){
	$the_strings = return_module_language($current_language, $_REQUEST['module_name']);
	$mod_name = $_REQUEST['module_name'];
	echo SugarThemeRegistry::current()->getCSS();
	echo '<table width="100%" border="0" cellspacing=0 cellpadding="0" class="contentBox">';
	$sugar_body_only = 0;
	if(isset($_REQUEST['sugar_body_only'])){
		$sugar_body_only = $_REQUEST['sugar_body_only'];
	}
	foreach($the_strings as $key=>$value){
		echo "<tr><td nowrap>$key &nbsp;=>&nbsp; <a href='index.php?action=EditView&module=LabelEditor&module_name=$mod_name&record=$key&sugar_body_only=$sugar_body_only&style=popup'> $value </a></td></tr>";	
		
	}
	echo '</table>';
}else if(isset($_REQUEST['module_name'])){
	$the_strings = return_module_language($current_language, $_REQUEST['module_name']);
	$mod_name = $_REQUEST['module_name'];
	global $app_strings;
	echo '<form name="ListEdit"  name="EditView" method="POST" action="index.php">';
	echo '<input type="hidden" name="action" value="Save">';
	echo '<input type="hidden" name="multi_edit" value="true">';
	echo '<input type="hidden" name="module_name" value="'.$_REQUEST['module_name'].'">';
	echo '<input type="hidden" name="module" value="LabelEditor">';
	echo SugarThemeRegistry::current()->getCSS();
	echo <<<EOQ
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
	<td><input title="{$app_strings['LBL_SAVE_BUTTON_TITLE']}" accessKey="{$app_strings['LBL_SAVE_BUTTON_KEY']}" class="button" type="submit" name="button" value="  {$app_strings['LBL_SAVE_BUTTON_LABEL']}  " > &nbsp;<input title="{$app_strings['LBL_CANCEL_BUTTON_TITLE']}" accessKey="{APP.LBL_CANCEL_BUTTON_KEY}" class="button" type="button" name="button" onclick="document.location.reload()" value="  {$app_strings['LBL_CANCEL_BUTTON_LABEL']}  " ></td>
	</tr>
	</table>
	
EOQ;
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">';
	$sugar_body_only = 0;
	if(isset($_REQUEST['sugar_body_only'])){
		$sugar_body_only = $_REQUEST['sugar_body_only'];
	}
	foreach($the_strings as $key=>$value){
		echo "<tr><td><span class='dataLabel'>$value</span><br><span style='font-size: 9;'>$key</span><br><input name='$key' value='$value' size='40'></td></tr>";	
		
	}
	echo '</table>';
	echo <<<EOQ
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
	<td style="padding-top: 2px;"><input title="{$app_strings['LBL_SAVE_BUTTON_TITLE']}"  class="button" type="submit" name="button" value="  {$app_strings['LBL_SAVE_BUTTON_LABEL']}  " > &nbsp;<input title="{$app_strings['LBL_CANCEL_BUTTON_TITLE']}" class="button" type="button" name="button" onclick="document.location.reload()" value="  {$app_strings['LBL_CANCEL_BUTTON_LABEL']}  " ></td>
	</tr>
	</table>
	
EOQ;
	echo '</form>';
}else{
	echo 'No Module Selected';
}	


?>