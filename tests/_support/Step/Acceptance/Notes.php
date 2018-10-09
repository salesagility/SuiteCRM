<?php

namespace Step\Acceptance;

class Notes extends \AcceptanceTester
{
    /**
     * Navigate to notes module
     */
    public function gotoNotes()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Notes');
    }
}
