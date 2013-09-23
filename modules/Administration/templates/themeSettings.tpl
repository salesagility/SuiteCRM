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
<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>

<form name="themeSettings" method="POST">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="ThemeSettings">
	<input type="hidden" name="disabled_themes" value="">
	
	<table border="0" cellspacing="1" cellpadding="1" class="actionsContainer">
		<tr>
			<td>
			<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveThemeSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
			<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.themeSettings.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
	
	<div class='add_table' style='margin-bottom:5px'>
		<table id="themeSettings" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
            <td nowrap><b>{$MOD.DEFAULT_THEME}</b> &nbsp;
                <select name='default_theme' id='default_theme'>{$THEMES}</select>
            </td>
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
	
	<table border="0" cellspacing="1" cellpadding="1" class="actionsContainer">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" class="button primary" onclick="SUGAR.saveThemeSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
				<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="button" onclick="document.themeSettings.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
(function(){ldelim}
    var Connect = YAHOO.util.Connect;
	Connect.url = 'index.php';
    Connect.method = 'POST';
    Connect.timeout = 300000; 

	var enabled_modules = {$enabled_modules};
	var disabled_modules = {$disabled_modules};
	var lblEnabled = '{sugar_translate label="LBL_ACTIVE_THEMES"}';
	var lblDisabled = '{sugar_translate label="LBL_DISABLED_THEMES"}';
	{literal}
	SUGAR.themeEnabledTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_div",
		[{key:"theme",  label: lblEnabled, width: 200, sortable: false},
		{key:"dir", hidden:true}],
		new YAHOO.util.LocalDataSource(enabled_modules, {
			responseSchema: {fields : [{key : "theme"}, {key : "dir"}]}
		}),  
		{height: "300px"}
	);
	SUGAR.themeDisabledTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_div",
		[{key:"theme",  label: lblDisabled, width: 200, sortable: false},
		{key:"dir", hidden:true}],
		new YAHOO.util.LocalDataSource(disabled_modules, {
			responseSchema: {fields : [{key : "theme"}, {key : "dir"}]}
		}),
		{height: "300px"}
	);
	SUGAR.themeEnabledTable.disableEmptyRows = true;
	SUGAR.themeDisabledTable.disableEmptyRows = true;
	SUGAR.themeEnabledTable.addRow({module: "", label: ""});
	SUGAR.themeDisabledTable.addRow({module: "", label: ""});
	SUGAR.themeEnabledTable.render();
	SUGAR.themeDisabledTable.render();
	
	SUGAR.saveThemeSettings = function()
	{
		var disabledTable = SUGAR.themeDisabledTable;
		var themes = [];
		for(var i=0; i < disabledTable.getRecordSet().getLength(); i++){
			var data = disabledTable.getRecord(i).getData();
			if (data.dir && data.dir != '') {
			    themes[i] = data.dir;
			    if ( themes[i] == document.getElementById('default_theme').value ) {
			        if ( !confirm(SUGAR.language.get('Administration', 'LBL_DEFAULT_THEME_IS_DISABLED')) ) {
			            return false;
			        }
			    }
			}
		}
		
		ajaxStatus.showStatus(SUGAR.language.get('Administration', 'LBL_SAVING'));
        Connect.asyncRequest(
            Connect.method, 
            Connect.url, 
            {success: SUGAR.saveCallBack},
			'to_pdf=1&module=Administration&action=ThemeSettings&default_theme='+document.getElementById('default_theme').value+'&disabled_themes=' + YAHOO.lang.JSON.stringify(themes)
        );
		
		return true;
	}
	SUGAR.saveCallBack = function(o)
	{
	   ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_DONE'));
	   if (o.responseText == "true")
	   {
	       window.location.assign('index.php?module=Administration&action=ThemeSettings');
	   } 
	   else 
	   {
	       YAHOO.SUGAR.MessageBox.show({msg:o.responseText});
	   }
	}	
})();
{/literal}
</script>