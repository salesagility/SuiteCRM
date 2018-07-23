<?php

use Faker\Generator;

class BasicModuleCest
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

    // Tests
    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ModuleBuilder $moduleBuilder
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to create and deploy a basic module so that I can test
     * that the basic functionality is working. Given that I have already created a module I expect to deploy
     * the module before testing.
     */
    public function testScenarioCreateBasicModule(
       \AcceptanceTester $I,
       \Step\Acceptance\ModuleBuilder $moduleBuilder,
       \Step\Acceptance\Repair $repair,
       \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a basic module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $moduleBuilder->createModule(
            \Page\BasicModule::$PACKAGE_NAME,
            \Page\BasicModule::$NAME,
            \SuiteCRM\Enumerator\SugarObjectType::basic
        );

        $repair->clickQuickRepairAndRebuild();
        $this->lastView = 'ModuleBuilder';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view my basic test module so that I can see if it has been
     * deployed correctly.
     */
    public function testScenarioViewBasicTestModule(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View Basic Test Module');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Navigate to module
        $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);

        $listView->waitForListViewVisible();
        $this->lastView = 'ListView';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\EditView $editView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a record with my basic test module so that I can test
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
        $I->wantTo('Create Basic Test Module Record');

        if ($this->lastView !== 'ListView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Basic Test Module
            $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);
            $listView->waitForListViewVisible();
        }

        // Select create Basic Test Module form the current menu
        $navigationBar->clickCurrentMenuItem('Create ' . \Page\BasicModule::$NAME);

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
     * @param \Helper\WebDriverHelper $webDriverHelper
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

        if ($this->lastView !== 'ListView') {
            // Go to Basic Test Module
            $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);
            $listView->waitForListViewVisible();
        }

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
        $I->wantTo('Edit Basic Test Module Record from detail view');


        if ($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Basic Test Module
            $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->name);
            $listView->click('Search', '.submitButtons');
            $listView->waitForListViewVisible();
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
        $I->wantTo('Duplicate Basic Test Module Record from detail view');

        if ($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Basic Test Module
            $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->name);
            $listView->click('Search', '.submitButtons');
            $listView->waitForListViewVisible();
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->clickNameLink($this->fakeData->name);
        }

        // duplicate Record
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
        $I->wantTo('Delete Basic Test Module Record from detail view');

        if ($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Basic Test Module
            $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->name);
            $listView->click('Search', '.submitButtons');
            $listView->waitForListViewVisible();
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
