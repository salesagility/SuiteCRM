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
        $I->clickAllMenuItem('Reports');
    }

    /**
     * Go to user profile
     */
    public function gotoProfile()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('Profile');
    }

    /**
     * Create a report
     *
     * @param $name
     * @param $module
     */
    public function createReport($name, $module)
    {
        $I = new EditView($this->getScenario());
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->selectOption('#report_module', $module);
    }

    /**
     * Create an account
     *
     * @param $name
     */
    public function createAccount($name)
    {
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());

        $I->see('Create Account', '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->fillField('#phone_office', '(810) 267-0146');
        $I->fillField('#website', 'www.afakeurl.com');
        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }
}