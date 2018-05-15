<?php

use Faker\Generator;

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
     * @param \Step\Acceptance\NavigationBar $NavigationBar
     * @param \Step\Acceptance\SideBar $sidebar
     * @param \Step\Acceptance\EditView $editView
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to verify the date field of a call
     */
    public function testScenarioCallDate(
        \AcceptanceTester $I,
        \Step\Acceptance\Reports $NavigationBar,
        \Step\Acceptance\SideBar $sidebar,
        \Step\Acceptance\EditView $editView,
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

        // Create Call
        $I->see('Log Call', '.actionmenulink');
        $sidebar->clickSideBarAction('Log');
        $I->waitForEditViewVisible();
        $I->fillField('#name', 'Call_Test');

        // Verify date
        $I->seeElement('date_start_meridiem');

        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
        $I->see('Call_Test');
    }
}