<?php
/**
 *
 * @package Advanced OpenPortal
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


global $current_user, $sugar_config;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $theme;

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

require_once('modules/Configurator/Configurator.php');


echo getClassicModuleTitle(
    "Administration",
    array(
        "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
        $mod_strings['LBL_AOP_ADMIN_MANAGE_AOP'],
    ),
    false
);

$cfg			= new Configurator();
$sugar_smarty	= new Sugar_Smarty();
$errors			= array();

if(!array_key_exists('aop',$cfg->config)){
    $cfg->config['aop'] = array(
        'enable_portal' => '',
        'joomla_url'=>'',
        'joomla_access_key'=>'',
        'distribution_method'=>'',
        'distribution_user_id'=>'',
        'user_email_template_id'=>'',
        'contact_email_template_id'=>'',
        'case_creation_email_template_id'=>'',
        'case_closure_email_template_id'=>'',
        'joomla_account_creation_email_template_id'=>'',
        'support_from_address'=>'',
        'support_from_name'=>'',
    );
}
if(isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
    if(!empty($_REQUEST['joomla_url'])){
        $cfg->config['aop']['joomla_url'] = 'http://' . preg_replace( '~^http://~', '', $_REQUEST['joomla_url']);
    }else{
        $cfg->config['aop']['joomla_url'] = '';
    }
    $cfg->config['aop']['enable_portal'] = !empty($_REQUEST['enable_portal']);
    $cfg->config['aop']['joomla_access_key'] = $_REQUEST['joomla_access_key'];
    $cfg->config['aop']['distribution_method'] = $_REQUEST['distribution_method'];
    $cfg->config['aop']['distribution_user_id'] = $_REQUEST['distribution_user_id'];
    $cfg->config['aop']['user_email_template_id'] = $_REQUEST['user_email_template_id'];
    $cfg->config['aop']['contact_email_template_id'] = $_REQUEST['contact_email_template_id'];
    $cfg->config['aop']['case_creation_email_template_id'] = $_REQUEST['case_creation_email_template_id'];
    $cfg->config['aop']['case_closure_email_template_id'] = $_REQUEST['case_closure_email_template_id'];
    $cfg->config['aop']['joomla_account_creation_email_template_id'] = $_REQUEST['joomla_account_creation_email_template_id'];
    $cfg->config['aop']['support_from_address'] = $_REQUEST['support_from_address'];
    $cfg->config['aop']['support_from_name'] = $_REQUEST['support_from_name'];
    $cfg->saveConfig();
    header('Location: index.php?module=Administration&action=index');
    exit();
}

$distributionMethod = "<OPTION value='singleUser'>".$mod_strings['LBL_SINGLE_USER']."</OPTION>";
$distributionMethod .= get_select_options_with_id($app_list_strings['dom_email_distribution_for_auto_create'], $cfg->config['aop']['distribution_method']);


if(!empty($cfg->config['aop']['distribution_user_id'])){
    $distributionUserName = BeanFactory::getBean("Users",$cfg->config['aop']['distribution_user_id'])->name;
}else{
    $distributionUserName = '';
}

$sugar_smarty->assign('distribution_user_name', $distributionUserName);

$emailTemplateList = get_bean_select_array(true,'EmailTemplate','name');

$userEmailTemplateDropdown = get_select_options_with_id($emailTemplateList,$cfg->config['aop']['user_email_template_id']);
$contactEmailTemplateDropdown = get_select_options_with_id($emailTemplateList,$cfg->config['aop']['contact_email_template_id']);
$creationEmailTemplateDropdown = get_select_options_with_id($emailTemplateList,$cfg->config['aop']['case_creation_email_template_id']);
$closureEmailTemplateDropdown = get_select_options_with_id($emailTemplateList,$cfg->config['aop']['case_closure_email_template_id']);
$joomlaEmailTemplateDropdown = get_select_options_with_id($emailTemplateList,$cfg->config['aop']['joomla_account_creation_email_template_id']);

$sugar_smarty->assign('USER_EMAIL_TEMPLATES', $userEmailTemplateDropdown);
$sugar_smarty->assign('CONTACT_EMAIL_TEMPLATES', $contactEmailTemplateDropdown);
$sugar_smarty->assign('CREATION_EMAIL_TEMPLATES', $creationEmailTemplateDropdown);
$sugar_smarty->assign('CLOSURE_EMAIL_TEMPLATES', $closureEmailTemplateDropdown);
$sugar_smarty->assign('JOOMLA_EMAIL_TEMPLATES', $joomlaEmailTemplateDropdown);

$sugar_smarty->assign('DISTRIBUTION_METHOD', $distributionMethod);
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign("JAVASCRIPT",get_set_focus_js());
$sugar_smarty->assign('config', $cfg->config['aop']);
$sugar_smarty->assign('error', $errors);


$buttons =  <<<EOQ
    <input title="{$app_strings['LBL_SAVE_BUTTON_TITLE']}"
                       accessKey="{$app_strings['LBL_SAVE_BUTTON_KEY']}"
                       class="button primary"
                       type="submit"
                       name="save"
                       onclick="return check_form('ConfigureSettings');"
                       value="  {$app_strings['LBL_SAVE_BUTTON_LABEL']}  " >
                &nbsp;<input title="{$mod_strings['LBL_CANCEL_BUTTON_TITLE']}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$app_strings['LBL_CANCEL_BUTTON_LABEL']}  " >
EOQ;

$sugar_smarty->assign("BUTTONS",$buttons);

$sugar_smarty->display('custom/modules/Administration/AOPAdmin.tpl');

$javascript = new javascript();
$javascript->setFormName('ConfigureSettings');
echo $javascript->getScript();
?>
<script language="Javascript" type="text/javascript">

    var selectElement = document.getElementById('distribution_method_select');
    selectElement.onchange = function(event){
        var distribRow = document.getElementById('distribution_user_row');
        if(selectElement.value == 'singleUser'){
            distribRow.style.display = "";
            addToValidate('ConfigureSettings','distribution_user_id','relate',true,"Please choose a user to assign cases to.");
        }else{
            SUGAR.clearRelateField(this.form, 'distribution_user_name', 'distribution_user_id');
            distribRow.style.display = "none";
            removeFromValidate('ConfigureSettings','distribution_user_id');
        }
    };
    selectElement.onchange();

    var currentEmailSelect;

    function open_email_template_form(id) {
        currentEmailSelect = id+"_select";
        URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
        URL += "&show_js=1";

        windowName = 'email_template';
        windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';

        win = window.open(URL, windowName, windowFeatures);
        if (window.focus) {
            // put the focus on the popup if the browser supports the focus() method
            win.focus();
        }
    }

    function edit_email_template_form(id) {
        currentEmailSelect = id+"_select";
        var field = document.getElementById(id+"_select");
        URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
        if (field.options[field.selectedIndex].value != 'undefined') {
            URL += "&record=" + field.options[field.selectedIndex].value;
        }
        URL += "&show_js=1";

        windowName = 'email_template';
        windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';

        win = window.open(URL, windowName, windowFeatures);
        if (window.focus) {
            // put the focus on the popup if the browser supports the focus() method
            win.focus();
        }
    }

    function refresh_email_template_list(template_id, template_name) {
        refresh_template_list(template_id, template_name, currentEmailSelect);
    }

    var templateFields = ['user_email_template_id_select','contact_email_template_id_select','case_creation_email_template_id_select','case_closure_email_template_id_select','joomla_account_creation_email_template_id_select'];

    function refreshEditVisibility(){
        for(var x = 0; x < templateFields.length; x++){
            var fieldId = templateFields[x];
            var field = document.getElementById(fieldId);
            field.onchange();
        }
    }

    function refresh_template_list(template_id, template_name, select) {
        var bfound = 0;
        for(var x = 0; x < templateFields.length; x++){
            var fieldId = templateFields[x];
            var field = document.getElementById(fieldId);
            for (var i = 0; i < field.options.length; i++) {
                if (field.options[i].value == template_id) {
                    if (field.options[i].selected == false  && fieldId == select) {
                        field.options[i].selected = true;
                    }
                    field.options[i].text = template_name;
                    bfound = 1;
                }
            }
            //add item to selection list.
            if (bfound == 0) {
                var newElement = document.createElement('option');
                newElement.text = template_name;
                newElement.value = template_id;
                field.options.add(newElement);
                if(fieldId == select) {
                    newElement.selected = true;
                }
            }
        }
        refreshEditVisibility();
    }
    function show_edit_template_link(field) {
        var field1 = document.getElementById(field.name + "_edit_template_link");
        if (field.selectedIndex == 0) {
            field1.style.visibility = "hidden";
        } else {
            field1.style.visibility = "visible";
        }
    }

    refreshEditVisibility();

</script>

