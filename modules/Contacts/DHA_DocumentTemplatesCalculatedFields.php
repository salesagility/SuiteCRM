<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/DHA_PlantillasDocumentos/DHA_DocumentTemplatesCalculatedFields_base.php');

class Contacts_DocumentTemplatesCalculatedFields extends DHA_DocumentTemplatesCalculatedFields {

   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function __construct($module, $bean) {
      parent::__construct($module, $bean);
   }
   
   ///////////////////////////////////////////////////////////////////////////////////////////////////
   function CalcFields() {
      global $db, $app_list_strings;
   
      parent::CalcFields();
      
      if ($this->MainModule == 'Opportunities') {         
         $id_contact = $this->bean->id;
         $id_opportunity = $this->Generate_Document_Instance->bean_datos->id; 
         
         $sql = " select contact_role from opportunities_contacts where opportunity_id = '{$id_opportunity}' and contact_id = '{$id_contact}' "; 
         $role = $db->getOne($sql);
         $this->bean->opportunity_role = $role;  // $app_list_strings['opportunity_relationship_type_dom']
      }      
   }      
   
}

?>