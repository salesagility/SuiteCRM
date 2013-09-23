<?php 

// custom/modules/Meetings/views/view.list.php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Meetings/MeetingsListViewSmarty.php');

class MeetingsViewList extends ViewList {
	
	function MeetingsViewList(){
		parent::ViewList();
	}
	
	function preDisplay(){
		$this->lv = new MeetingsListViewSmarty();
	}
}

?>
