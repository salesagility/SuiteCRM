<?php

namespace Step\Acceptance;

class Calls extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoCalls()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Calls');
    }
}