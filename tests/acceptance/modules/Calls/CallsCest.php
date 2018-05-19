<?php

class CallsCest
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
        }

        $this->fakeDataSeed = rand(0, 2048);
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Calls $calls
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the calls module.
     */
    public function testScenarioViewCallsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Calls $calls,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the calls module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to calls list-view
        $I->loginAsAdmin();
        $calls->gotoCalls();
        $listView->waitForListViewVisible();

        $I->see('Calls', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\NavigationBar $NavigationBar
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\Calls $calls
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to verify the date field of a call
     */
    public function testScenarioCallDate(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\NavigationBar $NavigationBar,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Calls $calls,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a call');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to Calls
        $I->loginAsAdmin();
        $NavigationBar->clickAllMenuItem('Calls');

        // Select create report from sidebar
        $I->see('Log Call', '.actionmenulink');
        $sidebar->clickSideBarAction('Log');

        // Create call
        $editView->waitForEditViewVisible();
        $this->fakeData->seed($this->fakeDataSeed);
        $callName = 'Test_'. $this->fakeData->company();
        $calls->createCall($callName);

        // Verify date
        $I->waitForElementVisible('#date_start_hours', 120);

        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
        $I->see($callName);

        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}