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
$moduleName = 'DHA_PlantillasDocumentos';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
   // Sistema nuevo
   // array(
      // 'label' =>'LNK_NEW_RECORD',
      // 'acl_action'=>'create',
      // 'acl_module'=>$moduleName,
      // 'icon' => 'icon-plus',
      // 'route'=>'#'.$moduleName.'/create',
   // ),
   // array(
      // 'route'=>'#'.$moduleName,
      // 'label' =>'LNK_LIST',
      // 'acl_action'=>'list',
      // 'acl_module'=>$moduleName,
      // 'icon' => 'icon-reorder',
   // ),

    
   array(
      'route' => '#bwc/index.php?' . http_build_query(
         array(
            'module' => $moduleName,
            'action' => 'EditView',
            'return_module' => $moduleName,
            'return_action' => 'DetailView',
         )
      ),
      'label' => 'LNK_NEW_RECORD',
      'acl_action' => 'create',
      'acl_module' => $moduleName,
      'icon' => 'icon-plus',
   ),
   array(
      'route' => '#bwc/index.php?' . http_build_query(
         array(
            'module' => $moduleName,
            'action' => 'index',
            'return_module' => $moduleName,
            'return_action' => 'index',
         )
      ),
      'label' => 'LNK_LIST',
      'acl_action' => 'list',
      'acl_module' => $moduleName,
      'icon' => 'icon-reorder',
   ),
   array(
      'route' => '#bwc/index.php?' . http_build_query(
         array(
            'module' => $moduleName,
            'action' => 'varlist',
            'return_module' => $moduleName,
            'return_action' => 'DetailView',
         )
      ),
      'label' => 'LBL_LISTA_VARIABLES',
      'acl_action' => 'create',
      'acl_module' => $moduleName,
      'icon' => 'icon-tags',
   ),
    
);
