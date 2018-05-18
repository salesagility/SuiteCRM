<?php

namespace Step\Acceptance;

class Campaigns extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoCampaigns()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Campaigns');
    }
}