<?php

namespace Step\Acceptance;

class Calendar extends \AcceptanceTester
{
    /**
     * Navigate to calendar module
     */
    public function gotoCalendar()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Calendar');
    }
}
