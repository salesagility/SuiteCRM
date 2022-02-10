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
<script type="text/javascript" src='{sugar_getjspath file ='cache/include/javascript/sugar_grp_yui_widgets.js'}'></script>
<script type="text/javascript" src='{sugar_getjspath file ='include/javascript/yui/build/paginator/paginator-min.js'}'></script>
{literal}
<style type="text/css">
    .yui-pg-container {
        background: none;
    }
</style>
{/literal}
<p>
{$MODULE_TITLE}
</p>
<form enctype="multipart/form-data" name="fontmanager" method="POST" action="index.php" id="fontmanager">
<input type="hidden" name="module" value="Configurator">
<input type="hidden" name="action" value="FontManager">
<input type="hidden" name="action_type" value="">
<input type="hidden" name="filename" value="">
<input type="hidden" name='return_action' value="{$RETURN_ACTION}">
<span class='error'>{$error}</span>
<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="left">
            <input title="{$MOD.LBL_BACK}"  class="button" type="button" name="gobackbutton" value="  {$MOD.LBL_BACK}  " id="gobackbutton">&nbsp;
            <input title="{$MOD.LBL_ADD_FONT}" class="button" type="button" name="addFontbutton" value="  {$MOD.LBL_ADD_FONT}  " id="addFontbutton">
        </td>
    </tr>
</table>

<br>
<div id="YuiListMarkup"></div>
<br>

</form>
{literal}
<script type="text/javascript">
var removeFormatter = function (el, oRecord, oColumn, oData) {
    if(oRecord._oData.type != "{/literal}{$MOD.LBL_FONT_TYPE_CORE}{literal}" && oRecord._oData.fontpath != "{/literal}{$K_PATH_FONTS}{literal}"){
        el.innerHTML = '<a href="#" name="deleteButton" onclick="return false;">{sugar_getimage name="delete_inline" ext=".gif" alt=$mod_strings.LBL_DELETE other_attributes='align="absmiddle" border="0" '}{/literal} {$MOD.LBL_REMOVE}{literal}<\/a>';
    }
};
YAHOO.util.Event.onDOMReady(function() {
{/literal}
	var fontColumnDefs = {$COLUMNDEFS};
    var fontData = {$DATASOURCE};
{literal}
	var fontDataSource = new YAHOO.util.DataSource(fontData);
	fontDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    fontDataSource.responseSchema = {/literal}{$RESPONSESCHEMA}{literal};
    var oConfigs = {
        paginator: new YAHOO.widget.Paginator({
            rowsPerPage:15
        })
    };
    var fontDataTable = new YAHOO.widget.DataTable("YuiListMarkup", fontColumnDefs, fontDataSource, oConfigs);

    fontDataTable.subscribe("linkClickEvent", function(oArgs){
        if(oArgs.target.name == "deleteButton"){
            if(confirm('{/literal}{$MOD.LBL_JS_CONFIRM_DELETE_FONT}{literal}')){
            	   document.getElementById("fontmanager").action.value = "deleteFont";
            	   document.getElementById("fontmanager").filename.value = this.getRecord(oArgs.target)._oData.filename;
            	   document.getElementById("fontmanager").submit();
            }
        }
    });
    
    document.getElementById('gobackbutton').onclick=function(){
        if(document.getElementById("fontmanager").return_action.value != ""){
        	document.location.href='index.php?module=Configurator&action=' + document.getElementById("fontmanager").return_action.value;
        }else{
        	document.location.href='index.php?module=Configurator&action=SugarpdfSettings';
        }
    };
    document.getElementById('addFontbutton').onclick=function(){
    	document.location.href='index.php?module=Configurator&action=addFontView';
    };
    
});
{/literal}
</script>
