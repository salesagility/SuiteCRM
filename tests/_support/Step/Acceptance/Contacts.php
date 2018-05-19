<?php

namespace Step\Acceptance;

class Contacts extends \AcceptanceTester
{
    /**
     * Navigate to contacts module
     */
    public function gotoContacts()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Contacts');
    }
}