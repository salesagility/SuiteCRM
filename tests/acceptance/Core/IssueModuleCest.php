<?php

use Faker\Generator;

class IssueModuleCest
{

    /**
     * @var string $lastView helps the test skip some repeated tests in order to make the test framework run faster at the
     * potential cost of being accurate and reliable
     */
    protected $lastView;

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
     * @param \Step\Acceptance\ModuleBuilder $moduleBuilder
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to create and deploy a issue module so that I can test
     * that the issue functionality is working. Given that I have already created a module I expect to deploy
     * the module before testing.
     */
    public function testScenarioCreateIssueModule(
       \AcceptanceTester $I,
       \Step\Acceptance\ModuleBuilder $moduleBuilder,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a issue module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $moduleBuilder->createModule(
            \Page\IssueModule::$PACKAGE_NAME,
            \Page\IssueModule::$NAME,
            \SuiteCRM\Enumerator\SugarObjectType::issue
        );

        $this->lastView = 'ModuleBuilder';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view my issue test module so that I can see if it has been
     * deployed correctly.
     */
    public function testScenarioViewIssueTestModule(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View Issue Test Module');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Navigate to module
        $navigationBar->clickAllMenuItem(\Page\IssueModule::$NAME);

        $listView->waitForListViewVisible();
        $this->lastView = 'ListView';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a record with my issue test module so that I can test
     * the standard fields.
     */
    public function testScenarioCreateRecord(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create Issue Test Module Record');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Issue Test Module
        $navigationBar->clickAllMenuItem(\Page\IssueModule::$NAME);
        $listView->waitForListViewVisible();

        // Select create Issue Test Module form the current menu
        $navigationBar->clickCurrentMenuItem('Create ' . \Page\IssueModule::$NAME);

        // Create a record
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', $this->fakeData->name);
        $editView->fillField('#description', $this->fakeData->paragraph);
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
        $this->lastView = 'DetailView';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view the record by selecting it in the list view
     */
    public function testScenarioViewRecordFromListView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Select Record from list view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Issue Test Module
        $navigationBar->clickAllMenuItem(\Page\IssueModule::$NAME);
        $listView->waitForListViewVisible();

        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->fillField('#name_basic', $this->fakeData->name);
        $listView->click('Search', '.submitButtons');
        $listView->wait(1);
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($this->fakeData->name);
        $detailView->waitForDetailViewVisible();
        $this->lastView = 'DetailView';

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
    public function testScenarioEditRecordFromDetailView(
        \AcceptanceTester$I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Edit Issue Test Module Record from detail view');
        if($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Issue Test Module
            $navigationBar->clickAllMenuItem(\Page\IssueModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->name);
            $listView->click('Search', '.submitButtons');
            $listView->wait(1);
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->clickNameLink($this->fakeData->name);
        }
        // Edit Record
        $detailView->clickActionMenuItem('Edit');

        // Save record
        $editView->click('Save');

        $detailView->waitForDetailViewVisible();
        $this->lastView = 'DetailView';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to duplicate the record
     */
    public function testScenarioDuplicateRecordFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Duplicate Issue Test Module Record from detail view');
        if($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Issue Test Module
            $navigationBar->clickAllMenuItem(\Page\IssueModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->name);
            $listView->click('Search', '.submitButtons');
            $listView->wait(1);
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->clickNameLink($this->fakeData->name);
        }

        // Edit Record
        $detailView->clickActionMenuItem('Duplicate');

        $this->fakeData->seed($this->fakeDataSeed);
        $editView->fillField('#name', $this->fakeData->name . '1');

        // Save record
        $editView->click('Save');

        $detailView->waitForDetailViewVisible();
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
        $this->lastView = 'ListView';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to delete the record by selecting it in the detail view
     */
    public function testScenarioDeleteRecordFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Delete Issue Test Module Record from detail view');
        if($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Issue Test Module
            $navigationBar->clickAllMenuItem(\Page\IssueModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->name);
            $listView->click('Search', '.submitButtons');
            $listView->wait(1);
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->clickNameLink($this->fakeData->name);
        }
        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
        $this->lastView = 'ListView';
    }
}