<?php

namespace Step\Acceptance;

class Invoices extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoInvoices()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Invoices');
    }
}