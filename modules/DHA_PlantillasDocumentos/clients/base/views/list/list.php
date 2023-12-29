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
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$moduleName = 'DHA_PlantillasDocumentos';
$viewdefs[$moduleName]['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
            
               // Calculado, ver el bean
               array (
                 'name' => 'file_url', 
                 'width' => '2%',
                 'label' => '',
                 'link' => true,
                 'enabled' => true,
                 'default' => true,
                 'related_fields' => 
                 array (
                   0 => 'file_ext',
                 ),
                 'sortable' => false,
                 'studio' => false,
                 'readonly' => true,
                 'dismiss_label' => true,
               ),
               
               array (
                 'name' => 'document_name', 
                 'width' => '20%',
                 'label' => 'LBL_NAME',
                 'link' => true,
                 'enabled' => true,
                 'default' => true,
               ),
               
               // Calculado, ver el bean
               array (
                 'name' => 'modulo_url', 
                 'width' => '2%',
                 'label' => '',
                 'link' => false, //true,
                 'enabled' => true,
                 'default' => true,
                 'sortable' => false,
                 'studio' => false,
                 'readonly' => true,
                 'dismiss_label' => true,
               ),  
               array (
                 'name' => 'modulo', 
                 'type' => 'enum',
                 'enabled' => true,
                 'default' => true,
                 'studio' => 'visible',
                 'label' => 'LBL_MODULO',
                 'width' => '10%',
               ),
               array (
                 'name' => 'idioma',  
                 'type' => 'enum',
                 'enabled' => true,
                 'default' => true,
                 'studio' => 'visible',
                 'label' => 'LBL_IDIOMA_PLANTILLA',
                 'width' => '10%',
               ),
               array (
                 'name' => 'status_id',  
                 'type' => 'enum',
                 'enabled' => true,
                 'default' => true,
                 'studio' => 'visible',
                 'label' => 'LBL_DOC_STATUS',
                 'width' => '10%',
               ),
               array (
                 'name' => 'category_id',  
                 'width' => '10%',
                 'label' => 'LBL_LIST_CATEGORY',
                 'enabled' => true,
                 'default' => true,
               ),
               array (
                 'name' => 'subcategory_id', 
                 'width' => '40%',
                 'label' => 'LBL_LIST_SUBCATEGORY',
                 'enabled' => true,
                 'default' => false,
               ),  

               array (
                 // 'link' => 'assigned_user_link',
                 // 'type' => 'relate',
                 // 'label' => 'LBL_ASSIGNED_TO_NAME',
                 // 'width' => '10%',
                 // 'enabled' => true,
                 // 'default' => true,
                 // 'module' => 'Employees',
                 
                 'name' => 'assigned_user_name',
                 'width' => '10%',
                 'label' => 'LBL_LIST_ASSIGNED_USER',
                 'id' => 'ASSIGNED_USER_ID',
                 'enabled' => true,
                 'default' => true,                 
               ),

               array (
                 'name' => 'description',
                 'name' => 'assigned_user_name',
                 'type' => 'text',
                 'label' => 'LBL_DESCRIPTION',
                 'sortable' => false,
                 'width' => '10%',
                 'enabled' => true,
                 'default' => false,
               ),
               array (
                 'name' => 'file_ext',
                 'type' => 'varchar',
                 'label' => 'LBL_FILE_EXTENSION',
                 'width' => '10%',
                 'enabled' => true,
                 'default' => false,
                 'readonly' => true,
               ),
               array (
                 'name' => 'aclroles',
                 'type' => 'multienum',
                 'enabled' => true,
                 'default' => true,
                 'studio' => 'visible',
                 'label' => 'LBL_ROLES_WITH_ACCESS',
                 'width' => '10%',
                 'sortable' => false,
               ), 
               array (
                 'name' => 'created_by_name',
                 'width' => '2%',
                 'label' => 'LBL_LIST_LAST_REV_CREATOR',
                 'enabled' => true,
                 'default' => false,
                 'sortable' => false,
                 'readonly' => true,
               ),
               array (
                 'name' => 'date_entered',
                 'type' => 'datetime',
                 'label' => 'LBL_DATE_ENTERED',
                 'width' => '10%',
                 'enabled' => true,
                 'default' => false,
                 'readonly' => true,            
               ),
               array (
                 'name' => 'modified_by_name',
                 'width' => '10%',
                 'label' => 'LBL_MODIFIED_USER',
                 'module' => 'Users',
                 'id' => 'USERS_ID',
                 'enabled' => true,
                 'default' => false,
                 'sortable' => false,
                 'related_fields' => 
                 array (
                   0 => 'modified_user_id',
                 ),
                 'readonly' => true,
               ),
               array (
                 'name' => 'date_modified',
                 'type' => 'datetime',
                 'label' => 'LBL_DATE_MODIFIED',
                 'width' => '10%',
                 'enabled' => true,
                 'default' => false,
                 'readonly' => true,
               ), 
               array (
                 'name' => 'uploadfile',
                 'type' => 'file',
                 'label' => 'LBL_FILE_UPLOAD',
                 'width' => '10%',
                 'enabled' => true,
                 'default' => false,
                 'readonly' => true,
               ),            
            ),
        ),
    ),
);
