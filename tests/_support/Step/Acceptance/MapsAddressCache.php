<?php

namespace Step\Acceptance;

class MapsAddressCache extends \AcceptanceTester
{
    /**
     * Navigate to maps address cache module
     */
    public function gotoMapsAddressCache()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Maps - Address Cache');
    }
}