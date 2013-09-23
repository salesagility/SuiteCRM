<?php 

// custom/modules/Prospects/views/view.list.php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Prospects/ProspectsListViewSmarty.php');

class ProspectsViewList extends ViewList {
	
	function LeadsViewList(){
		parent::ViewList();
	}
	
	function preDisplay(){
		$this->lv = new ProspectsListViewSmarty();
                
                // Bug: Missing "add to target list" entry in the action menu
                $this->lv->targetList = true;
	}
}

?>