<?php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Contacts/ContactsListViewSmarty.php');

class ContactsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
	 */
	public function preDisplay(){
	require_once('modules/AOS_PDF_Templates/formLetter.php');
	formLetter::LVPopupHtml('Contacts');
       parent::preDisplay();
	
	$this->lv = new ContactsListViewSmarty();	
    }
}

