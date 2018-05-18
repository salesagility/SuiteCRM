<?php

namespace Step\Acceptance;

class Notes extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoNotes()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Notes');
    }
}