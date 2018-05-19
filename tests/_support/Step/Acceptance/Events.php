<?php

namespace Step\Acceptance;

class Events extends \AcceptanceTester
{
    /**
     * Navigate to events module
     */
    public function gotoEvents()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Events');
    }
}