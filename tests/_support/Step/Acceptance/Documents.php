<?php

namespace Step\Acceptance;

class Documents extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoDocuments()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Documents');
    }
}