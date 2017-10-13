{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
*}

<div>
    <label>{$MOD.LBL_OPT_IN_CHECKBOX_ON_PERSON_FORM_ENABLED}</label>
    <input type="hidden" name="opt_in_checkbox_on_person_form_enabled" value="0">
    <input type="checkbox" id="opt_in_checkbox_on_person_form_enabled" name="opt_in_checkbox_on_person_form_enabled" {if $opt_in_checkbox_on_person_form_enabled}checked="checked"{/if} value="1">
</div>

<div>
    <label>{$MOD.LBL_OPT_IN_CONFIRMATION_EMAIL_ENABLED}</label>
    <input type="hidden" name="opt_in_confirmation_email_enabled" value="0">
    <input type="checkbox" id="opt_in_confirmation_email_enabled" name="opt_in_confirmation_email_enabled" {if $opt_in_confirmation_email_enabled}checked="checked"{/if} value="1">
</div>

<div>
    <label>{$MOD.LBL_OPT_IN_CONFIRMATION_EMAIL_TEMPLATE}</label>
    <select id='opt_in_confirmation_email_template_id_select' name='opt_in_confirmation_email_template_id' onchange='show_edit_template_link(this);'>{$OPT_IN_CONFIRMATION_EMAIL_TEMPLATES}</select>

    <a href='javascript:open_email_template_form("opt_in_confirmation_email_template_id")' >{$MOD.LBL_CREATE_EMAIL_TEMPLATE}</a>
    <span name='edit_template' id='opt_in_confirmation_email_template_id_edit_template_link' style='visibility: hidden;'>
                    <a href='javascript:edit_email_template_form("opt_in_confirmation_email_template_id")' >{$MOD.LBL_EDIT_EMAIL_TEMPLATE}</a></span>
</div>
<script>
    {literal}

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

    var templateFields = ['opt_in_confirmation_email_template_id_select'];

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
    {/literal}
</script>