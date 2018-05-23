<?php

use Faker\Generator;

class MeetingsCest
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
     * @param \Step\Acceptance\Meetings $meetings
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the meetings module.
     */
    public function testScenarioViewMeetingsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Meetings $meetings,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the meetings module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to meetings list-view
        $I->loginAsAdmin();
        $meetings->gotoMeetings();
        $listView->waitForListViewVisible();

        $I->see('Meetings', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Meetings $meeting
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a meeting so that I can test
     * the standard fields.
     */
    public function testScenarioCreateMeeting(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Meetings $meeting,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a meeting');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to meetings list-view
        $I->loginAsAdmin();
        $meeting->gotoMeetings();
        $listView->waitForListViewVisible();

        // Create meeting
        $this->fakeData->seed($this->fakeDataSeed);
        $meeting->createMeeting('Test_'. $this->fakeData->company());

        // Delete meeting
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }

}