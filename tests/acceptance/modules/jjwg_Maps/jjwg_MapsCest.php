<?php

use Faker\Generator;

class jjwg_MapsCest
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
     * @param \Step\Acceptance\Maps $maps
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the maps module.
     */
    public function testScenarioViewMapsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Maps $maps,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the maps module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to maps list-view
        $I->loginAsAdmin();
        $maps->gotoMaps();
        $listView->waitForListViewVisible();

        $I->see('Maps', '.module-title-text');
    }
}