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
// $searchFields[$module_name] = array (
//   'current_user_only'=> array('query_type'=>'default','db_field'=>array('assigned_user_id'),'my_items'=>true, 'vname' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'),
//   'document_name' => 
//   array (
//     'query_type' => 'default',
//   ),
//   'category_id' => 
//   array (
//     'query_type' => 'default',
//     'options' => 'document_category_dom',
//     'template_var' => 'CATEGORY_OPTIONS',
//   ),
//   'subcategory_id' => 
//   array (
//     'query_type' => 'default',
//     'options' => 'document_subcategory_dom',
//     'template_var' => 'SUBCATEGORY_OPTIONS',
//   ),
//   'active_date' => 
//   array (
//     'query_type' => 'default',
//   ),
//   'exp_date' => 
//   array (
//     'query_type' => 'default',
//   ),
//   'range_date_entered' => 
//   array (
//     'query_type' => 'default',
//     'enable_range_search' => true,
//     'is_date_field' => true,
//   ),
//   'start_range_date_entered' => 
//   array (
//     'query_type' => 'default',
//     'enable_range_search' => true,
//     'is_date_field' => true,
//   ),
//   'end_range_date_entered' => 
//   array (
//     'query_type' => 'default',
//     'enable_range_search' => true,
//     'is_date_field' => true,
//   ),
//   'range_date_modified' => 
//   array (
//     'query_type' => 'default',
//     'enable_range_search' => true,
//     'is_date_field' => true,
//   ),
//   'start_range_date_modified' => 
//   array (
//     'query_type' => 'default',
//     'enable_range_search' => true,
//     'is_date_field' => true,
//   ),
//   'end_range_date_modified' => 
//   array (
//     'query_type' => 'default',
//     'enable_range_search' => true,
//     'is_date_field' => true,
//   ),
// );

$searchFields['DHA_PlantillasDocumentos'] = array (
  'current_user_only' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'assigned_user_id',
    ),
    'my_items' => true,
    'vname' => 'LBL_CURRENT_USER_FILTER',
    'type' => 'bool',
  ),
  'document_name' => 
  array (
    'query_type' => 'default',
  ),
  'category_id' => 
  array (
    'query_type' => 'default',
    'options' => 'document_category_dom',
    'template_var' => 'CATEGORY_OPTIONS',
  ),
  'subcategory_id' => 
  array (
    'query_type' => 'default',
    'options' => 'document_subcategory_dom',
    'template_var' => 'SUBCATEGORY_OPTIONS',
  ),
  'active_date' => 
  array (
    'query_type' => 'default',
  ),
  'exp_date' => 
  array (
    'query_type' => 'default',
  ),
  'range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_entered' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_modified' => 
  array (
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'favorites_only' => array(
    'query_type' => 'format',
    'operator' => 'subquery',
    'checked_only' => true,
    'subquery' => 'SELECT favorites.parent_id FROM favorites
                            WHERE favorites.deleted = 0
                                and favorites.parent_type = \'DHA_PlantillasDocumentos\'
                                and favorites.assigned_user_id = \'{1}\'',
    'db_field' => array(
        0 => 'id',
    ),
  ),
);
// END STIC-Custom 

global $sugar_flavor, $sugar_version;
if(!empty($sugar_flavor) && $sugar_flavor != 'CE'){
   $searchFields [$module_name]['favorites_only'] = array (
      'query_type'=>'format',
      'operator' => 'subquery',
      'subquery' => 'SELECT sugarfavorites.record_id 
                     FROM sugarfavorites 
                     WHERE sugarfavorites.deleted=0 
                       and sugarfavorites.module = \'DHA_PlantillasDocumentos\' 
                       and sugarfavorites.assigned_user_id = \'{0}\' ',  
      'db_field'=>array('id')
   );
   
   // Sugar Bug. I don't know since which version it has been produced. All Sugar's own modules have "= \'{0}\'", but instead "= {0}" is needed. It is corrected only for version 7.2.0
   if (version_compare($sugar_version, '7.2.0', '==')) {
      $searchFields [$module_name]['favorites_only']['subquery'] = str_replace("'{0}'", "{0}", $searchFields [$module_name]['favorites_only']['subquery']);
   }
}  

?>
