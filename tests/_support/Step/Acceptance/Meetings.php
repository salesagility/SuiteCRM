<?php

namespace Step\Acceptance;

class Meetings extends \AcceptanceTester
{
    /**
     * Navigate to meetings module
     */
    public function gotoMeetings()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Meetings');
    }
}