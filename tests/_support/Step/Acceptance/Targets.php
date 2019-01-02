<?php

namespace Step\Acceptance;

class Targets extends \AcceptanceTester
{
    /**
     * Navigate to targets module
     */
    public function gotoTargets()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Targets');
    }
}
