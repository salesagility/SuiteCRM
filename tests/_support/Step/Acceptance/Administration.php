<?php

namespace Step\Acceptance;

class Administration extends \AcceptanceTester
{

    /**
     * Go to the administration page
     */
    public function gotoAdministration()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickUserMenuItem('#admin_link');
    }

    public function logout()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickUserMenuItem('#logout_link');
    }
}
