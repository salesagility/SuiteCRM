<?php

namespace Step\Acceptance;

class Calendar extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoCalendar()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Calendar');
    }
}