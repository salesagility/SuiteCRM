<?php

namespace Step\Acceptance;

class Spots extends \AcceptanceTester
{
    /**
     * Navigate to spots module
     */
    public function gotoSpots()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Spots');
    }
}
