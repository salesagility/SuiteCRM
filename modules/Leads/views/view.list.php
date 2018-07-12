<?php

require_once('include/MVC/View/views/view.list.php');
require_once('modules/Leads/LeadsListViewSmarty.php');

class LeadsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay()
    {
        require_once('modules/AOS_PDF_Templates/formLetter.php');
        formLetter::LVPopupHtml('Leads');
        parent::preDisplay();

        $this->lv = new LeadsListViewSmarty();
    }
}
