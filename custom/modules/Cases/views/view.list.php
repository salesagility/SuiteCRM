<?php 

// custom/modules/Cases/views/view.list.php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Cases/CasesListViewSmarty.php');

class CasesViewList extends ViewList {
	
	function CasesViewList(){
		parent::ViewList();
	}
	
	function preDisplay(){
		$this->lv = new CasesListViewSmarty();
	}
}

?>