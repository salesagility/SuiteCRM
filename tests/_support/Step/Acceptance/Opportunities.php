<?php

namespace Step\Acceptance;

class Opportunities extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoOpportunities()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Opportunities');
    }
}