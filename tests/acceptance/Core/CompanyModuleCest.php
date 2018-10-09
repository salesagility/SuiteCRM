<?php

use Faker\Generator;

class CompanyModuleCest
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
            $this->fakeData->addProvider(new Faker\Provider\en_US\Address($this->fakeData));
            $this->fakeData->addProvider(new Faker\Provider\en_US\PhoneNumber($this->fakeData));
            $this->fakeData->addProvider(new Faker\Provider\en_US\Company($this->fakeData));
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
     * As an administrator I want to create and deploy a company module so that I can test
     * that the company functionality is working. Given that I have already created a module I expect to deploy
     * the module before testing.
     */
    public function testScenarioCreateCompanyModule(
       \AcceptanceTester $I,
       \Step\Acceptance\ModuleBuilder $moduleBuilder,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a company module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $moduleBuilder->createModule(
            \Page\CompanyModule::$PACKAGE_NAME,
            \Page\CompanyModule::$NAME,
            \SuiteCRM\Enumerator\SugarObjectType::company
        );

        $this->lastView = 'ModuleBuilder';
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBar $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view my company test module so that I can see if it has been
     * deployed correctly.
     */
    public function testScenarioViewCompanyTestModule(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View Company Test Module');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Navigate to module
        $navigationBar->clickAllMenuItem(\Page\CompanyModule::$NAME);

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
     * As administrative user I want to create a record with my company test module so that I can test
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
        $I->wantTo('Create Company Test Module Record');

        if ($this->lastView !== 'ListView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Company Test Module
            $navigationBar->clickAllMenuItem(\Page\CompanyModule::$NAME);
            $listView->waitForListViewVisible();
        }
        // Select create Company Test Module form the current menu
        $navigationBar->clickCurrentMenuItem('Create ' . \Page\CompanyModule::$NAME);

        // Create a record
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->waitForEditViewVisible();
        $editView->fillField('#name', $this->fakeData->company);
        $editView->fillField('#phone_office', $this->fakeData->phoneNumber);
        $editView->fillField('#phone_fax', $this->fakeData->phoneNumber);
        $editView->fillField('#phone_alternate', $this->fakeData->phoneNumber);
        $editView->fillField('#ticker_symbol', $this->fakeData->randomAscii);
        $editView->fillField('#rating', $this->fakeData->randomAscii);
        $editView->fillField('#ownership', $this->fakeData->randomAscii);
        $editView->selectOption('#industry', 'Other');
        $editView->selectOption('test_'.strtolower(\Page\CompanyModule::$NAME).'_type', 'Other');
        $editView->fillField('#billing_address_street', $this->fakeData->streetAddress);
        $editView->fillField('#billing_address_city', $this->fakeData->city);
        $editView->fillField('#billing_address_state', $this->fakeData->randomAscii);
        $editView->fillField('#billing_address_postalcode', $this->fakeData->postcode);
        $editView->fillField('#billing_address_country', $this->fakeData->country);
        $editView->checkOption('#shipping_checkbox');
        $editView->fillField('#Test_'.\Page\CompanyModule::$NAME.'0emailAddress0', $this->fakeData->companyEmail);
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

        if ($this->lastView !== 'ListView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Company Test Module
            $navigationBar->clickAllMenuItem(\Page\CompanyModule::$NAME);
            $listView->waitForListViewVisible();


            $this->fakeData->seed($this->fakeDataSeed);
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->company);
            $listView->click('Search', '.submitButtons');
            $listView->wait(1);
            $listView->dontSee('No results found');
        }
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($this->fakeData->company);

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
        $I->wantTo('Edit Company Test Module Record from detail view');

        if ($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Company Test Module
            $navigationBar->clickAllMenuItem(\Page\CompanyModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->company);
            $listView->click('Search', '.submitButtons');
            $listView->wait(1);
            $listView->dontSee('No results found');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->clickNameLink($this->fakeData->company);
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
        $I->wantTo('Duplicate Company Test Module Record from detail view');

        if ($this->lastView !== 'DetailView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();


            // Go to Company Test Module
            $navigationBar->clickAllMenuItem(\Page\CompanyModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->company);
            $listView->click('Search', '.submitButtons');
            $listView->wait(1);
            $listView->dontSee('No results found');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->clickNameLink($this->fakeData->company);
        }

        // Edit Record
        $detailView->clickActionMenuItem('Duplicate');

        $this->fakeData->seed($this->fakeDataSeed);
        $editView->fillField('#name', $this->fakeData->company . '1');

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
        $I->wantTo('Delete Company Test Module Record from detail view');

        if ($this->lastView !== 'ListView') {
            $I->amOnUrl(
                $webDriverHelper->getInstanceURL()
            );

            $I->loginAsAdmin();

            // Go to Company Test Module
            $navigationBar->clickAllMenuItem(\Page\CompanyModule::$NAME);
            $listView->waitForListViewVisible();

            // Select record from list view
            $listView->clickFilterButton();
            $listView->click('Quick Filter');
            $this->fakeData->seed($this->fakeDataSeed);
            $listView->fillField('#name_basic', $this->fakeData->company);
            $listView->click('Search', '.submitButtons');
            $listView->wait(1);
            $listView->dontSee('No results found');
        }
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($this->fakeData->company);

        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
        $this->lastView = 'ListView';
    }
}
