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
}