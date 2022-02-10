{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
<link rel="stylesheet" type="text/css" href="modules/ModuleBuilder/tpls/MB.css" />
<form name='CreateModule'>
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='SaveModule'>
<input type='hidden' name='package' value='{$package->name}'>
<input type='hidden' name='original_name' value='{$module->name}'>
<input type='hidden' name='duplicate' value='0'>
<input type='hidden' name='to_pdf' value='1'>
<table class='mbLBL' >
	<tr><td></td><td colspan=4><input type='button' name='savebtn' value='{$mod_strings.LBL_BTN_SAVE}' class='button' onclick="ModuleBuilder.handleSave('CreateModule');">&nbsp;
		{if !empty($module->name)}
			<input type='button' name='duplicatebtn' value='{$mod_strings.LBL_BTN_DUPLICATE}' class='button' onclick="document.CreateModule.duplicate.value=1;ModuleBuilder.handleSave('CreateModule');">
			<input type='button' name='viewfieldsbtn' value='{$mod_strings.LBL_BTN_VIEW_FIELDS}' class='button' onclick="ModuleBuilder.handleSave('CreateModule', ModuleBuilder.moduleViewFields);">
			<input type='button' name='viewrelsbtn' value='{$mod_strings.LBL_BTN_VIEW_RELATIONSHIPS}' class='button' onclick="ModuleBuilder.handleSave('CreateModule', ModuleBuilder.moduleViewRelationships);">
			<input type='button' name='viewlayoutsbtn' value='{$mod_strings.LBL_BTN_VIEW_LAYOUTS}' class='button' onclick="ModuleBuilder.handleSave('CreateModule', ModuleBuilder.moduleViewLayouts);">
			&nbsp;<input type='button' name='deletebtn' value='{$mod_strings.LBL_BTN_DELETE}' class='button' onclick="ModuleBuilder.moduleDelete('{$package->name}', '{$module->name}');">{/if}</td></tr>
	<tr>
		<td height='100%'>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
	<tr><td class='mbLBL'><b>{$mod_strings.LBL_PACKAGE}</b></td><td colspan='5'>{$package->name}</td></tr>
	<tr><td class='mbLBL'><font color="#ff0000"> * </font><b>{$mod_strings.LBL_MODULE_NAME}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td colspan='5'><input type='text' name='name' value='{$module->name}' size='36' maxlength='36'></td></tr>
	<tr><td class='mbLBL'><font color="#ff0000"> * </font><b>{$mod_strings.LBL_LABEL}</b></td><td colspan='5'><input type='text' name='label' value='{$module->config.label}' size='36' maxlength='36'></td></tr>
	<tr>
	<tr>
	   <td class='mbLBL' width='5%' nowrap>{sugar_translate label='LBL_MB_IMPORTABLE' module='ModuleBuilder'}:</td>
       <td>&nbsp;<input type='checkbox' name='importable' value=1 {if !empty($module->config.importable)}checked{/if}></td>
    </tr>
	{counter name='items' assign='items' start=0}
	{foreach from=$module->implementable key='name' item='label'}
	</tr><tr>
	<td class='mbLBL' width='5%' nowrap>{$label}:</td>
	<td >&nbsp;<input type='checkbox' name='{$name}' value=1 {if !empty($module->config[$name])}checked{/if}></td>
	{counter name='items'}	
	{/foreach}
	</tr>
	<tr>
        <td class='mbLBL'><font color="#ff0000"> * </font><b>{$mod_strings.LBL_TYPE}</b></td>
        {counter name='items' assign='items' start=0}
        <td>
            <table id="factory-module">
                <tr{if empty($module->name)} id="factory_modules"{/if}>
                {if empty($module->name)}<input type='hidden' name='type'>{/if}
                {foreach from=$types key='type' item='name'}
					{assign var='imgurl' value=$type|cat:'_32'}
                    {if empty($module->name) || $type != 'basic' || count($module->mbvardefs->templates) == 1}
                        {if $items % 6 == 0 && $items != 0}
                </tr>
                <tr>
                        {/if}
                    <td>
                        {if empty($module->name)}
                    <td align='center'>
                        <table id='type_{$type}' onclick='ModuleBuilder.buttonDown(this,"{$type}", "type"); ModuleBuilder.buttonToForm("CreateModule", "type", "type");' class='wizardButton' onmousedown='return false;' onmouseout='ModuleBuilder.buttonOut(this,"{$type}", "type");'>
							<tr>
							  <td  align='center'>
								  <a href="javascript:void(0)">
									  <span class="suitepicon suitepicon-module-{$type}"></span>
								  </a>
							  </td>
							</tr>
							<tr>
								<td>
									<a href="javascript:void(0)">{$name}</a>
								</td>
							</tr>
					    </table>
						<script>ModuleBuilder.buttonAdd('type_{$type}', '{$type}', 'type');</script>
					</td>
                    {else}
                    <td align='center'><span class="suitepicon suitepicon-module-{$type}"></span><br>{$name}
                    {/if}
                    </td>
                    {/if}
                {counter name='items'}  
                {/foreach}
                </tr>
            </table>
        </td>
	</tr>	
	<tr>
		<td height='100%'>&nbsp;</td><td>&nbsp;</td>
	</tr>
</table>
{literal}
<script>
addForm('CreateModule');
addToValidate('CreateModule', 'name', 'DBName', true, '{/literal}{$mod_strings.LBL_JS_VALIDATE_NAME}{literal}');
addToValidate('CreateModule', 'label', 'varchar', true, '{/literal}{$mod_strings.LBL_JS_VALIDATE_LABEL}{literal}');
addToValidate('CreateModule', 'type', 'varchar', true, '{/literal}{$mod_strings.LBL_JS_VALIDATE_TYPE}{literal}');
ModuleBuilder.helpRegister('CreateModule');
if(document.getElementById('factory_modules'))
	ModuleBuilder.helpRegisterByID('factory_modules', 'table');
ModuleBuilder.helpSetup({/literal}'{$module->help.group}','{$module->help.default}'{literal});
ModuleBuilder.MBpackage = '{/literal}{$module->package}{literal}';
ModuleBuilder.module = '{/literal}{$module->name}{literal}';	
</script>
{/literal}
{include file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}
