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
        $DetailView = new DetailView();
        $Sidebar = new SideBar();

        $I->see('Create Account', '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }

    /**
     * Add a field to a report
     *
     * @param $name
     * @param $module
     */
    public function addField($name, $module)
    {
        $I = new EditView($this->getScenario());
        $I->executeJS('var node = $(\'span.jqtree_common.jqtree-title.jqtree-title-folder\').closest(\'li.jqtree_common\').data(\'node\');
$(\'#fieldTree\').tree(\'addToSelection\', node);');
        $I->click($module, '.jqtree_common jqtree-title jqtree-title-folder');
        $I->click($name, '.jqtree-title jqtree_common');
    }

    /**
     * Adds condition to report
     * @param $condition
     * @param $module
     */
    public function addCondition($condition, $module)
    {
        $I = new EditView($this->getScenario());

        $I->click('Conditions', 'tab-toggler');
        $I->click($module, 'jqtree_common jqtree-title jqtree-title-folder');
        $I->click($condition, 'jqtree-title jqtree_common');
    }
}