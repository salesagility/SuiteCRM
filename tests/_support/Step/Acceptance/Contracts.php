<?php

namespace Step\Acceptance;

class Contracts extends \AcceptanceTester
{
    /**
     * Navigate to contracts module
     */
    public function gotoContracts()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Contracts');
    }
}