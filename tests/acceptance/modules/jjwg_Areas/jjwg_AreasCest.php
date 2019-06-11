<?php

use Faker\Generator;

class jjwg_AreasCest
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
     * @param \Step\Acceptance\MapsAreas $mapsAreas
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the mapsAreas module.
     */
    public function testScenarioViewMapsAreasModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\MapsAreas $mapsAreas,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the mapsAreas module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to mapsAreas list-view
        $I->loginAsAdmin();
        $mapsAreas->gotoMapsAreas();
        $listView->waitForListViewVisible();

        $I->see('Maps - Areas', '.module-title-text');
    }
}
