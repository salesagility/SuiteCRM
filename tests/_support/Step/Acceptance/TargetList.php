<?php

namespace Step\Acceptance;

class TargetList extends \AcceptanceTester
{
    /**
     * Navigate to target list module
     */
    public function gotoTargetList()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Targets - Lists');
    }
}
