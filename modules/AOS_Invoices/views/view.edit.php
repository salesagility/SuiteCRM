<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class AOS_InvoicesViewEdit extends ViewEdit {
	function AOS_InvoicesViewEdit(){
 		parent::ViewEdit();
 	}
	
	function display(){
		$this->populateInvoiceTemplates();
		parent::display();
	}
	
	function populateInvoiceTemplates(){
		global $app_list_strings;
		
		$sql = "SELECT id, name FROM aos_pdf_templates WHERE deleted='0' AND type='AOS_Invoices'";
		$res = $this->bean->db->query($sql);
		
		$app_list_strings['template_ddown_c_list'] = array();
		while($row = $this->bean->db->fetchByAssoc($res)){
			$app_list_strings['template_ddown_c_list'][$row['id']] = $row['name'];
		}
	}
}
?>
