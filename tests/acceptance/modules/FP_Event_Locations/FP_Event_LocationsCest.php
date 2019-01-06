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

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Locations $location
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a locations with the so that I can test
     * the standard fields.
     */
    public function testScenarioCreateEventLocation(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Locations $location,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a Location');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to locations list-view
        $I->loginAsAdmin();
        $location->gotoLocations();
        $listView->waitForListViewVisible();

        // Create location
        $this->fakeData->seed($this->fakeDataSeed);
        $location->createEventLocation('Test_'. $this->fakeData->company());

        // Delete location
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}
