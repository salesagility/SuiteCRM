<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class FP_eventsViewEdit extends ViewEdit {
	function __construct(){
 		parent::__construct();
 	}

	function display(){
		$this->bean->email_templates();
		parent::display();
	}

}
?>
