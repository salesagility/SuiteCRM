<?php 

// custom/modules/Accounts/views/view.list.php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Accounts/AccountsListViewSmarty.php');

class AccountsViewList extends ViewList {
	
	function AccountsViewList(){
		parent::ViewList();
	}
	
	function preDisplay(){
		$this->lv = new AccountsListViewSmarty();
                
                // Bug: Missing "add to target list" entry in the action menu
                $this->lv->targetList = true;
	}
}

?>