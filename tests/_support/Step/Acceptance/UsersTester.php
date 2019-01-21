<?php

namespace Step\Acceptance;

class UsersTester extends \AcceptanceTester
{
    /**
     * Navigate to users profile module
     */
    public function gotoProfile()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('Profile');
    }

    /**
     * Navigate to users module
     */
    public function gotoUsers()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('Admin');
        $I->see('ADMINISTRATION');
    }

    /**
     * Logout a user
     */
    public function logoutUser()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('#logout_link');
    }
}
