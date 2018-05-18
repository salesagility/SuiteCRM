<?php

namespace Step\Acceptance;

class Contacts extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoContacts()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Contacts');
    }
}