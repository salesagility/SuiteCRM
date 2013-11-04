<?php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/Accounts/AccountsListViewSmarty.php');

class AccountsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay(){
        require_once('modules/AOS_PDF_Templates/formLetter.php');
        formLetter::LVPopupHtml('Accounts');
        parent::preDisplay();

        $this->lv = new AccountsListViewSmarty();
    }

}
