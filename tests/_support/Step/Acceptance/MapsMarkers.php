<?php

namespace Step\Acceptance;

class MapsMarkers extends \AcceptanceTester
{
    /**
     * Navigate to maps markers module
     */
    public function gotoMapsMarkers()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Maps - Markers ');
    }
}