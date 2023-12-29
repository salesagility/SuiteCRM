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

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$module_name = 'DHA_PlantillasDocumentos';
$subpanel_layout = array(
   'top_buttons' => array(
      array('widget_class' => 'SubPanelTopCreateButton'),
      array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => $module_name,),
   ),

   'where' => '',

   'list_fields'=> array(
      'object_image'=>array(
         'widget_class' => 'SubPanelIcon',
         'width' => '2%',
         'image2'=>'attachment',
         'image2_url_field'=>array('id_field'=>'selected_revision_id','filename_field'=>'selected_revision_filename'),
         'attachment_image_only'=>true,

      ),
      'document_name'=> array(
         'name' => 'document_name',
         'vname' => 'LBL_LIST_DOCUMENT_NAME',
         'widget_class' => 'SubPanelDetailViewLink',
         'width' => '45%',
      ),
      'edit_button'=>array(
         'widget_class' => 'SubPanelEditButton',
         'module' => $module_name,
         'width' => '5%',
      ),
      'remove_button'=>array(
         'widget_class' => 'SubPanelRemoveButton',
         'module' => $module_name,
         'width' => '5%',
      ),
   ),
);
?>
