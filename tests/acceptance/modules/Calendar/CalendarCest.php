<?php

use Faker\Generator;

class CalendarCest
{
    /**
     * @var Generator
     */
    protected $fakeData;

    /**
     * @var int
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

        $this->fakeDataSeed = mt_rand(0, 2048);
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param \AcceptanceTester $I
     *
     * As an administrator I want to view the calendar module
     */
    public function testScenarioViewCalendarModule(
        AcceptanceTester $I
    ) {
        $I->wantTo('View the calendar module for testing');

        // Navigate to calendar list-view
        $I->loginAsAdmin();
        $I->visitPage('Calendar', 'index');

        $I->see('Calendar', '.moduleTitle');
    }
}
