<?php

namespace Step\Acceptance;

class Spots extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoSpots()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Spots');
    }
}