<?php

use Faker\Generator;

class jjwg_Address_CacheCest
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
     * @param \Step\Acceptance\MapsAddressCache $mapsAddressCache
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the mapsAddressCache module.
     */
    public function testScenarioViewMapsAddressCacheModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\MapsAddressCache $mapsAddressCache,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the mapsAddressCache module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to mapsAddressCache list-view
        $I->loginAsAdmin();
        $mapsAddressCache->gotoMapsAddressCache();
        $listView->waitForListViewVisible();

        $I->see('Maps - Address Cache', '.module-title-text');
    }
}