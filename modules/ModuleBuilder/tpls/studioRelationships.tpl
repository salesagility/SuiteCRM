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
{if $view_module != 'KBDocuments'}
<input type='button' name='addrelbtn' value='{$mod_strings.LBL_BTN_ADD_RELATIONSHIP}'
	class='button' onclick='ModuleBuilder.moduleLoadRelationship2("");' style="margin-bottom:5px;">
{/if}
<div id='relGrid'></div>
{if $studio}{sugar_translate label='LBL_CUSTOM_RELATIONSHIPS' module='ModuleBuilder'}</h3>{/if}
<script>
{literal}
//Workaround for YUI bug 2527707: http://yuilibrary.com/projects/yui2/ticket/913efafad48ce433199f3e72e4847b18, should be removed when YUI 2.8+ is used
YAHOO.widget.DataTable.prototype.getColumn = function(column) {
    var oColumn = this._oColumnSet.getColumn(column);

    if(!oColumn) {
        // Validate TD element
        var elCell = column.nodeName.toLowerCase() != "th" ? this.getTdEl(column) : false;
        if(elCell) {
            oColumn = this._oColumnSet.getColumn(elCell.cellIndex);
        }
        // Validate TH element
        else {
            elCell = this.getThEl(column);
            if(elCell) {
                // Find by TH el ID
                var allColumns = this._oColumnSet.flat;
                for(var i=0, len=allColumns.length; i<len; i++) {
                    if(allColumns[i].getThEl().id === elCell.id) {
                        oColumn = allColumns[i];
                    } 
                }
            }
        }
    }
    if(!oColumn) {
        YAHOO.log("Could not get Column for column at " + column, "info", this.toString());
    }
    return oColumn;
};
{/literal}
var relationships = {ldelim}relationships:{$relationships}{rdelim};
var grid = new YAHOO.widget.ScrollingDataTable('relGrid',
	[
	    {ldelim}key:'name',       label: SUGAR.language.get('ModuleBuilder','LBL_REL_NAME'),        width: 200, sortable: true{rdelim},
	    {ldelim}key:'lhs_module', label: SUGAR.language.get('ModuleBuilder','LBL_LHS_MODULE'),      width: 120, sortable: true{rdelim},
	    {ldelim}key:'relationship_type', label: SUGAR.language.get('ModuleBuilder','LBL_REL_TYPE'), width: 120, sortable: true{rdelim},
	    {ldelim}key:'rhs_module', label: SUGAR.language.get('ModuleBuilder','LBL_RHS_MODULE'),      width: 120, sortable: true{rdelim}
	],{literal}
	new YAHOO.util.LocalDataSource(relationships, {
	    responseSchema: {
		   resultsList : "relationships",
		   fields : [{key : "name"}, {key: "lhs_module"}, {key: "relationship_type"}, {key: "rhs_module"}]
	    }
	}),
    {MSG_EMPTY: SUGAR.language.get('ModuleBuilder','LBL_NO_RELS'), height:"auto"}
);
grid.subscribe("rowMouseoverEvent", grid.onEventHighlightRow); 
grid.subscribe("rowMouseoutEvent", grid.onEventUnhighlightRow); 
grid.subscribe("rowClickEvent", function(args){
    var rel = this.getRecord(args.target).getData();
    var editTab = ModuleBuilder.findTabById("relEditor");
    if (editTab) ModuleBuilder.tabPanel.removeTab(editTab);
    var name = rel.name.indexOf("*") > -1 ? rel.name.substring(0, rel.name.length-1) : rel.name;
    ModuleBuilder.moduleLoadRelationship2(name);
});
grid.render();

{/literal}
ModuleBuilder.module = '{$view_module}';
ModuleBuilder.MBpackage = '{$view_package}';
ModuleBuilder.helpRegisterByID('relGrid');
{if $fromModuleBuilder}
ModuleBuilder.helpSetup('relationshipsHelp','default');
{else}
ModuleBuilder.helpSetup('studioWizard','relationshipsHelp');
{/if}
</script>