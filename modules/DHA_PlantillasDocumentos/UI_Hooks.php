<?php
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
   if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
   

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function get_massDocForm(&$bean) {
      require_once('modules/DHA_PlantillasDocumentos/MassGenerateDocument.php');
      $massDoc = new MassGenerateDocument();      
      $massDoc->setSugarBean($bean);
      $massDocForm = $massDoc->getMassGenerateDocumentForm();  // aqui se controlarán ya los permisos por roles
      unset($massDoc);
      
      // Modificación para corregir el error "javascript Syntax error : Unterminated string literal". 
      // Ver http://stackoverflow.com/questions/227552/common-sources-of-unterminated-string-literal
      $massDocForm = str_replace('"', "'", $massDocForm);
      $massDocForm = str_replace(array("\r", "\n"), '', $massDocForm);            
      $massDocForm = str_replace('</script>', '<\/script>', $massDocForm);
      //$GLOBALS['log']->fatal($massDocForm);
      
      return $massDocForm;
   }   


   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_getClientFileContents($module_name, $client_type, $client_name) {
      // En esta función sólo se recogerá los valores  de sistema, ya que si se llega a usar es porque las definiciones 
      // de "client" para ese modulo y vista no están definidas específicamente (esto es lo mismo que haría Sugar)
      
      // Ver las funciones getClientFileContents y la funcion getClientFiles -- IMPORTANTES
      // Tambien getMetadata y getMetadataCache -- PUNTOS DE ENTRADA
      // Tambien loadMetadata y loadSectionMetadata
      // Tambien getModuleData y getModuleViews
      // Tambien getModuleClientCache y buildModuleClientCache
      
      // La cache de los modulos se guarda en (ejemplo)
      //   - \cache\modules\Accounts\clients\base\view.php
      //   - \cache\api\metadata\metadata_base_private.php   (global a todos los modulos, se crea a partir de los ficheros individuales de los modulos en la cache)
      
      require_once 'modules/ModuleBuilder/parsers/MetaDataFiles.php';
      
   /*  PRUEBAS
      //$fileList = MetaDataFiles::getClientFiles(array('base'), 'view', $module_name);
      $fileList_system = MetaDataFiles::getClientFiles(array('base'), 'view');
      //$fileList_system = $fileList + $fileList_system;
      $fileList = array();
      
      foreach ($fileList_system as $file_name => $file_def) {
         $extension = substr($file_name, -3);
         if ($extension == 'php' && strrpos($file_name, "/{$client_name}/") !== false) {
            $fileList[$file_name] = $file_def;
         }
      }
      
      $result = MetaDataFiles::getClientFileContents( $fileList, 'view', $module_name);
   */
      
      // Esta funcion devuelve solo definiciones de sistema, no del modulo
      $result = MetaDataFiles::loadSingleClientMetadata($client_type, $client_name, 'base');
      
      return $result;
   }
   
   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_customize_clients($module_name, $client_type, $client_name, &$viewdefs) {
   
      // -----------------------------
      if ($module_name && $client_type == 'layout' && $client_name == 'list') {
      
         $new_component = array(
            'view' => 'massgeneratedocument',
         );
         
         if (!isset($viewdefs) || empty($viewdefs) || empty($viewdefs[$module_name]['base']['layout']['list'])) {
            $layout_def = MailMergeReports_getClientFileContents($module_name, $client_type, $client_name); 
            $viewdefs[$module_name]['base']['layout']['list'] = $layout_def;
         }

         array_unshift($viewdefs[$module_name]['base']['layout']['list']['components'], $new_component);      
      }

      
      // -----------------------------
      if ($module_name && $client_type == 'view' && $client_name == 'recordlist') {
      
         $new_action = array(
            'name' => 'generatedocument_button',
            'type' => 'button',
            'label' => 'LBL_GENERAR_DOCUMENTO',
            'primary' => true,
            'events' => array(
               'click' => 'list:massgeneratedocument:fire',
            ),
            'acl_module' => $module_name,
            'acl_action' => 'view',
         );

         // Aqui entrará si el módulo no tiene definido base/views/recordlist (ejemplo, módulo de Oportunidades)
         if (!isset($viewdefs) || empty($viewdefs) || empty($viewdefs[$module_name]['base']['view']['recordlist'])) {
            $view_def = MailMergeReports_getClientFileContents($module_name, $client_type, $client_name); 
            $viewdefs[$module_name]['base']['view']['recordlist'] = $view_def;
         }
         
         // Aqui entrará si no tiene definido base/views/recordlist/selection (ejemplo, módulo de Tareas en el que se definen sólo rowactions, pero no selection)
         // No copiar solo base/views/recordlist/selection/actions, porque dejamos sin copiar la (posible) propiedad 'type' => 'multi' (o 'type' => 'single') que está dentro de selections 
         // Tambien tener en cuenta que algunos modulos definen base/views/recordlist/selection como array vacío, para impedir que haya ningún tipo de accion, 
         // de momento se respetará esa decisión de diseño
         if (!isset($viewdefs[$module_name]['base']['view']['recordlist']['selection'])) {
            $view_def = MailMergeReports_getClientFileContents($module_name, $client_type, $client_name); 
            $viewdefs[$module_name]['base']['view']['recordlist']['selection'] = $view_def['selection'];
         }         
         
         // Nota: Un modulo que no entrará en ninguno de los casos anteriores sería el de Cuentas, en el que si que está definido base/views/recordlist y base/views/recordlist/selection/actions
         
         $viewdefs[$module_name]['base']['view']['recordlist']['selection']['actions'][] = $new_action;
      }
   }   

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook($event, $arguments) {
      // Este es el hook al que llamarán todos los módulos. Tiene dos partes, una para el detailview y otra para el ListView
      // No se utiliza en los nuevos modulos de Sugar 7
      
      global $sugar_config, $app_strings, $current_user;
      
      $controller = &$GLOBALS['app']->controller;
      $current_view = &$GLOBALS['current_view'];
      $bean = &$controller->bean;
      $user_id = $GLOBALS['current_user']->id;
      $action = strtolower($GLOBALS['action']);  //$controller->action;
      $module = $GLOBALS['module'];
      $record_id = $controller->record;
      $current_theme = '';
      
      //https://store.suitecrm.com/support/mail-merge-reports/949
      if (empty($bean)){
         return '';
      }
      
      $isSuiteCRM = MailMergeReports_isSuiteCRM();
      $isSuiteCRM_txt = 'false';
      $suitecrm_version = '';
      if ($isSuiteCRM){
         $suitecrm_version = MailMergeReports_SuiteCRMVersion();
         $isSuiteCRM_txt = 'true';
         $current_theme = &$GLOBALS['theme'];
      }
      

      if ($action == 'detailview') {
      
         if (!$bean->aclAccess("view")){
            return '';
         }

         $with_buttons = isset($sugar_config['enable_action_menu']) ? !$sugar_config['enable_action_menu'] : false;
         $with_buttons = ($with_buttons) ? 'true' : 'false';
         
         $massDocForm = get_massDocForm($bean);
         if (!$massDocForm) {
            return '';  // los permisos de roles se controlan en la funcion getMassGenerateDocumentForm
         }         
         
         // $module_div_id="{$module}_detailview_tabs";
         // $detailview_tabs_selector="#{$module_div_id}";
         // if ($isSuiteCRM && version_compare($suitecrm_version, '7.7.0', '>=')){
         //    $detailview_tabs_selector=".tab-content";
         // }
         
         $javascript =  <<<EOHTML
      <script type="text/javascript" language="JavaScript"> 

         jQuery( document ).ready(function() {
            if(jQuery('#generate_document_button').length == 0) {
               var massDocForm = "{$massDocForm}";
               var isSuiteCRM = {$isSuiteCRM_txt};
               var currentTheme = "{$current_theme}";
               
               if (isSuiteCRM && currentTheme == 'SuiteP') {
                  jQuery('.tab-content').before(massDocForm);
               }
               else {
                  jQuery('#{$module}_detailview_tabs').before(massDocForm);
               }

               var action_code_list = '<li><a id="generate_document_button" onclick="showMassGenerateDocumentForm();">{$app_strings['LBL_GENERAR_DOCUMENTO']}</a></li>';
               var action_code_button = '<span> </span><input title="{$app_strings['LBL_GENERAR_DOCUMENTO']}" class="button" onclick="showMassGenerateDocumentForm();" type="button" id="generate_document_button" name="generate_document_button" value="{$app_strings['LBL_GENERAR_DOCUMENTO']}">';

               if ({$with_buttons}) {
                  if (isSuiteCRM && currentTheme == 'SuiteP') {
                     jQuery('.actionsContainer #formDetailView .buttons').append(action_code_button);
                  }
                  else {
                     jQuery('div.actionsContainer div.action_buttons div.clear').before(action_code_button);
                  }
               }
               else {
                  if (isSuiteCRM && currentTheme == 'SuiteP') {
                     jQuery('#tab-actions ul.dropdown-menu').append(action_code_list);
                  }
                  else {
                     //jQuery('#detail_header_action_menu li.sugar_action_button ul.subnav').append(action_code_list);  // esto tambien funciona
                     jQuery("#detail_header_action_menu").sugarActionMenu('addItem',{item:jQuery(action_code_list)});
                  }
               }
            }
         });
      </script>
EOHTML;
         
         echo $javascript;
         return '';
      }
      else if ($action == 'index' || $action == 'listview') {
         
         if ($bean->bean_implements('ACL') && !ACLController::checkAccess($module,'view',true)){
            return '';
         }
         
         $massDocForm = get_massDocForm($bean);
         if (!$massDocForm) {
            return '';  // los permisos de roles se controlan en la funcion getMassGenerateDocumentForm
         }
         
         $action_code_list_top = "<a href=\"#massgeneratedocument_form\" id=\"massgeneratedocument_listview_top\" onclick=\"showMassGenerateDocumentForm(); var yLoc = YAHOO.util.Dom.getY(\'massgeneratedocument_form\'); scroll(0,yLoc);\">{$app_strings['LBL_GENERAR_DOCUMENTO']}</a>";
         $action_code_list_bottom = str_replace("massgeneratedocument_listview_top", "massgeneratedocument_listview_bottom", $action_code_list_top);
         
         $javascript =  <<<EOHTML
      <script type="text/javascript" language="JavaScript"> 

         jQuery( document ).ready(function() {
            if(jQuery('#massgeneratedocument_listview_top').length == 0) {
               var massDocForm = "{$massDocForm}";
               //jQuery('#search_form').after(massDocForm);
               jQuery('#MassUpdate').after(massDocForm);
            
               var action_code_list_top = '<li>{$action_code_list_top}</li>';
               var action_code_list_bottom = '<li>{$action_code_list_bottom}</li>';

               jQuery("#actionLinkTop").sugarActionMenu('addItem',{item:jQuery(action_code_list_top)});
               jQuery("#actionLinkBottom").sugarActionMenu('addItem',{item:jQuery(action_code_list_bottom)});
            }
         });
      </script>
EOHTML;
         
         echo $javascript;
         return '';
      }
   }
   
   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_get_action_array($module_name) {
      $action_array = array(
         1002,
         'Document Templates after_ui_frame Hook',
         "custom/modules/{$module_name}/DHA_DocumentTemplatesHooks.php", 
         "DHA_DocumentTemplates{$module_name}Hook_class", 
         'after_ui_frame_method'
      );
      return $action_array;      
   } 

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_get_all_modules() {
      // Devuelve un array con todos los módulos que existen en el sistema que puedan accederse a través del Estudio. 
      // Aqui se pueden aplicar filtros por si no interesa que algún módulo esté disponible por defecto
      
      global $app_list_strings, $sugar_version;
      
      // Nota: Esta funcion se requiere en la instalación del componente. 
      //       En Sugar 7 entra en bucle si se usa la funcion loadModules al intentar usarla durante la instalación (no durante su uso normal, una vez instalado)
      //       por eso se va a hacer una copia del código de la funcion loadModules (en \modules\ModuleBuilder\Module\StudioBrowser.php) adaptandola a lo que se necesita aqui
      //       Para que no de otros errores tambien en la instalacion se requiere que el bean del modulo tenga definido "$disable_custom_fields = true;" (en realidad si se definiera de esa forma no hace falta este código)
      //       Se deja este codigo, pero de momento no se va a realizar ninguna accion en la instalacion para Sugar 7
      if (version_compare($sugar_version, '7.0.0', '>=')) {
      
         $moduleList = $app_list_strings['moduleList'];
         if (empty($moduleList) && !is_array($moduleList)) {
            $moduleList = array();
         }
         $moduleNames = array_change_key_case($moduleList);

         
         global $current_user, $modInvisList;
         $modules = array();
         $access = $current_user->getDeveloperModules();
         $d = dir('modules');
         while($e = $d->read()){
            if (($e == "Project" || $e == "ProjectTask") && in_array($e, $modInvisList)) {
               continue;
            }
            if(substr($e, 0, 1) == '.' || !is_dir('modules/' . $e)){
               continue;
            }
            if(file_exists('modules/' . $e . '/metadata/studio.php') && isset($GLOBALS['beanList'][$e]) && (in_array($e, $access) || $current_user->isAdmin())) {// installed modules must also exist in the beanList
               $modules[$e] = isset($moduleNames[strtolower($e)]) ? $moduleNames[strtolower($e)] : strtolower($e);
            }
         }

      }
      else {

         require_once('modules/ModuleBuilder/Module/StudioBrowser.php');
         $browser = new StudioBrowser();
         $browser->loadModules();
         
         $modules = array();
         foreach ($browser->modules as $module_name => $def) {
            $modules[$module_name] = $def->name;
         }
      }
      
      $aditional_modules = array('ProspectLists');
      foreach ($aditional_modules as $module_name) {
         if (!isset($modules[$module_name])) {
            $modules[$module_name] = (isset($app_list_strings['moduleList'][$module_name])) ? $app_list_strings['moduleList'][$module_name] : $module_name;
         }
      }
      
      $remove_modules = array('Home', 'Calendar', 'Emails', 'Products');  // No deben de estar Home, Calendar ni Emails. El modulo Products es en realidad Quoted Line Items
      foreach ($remove_modules as $module_name) {
         if (isset($modules[$module_name])) {
            unset($modules[$module_name]);
         }
      }      

      return $modules;
   }     

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_enabled_modules() {
      // Devuelve un array con todos los módulos que tienen el hook instalado
      
      $modules = MailMergeReports_get_all_modules();
      $enabled_modules = array();
      foreach ($modules as $module_name => $module_label) {
         if (MailMergeReports_after_ui_frame_hook_module_enabled($module_name)) {
            $enabled_modules[$module_name] = $module_label;
         }
      }

      return $enabled_modules;
   }  

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_disabled_modules() {
      // Devuelve un array con todos los módulos permitidos que NO tienen el hook instalado
      
      $modules = MailMergeReports_get_all_modules();
      $enabled_modules = MailMergeReports_after_ui_frame_hook_enabled_modules();
      $disabled_modules = array();
      foreach ($modules as $module_name => $module_label) {
         if (!isset($enabled_modules[$module_name])) {
            $disabled_modules[$module_name] = $module_label;
         }
      }

      return $disabled_modules;
   }    
 
   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_module_enabled($module_name) {
      // Nos dice si un módulo tiene el hook instalado
      
      require_once('include/utils/logic_utils.php');   

      $OK = false;
      if (MailMergeReports_Sugar7Module($module_name)) {
         // Hay mas ficheros, pero con comprobar uno, suficiente
         if (file_exists("custom/Extension/modules/{$module_name}/Ext/clients/base/views/recordlist/MailMergeReports_recordlist.php")) {
            $OK = true;
         }
      }
      else {
         if (file_exists("custom/modules/{$module_name}/DHA_DocumentTemplatesHooks.php")) {
               $hook_array = get_hook_array($module_name);
               $action_array = MailMergeReports_after_ui_frame_hook_get_action_array ($module_name);
               $OK = check_existing_element($hook_array, 'after_ui_frame', $action_array);
         }
      }
      return $OK;      
   }  

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_module_remove($module_name, $repair = false) {
      // Elimina el hook del módulo pasado como parámetro
      
      require_once('include/utils.php');   

      // Antes de eliminar comprobamos que realmente el hook está instalado para el módulo pasado como parámetro
      $enabled = MailMergeReports_after_ui_frame_hook_module_enabled ($module_name);
      
      if (MailMergeReports_Sugar7Module($module_name)) {
      
         // PARA ESTE CASO SE REQUIERE SIEMPRE UN REPAIR AND REBUILD (SUGAR 7)
         $hook_file = "custom/Extension/modules/{$module_name}/Ext/clients/base/views/recordlist/MailMergeReports_recordlist.php";
         if (file_exists($hook_file)) {
            unlink ($hook_file);
         }
         $hook_file = "custom/Extension/modules/{$module_name}/Ext/clients/base/layouts/list/MailMergeReports_list.php";
         if (file_exists($hook_file)) {
            unlink ($hook_file);
         }         
      }
      else {
      
         if ($enabled) {
            $action_array = MailMergeReports_after_ui_frame_hook_get_action_array ($module_name);
            remove_logic_hook($module_name, 'after_ui_frame', $action_array);
         }
         
         $hook_file = "custom/modules/{$module_name}/DHA_DocumentTemplatesHooks.php";
         if (file_exists($hook_file)) {
            unlink ($hook_file);
         }
      }
      
      if ($repair) {
         MailMergeReports_repairAndClear($module_name);
      }
   }    
   
   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_module_install($module_name, $repair = false) {
      // Instala el hook en el módulo pasado como parámetro
      
      require_once('include/utils.php');   
      require_once('include/utils/logic_utils.php');
      require_once('include/utils/file_utils.php');
      require_once('include/utils/sugar_file_utils.php');
      
      // Antes de instalar, intentamos quitar el hook que ya estuviera instalado y reinstalamos despues, por si hay cambios en el codigo.
      // La función de eliminación ya se encargará de comprobar si existía o no previamente el hook
      MailMergeReports_after_ui_frame_hook_module_remove ($module_name, false);      
      
      if (MailMergeReports_Sugar7Module($module_name)) {
      
         // PARA ESTE CASO SE REQUIERE SIEMPRE UN REPAIR AND REBUILD (SUGAR 7)
         // Nos aseguramos primero de que existe el directorio del módulo dentro de 'custom/Extension'
         $hook_file = "Extension/modules/{$module_name}/Ext/clients/base/views/recordlist/MailMergeReports_recordlist.php";
         $hook_file = create_custom_directory($hook_file);
         
         // Guardamos el fichero del codigo
         $code = <<<EOHTML
<?php
   require_once('modules/DHA_PlantillasDocumentos/UI_Hooks.php');
   MailMergeReports_customize_clients ('{$module_name}', 'view', 'recordlist', \$viewdefs);
?>      
EOHTML;

         $OK = sugar_file_put_contents_atomic($hook_file, $code);  // ver tambien write_array_to_file y sugar_file_put_contents
         
         
         // Guardamos tambien la extension para el "client" list
         // Nota: Si se tuviera que extender globalmente (no por modulo) se puede hacer extendiendo \custom\Extension\application\Ext\clients\base\layouts\list\MailMergeReports_list.php
         //       Pero se tiene el peligro de si existiera una customizacion propia de algún módulo para "list"
         $hook_file = "Extension/modules/{$module_name}/Ext/clients/base/layouts/list/MailMergeReports_list.php";
         $hook_file = create_custom_directory($hook_file);
         
         // Guardamos el fichero del codigo
         $code = <<<EOHTML
<?php
   require_once('modules/DHA_PlantillasDocumentos/UI_Hooks.php');
   MailMergeReports_customize_clients ('{$module_name}', 'layout', 'list', \$viewdefs);
?>      
EOHTML;

         $OK = sugar_file_put_contents_atomic($hook_file, $code);  // ver tambien write_array_to_file y sugar_file_put_contents         
         
      }
      else {

         // Nos aseguramos primero de que existe el directorio del módulo dentro de 'custom'
         $hook_file = "modules/{$module_name}/DHA_DocumentTemplatesHooks.php";
         $hook_file = create_custom_directory($hook_file);
         
         // Guardamos el fichero del codigo del hook
         $code = <<<EOHTML
<?php
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
   if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
   class DHA_DocumentTemplates{$module_name}Hook_class {
      function after_ui_frame_method(\$event, \$arguments) {
         require_once('modules/DHA_PlantillasDocumentos/UI_Hooks.php');
         MailMergeReports_after_ui_frame_hook (\$event, \$arguments);
      }
   }
?>      
EOHTML;

         $OK = sugar_file_put_contents_atomic($hook_file, $code);  // ver tambien write_array_to_file y sugar_file_put_contents
         
         // Si todo ha ido bien, instalamos el hook
         if ($OK) {
            $action_array = MailMergeReports_after_ui_frame_hook_get_action_array ($module_name);
            check_logic_hook_file($module_name, 'after_ui_frame', $action_array);
         }
      }
      
      if ($repair) {
         MailMergeReports_repairAndClear($module_name);
      }
   } 

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_install_all_modules() {
      // Instala el hook para todos los módulos
      
      $modules = MailMergeReports_get_all_modules();
      
      foreach ($modules as $module_name => $module_label) {
         MailMergeReports_after_ui_frame_hook_module_install($module_name, false);
      }
   }  

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_after_ui_frame_hook_remove_all_modules() {
      // Elimina el hook de todos los módulos
      
      $modules = MailMergeReports_get_all_modules();
      
      foreach ($modules as $module_name => $module_label) {
         MailMergeReports_after_ui_frame_hook_module_remove($module_name, false);
      }
   }    

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_Sugar7Module($module_name) {

      global $sugar_version;
      $result = false;
      if (version_compare($sugar_version, '7.0.0', '>=')) {
         $result = true;
         if ($module_name) {
            global $bwcModules; 
            // Ver la funcion isModuleBWC
            $result = !in_array($module_name, $bwcModules);
         }
      }
      
      return $result;
   }

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_isSuiteCRM() {
      global $sugar_config;
      
      $isSuiteCRM = (isset($sugar_config['suitecrm_version']) && $sugar_config['suitecrm_version']);
      return $isSuiteCRM;
   }

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_SuiteCRMVersion() {
      global $sugar_config;
      
      $suitecrm_version = '';
      if (MailMergeReports_isSuiteCRM()){
         $suitecrm_version = $sugar_config['suitecrm_version'];
      }
      return $suitecrm_version;
   }

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function MailMergeReports_repairAndClear($module_name_or_module_list = '') {
      // Ver funcion repairAndClearAll
      // Esta funcion puede tardar mucho en ejecutarse
      
      $all_modules = false;
      if (is_array($module_name_or_module_list)){
         if (empty($module_name_or_module_list)){
            $all_modules = true;
         }
         else{
            $tmp_modules = $module_name_or_module_list;  
         }
      }
      else {
         if (!$module_name_or_module_list) {
            $all_modules = true;
         }
         else {
            $tmp_modules = Array($module_name_or_module_list);  
         }
      }
      
      
      $do_it = false;
      if ($all_modules) {
         $modules = Array(translate('LBL_ALL_MODULES', 'Administration'));
         $do_it = MailMergeReports_Sugar7Module('');
      }
      else {
         $modules = Array();
         foreach ($tmp_modules as $id => $module_name) {
            if (MailMergeReports_Sugar7Module($module_name)){
               $do_it = true;
               $modules[] = $module_name;
            }
         }         
      }
      
      if ($do_it) {  // SOLO PARA SUGAR 7 (Y SOLO MODULOS NUEVOS). EN SUGAR 6 NO SE NECESITA

         set_time_limit(0);
         
         require_once('modules/Administration/QuickRepairAndRebuild.php');

         // Nota: Este proceso se ejecutará desde la ventana de configuración (o desde el instalador del componente si fuera necesario), por lo que el usuario activo siempre será un Adminstrador
         
         // $old_user = $GLOBALS['current_user'];
         // $user = new User();
         // $GLOBALS['current_user'] = $user->getSystemUser();          
         $_REQUEST['repair_silent'] = 1;
         $show_output = false;
         
         $rc = new RepairAndClear();
         $actions = array(
            'clearAll',
         );
         $modules = Array(translate('LBL_ALL_MODULES', 'Administration'));  // TEMPORAL. Repair completo
         $rc->repairAndClearAll($actions, $modules, true, $show_output, false);

         // No se va a usar el repairAndClearAll, puesto que aqui no hace falta que haga todo tipo de reparación. Sólo las imprescindibles.
         // NO FUNCIONA BIEN. DESPUES DE GUARDAR SE QUEDA COLGADO ¿¿??
         /*
         $rc->module_list= $modules;
         $rc->show_output = false;
         $rc->execute = true; 
         MetaDataManager::enableCacheRefreshQueue(); 
         // Ver la sección 'clearAll' de la funcion repairAndClearAll
         //$rc->clearTpls();
         //$rc->clearJsFiles();
         $rc->clearVardefs();
         //$rc->clearJsLangFiles();
         //$rc->clearLanguageCache();
         //$rc->clearDashlets();
         //$rc->clearSmarty();
         //$rc->clearThemeCache();
         //$rc->clearXMLfiles();
         //$rc->clearSearchCache();
         $rc->clearExternalAPICache();
         $rc->clearAdditionalCaches();
         //$rc->clearPDFFontCache();
         //$rc->rebuildExtensions();
         if($all_modules) {
            $rc->rebuildExtensions();
         } else {
            $rc->rebuildExtensions($rc->module_list);
         }         
         //$rc->rebuildFileMap();     
         //$rc->rebuildAuditTables();
         //$rc->repairDatabase();
         $rc->repairMetadataAPICache('');
         MetaDataManager::runCacheRefreshQueue();
         */          
         
         
         //$GLOBALS['current_user'] = $old_user;
         //unset ($_REQUEST['repair_silent']);
      }  
   }       
 
?>