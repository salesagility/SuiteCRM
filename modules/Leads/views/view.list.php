<?php

require_once('modules/Leads/LeadsListViewSmarty.php');

class LeadsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay()
    {
        parent::preDisplay();

        $this->lv = new LeadsListViewSmarty();
    }
}
