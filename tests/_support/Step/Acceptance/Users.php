<?php

namespace Step\Acceptance;

class Users extends \AcceptanceTester
{
    /**
     * Navigate to users profile module
     */
    public function gotoProfile()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('Profile');
    }
}
