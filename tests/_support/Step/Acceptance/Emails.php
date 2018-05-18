<?php

namespace Step\Acceptance;

class Emails extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoEmails()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Emails');
    }
}