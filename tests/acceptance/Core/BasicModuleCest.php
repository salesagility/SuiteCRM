<?php

use Faker\Factory;
use Faker\Generator;

class BasicModuleCest
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
     * @param \Step\Acceptance\ModuleBuilder $I
     * As an administrator I want to create and deploy a basic module so that I can test
     * that the basic functionality is working. Given that I have already created a module I expect to deploy
     * the module before testing.
     */
    public function testScenarioCreateBasicModule(
       \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a basic module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $I->createModule(
            \Page\BasicModule::$PACKAGE_NAME,
            \Page\BasicModule::$NAME,
            \SuiteCRM\Enumerator\SugarObjectType::basic
        );
    }

    /**
     * @param \Step\Acceptance\ModuleBuilder $I
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view my basic test module so that I can see if it has been
     * deployed correctly.
     */
    public function testScenarioViewBasicTestModule(
        \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View Basic Test Module');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $navigationBar = new \Page\NavigationBar($I);
        $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);

        $I->seeElement('.listViewBody');
    }

    /**
     * @param \Step\Acceptance\ModuleBuilder $I
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a record with my basic test module so that I can test
     * the standard fields.
     */
    public function testScenarioCreateRecord(
        \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create Basic Test Module Record');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Basic Test Module
        $navigationBar = new \Page\NavigationBar($I);
        $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);

        // Select create Basic Test Module form the current menu
        $navigationBar->clickCurrentMenuItem('Create ' . \Page\BasicModule::$NAME);

        $this->fakeData->seed($this->fakeDataSeed);
        $I->fillField('#name', $this->fakeData->name);
        $I->fillField('#description', $this->fakeData->paragraph);

        $I->click('Save');
    }

    /**
     * @param \Step\Acceptance\ModuleBuilder $I
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view the record by selecting it in the list view
     */
    public function testScenarioViewRecordFromListView(
        \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Select Record from list view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Basic Test Module
        $navigationBar = new \Page\NavigationBar($I);
        $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);

        $this->fakeData->seed($this->fakeDataSeed);
        $I->click($this->fakeData->name, '//*[@id="MassUpdate"]/div[3]/table');
    }

    /**
     * @param \Step\Acceptance\ModuleBuilder $I
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to edit the record by selecting it in the detail view
     */
    public function testScenarioEditRecordFromDetailView(
        \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Edit Basic Test Module Record from detail view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Basic Test Module
        $navigationBar = new \Page\NavigationBar($I);
        $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);

        $this->fakeData->seed($this->fakeDataSeed);
        $I->click($this->fakeData->name, '//*[@id="MassUpdate"]/div[3]/table');

        $detailView = new \Page\DetailView($I);
        $detailView->clickActionMenuItem('Edit');

        $I->click('Save');

        $I->waitForElementVisible('.detail-view');

    }

    /**
     * @param \Step\Acceptance\ModuleBuilder $I
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to delete the record by selecting it in the detail view
     */
    public function testScenarioDeleteRecordFromDetailView(
        \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Delete Basic Test Module Record from detail view');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Go to Basic Test Module
        $navigationBar = new \Page\NavigationBar($I);
        $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);

        $this->fakeData->seed($this->fakeDataSeed);
        $I->click($this->fakeData->name, '//*[@id="MassUpdate"]/div[3]/table');

        $detailView = new \Page\DetailView($I);
        $detailView->clickActionMenuItem('Delete');

        $I->acceptPopup();

        $I->waitForElementVisible('.listViewBody');

    }
}