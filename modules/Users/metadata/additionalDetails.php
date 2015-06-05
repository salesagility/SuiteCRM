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


function additionalDetailsUser($fields) {
	static $mod_strings;
	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Users');
	}
		
	$overlib_string = '';
    if(!empty($fields['ID'])) {
        $overlib_string .= '<input type="hidden" value="'. $fields['ID'];
        $overlib_string .= '">';
    }

    $overlib_string .= '<h2><img src="index.php?entryPoint=getImage&themeName=' . SugarThemeRegistry::current()->name .'&imageName=Users.gif"/> '.$mod_strings['LBL_MODULE_NAME'].':</h2>';

    if(!empty($fields['NAME'])) {
          	$overlib_string .= '<b>'. $mod_strings['LBL_NAME'] . '</b> ' . $fields['NAME'];
            $overlib_string .= '<br>';
    }

    if(!empty($fields['TITLE'])) {
        $overlib_string .= '<b>'. $mod_strings['LBL_TITLE'] . '</b> ' . $fields['TITLE'];
        $overlib_string .= '<br>';
    }

    if(!empty($fields['DEPARTMENT'])) {
        $overlib_string .= '<b>'. $mod_strings['LBL_DEPARTMENT'] . '</b> ' . $fields['DEPARTMENT'];
        $overlib_string .= '<br>';
    }

    if(!empty($fields['PHONE_HOME'])) {
        $overlib_string .= '<b>'. $mod_strings['LBL_HOME_PHONE'] . '</b> ' . $fields['PHONE_HOME'];
        $overlib_string .= '<br>';
    }

    if(!empty($fields['PHONE_MOBILE'])) {
        $overlib_string .= '<b>'. $mod_strings['LBL_MOBILE_PHONE'] . '</b> ' . $fields['PHONE_MOBILE'];
        $overlib_string .= '<br>';
    }
    if(!empty($fields['EMAIL1'])) {
        $overlib_string .= '<b>'. $mod_strings['LBL_EMAIL'] . '</b> ' . $fields['EMAIL1'];
        $overlib_string .= '<br>';
    }

	$editLink = "index.php?action=EditView&module=Users&record={$fields['ID']}";
	$viewLink = "index.php?action=DetailView&module=Users&record={$fields['ID']}";

	return array('fieldToAddTo' => 'NAME',
				 'string' => $overlib_string,
				 'editLink' => $editLink,
				 'viewLink' => $viewLink);
}
 
?>
