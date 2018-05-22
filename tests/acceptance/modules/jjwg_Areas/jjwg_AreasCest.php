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

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\MapsAreas $mapsArea
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a maps area so that I can test
     * the standard fields.
     */
    public function testScenarioCreateMapsArea(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\MapsAreas $mapsArea,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create Maps Area');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to maps area list-view
        $I->loginAsAdmin();
        $mapsArea->gotoMapsAreas();
        $listView->waitForListViewVisible();

        // Create maps area
        $this->fakeData->seed($this->fakeDataSeed);
        $name = 'Test_'. $this->fakeData->company();
        $mapsArea->createMapsArea($name);

        // Delete maps area
        $listView->clickNameLink($name);
        $detailView->waitForDetailViewVisible();
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}