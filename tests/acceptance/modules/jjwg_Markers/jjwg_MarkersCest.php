<?php

use Faker\Generator;

class jjwg_MarkersCest
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
     * @param \Step\Acceptance\MapsMarkers $mapsMarkers
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the mapsMarkers module.
     */
    public function testScenarioViewMapsMarkersModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\MapsMarkers $mapsMarkers,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the mapsMarkers module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to mapsMarkers list-view
        $I->loginAsAdmin();
        $mapsMarkers->gotoMapsMarkers();
        $listView->waitForListViewVisible();

        $I->see('Maps - Markers', '.module-title-text');
    }
}