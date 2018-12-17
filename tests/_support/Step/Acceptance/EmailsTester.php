<?php

namespace Step\Acceptance;

class EmailsTester extends \AcceptanceTester
{
    /**
     * Navigate to emails module
     */
    public function gotoEmails()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Emails');
    }
}
