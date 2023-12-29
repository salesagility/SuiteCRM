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
$fields = array(
   array (
      'name' => 'uploadfile',
      'displayParams' => array (
         'onchangeSetFileNameTo' => 'document_name',
      ),
   ),
   //'document_name',
   array(  // vac�o
      'name' => '',
      'view' => 'detail',
      'readonly' => true,
   ),   
   'modulo',
   'idioma'
);

$fieldsHidden = array(
   'status_id',
   'category_id',
   'description',
   'assigned_user_name',
   array (
      'name' => 'aclroles',
      'customLabel' => '<span>{sugar_translate label=\'LBL_ROLES_WITH_ACCESS\' module=$fields.parent_type.value}<br>(<i>{sugar_translate label=\'LBL_ROLES_WITH_ACCESS_HELP\' module=$fields.parent_type.value}</i>) </span>',
      // 'displayParams' => array (
        // 'size' => ($count_roles > 20)? 20 : ($count_roles < 5)? 5 : $count_roles,
      // ),
   ),   
   array(  // vac�o
      'name' => '',
      'view' => 'detail',
      'readonly' => true,
   ),   
          
   array(
      'name' => 'date_entered_by',
      'readonly' => true,
      'type' => 'fieldset',
      'label' => 'LBL_DATE_ENTERED',
      'fields' => array(
         array(
            'name' => 'date_entered',
         ),
         array(
            'type' => 'label',
            'default_value' => 'LBL_BY'
         ),
         array(
            'name' => 'created_by_name',
         ),
      ),
   ),
   array(
      'name' => 'date_modified_by',
      'readonly' => true,
      'type' => 'fieldset',
      'label' => 'LBL_DATE_MODIFIED',
      'fields' => array(
         array(
            'name' => 'date_modified',
         ),
         array(
            'type' => 'label',
            'default_value' => 'LBL_BY',
         ),
         array(
            'name' => 'modified_by_name',
         ),
      ),
   ),
);


$moduleName = 'DHA_PlantillasDocumentos';
$viewdefs[$moduleName]['base']['view']['record'] = array(
   'panels' => array(
      array(
         'name' => 'panel_header',
         'header' => true,
         'fields' => array(
            array(
               'name'          => 'picture',
               'type'          => 'avatar',
               'size'          => 'large',
               'dismiss_label' => true,
               'readonly'      => true,
            ),
            array(
               'name' => 'document_name',
            ),
            array(
               'name' => 'favorite',
               'label' => 'LBL_FAVORITE',
               'type' => 'favorite',
               'dismiss_label' => true,
            ),
            array(
               'name' => 'follow',
               'label'=> 'LBL_FOLLOW',
               'type' => 'follow',
               'readonly' => true,
               'dismiss_label' => true,
            ),
         ),
      ),
      array(
         'name' => 'panel_body',
         'label' => 'LBL_RECORD_BODY',
         'columns' => 2,
         'labels' => true,
         'labelsOnTop' => true,
         'placeholders' => false,
         'fields' => $fields,
      ),
      array(
         'name' => 'panel_hidden',
         'label' => 'LBL_RECORD_SHOWMORE',
         'hide' => true,
         'labelsOnTop' => true,
         'placeholders' => false,
         'columns' => 2,
         'fields' => $fieldsHidden,
      ),
   ),
);
