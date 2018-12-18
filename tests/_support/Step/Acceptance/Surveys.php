<?php

namespace Step\Acceptance;

class Surveys extends \AcceptanceTester
{
    /**
     * Navigate to surveys module
     */
    public function gotoSurveys()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Surveys');
    }
}