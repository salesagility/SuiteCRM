<?php

namespace Step\Acceptance;

class MapsAreas extends \AcceptanceTester
{
    /**
     * Navigate to maps areas module
     */
    public function gotoMapsAreas()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Maps - Areas');
    }

    /**
     * Create maps area
     *
     * @param $name
     */
    public function createMapsArea($name)
    {
        $I = new EditView($this->getScenario());
        $ListView = new ListView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());
        $faker = $this->getFaker();

        $I->see('Create Areas', '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        $I->fillField('#city', $faker->city());
        $I->fillField('#state', $faker->city());
        $I->fillField('#country', $faker->country());
        $I->fillField('#description', $faker->text());
        $I->fillField('#coordinates', $faker->latitude() . ' ' . $faker->longitude());

        $I->seeElement('#assigned_user_name');

        $I->clickSaveButton();
        $ListView->waitForListViewVisible();
    }
}