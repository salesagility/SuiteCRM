<?php

namespace Step\Acceptance;

class Quotes extends \AcceptanceTester
{
    /**
     * Navigate to quotes module
     */
    public function gotoQuotes()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Quotes');
    }
}
