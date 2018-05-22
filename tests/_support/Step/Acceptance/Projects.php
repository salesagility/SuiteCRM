<?php

namespace Step\Acceptance;

class Projects extends \AcceptanceTester
{
    /**
     * Navigate to projects module
     */
    public function gotoProjects()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Projects');
    }
}