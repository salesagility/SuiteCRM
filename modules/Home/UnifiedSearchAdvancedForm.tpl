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

<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>

<form name='UnifiedSearchAdvancedMain' action='index.php' onsubmit="SUGAR.saveGlobalSearchSettings();" method='POST' class="search_form">
<input type='hidden' name='module' value='Home'>
<input type='hidden' name='query_string' value='test'>
<input type='hidden' name='advanced' value='true'>
<input type='hidden' name='action' value='UnifiedSearch'>
<input type='hidden' name='search_form' value='false'>
<input type='hidden' name='search_modules' value=''>
<input type='hidden' name='skip_modules' value=''>
<input type='hidden' id='showGSDiv' name='showGSDiv' value='{$SHOWGSDIV}'>
	<table width='600' border='0' cellspacing='1'>
	<tr style='padding-bottom: 10px'>
		<td class="submitButtons" colspan='8' nowrap>
			<input id='searchFieldMain' title="{$LBL_SEARCH}" class='searchField' type='text' size='80' name='query_string' value='{$query_string}'>
		    <input type="submit" title="{$LBL_SEARCH_BUTTON_TITLE}" class="button primary" value="{$LBL_SEARCH_BUTTON_LABEL}">&nbsp;
			<a href="#" onclick="javascript:toggleInlineSearch();" style="font-size:12px; font-weight:bold; text-decoration:none; text-shadow:0 1px #FFFFFF;">{$MOD.LBL_SELECT_MODULES}&nbsp;
            {if $SHOWGSDIV == 'yes'}
            {capture assign="alt_hide_show"}{sugar_translate label='LBL_ALT_HIDE_OPTIONS'}{/capture}
			{sugar_getimage  name="basic_search" ext=".gif" other_attributes='border="0" id="up_down_img" ' alt="$alt_hide_show"}
			{else}
            {capture assign="alt_hide_show"}{sugar_translate label='LBL_ALT_SHOW_OPTIONS'}{/capture}
			{sugar_getimage  name="advanced_search" ext=".gif" other_attributes='border="0" id="up_down_img" ' alt="$alt_hide_show"}
			{/if}
			</a>
		</td>
	</tr>
	<tr height='5'><td></td></tr>
	<tr style='padding-top: 10px;'>
		<td colspan='8' nowrap'>
		<div id='inlineGlobalSearch' class='add_table' {if $SHOWGSDIV != 'yes'}style="display:none;"{/if}>
		<table id="GlobalSearchSettings" class="GlobalSearchSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
		    <tr>
		    	<td colspan="2">
		    	{sugar_translate label="LBL_SELECT_MODULES_TITLE" module="Administration"}
		    	</td>
		    </tr>
		    <tr>
				<td width='1%'>
					<div id="enabled_div"></div>
				</td>
				<td>
					<div id="disabled_div"></div>
				</td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
	</table>
</form>

<script type="text/javascript">
{literal}
function toggleInlineSearch()
{
    if (document.getElementById('inlineGlobalSearch').style.display == 'none')
    {
		SUGAR.globalSearchEnabledTable.render();
		SUGAR.globalSearchDisabledTable.render();
        document.getElementById('showGSDiv').value = 'yes'
        document.getElementById('inlineGlobalSearch').style.display = '';
{/literal}
        document.getElementById('up_down_img').src='{sugar_getimagepath file="basic_search.gif"}';
        document.getElementById('up_down_img').setAttribute('alt',"{sugar_translate label='LBL_ALT_HIDE_OPTIONS'}");
{literal}
    }else{
{/literal}
        document.getElementById('up_down_img').src='{sugar_getimagepath file="advanced_search.gif"}';
        document.getElementById('up_down_img').setAttribute('alt',"{sugar_translate label='LBL_ALT_SHOW_OPTIONS'}");
{literal}
        document.getElementById('showGSDiv').value = 'no';
        document.getElementById('inlineGlobalSearch').style.display = 'none';
    }
}
{/literal}


var get = YAHOO.util.Dom.get;
var enabled_modules = {$enabled_modules};
var disabled_modules = {$disabled_modules};
var lblEnabled = '{sugar_translate label="LBL_ACTIVE_MODULES" module="Administration"}';
var lblDisabled = '{sugar_translate label="LBL_DISABLED_MODULES" module="Administration"}';
{literal}
SUGAR.saveGlobalSearchSettings = function()
{
	var enabledTable = SUGAR.globalSearchEnabledTable;
	var modules = "";
	for(var i=0; i < enabledTable.getRecordSet().getLength(); i++){
		var data = enabledTable.getRecord(i).getData();
		if (data.module && data.module != '')
		    modules += "," + data.module;
	}
	modules = modules == "" ? modules : modules.substr(1);
	document.forms['UnifiedSearchAdvancedMain'].elements['search_modules'].value = modules;
}
{/literal}

document.getElementById("inlineGlobalSearch").style.display={if $SHOWGSDIV == 'yes'}"";{else}"none";{/if}

{literal}
SUGAR.globalSearchEnabledTable = new YAHOO.SUGAR.DragDropTable(
	"enabled_div",
	[{key:"label",  label: lblEnabled, width: 200, sortable: false},
	 {key:"module", label: lblEnabled, hidden:true}],
	new YAHOO.util.LocalDataSource(enabled_modules, {
		responseSchema: {fields : [{key : "module"}, {key : "label"}]}
	}),
	{height: "200px"}
);

SUGAR.globalSearchDisabledTable = new YAHOO.SUGAR.DragDropTable(
	"disabled_div",
	[{key:"label",  label: lblDisabled, width: 200, sortable: false},
	 {key:"module", label: lblDisabled, hidden:true}],
	new YAHOO.util.LocalDataSource(disabled_modules, {
		responseSchema: {fields : [{key : "module"}, {key : "label"}]}
	}),
	{height: "200px"}
);

SUGAR.globalSearchEnabledTable.disableEmptyRows = true;
SUGAR.globalSearchDisabledTable.disableEmptyRows = true;
SUGAR.globalSearchEnabledTable.addRow({module: "", label: ""});
SUGAR.globalSearchDisabledTable.addRow({module: "", label: ""});
SUGAR.globalSearchEnabledTable.render();
SUGAR.globalSearchDisabledTable.render();
{/literal}
</script>
