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


require_once('include/MVC/Controller/SugarController.php');
class ConfiguratorController extends SugarController
{
    /**
     * Go to the font manager view
     */
    function action_FontManager(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'fontmanager';
    }

    /**
     * Delete a font and go back to the font manager
     */
    function action_deleteFont(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $urlSTR = 'index.php?module=Configurator&action=FontManager';
        if(!empty($_REQUEST['filename'])){
            require_once('include/Sugarpdf/FontManager.php');
            $fontManager = new FontManager();
            $fontManager->filename = $_REQUEST['filename'];
            if(!$fontManager->deleteFont()){
                $urlSTR .='&error='.urlencode(implode("<br>",$fontManager->errors));
            }
        }
        header("Location: $urlSTR");
    }

    function action_listview(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'edit';
    }
    /**
     * Show the addFont view
     */
    function action_addFontView(){
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'addFontView';
    }
    /**
     * Add a new font and show the addFontResult view
     */
    function action_addFont(){
        global $current_user, $mod_strings;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        if(empty($_FILES['pdf_metric_file']['name'])){
            $this->errors[]=translate("ERR_MISSING_REQUIRED_FIELDS")." ".translate("LBL_PDF_METRIC_FILE", "Configurator");
            $this->view = 'addFontView';
            return;
        }
        if(empty($_FILES['pdf_font_file']['name'])){
            $this->errors[]=translate("ERR_MISSING_REQUIRED_FIELDS")." ".translate("LBL_PDF_FONT_FILE", "Configurator");
            $this->view = 'addFontView';
            return;
        }
        $path_info = pathinfo($_FILES['pdf_font_file']['name']);
        $path_info_metric = pathinfo($_FILES['pdf_metric_file']['name']);
        if(($path_info_metric['extension']!="afm" && $path_info_metric['extension']!="ufm") ||
        ($path_info['extension']!="ttf" && $path_info['extension']!="otf" && $path_info['extension']!="pfb")){
            $this->errors[]=translate("JS_ALERT_PDF_WRONG_EXTENSION", "Configurator");
            $this->view = 'addFontView';
            return;
        }

        if($_REQUEST['pdf_embedded'] == "false"){
            if(empty($_REQUEST['pdf_cidinfo'])){
                $this->errors[]=translate("ERR_MISSING_CIDINFO", "Configurator");
                $this->view = 'addFontView';
                return;
            }
            $_REQUEST['pdf_embedded']=false;
        }else{
            $_REQUEST['pdf_embedded']=true;
            $_REQUEST['pdf_cidinfo']="";
        }
        $this->view = 'addFontResult';
    }
    function action_saveadminwizard()
    {
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $focus = new Administration();
        $focus->retrieveSettings();
        $focus->saveConfig();

        $configurator = new Configurator();
        $configurator->populateFromPost();
        $configurator->handleOverride();
        $configurator->parseLoggerSettings();
        $configurator->saveConfig();

        // Bug 37310 - Delete any existing currency that matches the one we've just set the default to during the admin wizard
        $currency = new Currency;
        $currency->retrieve($currency->retrieve_id_by_name($_REQUEST['default_currency_name']));
        if ( !empty($currency->id)
                && $currency->symbol == $_REQUEST['default_currency_symbol']
                && $currency->iso4217 == $_REQUEST['default_currency_iso4217'] ) {
            $currency->deleted = 1;
            $currency->save();
        }

        SugarApplication::redirect('index.php?module=Users&action=Wizard&skipwelcome=1');
    }

    function action_saveconfig()
    {
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $configurator = new Configurator();
        if ($configurator->saveConfig() === false)
        {
            $this->errors = array(
                'company_logo' => $configurator->getError(),
            );
            $this->view = 'edit';
            return;
        }

        $focus = new Administration();
        $focus->saveConfig();

        // Clear the Contacts file b/c portal flag affects rendering
        if (file_exists($cachedfile = sugar_cached('modules/Contacts/EditView.tpl')))
           unlink($cachedfile);

        SugarApplication::redirect('index.php?module=Administration&action=index');
    }

    function action_detail()
    {
        global $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'edit';
    }

    /**
     * Define correct view for action
     */
    function action_historyContactsEmails()
    {
        $this->view = 'historyContactsEmails';
    }

    /**
     * Generates custom field_defs for selected fields
     */
    function action_historyContactsEmailsSave()
    {
        if (!empty($_POST['modules']) && is_array($_POST['modules'])) {
            require_once('include/SubPanel/SubPanelDefinitions.php');

            $modules = array();
            foreach ($_POST['modules'] as $moduleName => $enabled) {
                $bean = BeanFactory::getBean($moduleName);

                if (!($bean instanceof SugarBean)) {
                    continue;
                }
                if (empty($bean->field_defs)) {
                    continue;
                }

                $subPanel = new SubPanelDefinitions($bean);
                if (empty($subPanel->layout_defs)) {
                    continue;
                }
                if (empty($subPanel->layout_defs['subpanel_setup'])) {
                    continue;
                }

                $isValid = false;
                foreach ($subPanel->layout_defs['subpanel_setup'] as $subPanelDef) {
                    if (empty($subPanelDef['module']) || $subPanelDef['module'] != 'History') {
                        continue;
                    }
                    if (empty($subPanelDef['collection_list'])) {
                        continue;
                    }
                    foreach ($subPanelDef['collection_list'] as $v) {
                        if (!empty($v['get_subpanel_data']) && $v['get_subpanel_data'] == 'function:get_emails_by_assign_or_link') {
                            $isValid = true;
                            break 2;
                        }
                    }
                }
                if (!$isValid) {
                    continue;
                }

                $bean->load_relationships();
                foreach ($bean->get_linked_fields() as $fieldName => $fieldDef) {
                    if ($bean->$fieldName->getRelatedModuleName() == 'Contacts') {
                        $modules[$moduleName] = !$enabled;
                        break;
                    }
                }
            }

            $configurator = new Configurator();
            $configurator->config['hide_history_contacts_emails'] = $modules;
            $configurator->handleOverride();
        }

        SugarApplication::redirect('index.php?module=Administration&action=index');
    }
}
