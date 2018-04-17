<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'modules/AOP_Case_Updates/util.php';

global $current_user, $sugar_config;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $theme;

if (!is_admin($current_user)) {
    sugar_die("Unauthorized access to administration.");
}

require_once('modules/Configurator/Configurator.php');

echo getClassicModuleTitle(
    "Administration",
    array(
        "<a href='index.php?module=Administration&action=index'>" .
        translate('LBL_MODULE_NAME', 'Administration') .
        "</a>",
        $mod_strings['LBL_AOP_ADMIN_MANAGE_AOP'],
    ),
    false
);

$cfg = new Configurator();
$sugar_smarty = new Sugar_Smarty();
$errors = array();
$lang = $app_list_strings['language_dom'];
$lang = array_merge( array( "default" => "Default" ), $lang );

if (!array_key_exists('aop', $cfg->config)) {

    $cfg->config['aop'] = array(
        'enable_aop' => 1,
        'enable_portal' => '',
        'joomla_url' => '',
        'joomla_access_key' => '',
        'distribution_method' => '',
        'distribution_options' => '',
        'distribution_user_id' => '',
        'case_status_changes' => json_encode(array()),
    );
    foreach( $lang as $key => $valor ){
       $cfg->config['aop'][$key] = array ( 'user_email_template_id' => '',
                                           'contact_email_template_id' => '',
                                           'case_creation_email_template_id' => '',
                                           'case_closure_email_template_id' => '',
                                           'joomla_account_creation_email_template_id' => '',
                                           'support_from_address' => '',
                                           'support_from_name' => '',
                                           'add_delimiter' => 0,
                                           'email_reply_delimiter' => '',
                                           'use_default_configuration' => 1,
                                           'use_delimiter_in_case_closure' => 0 );
    }
}
if (!array_key_exists('enable_aop', $cfg->config['aop'])) {
    $cfg->config['aop']['enable_aop'] = 1;
}
if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
    $joomlaUrl = strtolower(trim($_REQUEST['joomla_url']));
    if (!empty($joomlaUrl)) {
        $cfg->config['aop']['joomla_url'] =
            preg_match("@^https?://@", $joomlaUrl) ? $joomlaUrl : 'http://' . $joomlaUrl;
    } else {
        $cfg->config['aop']['joomla_url'] = '';
    }
    $cfg->config['aop']['enable_aop'] = !empty($_REQUEST['enable_aop']);
    $cfg->config['aop']['enable_portal'] = !empty($_REQUEST['enable_portal']);
    $cfg->config['aop']['joomla_access_key'] = $_REQUEST['joomla_access_key'];
    $cfg->config['aop']['distribution_method'] = $_REQUEST['distribution_method'];
    $cfg->config['aop']['distribution_user_id'] = $_REQUEST['distribution_user_id'];
    $cfg->config['aop']['distribution_options'] = $_REQUEST['distribution_options'];

    foreach( $lang as $key => $valor ){
       $cfg->config['aop'][$key]['user_email_template_id'] = $_REQUEST['user_email_template_id_'.$key];
       $cfg->config['aop'][$key]['contact_email_template_id'] = $_REQUEST['contact_email_template_id_'.$key];
       $cfg->config['aop'][$key]['case_creation_email_template_id'] = $_REQUEST['case_creation_email_template_id_'.$key];
       $cfg->config['aop'][$key]['case_closure_email_template_id'] = $_REQUEST['case_closure_email_template_id_'.$key];
       $cfg->config['aop'][$key]['joomla_account_creation_email_template_id'] = $_REQUEST['joomla_account_creation_email_template_id_'.$key];
       $cfg->config['aop'][$key]['support_from_address'] = $_REQUEST['support_from_address_'.$key];
       $cfg->config['aop'][$key]['support_from_name'] = $_REQUEST['support_from_name_'.$key];
       $cfg->config['aop'][$key]['add_delimiter'] = !empty( $_REQUEST['add_delimiter_'.$key] );
       $cfg->config['aop'][$key]['email_reply_delimiter'] = $_REQUEST['email_reply_delimiter_'.$key];
       $cfg->config['aop'][$key]['use_default_configuration'] = !empty( $_REQUEST['use_default_configuration_'.$key] );
       $cfg->config['aop'][$key]['use_delimiter_in_case_closure'] = !empty( $_REQUEST['use_delimiter_in_case_closure_'.$key] );
    }
    /*
     * We save the case_status_changes array as json since the way config changes are persisted to config.php
     * means that removing entries is tricky. json simplifies this.
     */
    $cfg->config['aop']['case_status_changes'] = json_encode(array_combine($_POST['if_status'], $_POST['then_status']));
    $cfg->saveConfig();
    header('Location: index.php?module=Administration&action=index');
    exit();
}
$distribStrings = $app_list_strings['dom_email_distribution_for_auto_create'];
unset($distribStrings['AOPDefault']);
$distributionMethod = get_select_options_with_id($distribStrings, $cfg->config['aop']['distribution_method']);
$distributionOptions = getAOPAssignField('distribution_options', $cfg->config['aop']['distribution_options']);

