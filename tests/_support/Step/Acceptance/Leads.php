<?php

namespace Step\Acceptance;

class Leads extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoLeads()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Leads');
    }
}