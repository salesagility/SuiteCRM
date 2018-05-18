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
}