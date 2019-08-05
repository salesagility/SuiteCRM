<?php

namespace Step\Acceptance;

class MapsAreas extends \AcceptanceTester
{
    /**
     * Navigate to maps areas module
     */
    public function gotoMapsAreas()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Maps - Areas');
    }
}
