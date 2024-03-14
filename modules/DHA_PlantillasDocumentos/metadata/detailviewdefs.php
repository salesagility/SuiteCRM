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
$_object_name = 'dha_plantillasdocumentos';

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $viewdefs [$module_name] = 
// array (
//   'DetailView' => 
//   array (
//     'templateMeta' => 
//     array (
//       'maxColumns' => '2',
//       'form' => 
//       array (
//         'buttons' => array (
//           0 => 'EDIT',
//           //1 => 'DUPLICATE',  // no se permite el duplicado !!!
//           1 => 'DELETE',
//         ),              
//       ),
//       'widths' => 
//       array (
//         0 => 
//         array (
//           'label' => '10',
//           'field' => '30',
//         ),
//         1 => 
//         array (
//           'label' => '10',
//           'field' => '30',
//         ),
//       ),
//       'useTabs' => false,
//     ),
//     'panels' => 
//     array (
//       'default' => 
//       array (
//         0 => 
//         array (
//           0 => 
//           array (
//             'name' => 'document_name',
//             'label' => 'LBL_DOC_NAME',
//           ),
//           1 => '',
//         ),
//         1 => 
//         array (
//           0 => 
//           array (
//             'name' => 'uploadfile',
//             //'type' => 'varchar',  // sobreescribimos aqui el tipo para poder rellenar el contenido de la variable en el bean de forma customizada (ANULADO DE MOMENTO, AUNQUE FUNCIONA)

//             'displayParams' => 
//             array (
//               'link' => 'uploadfile',
//               'id' => 'id',
//             ),
//           ),
//           1 => '',
//         ),
//         2 => 
//         array (
//           0 => 
//           array (
//             'name' => 'modulo',
//             'studio' => 'visible',
//             'label' => 'LBL_MODULO',
//           ),
//           1 => '',
//         ),
//         3 => 
//         array (
//           0 => 
//           array (
//             'name' => 'idioma',
//             'studio' => 'visible',
//             'label' => 'LBL_IDIOMA_PLANTILLA',
//           ),
//           1 => '',
//         ),
//         4 => 
//         array (
//           0 => 'status',
//           1 => '',
//         ),
//         5 => 
//         array (
//           0 => 'category_id',
//           1 => '',
//         ),
//         6 => 
//         array (
//           0 => 
//           array (
//             'name' => 'assigned_user_name',
//             'label' => 'LBL_ASSIGNED_TO',
//           ),
//           1 => '',
//         ),
//         7 => 
//         array (
//           0 => 
//           array (
//             'name' => 'description',
//             'label' => 'LBL_DOC_DESCRIPTION',
//           ),
//           1 => '',
//         ),
//         8 => 
//         array (
//           0 => 
//           array (
//             'name' => 'aclroles',
//           ),
//           1 => '',
//         ),        
//         9 => 
//         array (
//           0 => 
//           array (
//             'name' => 'date_entered',
//             'label' => 'LBL_DATE_ENTERED',            
//             'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
//           ),
//           1 => '',
//         ),
//         10 => 
//         array (
//           0 => 
//           array (
//             'name' => 'date_modified',
//             'label' => 'LBL_DATE_MODIFIED',
//             'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
//           ),
//           1 => '',
//         ),
//       ),
//     ),
//   ),
// );

$viewdefs[$module_name] =
array(
    'DetailView' => array(
        'templateMeta' => array(
            'maxColumns' => '2',
            'form' => array(
                'buttons' => array(
                    0 => 'EDIT',
                    1 => 'DELETE',
                ),
            ),
            'widths' => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'DEFAULT' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
                'LBL_STIC_PANEL_RECORD_DETAILS' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
        ),
        'panels' => array(
            'default' => array(
                0 => array(
                    0 => array(
                        'name' => 'document_name',
                        'label' => 'LBL_DOC_NAME',
                    ),
                    1 => '',
                ),
                1 => array(
                    0 => array(
                        'name' => 'uploadfile',
                        'displayParams' => array(
                            'link' => 'uploadfile',
                            'id' => 'id',
                        ),
                    ),
                    1 => '',
                ),
                2 => array(
                    0 => array(
                        'name' => 'modulo',
                        'studio' => 'visible',
                        'label' => 'LBL_MODULO',
                    ),
                    1 => '',
                ),
                3 => array(
                    0 => array(
                        'name' => 'idioma',
                        'studio' => 'visible',
                        'label' => 'LBL_IDIOMA_PLANTILLA',
                    ),
                    1 => '',
                ),
                4 => array(
                    0 => 'status',
                    1 => '',
                ),
                5 => array(
                    0 => array(
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO',
                    ),
                    1 => '',
                ),
                6 => array(
                    0 => array(
                        'name' => 'description',
                        'label' => 'LBL_DOC_DESCRIPTION',
                    ),
                    1 => '',
                ),
                7 => array(
                    0 => array(
                        'name' => 'aclroles',
                    ),
                    1 => '',
                ),
            ),
            'lbl_stic_panel_record_details' => array(
                0 => array(
                    0 => array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED',
                    ),
                    1 => array(
                        'name' => 'date_entered',
                        'label' => 'LBL_DATE_ENTERED',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'modified_by_name',
                        'label' => 'LBL_MODIFIED_NAME',
                    ),
                    1 => array(
                        'name' => 'date_modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                    ),
                ),
            ),
        ),
    ),
);
// END STIC-Custom 
