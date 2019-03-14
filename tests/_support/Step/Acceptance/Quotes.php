<?php

namespace Step\Acceptance;

class Quotes extends \AcceptanceTester
{
    /**
     * Navigate to quotes module
     */
    public function gotoQuotes()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Quotes');
    }
}
