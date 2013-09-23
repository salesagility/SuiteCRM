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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('modules/Administration/Forms.php');
require_once('modules/Configurator/Configurator.php');
require_once('include/MVC/View/SugarView.php');
        
class AdministrationViewThemesettings extends SugarView 
{	
 	/**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   "<a href='index.php?module=Administration&action=index'>".$mod_strings['LBL_MODULE_NAME']."</a>",
    	   $mod_strings['LBL_THEME_SETTINGS']
    	   );
    }
    
	/**
     * @see SugarView::process()
     */
    public function process()
    {
        global $current_user;
        if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

        // Check if default_theme is valid
        if (isset($_REQUEST['default_theme']) && !in_array($_REQUEST['default_theme'], array_keys(SugarThemeRegistry::allThemes()))) {
            sugar_die("Default theme is invalid.");          
        }
        
        if (isset($_REQUEST['disabled_themes']) ) {
            $toDecode = html_entity_decode  ($_REQUEST['disabled_themes'], ENT_QUOTES);
			$disabledThemes = json_decode($toDecode, true);
			if ( ($key = array_search(SugarThemeRegistry::current()->__toString(),$disabledThemes)) !== FALSE ) {
                unset($disabledThemes[$key]);
            }
            $_REQUEST['disabled_themes'] = implode(',',$disabledThemes);
            $configurator = new Configurator();
            $configurator->config['disabled_themes'] = $_REQUEST['disabled_themes'];
            $configurator->config['default_theme'] = $_REQUEST['default_theme'];
            $configurator->handleOverride();
            echo "true";
        } else {
        	parent::process();
        }
    }
    
 	/** 
     * display the form
     */
 	public function display()
    {
        global $mod_strings, $app_strings, $current_user;
        
        if ( !is_admin($current_user) )
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
            
        $enabled = array();
        foreach(SugarThemeRegistry::availableThemes() as $dir => $theme)
        {
        	$enabled[] = array("theme" => $theme, "dir" => $dir);
        }
    	$disabled = array();
        foreach(SugarThemeRegistry::unAvailableThemes() as $dir => $theme)
        {
        	$disabled[] = array("theme" => $theme, "dir" => $dir);
        }
        $this->ss->assign("THEMES", get_select_options_with_id(SugarThemeRegistry::allThemes(), $GLOBALS['sugar_config']['default_theme']));
        $this->ss->assign('enabled_modules', json_encode($enabled));
        $this->ss->assign('disabled_modules', json_encode($disabled));
        $this->ss->assign('mod', $mod_strings);
        $this->ss->assign('APP', $app_strings);
        $this->ss->assign('currentTheme', SugarThemeRegistry::current());
        
        echo $this->getModuleTitle(false);
        echo $this->ss->fetch('modules/Administration/templates/themeSettings.tpl');
    }
}
