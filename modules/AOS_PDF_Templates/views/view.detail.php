<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.detail.php');

class AOS_PDF_TemplatesViewDetail extends ViewDetail {
	function AOS_PDF_TemplatesViewDetail(){
 		parent::ViewDetail();
 	}
	
	function display(){
		$this->setDecodeHTML();
		parent::display();
	}
	
	function setDecodeHTML(){
		$this->bean->pdfheader = html_entity_decode(str_replace('&nbsp;',' ',$this->bean->pdfheader));
		$this->bean->description = html_entity_decode(str_replace('&nbsp;',' ',$this->bean->description));
		$this->bean->pdffooter = html_entity_decode(str_replace('&nbsp;',' ',$this->bean->pdffooter));
	}
}
?>
