{*
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


*}


{literal}
<style>
.yui-dt-col-required .yui-dt-liner, .yui-dt-col-select .yui-dt-liner, .yui-dt-col-copyData .yui-dt-liner,
.yui-dt-col-edit .yui-dt-liner, .yui-dt-col-delete .yui-dt-liner
{
    text-align:center;
}
</style>
{/literal}
{if !empty($warningMessage)}
<p class="error">{$warningMessage}</p>
{/if}
<input type='button' name='saveLayout' value='{sugar_translate label="LBL_BTN_SAVE" module="ModuleBuilder"}'
    class='button' onclick='ModuleBuilder.saveConvertLeadLayout();' style="margin-bottom:5px;">
<img class="spacer" src="include/images/blank.gif" style="width:50px;height:5px"/>
{html_options name="convertSelectNewModule" id="convertSelectNewModule" options=$availibleModules}
<input type='button' name='addModule' value='{sugar_translate label="LBL_CONVERT_ADD_MODULE"}'
    class='button' onclick='ModuleBuilder.addConvertLeadLayout();' style="margin-bottom:5px;">


<div id='relGrid'></div>
{if $studio}{sugar_translate label='LBL_CUSTOM_RELATIONSHIPS' module='ModuleBuilder'}</h3>{/if}
<script>
{literal}

function getModuleNameFromLabel(label) {
    var moduleList = SUGAR.language.get('app_list_strings', "moduleList");
    for ( var i in moduleList) {
        if (moduleList[i] == label) {
            return i;
        }
    }
    return label;
}

var editLayout = function(row)
{
	var panel = ModuleBuilder.findTabById('convEditor');
    if (!panel) {
        panel = new YAHOO.SUGAR.ClosableTab({ {/literal}
            label: "{sugar_translate label="LBL_CONVERT_EDIT_LAYOUT"}",
            id: 'convEditor',
            scroll: true,
            cacheData: true,
            active :true,
            content: "<img alt='{$mod_strings.LBL_LOADING}' name='loading' src='{sugar_getimagepath file='loading.gif'}' />{sugar_translate label='LBL_LOADING'}"{literal}
        }, ModuleBuilder.tabPanel);
        ModuleBuilder.tabPanel.addTab(panel);
    } else {
        ModuleBuilder.tabPanel.set("activeTab", panel);
    }
    var params = {
        module: 'Leads',
        action: 'editconvertlayout',
        view_module: getModuleNameFromLabel(row.module),
        json: false,
        id:'convEditor'
    };
    ModuleBuilder.asyncRequest(params, function(o) {
        ajaxStatus.hideStatus();
        var tab = ModuleBuilder.findTabById('convEditor');
        tab.set("content", o.responseText);
        SUGAR.util.evalScript(o.responseText);
    });
}
var removeLayout = function(row)
{
	if (confirm("Are you sure you wish to remove this layout?")) {
		var params = {
	        module: 'Leads',
	        action: 'editconvert',
	        removeLayout: true,
                targetModule:getModuleNameFromLabel(row.module)
	    };

	    ModuleBuilder.asyncRequest(params, function(o) {
	        ajaxStatus.hideStatus();
	        ModuleBuilder.updateContent(o);
	    });
	}
}

var formatSelect = function(el, rec, col, data)
{
    var row = rec.getData();
    var selected = false;
    if (row.select) selected = row.select;
    var ret = "<input type='checkbox' name='" + rec.getData().module + "-" + col.field + "'";
    if(typeof(relationships[row.module]) == "undefined")
    	ret += " disabled />";
    else {
        ret += "onclick='ModuleBuilder.convertLayoutGrid.getRecord(this).setData(\"select\", this.checked ? \""
            + relationships[row.module][0] + "\" : false);'";
        if (selected)
        	ret += " checked='true'";
        ret += "/>";
    }
    el.innerHTML = ret;
}
var getEditButton = function(el, rec, col, data){
    var out = {/literal}"<img alt='{$mod_strings.LBL_EDIT_INLINE}' name='edit_inline' src='{sugar_getimagepath file='edit_inline.gif'}' />";{literal}
	el.innerHTML = out;
	YAHOO.util.Event.addListener(el, "click", function(){editLayout(grid.getRecord(el).getData());});
}
var getRemoveButton = function(el, rec, col, data){
	if (rec.getData().module =="Contacts")
	   return;
    var out = {/literal}"<img alt='{$mod_strings.LBL_EDIT_INLINE}' name='delete_inline' src='{sugar_getimagepath file='delete_inline.gif'}' />";{literal}
    el.innerHTML = out;
    YAHOO.util.Event.addListener(el, "click", function(){removeLayout(grid.getRecord(el).getData());});
}
var getDisabledCheckbox = function(el, rec, col, data){
    var out = "<input type='checkbox' name='" + rec.getData().module + "-" + col.field + "'"
	       + "onclick='ModuleBuilder.convertLayoutGrid.getRecord(this).setData(\"" + col.field + "\", this.checked)';";
    if(data)
        out += " checked='checked'";
	if (rec.getData().module == "Contacts")
	   out += " disabled ";
    out += " />";
    el.innerHTML = out;
   // YAHOO.util.Event.addListener(el, "click", function(){editLayout(grid.getRecord(el).getData());});
}

