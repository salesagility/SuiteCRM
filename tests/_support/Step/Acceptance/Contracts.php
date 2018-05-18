<?php

namespace Step\Acceptance;

class Contracts extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoContracts()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Contracts');
    }
}