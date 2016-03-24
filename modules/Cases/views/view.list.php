<?php

require_once('include/MVC/View/views/view.list.php');
require_once('modules/Cases/CasesListViewSmarty.php');

class CasesViewList extends ViewList {

	function __construct(){
		parent::__construct();
	}

	function preDisplay(){
		$this->lv = new CasesListViewSmarty();
	}
}

?>