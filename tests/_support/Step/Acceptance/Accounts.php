<?php

namespace Step\Acceptance;

class Accounts extends \AcceptanceTester
{
    /**
     * Navigate to accounts module
     */
    public function gotoAccounts()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Accounts');
    }
}