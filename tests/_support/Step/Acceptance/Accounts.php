<?php

namespace Step\Acceptance;

class Accounts extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoAccounts()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Accounts');
    }
}