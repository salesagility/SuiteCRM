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

<form name='relform' onsubmit='return false;'>
<input type='hidden' name='to_pdf' value='1'>
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='SaveRelationship'>
<input type='hidden' name='remove_tables' value='true' id="rel_remove_tables">
{if ! empty($view_package)}
<input type='hidden' name='view_package' value='{$view_package}'>
{/if}
<input type='hidden' name='view_module' value='{$view_module}' />
{if $rel.relationship_only}
<input type='hidden' name='relationship_only' value='1'>
{/if}
<table style="width:100%;" class="relform">
	<tr>
		<td colspan='2' style="padding:5px 5px 15px 5px">
			{if !$rel.readonly}
				{if empty($view_package)}
				<input type='button' name='saverelbtn' value='{$mod_strings.LBL_BTN_SAVEPUBLISH}' onclick='if(check_form("relform"))
				{else}
				<input type='button' name='saverelbtn' value='{$mod_strings.LBL_BTN_SAVE}' onclick='if(check_form("relform"))
				{/if}
				ModuleBuilder.submitForm("relform");' class='button'>
				{if ! empty($view_package)}
				&nbsp;
				{/if}
			{/if}
			{if ($rel.from_studio  || $rel.readonly && !$is_new) && $rel.relationship_type != 'one-to-one'}
			<input type='button' name='saverelbtn' value='{$mod_strings.LBL_BTN_SAVE}' onclick='if(check_form("relform")){ldelim} this.form.action.value="SaveRelationshipLabel"; ModuleBuilder.submitForm("relform");{rdelim}' class='button'>
			{/if}
			<input type='button' name='cancelbtn' value='{$mod_strings.LBL_BTN_CANCEL}' onclick='ModuleBuilder.tabPanel.removeTab(ModuleBuilder.findTabById("relEditor"));' class='button'>
            {if $hideLevel < 3 && ($rel.from_studio || !$rel.readonly && !$is_new)}
			<input type='button' name='deleterelbtn' value='{$mod_strings.LBL_BTN_DELETE}' onclick='ModuleBuilder.deleteRel()' class='button'>
            {/if}

		</td>
	</tr>
	{if empty($view_package) && $rel.relationship_type != 'one-to-one'}
	<tr>
		<td class='mbLBLL'>
			{$mod_strings.LBL_DROPDOWN_LANGUAGE}:&nbsp;
			{html_options name='relationship_lang' id='relationship_lang' options=$available_languages selected=$selected_lang onchange='ModuleBuilder.moduleLoadRelationship2(document.relform.relationship_name.value, null, "true");'}
		</td>
	</tr>
	{/if}
	<tr >
       <td>
       {if !empty($rel.relationship_name)}
       <span align="right" scope="row">{$mod_strings.LBL_REL_NAME}:&nbsp;</span><span>{$rel.relationship_name}</span>
       {/if}
       <input type="hidden" value="{$rel.relationship_name}" name="relationship_name" />
       </td>
    </tr>
	<tr><td colspan=2>
		<table class="edit view">
		    <tr><th align="center" colspan=2>{$mod_strings.LBL_LHS_MODULE}</th><th>{$mod_strings.LBL_REL_TYPE}</th><th colspan=2>{$mod_strings.LBL_RHS_MODULE}</th></tr>
			<tr>
				<td align="right" scope="row">
				{sugar_translate label='LBL_MODULE'}:
				</td>
				<td>
					<input name='ignore' value="{sugar_translate label=$module_key}" disabled >
					<input type='hidden' name='lhs_module' value='{$module_key}'>
				</td>
				<td>
				{if $rel.readonly}
                    {html_options disabled=true name="relationship_type" id="relationship_type_field" output=$translated_cardinality values=$cardinality selected=$selected_cardinality }
				{else}
                    {html_options name="relationship_type" id="relationship_type_field" output=$translated_cardinality values=$cardinality selected=$selected_cardinality onchange='ModuleBuilder.moduleLoadRelationship2(document.relform.relationship_name.value);' }
				{/if}
				</td>
				<td align="right" scope="row">
				{sugar_translate label='LBL_MODULE'}:
				</td>
				<td>{if $rel.readonly}
					<input name="rhs_module" id="rhs_mod_field" value="{$rel.rhs_module}" disabled>
					{else}
                    {html_options name="rhs_module" id="rhs_mod_field" output=$translated_relatable values=$relatable selected=$rel.rhs_module onchange='ModuleBuilder.moduleLoadRelationship2(document.relform.relationship_name.value, true);'}
					{/if}
				</td>
			</tr>

            {if $rel.relationship_only}
                <tr>
                    <td colspan=3>
                    {$mod_strings.LBL_RELATIONSHIP_ONLY}
                    </td>
                </tr>
            {else}
			{* add in subpanels and optional extended relationship condition *}
			{if !empty($rel.rhs_module) && $rel.relationship_type != 'one-to-one'}
			<tr>
                {if $rel.relationship_type == 'many-to-many' || $rel.relationship_type == 'many-to-one'}
                    <td align="right" scope="row">{sugar_translate label="LBL_REL_LABEL"}:</td>
                    <td><input name="lhs_label" id="lhs_label" value="{$rel.lhs_label}"  ></td>
                {else}
                    <td></td><td><input type="hidden" name="lhs_label" id="lhs_label" value="{$rel.lhs_label}"  ></td>
                {/if}
                <td></td>
                {if $rel.relationship_type != 'many-to-one'} 
                <td align="right" scope="row">{sugar_translate label="LBL_REL_LABEL"}:</td>
                <td><input name="rhs_label" id="rhs_label" value="{$rel.rhs_label}"  ></td>
                {else}
                    <td></td><td><input type="hidden" name="rhs_label" id="rhs_label" value="{$rel.rhs_label}"  ></td>
                {/if}
            </tr>
            <tr>
                {if $rel.relationship_type == 'many-to-many' || $rel.relationship_type == 'many-to-one'}
                <td align="right" scope="row">{$mod_strings.LBL_SUBPANEL_FROM} {sugar_translate label=$rel.lhs_module}:</td>
                <td> {if $rel.readonly}
                    <input name="lhs_subpanel" id="lhs_subpanel" value="{$rel.lhs_subpanel}" disabled>
                    {else}
                    {html_options name="lhs_subpanel" id="lhs_subpanel"  output=$lhspanels values=$lhspanels selected=$rel.lhs_subpanel alt=$mod_strings.LBL_MSUB}
                    {/if}
                </td>
                {else}<td></td><td></td>{/if}
                <td></td>
                {if $rel.relationship_type != 'many-to-one'} 
                <td align="right" scope="row">{$mod_strings.LBL_SUBPANEL_FROM} {sugar_translate label=$rel.rhs_module}:</td>
                <td>
                {if $rel.readonly}
                    <input name="lhs_subpanel" id="lhs_subpanel" value="{$rel.rhs_subpanel}" disabled>
                {else}
                    {html_options name="rhs_subpanel" id="rhs_subpanel"  output=$rhspanels values=$rhspanels selected=$rel.rhs_subpanel alt=$mod_strings.LBL_RSUB}
                {/if}
				</td>
				{/if}
				
				
            </tr>
			<tr>
                {* add in the extended relationship condition *}
                {* comment out for now as almost no expressed need for this - to revert, uncomment and test, test, test...
                <td></td>
                <td></td>
                <td align="right" scope="row">{$mod_strings.LBL_RELATIONSHIP_ROLE_ENTRIES}:</td>
                </tr>
                {if $rel.relationship_type == 'one-to-many'}
                <tr>
                    <td></td>
                    <td><span style='float:right;'>{$mod_strings.LBL_RELATIONSHIP_ROLE_COLUMN}:</span></td>
                    <td>
                    <input name="relationship_role_column" id="relationship_role_column_field" value="{$rel.relationship_role_column}" {if $rel.readonly}disabled{/if} />
                </td>
                </tr>
                {/if} {* one-to-many *}
                {*
                <tr>
                    <td></td>
                    <td align="right" scope="row"><span style='float:right;'>{$mod_strings.LBL_RELATIONSHIP_ROLE_VALUE}:</span></td>
                    <td>
                        <input name="relationship_role_column_value" id="relationship_role_column__value_field" value="{$rel.relationship_role_column_value}" {if $rel.readonly}disabled{/if} />
                    </td>
                </tr>
                *}

			{/if} {* subpanels etc for all but one-to-one relationships *}
			{/if} {* if relationship_only *}
		</table>
	</td></tr>
</table>
</form>
<script>
{literal}
ModuleBuilder.deleteRel = function()
{
    YAHOO.util.Dom.get("rel_remove_tables").value = true;
	YAHOO.SUGAR.MessageBox.show(
	{
	    type:'confirm',
		width: 300,
	    {/literal}
	    msg:'<b>{sugar_translate label="LBL_CONFIRM_RELATIONSHIP_DELETE"}</b>' + 
	       "<div style='height:1em;'>&nbsp;</div><p><input type='checkbox' onclick='YAHOO.util.Dom.get(\"rel_remove_tables\").value = this.checked ? \"\" : true;' />" +
		   "&nbsp;{sugar_translate label="ML_LBL_DO_NOT_REMOVE_TABLES" module="Administration"}</p>",
	    {literal}
	    fn: function(confirm) {
		    if (confirm == 'yes') {
		        document.forms.relform.action.value="DeleteRelationship";
			    ModuleBuilder.submitForm("relform");
			    ModuleBuilder.tabPanel.removeTab(ModuleBuilder.findTabById("relEditor"));
			}
		}
	});		
}
{/literal}	
addForm('relform');
addToValidate('relform', 'label', 'varchar', true, '{$mod_strings.LBL_JS_VALIDATE_REL_LABEL}');
{if $fromModuleBuilder}
ModuleBuilder.helpSetup('relationshipsHelp','addRelationship');
{else}
ModuleBuilder.helpSetup('studioWizard','relationshipHelp');
{/if}

</script>
