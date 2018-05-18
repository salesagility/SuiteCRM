<?php

namespace Step\Acceptance;

class Quotes extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoQuotes()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Quotes');
    }
}