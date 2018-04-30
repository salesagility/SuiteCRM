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
        if(!$this->fakeData) {
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

    // Tests
    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the reports module.
     */
    public function testScenarioViewReportsModule(
       \AcceptanceTester $I,
       \Step\Acceptance\NavigationBar $navigationBar,
       \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the reports module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $navigationBar->clickAllMenuItem('Reports');

        $I->see('Reports', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\DetailView $detailView,
     * @param \Step\Acceptance\Step\Acceptance\SideBar $sidebar,
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a report with the reports module so that I can test
     * the standard fields.
     */
    public function testScenarioCreateReport(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\SideBar $sidebar,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a Report');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $navigationBar->clickAllMenuItem('Reports');

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
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView,
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view the report by selecting it in the list view
     */
    public function testScenarioViewReportFromListView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Select Report from list view');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $navigationBar->clickAllMenuItem('Reports');

        $listView->clickNameLink('Report_Test');
        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to edit the record by selecting it in the detail view
     */
    public function testScenarioEditReportFromDetailView(
        \AcceptanceTester$I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Edit a Report from the detail view');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $navigationBar->clickAllMenuItem('Reports');
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
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to duplicate the report
     */
    public function testScenarioDuplicateReportFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Duplicate Report from detail view');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $navigationBar->clickAllMenuItem('Reports');
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
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to delete the report by selecting it in the detail view
     */
    public function testScenarioDeleteRecordFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Delete Report from detail view');

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $listView->waitForListViewVisible();
        $navigationBar->clickAllMenuItem('Reports');
        $listView->clickNameLink('Report_Test');
        $detailView->waitForDetailViewVisible();

        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
    }
}
