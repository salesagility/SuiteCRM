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

$sm = sm_build_array();
$sm_smarty = new Sugar_Smarty();

global $sugar_config;
if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
{
    $current_language = $_SESSION['authenticated_user_language'];
}
else
{
    $current_language = $sugar_config['default_language'];
}

$mod_strings = return_module_language($current_language, 'Home');
$sm_smarty->assign('CLOSE', isset($mod_strings['LBL_CLOSE_SITEMAP']) ? $mod_strings['LBL_CLOSE_SITEMAP'] : '');

// get the list_strings in order for module friendly name display.
$app_list_strings = return_app_list_strings_language($current_language);

foreach ($sm as $mod_dir_name => $links)
{
    $module_friendly_name = $app_list_strings['moduleList'][$mod_dir_name];
    $temphtml = "";
    $temphtml .= '<h4><a href="javascript:window.location=\'index.php?module='.$mod_dir_name.'&action=index\'">' . $module_friendly_name .'</a></h4><ul class=\'noBullet\'>';

    foreach ($links as $name => $href)
    {
        $temphtml .= '<li class=\'noBullet\'><a href="javascript:window.location=\''. $href .'\'">' . $name . ' ' . '</a></li>';
    }

    $temphtml .= '</ul>';
    $sm_smarty->assign(strtoupper($mod_dir_name), $temphtml);
}

// Specify the sitemap template to use; allow developers to override this with a custom one to add/remove modules
// from the list
$tpl = 'modules/Home/sitemap.tpl';
if ( sugar_is_file('custom/modules/Home/sitemap.tpl') ) {
    $tpl = 'custom/modules/Home/sitemap.tpl';
}
echo $sm_smarty->fetch($tpl);

function sm_build_array()
{
    //if the sitemap array is already stored, then pass it back
    if (isset($_SESSION['SM_ARRAY']) && !empty($_SESSION['SM_ARRAY'])){
        return $_SESSION['SM_ARRAY'];   
    }   


    include("include/modules.php");
	global $sugar_config,$mod_strings;


	// Need to set up mod_strings when we iterate through module menus.
    $orig_modstrings = array();
    if(!empty($mod_strings))
    {
     $orig_modstrings = $mod_strings;
    }
    if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
    {
        $current_language = $_SESSION['authenticated_user_language'];
    }
    else
    {
        $current_language = $sugar_config['default_language'];
    }
	$exclude= array();		// in case you want to exclude any.
    $mstr_array = array();

	global $modListHeader;
	if(!isset($modListHeader))
	{
		global $current_user;
		if(isset($current_user))
		{
			$modListHeader = query_module_access_list($current_user);
		}
	}

    foreach($modListHeader as $key=>$val)
    {
        if(!empty($exclusion_array) && in_array($val,$exclude ))
        {
           continue;
        }
        else
        {
		    if (file_exists('modules/'.$val.'/Menu.php'))
		    {
                $mod_strings = return_module_language($current_language, $val);
                $module_menu = array();
                include('modules/'.$val.'/Menu.php');

                $tmp_menu_items = array();
                foreach($module_menu as $menu)
                {
               		if(isset($menu[0]) && !empty($menu[0]) && isset($menu[1]) && !empty($menu[1]) && trim($menu[0]) !='#')
               		{
                        $tmp_menu_items[$menu[1]] =$menu[0];
                    }
                }
                $mstr_array[$val] = $tmp_menu_items;
            }
        }
    }

	//reset the modstrings to current module
	$mod_strings = $orig_modstrings ;
    //store master array into session variable
    $_SESSION['SM_ARRAY'] = $mstr_array; 
	return $mstr_array;
}
