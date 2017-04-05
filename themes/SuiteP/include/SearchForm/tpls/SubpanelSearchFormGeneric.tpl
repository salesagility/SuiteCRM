{*
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
*}
{{* If templateMeta.maxColumnsBasic is not set, use maxColumns *}}
{if !isset($templateMeta.maxColumnsBasic)}
	{assign var="basicMaxColumns" value=$templateMeta.maxColumns}
{else}
    {assign var="basicMaxColumns" value=$templateMeta.maxColumnsBasic}
{/if}
<script>
{literal}
	$(function() {
	var $dialog = $('<div></div>')
		.html(SUGAR.language.get('app_strings', 'LBL_SEARCH_HELP_TEXT'))
		.dialog({
			autoOpen: false,
			title: SUGAR.language.get('app_strings', 'LBL_HELP'),
			width: 700
		});

		$('#filterHelp').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
	});

	});
{/literal}
</script>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>

{{assign var='accesskeycount' value=0}}  {{assign var='ACCKEY' value=''}}
{{foreach name=colIteration from=$formData key=col item=colData}}
    {{math assign="accesskeycount" equation="$accesskeycount + 1"}}
    {{if $accesskeycount==1}} {{assign var='ACCKEY' value=$APP.LBL_FIRST_INPUT_SEARCH_KEY}} {{else}} {{assign var='ACCKEY' value=''}} {{/if}}

	{counter assign=index}
	{math equation="left % right"
   		  left=$index
          right=$basicMaxColumns
          assign=modVal
    }
	{if ($index % $basicMaxColumns == 1 && $index != 1)}
		</tr><tr>
	{/if}

	<td scope="row" nowrap="nowrap" width='1%' >
	{{if isset($colData.field.label)}}
		<label for='{{$colData.field.name}}' >{sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}</label>
    {{elseif isset($fields[$colData.field.name])}}
		<label for='{{$fields[$colData.field.name].name}}'> {sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}
	{{/if}}
	</td>


	<td  nowrap="nowrap" width='1%'>
	{{if $fields[$colData.field.name]}}
		{{sugar_field parentFieldArray='fields' vardef=$fields[$colData.field.name] accesskey=$ACCKEY displayType='searchView' displayParams=$colData.field.displayParams typeOverride=$colData.field.type formName=$form_name}}
   	{{/if}}
   	</td>
{{/foreach}}
    {if $formData|@count >= $basicMaxColumns+1}
    </tr>
    <tr>
	<td colspan="{$searchTableColumnCount}">
    {else}
	<td class="sumbitButtons">
    {/if}
        <input tabindex='2' title='{$APP.LBL_SEARCH_BUTTON_TITLE}' onclick='submitSearch("{$subpanel}");' class='button' type='button' name='search' id='search_form_search' value='{$APP.LBL_SEARCH_BUTTON_TITLE}'/>
	    <input tabindex='2' title='{$APP.LBL_CLEAR_BUTTON_TITLE}' onclick='clearSearch("{$subpanel}");'  class='button' type='button' name='clear' id='search_form_clear' value='{$APP.LBL_CLEAR_BUTTON_LABEL}'/>
			{$subpanelPageOffset}
		</td>
	</tr>
</table>
