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

global $current_language;
$module_name = $_REQUEST['module_name'];
if(isset($_REQUEST['multi_edit'])){
	unset($_REQUEST['action']);
	unset($_REQUEST['module_name']);
	unset($_REQUEST['module']);
	$the_strings = return_module_language($current_language, $module_name);
	foreach($_REQUEST as $key=>$value){
		if(isset($the_strings[$key])){
			create_field_label($module_name, $current_language, $key, $value, true);
		}
	}
	$location = "index.php?action=LabelList&module=LabelEditor&refreshparent=1&sugar_body_only=1";
	header("Location:$location" );
}else{
	create_field_label($module_name, $current_language, $_REQUEST['record'], $_REQUEST['value'], true);
		$location = "index.php?action=". $_REQUEST['return_action']."&module=". $_REQUEST['return_module'];
	if(isset($_REQUEST['module_name'])){
		$location .= "&module_name=" . $_REQUEST['module_name'];
	}
	if(isset($_REQUEST['sugar_body_only'])){
		$location .= "&sugar_body_only=" . $_REQUEST['sugar_body_only'];
	}
	if(isset($_REQUEST['style']) && $_REQUEST['style'] == 'popup'){
		$location .= '&refreshparent=1';	
	}
	header("Location:$location" );
}


?>