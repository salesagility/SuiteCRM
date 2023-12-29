{* 
/**
 * This file is part of Mail Merge Reports by Izertis.
 * Copyright (C) 2015 Izertis. 
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * You can contact Izertis at email address info@izertis.com.
 */
*}
<script type="text/javascript" src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>
<form name="enableTemplatesModules" method="POST">

   {if $sugar_7_7 eq "1"}
   {$csrf_form_token_input}
   {/if}  

   <input type="hidden" name="module" value="Administration">
   <input type="hidden" name="action" value="index">
   <input type="hidden" name="enabled_modules" value="">
   
   <table border="0" cellspacing="1" cellpadding="1">
      <tr>
         <td>
            <input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveTemplatesSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
            <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.enableTemplatesModules.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
         </td>
      </tr>
   </table>
   
   <br> 
   
   {if $sugar_7 eq "1"}
   <div style='margin-bottom:5px'>
      <span style="color:red; text-decoration:underline; font-weight: bold;">SugarCRM 7 notes</span> 
      <br>
      <span style="color:red">If new modules are added or removed from Enabled Modules, you will need to execute a <span style="color:red; font-weight: bold;">Quick Repair and Rebuild</span> after save (to refresh SugarCRM metadata cache).</span> 
      <br>
      <span style="color:red">Please read the &quot;SugarCRM 7 Notes&quot; section in the README.txt file for more information</span>
   </div>
   
   <br>
   {/if}      
   
   <div class='add_table' style='margin-bottom:5px'>
      <table class="edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0" width="25%">
         <tr>
            <td colspan="2">
               <table>                
                  <tr>
                     <td colspan="2" white-space="wrap" style="font-style: bold;"><span>{sugar_translate label='LBL_CONFIG_TEMPLATES_ENABLED_MODULES'}</span>
                         &nbsp;{sugar_help text=$MOD.LBL_CONFIG_TEMPLATES_ENABLED_MODULES_HELP}
                     </td>
                  </tr>
               </table>
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
   
   <br>
   
   <div class='add_table' style='margin-bottom:5px'>
      <table class="edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0" width="25%">
         <tr>
            <td colspan="2">
               <table>                
                  <tr>
                     <td colspan="2" white-space="wrap" style="font-style: bold;"><span>{sugar_translate label='LBL_CONFIG_TEMPLATES_ENABLED_ROLES'}</span>
                         &nbsp;{sugar_help text=$MOD.LBL_CONFIG_TEMPLATES_ENABLED_ROLES_HELP}
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
        
         <tr>
            <td colspan="2">
               <table>
                  {foreach item=ROL from=$ROLES}
                  <tr>
                     <td scope="row" nowrap="nowrap">{$ROL.name} 
                     </td>
                     <td>
                        <select class="templates_roles_enabled_levels" id="templates_roles_enabled_levels_{$ROL.id}" name="templates_roles_enabled_levels[{$ROL.id}]">{$ROL.enabled_options}</select>
                     </td>
                  </tr>
                  {/foreach}
               </table>
            </td>
         </tr>

      </table>
   </div>
   
   <br>    
   
   <div class='add_table' style='margin-bottom:5px'>
      <table class="edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0" width="25%">
         <tr>
            <td colspan="2">
               <table>
                  <tr>
                     <td scope="row" nowrap="nowrap">{sugar_translate module='DHA_PlantillasDocumentos' label='LBL_CONFIG_DEFAULT_LANG'}
                         &nbsp;{sugar_help text=$MOD.LBL_CONFIG_DEFAULT_LANG_HELP}
                     </td>
                     <td>
                        <select id='DHA_templates_default_lang' name="DHA_templates_default_lang">{$DHA_templates_default_lang}</select>
                     </td>
                  </tr>
                  <tr>
                     <td scope="row" nowrap="nowrap">{sugar_translate module='DHA_PlantillasDocumentos' label='LBL_CONFIG_OPENOFFICE_EXE'}
                         &nbsp;{sugar_help text=$MOD.LBL_CONFIG_OPENOFFICE_EXE_HELP}
                     </td>
                     <td>
                        <input type='text' size='80' id='DHA_OpenOffice_exe' name='DHA_OpenOffice_exe' value='{$config.DHA_OpenOffice_exe}'>
                     </td>
                  </tr>                    
                  <tr>
                     <td scope="row" nowrap="nowrap">{sugar_translate module='DHA_PlantillasDocumentos' label='LBL_CONFIG_OPENOFFICE_CDE'}
                         &nbsp;{sugar_help text=$MOD.LBL_CONFIG_OPENOFFICE_CDE_HELP}
                     </td>
                     <td>
                        <input type='text' size='80' id='DHA_OpenOffice_cde' name='DHA_OpenOffice_cde' value='{$config.DHA_OpenOffice_cde}'>
                     </td>
                  </tr> 
                  <tr>
                     <td scope="row" nowrap="nowrap">{sugar_translate module='DHA_PlantillasDocumentos' label='LBL_CONFIG_OPENOFFICE_HOME'} 
                         &nbsp;{sugar_help text=$MOD.LBL_CONFIG_OPENOFFICE_HOME_HELP}
                     </td>
                     <td>
                        <input type='text' size='80' id='DHA_OpenOffice_HOME' name='DHA_OpenOffice_HOME' value='{$config.DHA_OpenOffice_HOME}'>
                     </td>
                  </tr> 
               </table>
            </td>
         </tr>
      </table>
   </div>   
   
   <table border="0" cellspacing="1" cellpadding="1">
      <tr>
         <td>
            <input title="{$APP.LBL_SAVE_BUTTON_LABEL}" class="button primary" onclick="SUGAR.saveTemplatesSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
            <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="button" onclick="document.enableTemplatesModules.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
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
      var get = YAHOO.util.Dom.get;

      var enabled_modules = {$enabled_modules};
      var disabled_modules = {$disabled_modules};
      var lblEnabled = '{sugar_translate label="LBL_ACTIVE_MODULES" module="Administration"}';
      var lblDisabled = '{sugar_translate label="LBL_DISABLED_MODULES" module="Administration"}';
      
      {if $sugar_7_7 eq "1"}
      var var_csrf_token_value = get('{$csrf_form_token_input_id}').value;
      {else}
      var var_csrf_token_value = '';
      {/if}      
      
