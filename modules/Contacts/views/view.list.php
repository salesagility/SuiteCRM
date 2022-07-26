<?php

require_once('modules/Contacts/ContactsListViewSmarty.php');

class ContactsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay()
    {
        parent::preDisplay();

        $this->lv = new ContactsListViewSmarty();
    }
}
