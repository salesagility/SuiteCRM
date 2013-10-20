<?php 

// custom/modules/Contacts/views/view.list.php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Contacts/ContactsListViewSmarty.php');

class ContactsViewList extends ViewList {
	
	function ContactsViewList(){
		parent::ViewList();
	}
	
	function preDisplay(){
		$this->lv = new ContactsListViewSmarty();
                
                // Bug: Missing "add to target list" entry in the action menu
                $this->lv->targetList = true;
	}
}

?>