if (!empty($cfg->config['aop']['distribution_user_id'])) {
    $distributionUserName = BeanFactory::getBean("Users", $cfg->config['aop']['distribution_user_id'])->name;
} else {
    $distributionUserName = '';
}

$sugar_smarty->assign('distribution_user_name', $distributionUserName);

$emailTemplateList = get_bean_select_array(true, 'EmailTemplate', 'name', '', 'name');
$jsv = "var templateFields = [";
$jsf = "";
$jdaop = "";
$i = 0;
foreach( $lang as $key => $valor ){
   if ( $i>0 ) {
      $jsv .= ",";
   }
   $userEmailTemplateDropdown =
       get_select_options_with_id($emailTemplateList, $cfg->config['aop'][$key]['user_email_template_id']);
   $contactEmailTemplateDropdown =
       get_select_options_with_id($emailTemplateList, $cfg->config['aop'][$key]['contact_email_template_id']);
   $creationEmailTemplateDropdown =
       get_select_options_with_id($emailTemplateList, $cfg->config['aop'][$key]['case_creation_email_template_id']);
   $closureEmailTemplateDropdown =
       get_select_options_with_id($emailTemplateList, $cfg->config['aop'][$key]['case_closure_email_template_id']);
   $joomlaEmailTemplateDropdown =
       get_select_options_with_id($emailTemplateList, $cfg->config['aop'][$key]['joomla_account_creation_email_template_id']);

   $usetd[$key] = $userEmailTemplateDropdown;
   $coetd[$key] = $contactEmailTemplateDropdown;
   $cretd[$key] = $creationEmailTemplateDropdown;
   $cletd[$key] = $closureEmailTemplateDropdown;
   $joetd[$key] = $joomlaEmailTemplateDropdown; 
   $jsv .= "'user_email_template_id_{$key}_select', 'contact_email_template_id_{$key}_select', 'case_creation_email_template_id_{$key}_select', 'case_closure_email_template_id_{$key}_select', 'joomla_account_creation_email_template_id_{$key}_select'";
   $i++;
   $jsf .= "$('#add_delimiter_{$key}').change(function (){
      if($('#add_delimiter_{$key}').is(':checked') && $('#enable_aop').is(':checked')){
         addToValidate('ConfigureSettings','email_reply_delimiter_{$key}','text',true,'{$mod_strings['LBL_AOP_EMAIL_REPLY_ADD_DELIMITER']}');
         $('#truse_delimiter_in_case_closure_{$key}').show();
         $('#tremail_reply_delimiter_{$key}').show();
      } else {
         removeFromValidate('ConfigureSettings','email_reply_delimiter_{$key}');
         $('#truse_delimiter_in_case_closure_{$key}').hide();
         $('#tremail_reply_delimiter_{$key}').hide();
      }
   });$('#add_delimiter_{$key}').change();";

   $jdaop .= "$('#add_delimiter_{$key}').attr('checked', false);
              removeFromValidate('ConfigureSettings','email_reply_delimiter_{$key}');
              $('#add_delimiter_{$key}').change();";

   if ( $key != "default" ){
      $jsf .= "$('#use_default_configuration_{$key}').change(function (){
         if($('#use_default_configuration_{$key}').is(':checked') && $('#enable_aop').is(':checked')) {
            $('#e_settings_detail_{$key}').hide();
            $('#add_delimiter_{$key}').attr('checked', false);
            removeFromValidate('ConfigureSettings','email_reply_delimiter_{$key}');
            $('#add_delimiter_{$key}').change();
         } 
         else {
            $('#e_settings_detail_{$key}').show();
            $('#add_delimiter_{$key}').change();
         }
      });$('#use_default_configuration_{$key}').change();";
   }
}
$jsv .= "];";

$sugar_smarty->assign('USER_EMAIL_TEMPLATES', $usetd );
$sugar_smarty->assign('CONTACT_EMAIL_TEMPLATES', $coetd );
$sugar_smarty->assign('CREATION_EMAIL_TEMPLATES', $cretd );
$sugar_smarty->assign('CLOSURE_EMAIL_TEMPLATES', $cletd );
$sugar_smarty->assign('JOOMLA_EMAIL_TEMPLATES', $joetd );
$sugar_smarty->assign('DISTRIBUTION_METHOD', $distributionMethod);
$sugar_smarty->assign('DISTRIBUTION_OPTIONS', $distributionOptions);
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign("JAVASCRIPT", get_set_focus_js());
$sugar_smarty->assign('config', $cfg->config['aop']);
$sugar_smarty->assign('error', $errors);
$sugar_smarty->assign('AOP_JSF', $jsf);
$sugar_smarty->assign('AOP_JDAOP', $jdaop);

$sugar_smarty->assign('CONTACT_LANGUAGES', $lang);

$cBean = BeanFactory::getBean('Cases');
$statusDropdown = get_select_options($app_list_strings[$cBean->field_name_map['status']['options']], '');
$currentStatuses = '';

