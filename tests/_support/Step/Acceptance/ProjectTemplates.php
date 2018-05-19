<?php

namespace Step\Acceptance;

class ProjectTemplates extends \AcceptanceTester
{
    /**
     * Navigate to project templates module
     */
    public function gotoProjectTemplates()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('ProjectTemplates');
    }
}