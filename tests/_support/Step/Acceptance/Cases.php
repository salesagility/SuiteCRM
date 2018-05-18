<?php

namespace Step\Acceptance;

class Cases extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoCases()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Cases');
    }
}