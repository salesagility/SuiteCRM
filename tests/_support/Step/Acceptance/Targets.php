<?php

namespace Step\Acceptance;

class Targets extends \AcceptanceTester
{
    /**
     * Navigate to targets module
     */
    public function gotoTargets()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Targets');
    }
}
