<?php

namespace Step\Acceptance;

class Documents extends \AcceptanceTester
{
    /**
     * Navigate to documents module
     */
    public function gotoDocuments()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Documents');
    }
}
