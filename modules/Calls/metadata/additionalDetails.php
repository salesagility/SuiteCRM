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


function additionalDetailsCall($fields) {
    global $timedate;
	static $mod_strings;
	if(empty($mod_strings)) {
		global $current_language;
		$mod_strings = return_module_language($current_language, 'Calls');
	}
    $overlib_string = '';
    $overlib_string .= '<input id="type" type="hidden" value="Call"/>';

    if(!empty($fields['ID'])) {
        $overlib_string .= '<input id="id" type="hidden" value="'. $fields['ID'];
        $overlib_string .= '"/>';
    }

    $overlib_string .= '<h2><img src="index.php?entryPoint=getImage&themeName=' . SugarThemeRegistry::current()->name .'&imageName=Calls.gif"/> '.$mod_strings['LBL_CALL'].'</h2>';

   if(!empty($fields['NAME'])) {
        	$overlib_string .= '<b>'. $mod_strings['LBL_SUBJECT'] . '</b> ';
            $url = 'index.php?action=DetailView&module=Calls&record='.$fields['ID'];
            $overlib_string .= '<a href="'.$url.'">' . $fields['NAME'] . '</a>';
        	$overlib_string .= '<br>';
    }
	if(!empty($fields['DATE_START'])) {
        $data_date = $timedate->fromUser($fields['DATE_START'])->format('Y-m-d H:i:s');
        $overlib_string .= '<span data-field="DATE_START" data-date="' . $data_date . '">';
        $overlib_string .= '<b>' . $mod_strings['LBL_DATE_TIME'] . '</b> ' . $fields['DATE_START'] . ' <br>';
        $overlib_string .= '</span>';
    }
	if(isset($fields['DURATION_HOURS']) || isset($fields['DURATION_MINUTES'])) {
		$overlib_string .= '<b>'. $mod_strings['LBL_DURATION'] . '</b> ';
        if(isset($fields['DURATION_HOURS'])) {
            $overlib_string .= $fields['DURATION_HOURS'] . $mod_strings['LBL_HOURS_ABBREV'] . ' ';
        }
        if(isset($fields['DURATION_MINUTES'])) {
            $overlib_string .=  $fields['DURATION_MINUTES'] . $mod_strings['LBL_MINSS_ABBREV'];
        }
        $overlib_string .=  '<br>';
	}
    if (!empty($fields['PARENT_ID']))
    {
            $overlib_string .= "<b>". $mod_strings['LBL_RELATED_TO'] . "</b> ".
                    "<a href='index.php?module=".$fields['PARENT_TYPE']."&action=DetailView&record=".$fields['PARENT_ID']."'>".
                    $fields['PARENT_NAME'] . "</a>";
            $overlib_string .= '<br>';
    }
    if(!empty($fields['STATUS'])) {
      	$overlib_string .= '<b>'. $mod_strings['LBL_STATUS'] . '</b> ' . $fields['STATUS'];
      	$overlib_string .= '<br>';
      }
	if(!empty($fields['DESCRIPTION'])) {
		$overlib_string .= '<b>'. $mod_strings['LBL_DESCRIPTION'] . '</b> ' . substr($fields['DESCRIPTION'], 0, 300);
		if(strlen($fields['DESCRIPTION']) > 300) $overlib_string .= '...';
		$overlib_string .= '<br>';
	}
    $overlib_string .= '<br>';
	$editLink = "index.php?action=EditView&module=Calls&record={$fields['ID']}";
	$viewLink = "index.php?action=DetailView&module=Calls&record={$fields['ID']}";

	return array('fieldToAddTo' => 'NAME',
				 'string' => $overlib_string,
				 'editLink' => $editLink,
				 'viewLink' => $viewLink);
}

