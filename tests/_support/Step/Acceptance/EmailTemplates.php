<?php

namespace Step\Acceptance;

class EmailTemplates extends \AcceptanceTester
{
    /**
     * Navigate to email templates module
     */
    public function gotoEmailTemplates()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Email - Templates');
    }
}
