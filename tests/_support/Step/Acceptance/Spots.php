<?php

namespace Step\Acceptance;

class Spots extends \AcceptanceTester
{
    /**
     * Navigate to spots module
     */
    public function gotoSpots()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Spots');
    }
}
