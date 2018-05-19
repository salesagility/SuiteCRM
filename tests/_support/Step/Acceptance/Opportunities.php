<?php

namespace Step\Acceptance;

class Opportunities extends \AcceptanceTester
{
    /**
     * Navigate to opportunities module
     */
    public function gotoOpportunities()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Opportunities');
    }
}