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
global $sugar_config;

$dictionary['DHA_PlantillasDocumentos'] = array(
   'table'=>'dha_plantillasdocumentos',
   'audited'=> true,
   'activity_enabled' => true,
   'unified_search' => true,
   'full_text_search' => true,
   'unified_search_default_enabled' => true,
   'duplicate_merge' => true,
   'comment' => 'Document templates',
   'favorites' => true,
   
   'fields'=> array (
      'document_name' => array (
         'name' => 'document_name',
         'vname' => 'LBL_NAME',
         'type' => 'name',
         'link' => true,
         'dbType' => 'varchar',
         'len' => '255',
         'required' => true,
         'unified_search' => true,
         'full_text_search' => array('enabled' => true, 'searchable' => true, 'boost' => 1.10),
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'importable' => 'required',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'size' => '20',
      ),
      'name' => array(
         'name' => 'name',
         'vname' => 'LBL_NAME',
         'source' => 'non-db',
         'type' => 'varchar',
         'fields' => array('document_name'),
         'sort_on' => 'name',
      ),      
      'filename' => array (
         'name' => 'filename',
         'vname' => 'LBL_FILENAME',
         'type' => 'varchar',
         'required' => true,
         'importable' => 'required',
         'len' => '255',
         'studio' => 'false',
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'size' => '20',
      ),
      'file_ext' => array (
         'name' => 'file_ext',
         'vname' => 'LBL_FILE_EXTENSION',
         'type' => 'varchar',
         'len' => '100',
         'required' => false,
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'size' => '20',
      ),
      'file_mime_type' => array (
         'name' => 'file_mime_type',
         'vname' => 'LBL_MIME',
         'type' => 'varchar',
         'len' => '100',
         'required' => false,
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'size' => '20',
      ),
      'uploadfile' => array (
         'name' => 'uploadfile',
         'vname' => 'LBL_FILE_UPLOAD',
         'type' => 'file',
         //'noChange' => true,      // si quitamos esta propiedad nos da la opcion de quitar el fichero (aparece un boton de "Quitar")
         'required' => false, //true,
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'len' => '255',
         'size' => '20',
         'allowEapm' => true,  // De momento si no se pone en el editview no indica el tama�o maximo del archivo
         //'docType' => 'file_ext',
         //'docUrl' => 'file_url',
         // 'docId' => 'id',    
      ),
      // 'file_url' => array(
         // 'name' => 'file_url',
         // 'source' => 'non-db',
         // 'vname' => 'URL',
         // 'type' => 'varchar',
         // 'len' => '2000',
         // 'comment' => '',
         // 'importable' => false,
         // 'massupdate' => false,
         // 'studio' => 'false',
      // ), 
      'active_date' => array (
         'name' => 'active_date',
         'vname' => 'LBL_DOC_ACTIVE_DATE',
         'type' => 'date',
         'required' => false,
         'importable' => 'required',
         'display_default' => 'now',
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'size' => '20',
         'enable_range_search' => false,
      ),
      'exp_date' => array (
         'name' => 'exp_date',
         'vname' => 'LBL_DOC_EXP_DATE',
         'type' => 'date',
         'required' => false,
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'size' => '20',
         'enable_range_search' => false,
      ),
      'category_id' => array (
         'name' => 'category_id',
         'vname' => 'LBL_SF_CATEGORY',
         'type' => 'enum',
         'len' => 100,
         'options' => 'dha_plantillasdocumentos_category_dom',
         'reportable' => true,
         'required' => false,
         'massupdate' => 1,
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'size' => '20',
         'studio' => 'visible',
         'dependency' => false,
      ),
      'subcategory_id' => array (
         'name' => 'subcategory_id',
         'vname' => 'LBL_SF_SUBCATEGORY',
         'type' => 'enum',
         'len' => 100,
         'options' => 'dha_plantillasdocumentos_subcategory_dom',
         'reportable' => true,
         'required' => false,
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'size' => '20',
         'studio' => 'visible',
         'dependency' => false,
      ),
      'status_id' => array (
         'name' => 'status_id',
         'vname' => 'LBL_DOC_STATUS',
         'type' => 'enum',
         'len' => 100,
         'options' => 'dha_plantillasdocumentos_status_dom',
         'reportable' => true,
         'required' => false,
         'massupdate' => 1,
         'default' => '',
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'size' => '20',
         'studio' => 'visible',
         'dependency' => false,
      ),
      'status' => array (
         'name' => 'status',
         'vname' => 'LBL_DOC_STATUS',
         'type' => 'varchar',
         'Comment' => '',
         'required' => false,
         'massupdate' => 0,
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => false,
         'reportable' => true,
         'len' => '255',
         'size' => '20',
      ),
      'modulo' => array (
         'name' => 'modulo',
         'vname' => 'LBL_MODULO',
         'type' => 'enum',
         'len' => 100,
         'options' => 'dha_plantillasdocumentos_module_dom',  // esta lista se rellena dinamicamente !!!
         'reportable' => true,
         'required' => true,
         'massupdate' => 0,
         'default' => '',
         'comments' => '',
         'help' => '',
         'importable' => 'required',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => true,
         'size' => '20',
         'studio' => 'visible',
         'dependency' => false,
         'bold' => true,
      ),  
      'idioma' => array (
         'name' => 'idioma',
         'vname' => 'LBL_IDIOMA_PLANTILLA',
         'type' => 'enum',
         'len' => 50,
         'options' => 'dha_plantillasdocumentos_idiomas_dom',
         'reportable' => true,
         'required' => true,
         'massupdate' => 0,
         'default' => $sugar_config['DHA_templates_default_lang'], //'es',
         'comments' => '',
         'help' => '',
         'importable' => 'required',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => true,
         'size' => '20',
         'studio' => 'visible',
         'dependency' => false,
      ),
      'aclroles' => array (
         'required' => false,
         'name' => 'aclroles',
         'vname' => 'LBL_ROLES_WITH_ACCESS',
         'type' => 'multienum',
         'massupdate' => 0,
         'default' => '^^',    
         'comments' => '',
         'help' => '',
         'importable' => 'true',
         'duplicate_merge' => 'disabled',
         'duplicate_merge_dom_value' => '0',
         'audited' => true,
         'reportable' => true,
         'size' => '20',
         'options' => 'dha_plantillasdocumentos_roles_dom',  // esta lista se rellena dinamicamente !!!
         'studio' => 'visible',
         'isMultiSelect' => true,
      ),   
   ),
   
   'indices' => array(
      array('name' => 'idx_dhapd_id_del', 'type' => 'index', 'fields' => array('id', 'deleted')),
      array('name' => 'idx_dhapd_name_del', 'type' => 'index', 'fields' => array('document_name', 'deleted')), 
      array('name' => 'idx_dhapd_mod_del', 'type' => 'index', 'fields' => array('modulo', 'deleted')), 
   ),   
   
   'relationships'=> array (
   ),
   
   // Sugar 7
   'duplicate_check' => array(
      'enabled' => true,
      'FilterDuplicateCheck' => array(
         'filter_template' => array(
            //array('document_name' => array('$starts' => '$document_name')),
            array(
              '$and' => array(
                  array('document_name' => array('$equals' => '$document_name')),
                  array('modulo' => array('$equals' => '$modulo'))
               )
            ),            
         ),
         'ranking_fields' => array(
            array('in_field_name' => 'document_name', 'dupe_field_name' => 'document_name'),
            array('in_field_name' => 'modulo', 'dupe_field_name' => 'modulo'),
         )
      )
   ),
   
   'optimistic_locking'=> true,
);
   
// if (!class_exists('VardefManager')){
   // require_once('include/SugarObjects/VardefManager.php');
// }

VardefManager::createVardef('DHA_PlantillasDocumentos','DHA_PlantillasDocumentos', array('basic', 'assignable', 'file', /*'team_security'*/ ));


// // Listas dinamicas
// require_once('modules/DHA_PlantillasDocumentos/DHA_PlantillasDocumentos.php');
// DHA_PlantillasDocumentos::get_dynamic_list_strings();

