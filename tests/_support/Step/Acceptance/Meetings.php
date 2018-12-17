<?php

namespace Step\Acceptance;

class Meetings extends \AcceptanceTester
{
    /**
     * Navigate to meetings module
     */
    public function gotoMeetings()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Meetings');
    }

    /**
     * Create a meeting
     *
     * @param $name
     */
    public function createMeeting($name)
    {
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());
        $faker = $this->getFaker();

        $I->see('Schedule Meeting', '.actionmenulink');
        $Sidebar->clickSideBarAction('Schedule');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->fillField('#date_start_date', '01/19/2038');
        $I->fillField('#description', $faker->text());
        $I->fillField('#location', $faker->city());

        $I->waitForElementVisible('#date_start_hours', 120);

        $I->selectOption('#duration', '15 minutes');
        $I->selectOption('#status', 'Held');
        $I->selectOption('#parent_type', 'Account');

        $I->seeElement('#assigned_user_name');

        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }
}