{literal}
      SUGAR.TemplatesEnabledTable = new YAHOO.SUGAR.DragDropTable(
         "enabled_div",
         [{key:"label",  label: lblEnabled, width: 200, sortable: false},
          {key:"module", label: lblEnabled, hidden:true}],
         new YAHOO.util.LocalDataSource(enabled_modules, {
            responseSchema: {fields : [{key : "module"}, {key : "label"}]}
         }),  
         {height: "300px"}
      );
      
      SUGAR.TemplatesDisabledTable = new YAHOO.SUGAR.DragDropTable(
         "disabled_div",
         [{key:"label",  label: lblDisabled, width: 200, sortable: false},
          {key:"module", label: lblDisabled, hidden:true}],
         new YAHOO.util.LocalDataSource(disabled_modules, {
            responseSchema: {fields : [{key : "module"}, {key : "label"}]}
         }),
         {height: "300px"}
      );
      
      SUGAR.TemplatesEnabledTable.disableEmptyRows = true;
      SUGAR.TemplatesDisabledTable.disableEmptyRows = true;
      SUGAR.TemplatesEnabledTable.addRow({module: "", label: ""});
      SUGAR.TemplatesDisabledTable.addRow({module: "", label: ""});
      SUGAR.TemplatesEnabledTable.render();
      SUGAR.TemplatesDisabledTable.render();
      
      SUGAR.saveTemplatesSettings = function(){
         var enabledTable = SUGAR.TemplatesEnabledTable;
         var modules = "";
         for(var i=0; i < enabledTable.getRecordSet().getLength(); i++){
            var data = enabledTable.getRecord(i).getData();
            if (data.module && data.module != '')
                modules += "," + data.module;
         }
         modules = modules == "" ? modules : modules.substr(1);
         
         var roles_enabled_levels = "";
         var roles_enabled_levels_ids = "";
         var id = "";
         jQuery(".templates_roles_enabled_levels").each(function() {
            id = jQuery(this).attr("id");
            id = id.substr("templates_roles_enabled_levels_".length);
            roles_enabled_levels += "," + jQuery(this).val();
            roles_enabled_levels_ids += "," + id;
         });
         roles_enabled_levels = roles_enabled_levels == "" ? roles_enabled_levels : roles_enabled_levels.substr(1);
         roles_enabled_levels_ids = roles_enabled_levels_ids == "" ? roles_enabled_levels_ids : roles_enabled_levels_ids.substr(1);
         
         ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
         Connect.asyncRequest(
            Connect.method, 
            Connect.url, 
            {success: SUGAR.saveCallBack},
            SUGAR.util.paramsToUrl({
               module: "DHA_PlantillasDocumentos",
               action: "saveconfig",
               enabled_modules: modules,
               DHA_templates_default_lang : get('DHA_templates_default_lang').value,
               DHA_OpenOffice_cde : get('DHA_OpenOffice_cde').value,
               DHA_OpenOffice_exe : get('DHA_OpenOffice_exe').value,
               DHA_OpenOffice_HOME : get('DHA_OpenOffice_HOME').value,
               templates_roles_enabled_levels : roles_enabled_levels,
               templates_roles_enabled_levels_ids : roles_enabled_levels_ids,
               {/literal}{$csrf_form_token_input_id}{literal}: var_csrf_token_value
            })
         );
         
         return true;
      }
      
      SUGAR.saveCallBack = function(o) {
         ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_DONE_BUTTON_LABEL'));
         if (o.responseText == "true") {
            window.location.assign('index.php?module=Administration&action=index');
         } 
         else {
            YAHOO.SUGAR.MessageBox.show({msg:o.responseText});
         }
      }
   })();
{/literal}

</script>