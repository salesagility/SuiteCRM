<?php

namespace Step\Acceptance;

class UsersTester extends \AcceptanceTester
{
    /**
     * Navigate to users profile module
     */
    public function gotoProfile()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickUserMenuItem('Profile');
    }
}
