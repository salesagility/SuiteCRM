<?php

namespace Step\Acceptance;

class EmailsTester extends \AcceptanceTester
{
    /**
     * Navigate to emails module
     */
    public function gotoEmails()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Emails');
    }
}