if($cfg->config['aop']['case_status_changes']) {
    foreach (json_decode($cfg->config['aop']['case_status_changes'], true) as $if => $then) {
        $ifDropdown = get_select_options($app_list_strings[$cBean->field_name_map['status']['options']], $if);
        $thenDropdown = get_select_options($app_list_strings[$cBean->field_name_map['status']['options']], $then);
        $currentStatuses .= getStatusRowTemplate($mod_strings, $ifDropdown, $thenDropdown) . "\n";
    }
}


$sugar_smarty->assign('currentStatuses', $currentStatuses);

$buttons = <<<EOQ
    <input title="{$app_strings['LBL_SAVE_BUTTON_TITLE']}"
                       accessKey="{$app_strings['LBL_SAVE_BUTTON_KEY']}"
                       class="button primary"
                       type="submit"
                       name="save"
                       onclick="return check_form('ConfigureSettings');"
                       value="  {$app_strings['LBL_SAVE_BUTTON_LABEL']}  " >
                &nbsp;<input title="{$mod_strings['LBL_CANCEL_BUTTON_TITLE']}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$app_strings['LBL_CANCEL_BUTTON_LABEL']}  " >
EOQ;

$sugar_smarty->assign("BUTTONS", $buttons);

$sugar_smarty->display('modules/Administration/AOPAdmin.tpl');

$javascript = new javascript();
$javascript->setFormName('ConfigureSettings');
echo $javascript->getScript();
?>
    <script type="text/template" id="statusRowTemplate">
        <?= getStatusRowTemplate($mod_strings, $statusDropdown, $statusDropdown) ?>
    </script>
    <script language="Javascript" type="text/javascript">

      var selectElement = document.getElementById('distribution_method_select');
      selectElement.onchange = function (event) {
        var distribRow = document.getElementById('distribution_user_row');
        var distribOptionsRow = document.getElementById('distribution_options_row');
        if (selectElement.value == 'singleUser') {
          showElem('distribution_user_row');
          hideElem('distribution_options_row');
          addToValidate('ConfigureSettings', 'distribution_user_id', 'relate', true, "Please choose a user to assign cases to.");
        } else {
          SUGAR.clearRelateField(this.form, 'distribution_user_name', 'distribution_user_id');
          hideElem('distribution_user_row');
          showElem('distribution_options_row');
          removeFromValidate('ConfigureSettings', 'distribution_user_id');
        }
      };
      selectElement.onchange();
      function hideElem(id) {
        if (document.getElementById(id)) {
          document.getElementById(id).style.display = "none";
          document.getElementById(id).value = "";
        }
      }

      function showElem(id) {
        if (document.getElementById(id)) {
          document.getElementById(id).style.display = "";
        }
      }

      function assign_field_change(field) {
        hideElem(field + '[1]');
        hideElem(field + '[2]');

        if (document.getElementById(field + '[0]').value == 'role') {
          showElem(field + '[2]');
        }
        else if (document.getElementById(field + '[0]').value == 'security_group') {
          showElem(field + '[1]');
          showElem(field + '[2]');
        }
      }
      var currentEmailSelect;

      function open_email_template_form(id) {
        currentEmailSelect = id + "_select";
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
        currentEmailSelect = id + "_select";
        var field = document.getElementById(id + "_select");
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

// templateFields definition variable
<?php
 echo $jsv;
?>

      function refreshEditVisibility() {
        for (var x = 0; x < templateFields.length; x++) {
          var fieldId = templateFields[x];
          var field = document.getElementById(fieldId);
          field.onchange();
        }
      }

      function refresh_template_list(template_id, template_name, select) {
        var bfound = 0;
        for (var x = 0; x < templateFields.length; x++) {
          var fieldId = templateFields[x];
          var field = document.getElementById(fieldId);
          for (var i = 0; i < field.options.length; i++) {
            if (field.options[i].value == template_id) {
              if (field.options[i].selected == false && fieldId == select) {
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
            if (fieldId == select) {
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
      $(document).ready(function () {
        $('#addStatusButton').click(function (e) {
          var template = $('#statusRowTemplate').html();
          $(e.target).closest('tr').before(template);
        });
        $(document).on('click', '.removeStatusButton', function (e) {
          $(e.target).closest('tr').remove();
        });
      });
    </script>
<?php
/**
 * @param $mod_strings
 * @param $ifDropdown
 * @param $thenDropdown
 * @return string
 */
function getStatusRowTemplate($mod_strings, $ifDropdown, $thenDropdown)
{
    $html = <<<EOF
    <tr>
        <td  scope="row" width="100">{$mod_strings['LBL_AOP_IF_STATUS']}: </td>
        <td width="100">
            <select id='if_status_select[]' name='if_status[]'>{$ifDropdown}</select>
        </td>
        <td  scope="row" width="100">{$mod_strings['LBL_AOP_THEN_STATUS']}: </td>
        <td width="100">
            <select id='then_status_select[]' name='then_status[]'>{$thenDropdown}</select>
        </td>
        <td><button class="removeStatusButton" type="button">{$mod_strings['LBL_AOP_REMOVE_STATUS']}</button></td>
    </tr>
EOF;

    return $html;
}
