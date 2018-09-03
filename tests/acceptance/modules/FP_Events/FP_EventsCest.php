<?php

use Faker\Generator;

class EventsCest
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
     * @param \Step\Acceptance\Events $events
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the events module.
     */
    public function testScenarioViewEventsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Events $events,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the events module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to events list-view
        $I->loginAsAdmin();
        $events->gotoEvents();
        $listView->waitForListViewVisible();

        $I->see('Events', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Events $event
     * @param \Step\Acceptance\Locations $location
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create an event so that I can test
     * the standard fields.
     */
    public function testScenarioCreateEvent(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Events $event,
        \Step\Acceptance\Locations $location,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create an Event');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to locations list-view
        $I->loginAsAdmin();
        $location->gotoLocations();
        $listView->waitForListViewVisible();

        // Create location
        $this->fakeData->seed($this->fakeDataSeed);
        $location_name = 'Test_'. $this->fakeData->company();
        $location->createEventLocation($location_name);

        // Navigate to events list-view
        $event->gotoEvents();
        $listView->waitForListViewVisible();

        // Create event
        $this->fakeData->seed($this->fakeDataSeed);
        $event->createEvent('Test_'. $this->fakeData->company(), $location_name);

        // Delete event
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();

        // Delete location
        $location->gotoLocations();
        $listView->waitForListViewVisible();
        $listView->clickFilterButton();
        $I->fillField('#name_basic', $location_name);
        $I->click('#search_form_submit');
        $listView->waitForListViewVisible();
        $listView->clickNameLink($location_name);
        $detailView->waitForDetailViewVisible();
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}
