<?php

use Faker\Generator;

class CalendarCest
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
     * @param \Step\Acceptance\Calendar $calendar
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the calendar module.
     */
    public function testScenarioViewCalendarModule(
        \AcceptanceTester $I,
        \Step\Acceptance\Calendar $calendar,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the calendar module for testing');

        // Navigate to calendar list-view
        $I->loginAsAdmin();
        $I->visitPage('Calendar', 'index');

        $I->see('Calendar', '.moduleTitle');
    }
}
