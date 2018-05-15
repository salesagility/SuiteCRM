<?php
namespace Step\Acceptance;

class Reports extends \AcceptanceTester
{
    /**
     * Go to the reports
     */
    public function gotoReports()
    {
        $I = new NavigationBar($this->getScenario());
        $I ->clickAllMenuItem('Reports');
    }

    /**
     * Go to user profile
     */
    public function gotoProfile()
    {
        $I = new NavigationBar($this->getScenario());
        $I ->clickUserMenuItem('Profile');
    }
}