<?php

use Faker\Generator;

class LocationsCest
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
     * @param \Step\Acceptance\Locations $locations
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the locations module.
     */
    public function testScenarioViewLocationsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Locations $locations,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the locations module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to locations list-view
        $I->loginAsAdmin();
        $locations->gotoLocations();
        $listView->waitForListViewVisible();

        $I->see('Locations', '.module-title-text');
    }
}