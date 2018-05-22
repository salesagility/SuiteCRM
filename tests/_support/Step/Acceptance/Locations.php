<?php

namespace Step\Acceptance;

class Locations extends \AcceptanceTester
{
    /**
     * Navigate to locations module
     */
    public function gotoLocations()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Locations');
    }
}