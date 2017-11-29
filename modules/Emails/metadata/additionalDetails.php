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

 

function additionalDetailsEmail($fields) {
	global $current_language;
	$mod_strings = return_module_language($current_language, 'Emails');
	$newLines = array("\r", "\R", "\n", "\N");
		
	$overlib_string = '';
	// From Name
	if(!empty($fields['FROM_NAME'])) {
		$overlib_string .= '<b>' . $mod_strings['LBL_FROM'] . '</b>&nbsp;';
		$overlib_string .= $fields['FROM_NAME'];
	}

	// email text
	if(!empty($fields['DESCRIPTION_HTML'])) {
		if(!empty($overlib_string)) $overlib_string .= '<br>';
		$overlib_string .= '<b>'.$mod_strings['LBL_BODY'].'</b><br>';
		$descH = strip_tags($fields['DESCRIPTION_HTML'], '<a>');
		$desc = str_replace($newLines, ' ', $descH);
		$overlib_string .= substr($desc, 0, 300);
		if(strlen($descH) > 300) $overlib_string .= '...';
	} elseif (!empty($fields['DESCRIPTION'])) {
		if(!empty($overlib_string)) $overlib_string .= '<br>';
		$overlib_string .= '<b>'.$mod_strings['LBL_BODY'].'</b><br>';
		$descH = strip_tags(nl2br($fields['DESCRIPTION']));
		$desc = str_replace($newLines, ' ', $descH);
		$overlib_string .= substr($desc, 0, 300);
		$overlib_string .= substr($desc, 0, 300);
		if(strlen($descH) > 300) $overlib_string .= '...';
	}
	
	$editLink = "index.php?action=EditView&module=Emails&record={$fields['ID']}"; 
	$viewLink = "index.php?action=DetailView&module=Emails&record={$fields['ID']}";	

	$return_module = empty($_REQUEST['module']) ? 'Meetings' : $_REQUEST['module'];
	$return_action = empty($_REQUEST['action']) ? 'ListView' : $_REQUEST['action'];
	$type = empty($_REQUEST['type']) ? '' : $_REQUEST['type'];
	$user_id = empty($_REQUEST['assigned_user_id']) ? '' : $_REQUEST['assigned_user_id'];
	
	$additional_params = "&return_module=$return_module&return_action=$return_action&type=$type&assigned_user_id=$user_id"; 
	
	$editLink .= $additional_params;
	$viewLink .= $additional_params;
	
	return array('fieldToAddTo' => 'NAME', 
				 'string' => $overlib_string, 
				 'editLink' => $editLink, 
				 'viewLink' => $viewLink);
}
 
 ?>
 