{/literal}
var modules = {ldelim}modules:{$modules}{rdelim};
var relationships = {$relationships};
YAHOO.SUGAR.DragDropTable.groups = [];
var grid = ModuleBuilder.convertLayoutGrid = new YAHOO.SUGAR.DragDropTable('relGrid',
    [
        {ldelim}key:'module',       label: '{sugar_translate label="LBL_CONVERT_MODULE_NAME"}', hidden: true {rdelim},
        {ldelim}key:'moduleName',   label: '{sugar_translate label="LBL_CONVERT_MODULE_NAME"}', width: 200,sortable: true {rdelim},
        {ldelim}key:'required',     label: '{sugar_translate label="LBL_CONVERT_REQUIRED"}',    width: 80, sortable: false, formatter:getDisabledCheckbox{rdelim},
        {ldelim}key:'copyData',     label: '{sugar_translate label="LBL_CONVERT_COPY"}',        width: 80, sortable: false, formatter:getDisabledCheckbox{rdelim},
        {ldelim}key:'select',       label: '{sugar_translate label="LBL_CONVERT_SELECT"}',      width: 80, sortable: false, formatter:formatSelect{rdelim},
        {ldelim}key:'edit',         label: '{sugar_translate label="LBL_CONVERT_EDIT"}',        width: 40, sortable: false, formatter:getEditButton{rdelim},
        {ldelim}key:'delete',       label: '{sugar_translate label="LBL_CONVERT_DELETE"}',      width: 40, sortable: false, formatter:getRemoveButton{rdelim}
    ],{literal}
    new YAHOO.util.LocalDataSource(modules, {
        responseSchema: {
           resultsList : "modules",
           fields : [{key : "module"}, {key : "moduleName"},{key: "required"}, {key: "select"}, {key: "copyData"}, {key: "edit"}, {key: "delete"}]
        }
    }),
    {MSG_EMPTY: SUGAR.language.get('ModuleBuilder','LBL_NO_RELS')}
);
grid.subscribe("rowMouseoverEvent", grid.onEventHighlightRow);
grid.subscribe("rowMouseoutEvent", grid.onEventUnhighlightRow);
grid.render();
{/literal}
//tooltips
new YAHOO.widget.Tooltip("module_tooltip", {ldelim}
    context: grid.getColumn(0).getThEl(),
    text: '{sugar_translate label="LBL_MODULE_TIP"}',
    showDelay: 500
{rdelim});
new YAHOO.widget.Tooltip("required_tooltip", {ldelim}
    context: grid.getColumn(1).getThEl(),
    text: '{sugar_translate label="LBL_REQUIRED_TIP"}',
    showDelay: 500
{rdelim});
new YAHOO.widget.Tooltip("copy_tooltip", {ldelim}
    context: grid.getColumn(2).getThEl(),
    text: '{sugar_translate label="LBL_COPY_TIP"}',
    showDelay: 500
{rdelim});
new YAHOO.widget.Tooltip("selection_tooltip", {ldelim}
    context: grid.getColumn(3).getThEl(),
    text: '{sugar_translate label="LBL_SELECTION_TIP"}',
    showDelay: 500
{rdelim});
new YAHOO.widget.Tooltip("edit_tooltip", {ldelim}
    context: grid.getColumn(4).getThEl(),
    text: '{sugar_translate label="LBL_EDIT_TIP"}',
    showDelay: 500
{rdelim});
new YAHOO.widget.Tooltip("delete_tooltip", {ldelim}
    context: grid.getColumn(5).getThEl(),
    text: '{sugar_translate label="LBL_DELETE_TIP"}',
    showDelay: 500
{rdelim});
{literal}
ModuleBuilder.saveConvertLeadLayout = function()
{
	var rows = ModuleBuilder.convertLayoutGrid.getRecordSet().getRecords();
    var out = {};
    for (var i in rows) {
        out[i] = rows[i].getData();
        out[i].module = getModuleNameFromLabel(out[i].module);
    }
    var params = {
        module: 'Leads',
        action: 'editconvert',
        updateOrder: true,
        data:YAHOO.lang.JSON.stringify(out)
    };

	ModuleBuilder.asyncRequest(params, function(o) {
	    ajaxStatus.hideStatus();
	    ModuleBuilder.updateContent(o);
	});
}
ModuleBuilder.addConvertLeadLayout = function()
{
    var rows = ModuleBuilder.convertLayoutGrid.getRecordSet().getRecords();
    var Dom = YAHOO.util.Dom;
    ModuleBuilder.convertLayoutGrid.addRow({
        module:Dom.get("convertSelectNewModule").value,
        required:false,
        copyData:false,
        select:false
    });
    ModuleBuilder.saveConvertLeadLayout();
}
{/literal}
ModuleBuilder.module = '{$view_module}';
ModuleBuilder.MBpackage = '{$view_package}';
ModuleBuilder.helpSetup('studioWizard','convertLeadHelp');
</script>