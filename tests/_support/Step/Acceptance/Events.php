<?php

namespace Step\Acceptance;

class Events extends \AcceptanceTester
{
    /**
     * Create an event
     *
     * @param $name
     */
    public function createEvent($name, $location)
    {
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());
        $faker = $this->getFaker();

        $I->see('Create Event', '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->fillField('#fp_event_locations_fp_events_1_name', $location);
        $I->fillField('#description', $faker->text());
        $I->fillField('#budget', $faker->randomDigit());

        $I->selectOption('#duration', '15 minutes');

        $I->seeElement('#assigned_user_name');
        $I->seeElement('#date_start_date');
        $I->seeElement('#date_end_date');

        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }
}
