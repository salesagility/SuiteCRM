<?php

use Faker\Generator;

class EventsCest
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
     * @param \Step\Acceptance\Events $events
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the events module.
     */
    public function testScenarioViewEventsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Events $events,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the events module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to events list-view
        $I->loginAsAdmin();
        $events->gotoEvents();
        $listView->waitForListViewVisible();

        $I->see('Events', '.module-title-text');
    }
}