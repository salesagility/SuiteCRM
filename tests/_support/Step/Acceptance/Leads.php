<?php

namespace Step\Acceptance;

class Leads extends \AcceptanceTester
{
    /**
     * Navigate to leads module
     */
    public function gotoLeads()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Leads');
    }
}