<?php

require_once('modules/Accounts/AccountsListViewSmarty.php');

class AccountsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay()
    {
        parent::preDisplay();

        $this->lv = new AccountsListViewSmarty();
    }
}
