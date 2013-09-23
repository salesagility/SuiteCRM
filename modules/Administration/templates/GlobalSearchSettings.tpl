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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="100">
        <h2> {$moduleTitle}</h2>
    </td>
</tr>
<tr>
    <td colspan="100">{$MOD.LBL_GLOBAL_SEARCH_SETTINGS_TITLE}</td>
</tr>
<tr>
    <td>
        <br>
    </td>
</tr>
<tr>
<td colspan="100">

<script type="text/javascript" src="{sugar_getjspath file='cache/include/javascript/sugar_grp_yui_widgets.js'}"></script>
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>
<form name="GlobalSearchSettings" method="POST">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="saveGlobalSearchSettings">
	<input type="hidden" name="enabled_modules" value="">

	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
			<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveGlobalSearchSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
                <input title="{$MOD.LBL_SAVE_SCHED_BUTTON}" class="button primary schedFullSystemIndex" onclick="SUGAR.FTS.schedFullSystemIndex();" style="{if !$showSchedButton}display:none;{/if}text-decoration: none;" id='schedFullSystemIndexBtn' type="button" name="button" value="{$MOD.LBL_SAVE_SCHED_BUTTON}">
            <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.GlobalSearchSettings.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>

	<div class='add_table' style='margin-bottom:5px'>
		<table id="GlobalSearchSettings" class="GlobalSearchSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
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
	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" class="button primary" onclick="SUGAR.saveGlobalSearchSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
                <input title="{$MOD.LBL_SAVE_SCHED_BUTTON}" class="button primary schedFullSystemIndex" onclick="SUGAR.FTS.schedFullSystemIndex();" style="{if !$showSchedButton}display:none;{/if}text-decoration: none;" id='schedFullSystemIndex' type="button" name="button" value="{$MOD.LBL_SAVE_SCHED_BUTTON}">
                <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="button" onclick="document.GlobalSearchSettings.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</form>

<div id='selectFTSModules' class="yui-hidden">
    <div style="background-color: white; padding: 20px;">
        <div id='selectFTSModulesTable' ></div>
        <div style="padding-top: 10px"><input type="checkbox" name="clearDataOnIndex" id="clearDataOnIndex" >&nbsp;{$MOD.LBL_DELETE_FTS_DATA}</div>
    </div>
</div>
<script type="text/javascript">
(function(){ldelim}
    var Connect = YAHOO.util.Connect;
	Connect.url = 'index.php';
    Connect.method = 'POST';
    Connect.timeout = 300000;
	var get = YAHOO.util.Dom.get;

	var enabled_modules = {$enabled_modules};
	var disabled_modules = {$disabled_modules};
	var lblEnabled = '{sugar_translate label="LBL_ACTIVE_MODULES"}';
	var lblDisabled = '{sugar_translate label="LBL_DISABLED_MODULES"}';
	{literal}
	SUGAR.globalSearchEnabledTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_div",
		[{key:"label",  label: lblEnabled, width: 200, sortable: false},
		 {key:"module", label: lblEnabled, hidden:true}],
		new YAHOO.util.LocalDataSource(enabled_modules, {
			responseSchema: {fields : [{key : "module"}, {key : "label"}]}
		}),
		{height: "300px"}
	);
	SUGAR.globalSearchDisabledTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_div",
		[{key:"label",  label: lblDisabled, width: 200, sortable: false},
		 {key:"module", label: lblDisabled, hidden:true}],
		new YAHOO.util.LocalDataSource(disabled_modules, {
			responseSchema: {fields : [{key : "module"}, {key : "label"}]}
		}),
		{height: "300px"}
	);

	SUGAR.globalSearchEnabledTable.disableEmptyRows = true;
	SUGAR.globalSearchDisabledTable.disableEmptyRows = true;
	SUGAR.globalSearchEnabledTable.addRow({module: "", label: ""});
	SUGAR.globalSearchDisabledTable.addRow({module: "", label: ""});
	SUGAR.globalSearchEnabledTable.render();
	SUGAR.globalSearchDisabledTable.render();

    SUGAR.getEnabledModules = function()
    {
        var enabledTable = SUGAR.globalSearchEnabledTable;
        var modules = "";
        for(var i=0; i < enabledTable.getRecordSet().getLength(); i++)
        {
            var data = enabledTable.getRecord(i).getData();
            if (data.module && data.module != '')
                modules += "," + data.module;
        }
        return modules;
    }
    SUGAR.getEnabledModulesForFTSSched = function()
    {
        var enabledTable = SUGAR.FTS.selectedDataTable;
        var modules = [];
        var selectedIDs = enabledTable.getSelectedRows();
        for(var i=0; i < selectedIDs.length; i++)
        {
            var data = enabledTable.getRecord(selectedIDs[i]).getData();
            modules.push(data.module);
        }

        return modules;
    }
    SUGAR.getTranslatedEnabledModules = function()
    {
        var enabledTable = SUGAR.globalSearchEnabledTable;
        var modules = [{module:'', label: SUGAR.language.get('Administration', 'LBL_ALL')}];
        for(var i=0; i < enabledTable.getRecordSet().getLength(); i++)
        {
            var data = enabledTable.getRecord(i).getData();
            if (data.module && data.module != '')
            {
                var tmp = {'module' : data.module, 'label' : data.label};
                modules.push(tmp);
            }
        }

        return modules;
    }
	SUGAR.saveGlobalSearchSettings = function()
	{
		var enabledTable = SUGAR.globalSearchEnabledTable;
		var modules = SUGAR.getEnabledModules();
		modules = modules == "" ? modules : modules.substr(1);

		ajaxStatus.showStatus(SUGAR.language.get('Administration', 'LBL_SAVING'));
		Connect.asyncRequest(
            Connect.method,
            Connect.url,
            {success: SUGAR.saveCallBack},
			SUGAR.util.paramsToUrl({
				module: "Administration",
				action: "saveglobalsearchsettings",
				enabled_modules: modules
			}) + "to_pdf=1"
        );

		return true;
	}

	SUGAR.saveCallBack = function(o)
	{
	   ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_DONE'));
	   if (o.responseText == "true")
	   {
	       window.location.assign('index.php?module=Administration&action=index');
	   } else {
	       YAHOO.SUGAR.MessageBox.show({msg:o.responseText});
	   }
	}
})();
{/literal}
</script>
<script type="text/javascript">
</script>
