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

$module_name = 'DHA_PlantillasDocumentos';
$OBJECT_NAME = 'DHA_PLANTILLASDOCUMENTOS';
 
// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $listViewDefs [$module_name] = 
// array (
//   // Calculado, ver el bean
//   'FILE_URL' => 
//   array (
//     'width' => '2%',
//     'label' => '&nbsp;',
//     'link' => true,
//     'default' => true,
//     'related_fields' => 
//     array (
//       0 => 'file_ext',
//     ),
//     'sortable' => false,
//     'studio' => false,
//   ),
  
//   'DOCUMENT_NAME' => 
//   array (
//     'width' => '25%',
//     'label' => 'LBL_NAME',
//     'link' => true,
//     'default' => true,
//   ),
  
//   // Calculado, ver el bean
//   'MODULO_URL' => 
//   array (
//     'width' => '2%',
//     'label' => '&nbsp;',
//     'link' => false, //true,
//     'default' => true,
//     'sortable' => false,
//     'studio' => false,
//   ),  
  
//   'MODULO' => 
//   array (
//     'type' => 'enum',
//     'default' => true,
//     'studio' => 'visible',
//     'label' => 'LBL_MODULO',
//     'width' => '10%',
//   ),
//   'IDIOMA' => 
//   array (
//     'type' => 'enum',
//     'default' => true,
//     'studio' => 'visible',
//     'label' => 'LBL_IDIOMA_PLANTILLA',
//     'width' => '10%',
//   ),
//   'STATUS_ID' => 
//   array (
//     'type' => 'enum',
//     'default' => true,
//     'studio' => 'visible',
//     'label' => 'LBL_DOC_STATUS',
//     'width' => '10%',
//   ),
//   'CATEGORY_ID' => 
//   array (
//     'width' => '10%',
//     'label' => 'LBL_LIST_CATEGORY',
//     'default' => true,
//   ),
//   'SUBCATEGORY_ID' => 
//   array (
//     'width' => '40%',
//     'label' => 'LBL_LIST_SUBCATEGORY',
//     'default' => false,
//   ),  
//   'ASSIGNED_USER_NAME' => 
//   array (
//     'link' => 'assigned_user_link',
//     'type' => 'relate',
//     'label' => 'LBL_ASSIGNED_TO_NAME',
//     'width' => '10%',
//     'default' => true,
//     'module' => 'Employees',
//   ),
//   'DESCRIPTION' => 
//   array (
//     'type' => 'text',
//     'label' => 'LBL_DESCRIPTION',
//     'sortable' => false,
//     'width' => '10%',
//     'default' => false,
//   ),
//   'FILE_EXT' => 
//   array (
//     'type' => 'varchar',
//     'label' => 'LBL_FILE_EXTENSION',
//     'width' => '10%',
//     'default' => false,
//   ),
//   'ACLROLES' => 
//   array (
//     'type' => 'multienum',
//     'default' => true,
//     'studio' => 'visible',
//     'label' => 'LBL_ROLES_WITH_ACCESS',
//     'width' => '10%',
//   ), 
//   'CREATED_BY_NAME' => 
//   array (
//     'width' => '2%',
//     'label' => 'LBL_LIST_LAST_REV_CREATOR',
//     'default' => false,
//     'sortable' => false,
//   ),
//   'DATE_ENTERED' => 
//   array (
//     'type' => 'datetime',
//     'label' => 'LBL_DATE_ENTERED',
//     'width' => '10%',
//     'default' => false,
//   ),
//   'MODIFIED_BY_NAME' => 
//   array (
//     'width' => '10%',
//     'label' => 'LBL_MODIFIED_USER',
//     'module' => 'Users',
//     'id' => 'USERS_ID',
//     'default' => false,
//     'sortable' => false,
//     'related_fields' => 
//     array (
//       0 => 'modified_user_id',
//     ),
//   ),
//   'DATE_MODIFIED' => 
//   array (
//     'type' => 'datetime',
//     'label' => 'LBL_DATE_MODIFIED',
//     'width' => '10%',
//     'default' => false,
//   ),
//   'UPLOADFILE' => 
//   array (
//     'type' => 'file',
//     'label' => 'LBL_FILE_UPLOAD',
//     'width' => '10%',
//     'default' => false,
//   ),
// );

$listViewDefs [$module_name] = 
array (
  'FILE_URL' => 
  array (
    'width' => '2%',
    'label' => '&nbsp;',
    'link' => true,
    'default' => true,
    'related_fields' => 
    array (
      0 => 'file_ext',
    ),
    'sortable' => false,
    'studio' => false,
  ),
  'MODULO_URL' => 
  array (
    'width' => '2%',
    'label' => '&nbsp;',
    'link' => false,
    'default' => true,
    'sortable' => false,
    'studio' => false,
  ),
  'DOCUMENT_NAME' => 
  array (
    'width' => '25%',
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
  ),
  'MODULO' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_MODULO',
    'width' => '10%',
  ),
  'IDIOMA' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_IDIOMA_PLANTILLA',
    'width' => '10%',
  ),
  'STATUS_ID' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_DOC_STATUS',
    'width' => '10%',
  ),
  'CATEGORY_ID' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_CATEGORY',
    'default' => false,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => 'assigned_user_link',
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'width' => '10%',
    'default' => true,
    'module' => 'Employees',
  ),
  'ACLROLES' => 
  array (
    'type' => 'multienum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_ROLES_WITH_ACCESS',
    'width' => '10%',
  ),
  'SUBCATEGORY_ID' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_SUBCATEGORY',
    'default' => false,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'FILE_EXT' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FILE_EXTENSION',
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'width' => '2%',
    'label' => 'LBL_LIST_LAST_REV_CREATOR',
    'default' => false,
    'sortable' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_MODIFIED_USER',
    'module' => 'Users',
    'id' => 'USERS_ID',
    'default' => false,
    'sortable' => false,
    'related_fields' => 
    array (
      0 => 'modified_user_id',
    ),
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => false,
  ),
  'UPLOADFILE' => 
  array (
    'type' => 'file',
    'label' => 'LBL_FILE_UPLOAD',
    'width' => '10%',
    'default' => false,
  ),
);
// END STIC-Custom 