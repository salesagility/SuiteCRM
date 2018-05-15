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
     * @param \Step\Acceptance\ListView $listView
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
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        $I->see('Reports', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\ListView $listView
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
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a Report');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        // Select create report from sidebar
        $I->see('Create Report', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');

        // Create a report
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Report_Test');
        $editView->selectOption('#report_module', 'Accounts');
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
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
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the output of a report using text fields
     */
    public function testScenarioTextFieldReportOutput(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\ListView $listView,
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
        $editView->selectOption('#report_module', 'Accounts');

        // Add field
        $editView->executeJS('var node = $(\'span.jqtree_common.jqtree-title.jqtree-title-folder\').closest(\'li.jqtree_common\').data(\'node\');
$(\'#fieldTree\').tree(\'addToSelection\', node);');
        $editView->click('Accounts', '.jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', '.jqtree-title jqtree_common');

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

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the output of a report using date fields
     */
    public function testScenarioDateFieldReportOutput(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Verify the output of a report based on date fields');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        // Select create report from sidebar
        $I->see('Create Report', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');

        // Create a report
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Report_Test_Dates');
        $editView->selectOption('#report_module', 'Accounts');

        // Add field
        $editView->click('Fields', 'tab-toggler');
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->click('Date Created', 'jqtree-title jqtree_common');

        // Add condition
        $editView->click('Conditions', 'tab-toggler');
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->click('Date Created', 'jqtree-title jqtree_common');
        $editView->click('Date Created', 'jqtree-title jqtree_common');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->fillField('#aor_conditions_value[0]', 'Test_Account');

        // Set users date format
        $reports->gotoProfile();
        $reports->setDateTime();
        $editView->fillField('dateformat', 'd/m/Y');
        $editView->fillField('timeformat', 'H:i');
        $editView->fillField('timezone', 'UTC');

        $date1 = strtotime("-1 day", strtotime(date('d/m/Y')));
        $date2 = strtotime("+1 day", strtotime(date('d/m/Y')));

        $editView->fillField('#aor_conditions_fieldInput1', $date1);
        $editView->fillField('#aor_conditions_operator[1]', 'Greater Than');


        $editView->fillField('#aor_conditions_fieldInput2', $date2);
        $editView->fillField('#aor_conditions_operator[2]', 'Less Than');


        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Check Output
        $I->see('Test_Account', '.sugar_field');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the output of a report using checkbox fields
     */
    public function testScenarioCheckboxFieldReportOutput(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Verify the output of a report based on checkbox fields');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to Accounts
        $I->loginAsAdmin();
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
        $editView->selectOption('#report_module', 'Accounts');

        // Add field
        $editView->executeJS('var node = $(\'span.jqtree_common.jqtree-title.jqtree-title-folder\').closest(\'li.jqtree_common\').data(\'node\');
$(\'#fieldTree\').tree(\'addToSelection\', node);');
        $editView->click('Accounts', '.jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', '.jqtree-title jqtree_common');

        // Add condition
        $editView->click('Conditions', 'tab-toggler');
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->fillField('#aor_conditions_value[0]', 'Test_Account');
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Check Output
        $I->see('Deleted');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the pagination of reports
     */
    public function testScenarioPagination(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('verify the pagination of reports');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        // Select create report from sidebar
        $I->see('Create Report', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');

        // Create a report
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Report_Test_Pagination');
        $editView->selectOption('#report_module', 'Accounts');

        // Add field
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');

        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Check Output
        $editView->click('button', 'listViewNextButton_top');
        $I->see('21 - 40', 'pageNumbers');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the pagination of reports with parameters
     */
    public function testScenarioPaginationParameters(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('verify the pagination of reports with parameters');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        // Select create report from sidebar
        $I->see('Create Report', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');

        // Create a report
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Report_Test_Pagination_Parameters');
        $editView->selectOption('#report_module', 'Accounts');

        // Add field
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');

        $editView->click('Conditions', 'tab-toggler');
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->fillField('#aor_conditions_operator[0]', 'Not_Equal_To');
        $editView->fillField('#aor_conditions_operator[1]', 'Not_Equal_To');
        $editView->fillField('#aor_conditions_value[0]', 'False');
        $editView->fillField('#aor_conditions_value[1]', 'False');
        $editView->checkOption('#aor_conditions_parameter[0]');
        $editView->checkOption('#aor_conditions_parameter[1]');

        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Check Output
        $editView->click('button', 'listViewNextButton_top');
        $I->see('21 - 40', 'pageNumbers');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the output of a report using charts
     */
    public function testScenarioReportsChartOutput(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Verify the output of a reports chart');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to reports list-view
        $I->loginAsAdmin();
        $reports->gotoReports();
        $listView->waitForListViewVisible();

        // Select create report from sidebar
        $I->see('Create Report', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');

        // Create a report
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Report_Test_Charts');
        $editView->selectOption('#report_module', 'Accounts');

        // Add field
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');

        // Add Chart
        $editView->click('Charts', 'tab-toggler');
        $editView->click('Add chart', 'addChartButton');
        $editView->fillField('#aor_chart_title[]', 'ChartTitle');

        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Check Output
        $I->seeInSource('ChartTitle');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\Reports $reports
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to verify the output of a report using the contains operator
     */
    public function testScenarioContainsReportOutput(
        \AcceptanceTester $I,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\Reports $reports,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Verify the output of a report using the contains operator');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to Accounts
        $I->loginAsAdmin();
        $navigationBar->clickAllMenuItem('Accounts');
        $listView->waitForListViewVisible();

        // Create Account
        $I->see('Create Account', '.actionmenulink');
        $sidebar->clickSideBarAction('Create');
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', 'Test_Account_Contains');
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
        $editView->fillField('#name', 'Report_Test_Contains');
        $editView->selectOption('#report_module', 'Accounts');

        // Add field
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');

        // Add condition
        $editView->click('Conditions', 'tab-toggler');
        $editView->click('Accounts', 'jqtree_common jqtree-title jqtree-title-folder');
        $editView->click('Name', 'jqtree-title jqtree_common');
        $editView->fillField('#aor_conditions_operator[0]', 'Contains');
        $editView->fillField('#aor_conditions_value[0]', 'Test_Account_Contains');
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();

        // Check Output
        $I->see('Test_Account_Contains', '.sugar_field');
    }
}
