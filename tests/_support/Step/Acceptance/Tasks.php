<?php

namespace Step\Acceptance;

class Tasks extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoTasks()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Tasks');
    }
}