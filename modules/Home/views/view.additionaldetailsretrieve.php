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

/*********************************************************************************

 * Description:  Target for ajax calls to retrieve AdditionalDetails
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/MVC/View/SugarView.php');
 
class HomeViewAdditionaldetailsretrieve extends SugarView
{
 	public function display()
 	{
        global $beanList, $beanFiles, $current_user, $app_strings, $app_list_strings;
        
        $moduleDir = empty($_REQUEST['bean']) ? '' : $_REQUEST['bean'];
        $beanName = empty($beanList[$moduleDir]) ? '' : $beanList[$moduleDir];
        $id = empty($_REQUEST['id']) ? '' : $_REQUEST['id'];
        
        // Bug 40216 - Add support for a custom additionalDetails.php file
        $additionalDetailsFile = $this->getAdditionalDetailsMetadataFile($moduleDir);
        
        if(empty($beanFiles[$beanName]) || 
            empty($id) || !is_file($additionalDetailsFile) ) {
                echo 'bad data';
                die();
        } 
        
        require_once($beanFiles[$beanName]);
        require_once($additionalDetailsFile);
        $adFunction = 'additionalDetails' . $beanName;
        
        if(function_exists($adFunction)) { // does the additional details function exist
            $json = getJSONobj();
            $bean = new $beanName();
            $bean->retrieve($id);
            
        	//bug38901 - shows dropdown list label instead of database value
			foreach($bean->field_name_map as $field => $value)
			{
				if($value["type"] == "enum" && isset($app_list_strings[$value['options']][$bean->$field]))
				{
					$bean->$field = $app_list_strings[$value['options']][$bean->$field];
				}
			}            
            
            $arr = array_change_key_case($bean->toArray(), CASE_UPPER);
        
            $results = $adFunction($arr);
            $retArray['body'] = str_replace(array("\rn", "\r", "\n"), array('','','<br />'), $results['string']);
            if(!$bean->ACLAccess('EditView')) $results['editLink'] = '';
            if(!$bean->ACLAccess('DetailView')) $results['viewLink'] = '';
            
            $retArray['caption'] = "<div style='float:left'>{$app_strings['LBL_ADDITIONAL_DETAILS']}</div><div style='float: right'>";
            if(!empty($_REQUEST['show_buttons'])){            
		    if(!empty($results['editLink']))
		    	$retArray['caption'] .= "<a title='".$GLOBALS['app_strings']['LBL_EDIT_BUTTON']."' href='".$results['editLink']."'><img border=0 src='".SugarThemeRegistry::current()->getImageURL('edit_inline.png',false)."'></a>";
		    if(!empty($results['viewLink']))
		    	$retArray['caption'] .= "<a title='".$GLOBALS['app_strings']['LBL_VIEW_BUTTON']."' href='".$results['viewLink']."'><img border=0 src='".SugarThemeRegistry::current()->getImageURL('view_inline.png',false)."' style='margin-left:2px;'></a>";
		    	$retArray['caption'] .= "<a title='".$GLOBALS['app_strings']['LBL_ADDITIONAL_DETAILS_CLOSE_TITLE']."' href='javascript: SUGAR.util.closeStaticAdditionalDetails();'><img border=0 src='".SugarThemeRegistry::current()->getImageURL('close.png',false)."' style='margin-left:2px;'></a>";
            }
            $retArray['caption'] .= ""; 
            $retArray['width'] = (empty($results['width']) ? '300' : $results['width']);              
            echo 'result = ' . $json->encode($retArray);
        }
    }
    
    protected function getAdditionalDetailsMetadataFile(
        $moduleName
        )
    {
        $additionalDetailsFile = 'modules/' . $moduleName . '/metadata/additionalDetails.php';
        if (file_exists('custom/'.$additionalDetailsFile)) {
            $additionalDetailsFile = 'custom/'.$additionalDetailsFile;
        }
        
        return $additionalDetailsFile;
    }
}
