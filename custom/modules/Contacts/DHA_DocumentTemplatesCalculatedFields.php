<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Contacts/DHA_DocumentTemplatesCalculatedFields.php');

/**
 * This file can be used in any module to include images from Sugar Fields
 * into MailMerge reports templates.
 * 
 * The name of the field needs to be modified in the private variable $imageField
 * 
 * NOTE that this class is extending from Contacts because there is some core code 
 * from DHA_PlantillasDocumentos there. If this file is implemented in another module 
 * it could be extended directly from modules/DHA_PlantillasDocumentos/DHA_DocumentTemplatesCalculatedFields_base.php
 * 
 */
class CustomContacts_DocumentTemplatesCalculatedFields extends Contacts_DocumentTemplatesCalculatedFields {

   // This variable string should be modified with the name of the image field of the module.
   private $imageField = 'photo';

   function __construct($module, $bean) {
      parent::__construct($module, $bean);
   }    
   
   protected function SetCalcFieldsDefs() {
      $this->CalcFieldsDefs['image_file_path'] = array (
            'name' => 'image_file_path',
            'vname' => $this->translate('LBL_IMAGE_FILE_PATH', 'DHA_PlantillasDocumentos'),
            'type' => 'image_path',
            'help' => $this->translate('LBL_IMAGE_FILE_PATH_HELP', 'DHA_PlantillasDocumentos'),
      );  
   }

   function CalcFields() {
      parent::CalcFields(); 
      $this->SetCalcValue('image_file_path', $this->get_image_file_path()); 
   }
   
   function get_image_file_path() {
      global $sugar_config;

      $image_path = '';
      $image_path_original = '';
      $image_ext = '';
      $mime_type = '';
      
      $mime_types = array("image/jpeg", "image/gif", "image/png", "image/tiff", "image/pjpeg", "image/x-png", "image/x-tiff");
      $imageField = $this->imageField;
      $id = $this->bean->id . '_'.$imageField;
      $image_path_original = "upload://{$id}";
      $mime_type = strtolower(mime_content_type($image_path_original));
      if (!in_array($mime_type, $mime_types)) {
         return '';
      }
      
      $image_path_original = "upload://{$id}";
      
      $templates_dir = $sugar_config['DHA_templates_dir'];
      $templates_dir = $this->Generate_Document_Instance->includeTrailingCharacter ($templates_dir, '/');
      if (!file_exists($templates_dir)) {
         return '';
      } 

      if ($mime_type == "image/jpeg" || $mime_type == "image/pjpeg")
         $image_ext = 'jpg';
      elseif ($mime_type == "image/gif")
         $image_ext = 'gif';
      elseif ($mime_type == "image/png" || $mime_type == "image/x-png")
         $image_ext = 'png';
      elseif ($mime_type == "image/tiff" || $mime_type == "image/x-tiff")
         $image_ext = 'tiff';

      $image_path = $templates_dir . $id . '.' . $image_ext; 
      
      if (copy ($image_path_original, $image_path)) {
         $this->Generate_Document_Instance->temp_files[] = $image_path;  // esto es para que se borre automaticamente la imagen temporal cuando ya se ha generado el documento
         return $image_path; 
      }
      else {
         return '';
      }
   }    
}
