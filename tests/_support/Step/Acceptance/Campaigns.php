<?php

namespace Step\Acceptance;

class Campaigns extends \AcceptanceTester
{
    /**
     * Navigate to campaigns module
     */
    public function gotoCampaigns()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Campaigns');
    }
}