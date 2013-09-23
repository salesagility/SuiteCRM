<?php 

// custom/modules/Project/views/view.list.php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Project/ProjectListViewSmarty.php');

class ProjectViewList extends ViewList {
	
	function ProjectViewList(){
		parent::ViewList();
	}
	
	function preDisplay(){
		$this->lv = new ProjectListViewSmarty();
	}
}

?>