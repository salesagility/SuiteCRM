<?php

use Faker\Generator;
use JeroenDesloovere\VCard\VCard;

class SaleModuleCest
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

    // Tests
    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ModuleBuilder $moduleBuilder
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to create and deploy a sale module so that I can test
     * that the sale functionality is working. Given that I have already created a module I expect to deploy
     * the module before testing.
     */
    public function testScenarioCreateSaleModule(
       \AcceptanceTester $I,
       \Step\Acceptance\ModuleBuilder $moduleBuilder,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a sale module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $moduleBuilder->createModule(
            \Page\SaleModule::$PACKAGE_NAME,
            \Page\SaleModule::$NAME,
            \SuiteCRM\Enumerator\SugarObjectType::sale
        );
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view my sale test module so that I can see if it has been
     * deployed correctly.
     */
    public function testScenarioViewSaleTestModule(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View Sale Test Module');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Navigate to module
        $navigationBar->clickAllMenuItem(\Page\SaleModule::$NAME);

        $listView->waitForListViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a record with my sale test module so that I can test
     * the standard fields.
     */
    public function testScenarioCreateRecord(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create Sale Test Module Record');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Sale Test Module
        $navigationBar->clickAllMenuItem(\Page\SaleModule::$NAME);
        $listView->waitForListViewVisible();

        // Select create Sale Test Module form the current menu
        $navigationBar->clickCurrentMenuItem('Create ' . \Page\SaleModule::$NAME);

        // Create a record
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', implode(' ', $this->fakeData->words()));
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->selectOption(strtolower('#test_'.\Page\SaleModule::$NAME.'_type'), 'New Business');
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->fillField('#amount', $this->fakeData->randomFloat(2));
        $editView->click('#date_closed_trigger');
        $editView->waitForElementVisible('#container_date_closed_trigger_c');
        $editView->click('.today .selector', '#container_date_closed_trigger_c');
        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view the record by selecting it in the list view
     */
    public function testScenarioViewRecordFromListView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Select Record from list view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Sale Test Module
        $navigationBar->clickAllMenuItem(\Page\SaleModule::$NAME);
        $listView->waitForListViewVisible();

        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $name = implode(' ', $this->fakeData->words());
        $listView->fillField('#name_basic', $name);
        $listView->click('Search', '.submitButtons');
        $listView->wait(1);
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($name);
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
        $I->wantTo('Edit Sale Test Module Record from detail view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Sale Test Module
        $navigationBar->clickAllMenuItem(\Page\SaleModule::$NAME);
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $name = implode(' ', $this->fakeData->words());
        $listView->fillField('#name_basic', $name);
        $listView->click('Search', '.submitButtons');
        $listView->waitForListViewVisible();
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($name);

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
        $I->wantTo('Duplicate Sale Test Module Record from detail view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Sale Test Module
        $navigationBar->clickAllMenuItem(\Page\SaleModule::$NAME);
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $name = implode(' ', $this->fakeData->words());
        $listView->fillField('#name_basic', $name);
        $listView->click('Search', '.submitButtons');
        $listView->waitForListViewVisible();
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($name);

        // Edit Record
        $detailView->clickActionMenuItem('Duplicate');

        $editView->fillField('#name', $name);

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
     * As administrative user I want to delete the record by selecting it in the detail view
     */
    public function testScenarioDeleteRecordFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Delete Sale Test Module Record from detail view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Sale Test Module
        $navigationBar->clickAllMenuItem(\Page\SaleModule::$NAME);
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $name = implode(' ', $this->fakeData->words());
        $listView->fillField('#name_basic', $name);
        $listView->click('Search', '.submitButtons');
        $listView->waitForListViewVisible();
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($name);

        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
    }
}
