{*
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

*}
{$SQS}
{literal}
<script>

disabledModules = [];
enableQS(true);
function parent_typechangeQS() {
    var formName = {/literal}'{$formName}';{literal}
    var parentFieldName = formName + "_parent_name";
    
    disabledModules = [];
    new_module = document[formName].parent_type.value;
    
    if(typeof(disabledModules[new_module]) != 'undefined') {
        sqs_objects[parentFieldName]['disable'] = true;
        document.getElementById('parent_name').readOnly = true;
        document.getElementById('parent_name').value = mod_strings['LBL_QS_DISABLED'];
    }
    else {
        sqs_objects[parentFieldName]['disable'] = false;
        document.getElementById('parent_name').readOnly = false;
    }   
    sqs_objects[parentFieldName]['modules'] = new Array(new_module);
    if (document.getElementById('smartInputFloater')) document.getElementById('smartInputFloater').style.display = 'none';
    //var newArray = array();
    QSFieldsArray[parentFieldName].sqs.modules = new Array(new_module);

    enableQS(true);
}
</script>
{/literal}
<form name="{$formName}" id="{$formName}">
<div id="importDiv" class='edit view'>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td>
<input name="module" value="Emails" type="hidden">
<input name="record" value="{$emailId}" type="hidden">
<input name="isDuplicate" value="false" type="hidden">
<input name="action" type="hidden">
<input name="return_module" type="hidden">
<input name="return_action" type="hidden">
<input name="return_id" type="hidden">
</td>
</tbody></table>
<table border="0" cellpadding="0" cellspacing="1" width="100%">
<tbody>
<tr>
{if $showAssignedTo}
<td scope="row" nowrap="nowrap" valign="top" width="12%">
<script type="text/javascript">addToValidate("{$formName}", "assigned_user_id", "relate", false, "{sugar_translate label="LBL_ASSIGNED_TO_ID"}");</script>
<script type="text/javascript">addToValidate("{$formName}", "assigned_user_name", "relate", false, "{sugar_translate label="LBL_ASSIGNED_TO"}");</script>
{sugar_translate label="LBL_ASSIGNED_TO"}:
</td>
<td nowrap="nowrap" width="37%">
<input name="assigned_user_name" class="sqsEnabled" tabindex="2" id="assigned_user_name" size="" value="{$userName}" type="text">
<input name="assigned_user_id" id="assigned_user_id" value="{$userId}" type="hidden">
<input name="btn_assigned_user_name" tabindex="2" title="{$APP.LBL_SELECT_BUTTON_TITLE}"  class="button" value="{$APP.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("Users", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"{/literal}{$formName}{literal}","field_to_name_array":{"id":"assigned_user_id","name":"assigned_user_name"}}{/literal}, "single", true);' type="button">
<input name="btn_clr_assigned_user_name" tabindex="2" title="{$APP.LBL_CLEAR_BUTTON_TITLE}"  class="button" onclick="this.form.assigned_user_name.value = ''; this.form.assigned_user_id.value = '';" value="{$APP.LBL_CLEAR_BUTTON_LABEL}" type="button">
</td>
</tr>
{/if}
<tr>
<td scope="row" nowrap="nowrap" valign="top" width="12%">
{sugar_translate label="LBL_EMAIL_RELATE"}:
</td>
<td nowrap="nowrap" width="37%"><slot _moz-userdefined="">
<table><tr><td>
<select onchange=" document['{$formName}'].parent_name.value=''; checkParentType(document['{$formName}'].parent_type.value, document['{$formName}'].change_parent); parent_typechangeQS();" name="parent_type" id="parent_type" tabindex="2">
{$parentOptions}</select>
</slot>
</td><td>
<slot _moz-userdefined="">
<input type="hidden" value="" name="parent_id" id="parent_id"/>
<input type="text" value="" tabindex="2" name="parent_name" id="parent_name" class="sqsEnabled" autocomplete="OFF"/>
<input type="button"  onclick='{literal} if(document["{/literal}{$formName}{literal}"].parent_type.value != ""){open_popup(document["{/literal}{$formName}{literal}"].parent_type.value,600,400,"",true,false,{"call_back_function":"set_return","form_name":"{/literal}{$formName}{literal}","field_to_name_array":{"id":"parent_id","name":"parent_name"}});}'{/literal} value="{$APP.LBL_SELECT_BUTTON_LABEL}"  title="{$APP.LBL_SELECT_BUTTON_TITLE}" class="button" tabindex="2" name="button" id="change_parent"/>
</slot>
</td></tr></table>
</td>
</tr>
{if $showDelete}
<tr><td scope="row" nowrap="nowrap" valign="top" width="12%">
{sugar_translate label="LBL_DELETE_FROM_SERVER"}:
</td>
<td nowrap="nowrap" width="37%">
<input class='ctabEditViewDF' type='checkbox' name='serverDelete'>
</td></tr>
{/if}
</tbody></table>
</div>
</form>