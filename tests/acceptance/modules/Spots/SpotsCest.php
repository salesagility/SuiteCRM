<?php

use Faker\Generator;

class SpotsCest
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
     * @param \Step\Acceptance\Spots $spots
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the spots module.
     */
    public function testScenarioViewSpotsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Spots $spots,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the spots module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to spots list-view
        $I->loginAsAdmin();
        $spots->gotoSpots();
        $listView->waitForListViewVisible();

        $I->see('Spots', '.module-title-text');
    }
}