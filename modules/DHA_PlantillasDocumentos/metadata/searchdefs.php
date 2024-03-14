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

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $searchdefs [$module_name] = 
// array (
//   'layout' => 
//   array (
//     'basic_search' => 
//     array (
//       'document_name' => 
//       array (
//         'name' => 'document_name',
//         'default' => true,
//         'width' => '10%',
//       ),
//       'modulo' => 
//       array (
//         'type' => 'enum',
//         'default' => true,
//         'studio' => 'visible',
//         'label' => 'LBL_MODULO',
//         'width' => '10%',
//         'name' => 'modulo',
//       ),
//       'current_user_only' => 
//       array (
//         'name' => 'current_user_only',
//         'label' => 'LBL_CURRENT_USER_FILTER',
//         'type' => 'bool',
//         'default' => true,
//         'width' => '10%',
//       ),      
//     ),
//     'advanced_search' => 
//     array (
//       'document_name' => 
//       array (
//         'name' => 'document_name',
//         'default' => true,
//         'width' => '10%',
//       ),
//       'modulo' => 
//       array (
//         'type' => 'enum',
//         'default' => true,
//         'studio' => 'visible',
//         'label' => 'LBL_MODULO',
//         'width' => '10%',
//         'name' => 'modulo',
//       ),
//       'idioma' => 
//       array (
//         'type' => 'enum',
//         'default' => true,
//         'studio' => 'visible',
//         'label' => 'LBL_IDIOMA_PLANTILLA',
//         'width' => '10%',
//         'name' => 'idioma',
//       ),
//       'category_id' => 
//       array (
//         'name' => 'category_id',
//         'default' => true,
//         'width' => '10%',
//       ),
//       'status_id' => 
//       array (
//         'type' => 'enum',
//         'default' => true,
//         'studio' => 'visible',
//         'label' => 'LBL_DOC_STATUS',
//         'width' => '10%',
//         'name' => 'status_id',
//       ),
//       'assigned_user_name' => 
//       array (
//         'link' => 'assigned_user_link',
//         'type' => 'relate',
//         'label' => 'LBL_ASSIGNED_TO_NAME',
//         'width' => '10%',
//         'default' => true,
//         'name' => 'assigned_user_name',
//       ),
//       'description' => 
//       array (
//         'type' => 'text',
//         'label' => 'LBL_DESCRIPTION',
//         'sortable' => false,
//         'width' => '10%',
//         'default' => true,
//         'name' => 'description',
//       ),
//       'aclroles' => 
//       array (
//         'type' => 'multienum',
//         'default' => true,
//         'studio' => 'visible',
//         'label' => 'LBL_ROLES_WITH_ACCESS',
//         'width' => '10%',
//         'name' => 'aclroles',
//       ),       
//     ),
//   ),
//   'templateMeta' => 
//   array (
//     'maxColumns' => '3',
//     'maxColumnsBasic' => '4',
//     'widths' => 
//     array (
//       'label' => '10',
//       'field' => '30',
//     ),
//   ),
// );

$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'document_name' => array(
                'name' => 'document_name',
                'default' => true,
                'width' => '10%',
            ),
            'modulo' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_MODULO',
                'width' => '10%',
                'name' => 'modulo',
            ),
            'idioma' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_IDIOMA_PLANTILLA',
                'width' => '10%',
                'name' => 'idioma',
            ),
            'status_id' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_DOC_STATUS',
                'width' => '10%',
                'name' => 'status_id',
            ),
            'assigned_user_name' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            'document_name' => array(
                'name' => 'document_name',
                'default' => true,
                'width' => '10%',
            ),
            'modulo' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_MODULO',
                'width' => '10%',
                'name' => 'modulo',
            ),
            'idioma' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_IDIOMA_PLANTILLA',
                'width' => '10%',
                'name' => 'idioma',
            ),
            'status_id' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_DOC_STATUS',
                'width' => '10%',
                'name' => 'status_id',
            ),
            'assigned_user_name' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'aclroles' => array(
                'type' => 'multienum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_ROLES_WITH_ACCESS',
                'width' => '10%',
                'name' => 'aclroles',
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);
// END STIC-Custom 

global $sugar_flavor;
if(!empty($sugar_flavor) && $sugar_flavor != 'CE'){
   $searchdefs [$module_name]['layout']['basic_search']['favorites_only'] = array (
      'name' => 'favorites_only',
      'label' => 'LBL_FAVORITES_FILTER',
      'type' => 'bool',
   );
   $searchdefs [$module_name]['layout']['advanced_search']['favorites_only'] = $searchdefs [$module_name]['layout']['basic_search']['favorites_only'];
}

?>
