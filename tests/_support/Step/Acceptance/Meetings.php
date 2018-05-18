<?php

namespace Step\Acceptance;

class Meetings extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoMeetings()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Meetings');
    }
}