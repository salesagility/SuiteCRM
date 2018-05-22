<?php

namespace Step\Acceptance;

class Maps extends \AcceptanceTester
{
    /**
     * Navigate to maps module
     */
    public function gotoMaps()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Maps');
    }
}