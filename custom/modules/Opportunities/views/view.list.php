<?php 

// custom/modules/Opportunities/views/view.list.php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Opportunities/OpportunitiesListViewSmarty.php');

class OpportunitiesViewList extends ViewList {
	
	function OpportunitiesViewList(){
		parent::ViewList();
	}
	
	function preDisplay(){
		$this->lv = new OpportunitiesListViewSmarty();
	}
}

?>