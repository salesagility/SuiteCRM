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


class AdministrationController extends SugarController
{
    public function action_savetabs()
    {
        require_once('include/SubPanel/SubPanelDefinitions.php');
        require_once('modules/MySettings/TabController.php');


        global $current_user, $app_strings;

        if (!is_admin($current_user)) sugar_die($app_strings['ERR_NOT_ADMIN']);

        // handle the tabs listing
        $toDecode = html_entity_decode  ($_REQUEST['enabled_tabs'], ENT_QUOTES);
        $enabled_tabs = json_decode($toDecode);
        $tabs = new TabController();
        $tabs->set_system_tabs($enabled_tabs);
        $tabs->set_users_can_edit(isset($_REQUEST['user_edit_tabs']) && $_REQUEST['user_edit_tabs'] == 1);

        // handle the subpanels
        if(isset($_REQUEST['disabled_tabs'])) {
            $disabledTabs = json_decode(html_entity_decode($_REQUEST['disabled_tabs'], ENT_QUOTES));
            $disabledTabsKeyArray = TabController::get_key_array($disabledTabs);
            SubPanelDefinitions::set_hidden_subpanels($disabledTabsKeyArray);
        }

        header("Location: index.php?module=Administration&action=ConfigureTabs");
    }

    public function action_savelanguages()
    {
        global $sugar_config;
        $toDecode = html_entity_decode  ($_REQUEST['disabled_langs'], ENT_QUOTES);
        $disabled_langs = json_decode($toDecode);
        $toDecode = html_entity_decode  ($_REQUEST['enabled_langs'], ENT_QUOTES);
        $enabled_langs = json_decode($toDecode);
        $cfg = new Configurator();
        $cfg->config['disabled_languages'] = join(',', $disabled_langs);
        // TODO: find way to enforce order
        $cfg->handleOverride();
        header("Location: index.php?module=Administration&action=Languages");
    }


    /**
     * action_saveglobalsearchsettings
     *
     * This method handles saving the selected modules to display in the Global Search Settings.
     * It instantiates an instance of UnifiedSearchAdvanced and then calls the saveGlobalSearchSettings
     * method.
     *
     */
    public function action_saveglobalsearchsettings()
    {
		 global $current_user, $app_strings;

		 if (!is_admin($current_user))
		 {
		     sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
		 }

    	 try
         {
	    	 require_once('modules/Home/UnifiedSearchAdvanced.php');
	    	 $unifiedSearchAdvanced = new UnifiedSearchAdvanced();
	    	 $unifiedSearchAdvanced->saveGlobalSearchSettings();
	    	    echo "true";
    	 }
         catch (Exception $ex)
         {
    	 	 echo "false";
    	 }
    }

    public function action_UpdateAjaxUI()
    {
        require_once('modules/Configurator/Configurator.php');
        $cfg = new Configurator();
        $disabled = json_decode(html_entity_decode  ($_REQUEST['disabled_modules'], ENT_QUOTES));
        $cfg->config['addAjaxBannedModules'] = empty($disabled) ? FALSE : $disabled;
        $cfg->handleOverride();
        $this->view = "configureajaxui";
    }


    /*
     * action_callRebuildSprites
     *
     * This method is responsible for actually running the SugarSpriteBuilder class to rebuild the sprites.
     * It is called from the ajax request issued by RebuildSprites.php.
     */
    public function action_callRebuildSprites()
    {
        global $current_user;
        $this->view = 'ajax';
        if(function_exists('imagecreatetruecolor'))
        {
            if(is_admin($current_user))
            {
                require_once('modules/UpgradeWizard/uw_utils.php');
                rebuildSprites(false);
            }
        } else {
            echo $mod_strings['LBL_SPRITES_NOT_SUPPORTED'];
            $GLOBALS['log']->error($mod_strings['LBL_SPRITES_NOT_SUPPORTED']);
        }
    }
}
