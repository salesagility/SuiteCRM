<?php

use Faker\Generator;

class FileModuleCest
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
     *
     * As an administrator I want to create and deploy a file module so that I can test
     * that the file functionality is working. Given that I have already created a module I expect to deploy
     * the module before testing.
     */
    public function testScenarioCreateFileModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ModuleBuilder $moduleBuilder
    ) {
        $I->wantTo('Create a file module for testing');

        $I->loginAsAdmin();

        $moduleBuilder->createModule(
            \Page\FileModule::$PACKAGE_NAME,
            \Page\FileModule::$NAME,
            \SuiteCRM\Enumerator\SugarObjectType::file
        );
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBarTester $navigationBar
     * @param \Step\Acceptance\ListView $listView
     *
     * As administrative user I want to view my file test module so that I can see if it has been
     * deployed correctly.
     */
    public function testScenarioViewFileTestModule(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBarTester $navigationBar,
        \Step\Acceptance\ListView $listView
    ) {
        $I->wantTo('View File Test Module');
        $I->loginAsAdmin();

        // Navigate to module
        $navigationBar->clickAllMenuItem(\Page\FileModule::$NAME);

        $listView->waitForListViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBarTester $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailview
     * @param \Step\Acceptance\EditView $editView
     *
     * As administrative user I want to create a record with my file test module so that I can test
     * the standard fields.
     */
    public function testScenarioCreateRecord(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBarTester $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailview,
        \Step\Acceptance\EditView $editView
    ) {
        $I->wantTo('Create File Test Module Record');
        $I->loginAsAdmin();

        // Go to File Test Module
        $navigationBar->clickAllMenuItem(\Page\FileModule::$NAME);
        $listView->waitForListViewVisible();

        // Select create File Test Module form the current menu
        $navigationBar->clickCurrentMenuItem('Create ' . \Page\FileModule::$NAME);

        // Create a record
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->waitForEditViewVisible();
        $fileDir = 'tests/_data/';
        $fileName = $this->fakeData->lastName.'.test.txt';
        $I->writeToFile($fileDir.$fileName, 'test file');
        $editView->attachFile('#uploadfile_file', $fileName);
        $I->wait(1);
        $editView->seeInField('#document_name', $fileName);
        $editView->fillField('#description', $this->fakeData->paragraph);
        // TODO: other fields
        $editView->clickSaveButton();
        $detailview->waitForDetailViewVisible();
        $detailview->see($fileName, '#uploadfile');
        
        $I->deleteFile($fileDir.$fileName);
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBarTester $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     *
     * As administrative user I want to view the record by selecting it in the list view
     */
    public function testScenarioViewRecordFromListView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBarTester $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView
    ) {
        $I->wantTo('Select Record from list view');
        
        $I->loginAsAdmin();

        // Go to File Test Module
        $navigationBar->clickAllMenuItem(\Page\FileModule::$NAME);
        $listView->waitForListViewVisible();

        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->fillField('#document_name_basic', $this->fakeData->lastName . '.test.txt');
        $listView->click('Search', '.submitButtons');
        $listView->wait(1);

        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($this->fakeData->lastName . '.test.txt');
        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBarTester $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     *
     * As administrative user I want to edit the record by selecting it in the detail view
     */
    public function testScenarioEditRecordFromDetailView(
        \AcceptanceTester$I,
        \Step\Acceptance\NavigationBarTester $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView
    ) {
        $I->wantTo('Edit File Test Module Record from detail view');
        $I->loginAsAdmin();

        // Go to File Test Module
        $navigationBar->clickAllMenuItem(\Page\FileModule::$NAME);
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->fillField('#document_name_basic', $this->fakeData->lastName . '.test.txt');
        $listView->click('Search', '.submitButtons');
        $listView->wait(1);
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($this->fakeData->lastName . '.test.txt');
        // Edit Record
        $detailView->clickActionMenuItem('Edit');

        // Save record
        $editView->click('Save');

        $detailView->waitForDetailViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBarTester $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\EditView $editView
     *
     * As administrative user I want to duplicate the record
     */
    public function testScenarioDuplicateRecordFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBarTester $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView
    ) {
        $I->wantTo('Duplicate File Test Module Record from detail view');
        $I->loginAsAdmin();

        // Go to File Test Module
        $navigationBar->clickAllMenuItem(\Page\FileModule::$NAME);
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->fillField('#document_name_basic', $this->fakeData->lastName . '.test.txt');
        $listView->click('Search', '.submitButtons');
        $listView->wait(1);
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($this->fakeData->lastName . '.test.txt');

        // Edit Record
        $detailView->clickActionMenuItem('Duplicate');

        $this->fakeData->seed($this->fakeDataSeed);
        $editView->fillField('#document_name', $this->fakeData->lastName.'.test.txt' . '1');

        // Save record
        $editView->click('Save');

        $detailView->waitForDetailViewVisible();
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\NavigationBarTester $navigationBar
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\DetailView $detailView
     *
     * As administrative user I want to delete the record by selecting it in the detail view
     */
    public function testScenarioDeleteRecordFromDetailView(
        \AcceptanceTester $I,
        \Step\Acceptance\NavigationBarTester $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView
    ) {
        $I->wantTo('Delete File Test Module Record from detail view');
        $I->loginAsAdmin();

        // Go to File Test Module
        $navigationBar->clickAllMenuItem(\Page\FileModule::$NAME);
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->fillField('#document_name_basic', $this->fakeData->lastName);
        $listView->click('Search', '.submitButtons');
        $listView->wait(1);
        $this->fakeData->seed($this->fakeDataSeed);
        $listView->clickNameLink($this->fakeData->lastName . '.test.txt');
        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
    }
}
