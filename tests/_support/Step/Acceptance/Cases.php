<?php

namespace Step\Acceptance;

class Cases extends \AcceptanceTester
{
    /**
     * Navigate to cases module
     */
    public function gotoCases()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Cases');
    }
}