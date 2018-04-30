<?php

use Faker\Generator;

class AOR_ReportsCest
{
    /**
     * @var Generator $fakeData
     */
    protected $fakeData;

    /**
     * @var integer $fakeDataSeed
     */
    protected $fakeDataSeed;

    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        if (!$this->fakeData) {
            $this->fakeData = Faker\Factory::create();
            $this->fakeDataSeed = rand(0, 2048);
        }
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I)
    {

    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\Reports $reports
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the reports module.
     */
    public function testScenarioViewReportsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the reports module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        $I->see('Reports', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\DetailView $detailView ,
     * @param \Step\Acceptance\Step\Acceptance\SideBar $sidebar ,
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a report with the reports module so that I can test
     * the standard fields.
     */
    public function testScenarioCreateReport(
        \AcceptanceTester $I,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a Report');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        // Select create report from sidebar
        $I->see('Create Report', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');

        // Create a report
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Report_Test');
        $editView->fillField('#report_module', 'Accounts');
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView ,
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view the report by selecting it in the list view
     */
    public function testScenarioViewReportFromListView(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Select Report from list view');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        $listView->clickNameLink('Report_Test');
        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to edit the record by selecting it in the detail view
     */
    public function testScenarioEditReportFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Edit a Report from the detail view');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to a report
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $reports->gotoReports();
        $listView->waitForListViewVisible();
        $listView->clickNameLink('Report_Test');
        $detailView->waitForDetailViewVisible();

        // Edit Record
        $detailView->clickActionMenuItem('Edit');

        // Save record
        $editView->click('Save');

        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to duplicate the report
     */
    public function testScenarioDuplicateReportFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Duplicate Report from detail view');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to a report
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $reports->gotoReports();
        $listView->waitForListViewVisible();
        $listView->clickNameLink('Report_Test');
        $detailView->waitForDetailViewVisible();

        // duplicate Record
        $detailView->clickActionMenuItem('Duplicate');
        $editView->fillField('#name', 'Report_Test' . '1');

        // Save record
        $editView->click('Save');

        $detailView->waitForDetailViewVisible();
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to delete the report by selecting it in the detail view
     */
    public function testScenarioDeleteRecordFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Delete Report from detail view');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to a report
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $reports->gotoReports();
        $listView->waitForListViewVisible();
        $listView->clickNameLink('Report_Test');
        $detailView->waitForDetailViewVisible();

        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\NavigationBar $navigationBar,
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the output of a report using text fields
     */
    public function testScenarioTextFieldReportOutput(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Verify the output of a report based on text fields');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to Accounts
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $navigationBar->clickAllMenuItem('Accounts');
        $listView->waitForListViewVisible();

        // Create Account
        $I->see('Create Account', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Test_Account');
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Navigate to reports list-view
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        // Select create report from sidebar
        $I->see('Create Report', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');

        // Create a report
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Report_Test_Text');
        $editView->fillField('#report_module', 'Accounts');

        // Add field
        $editView->click('Fields', 'tab-toggler');
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');

        // Add condition
        $editView->click('Conditions', 'tab-toggler');
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->fillField('#aor_conditions_value[0]', 'Test_Account');
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Check Output
        $I->see('Test_Account', '.sugar_field');
    }
}
