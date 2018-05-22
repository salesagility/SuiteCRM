<?php

namespace Step\Acceptance;

class Invoices extends \AcceptanceTester
{
    /**
     * Navigate to invoices module
     */
    public function gotoInvoices()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Invoices');
    }
}