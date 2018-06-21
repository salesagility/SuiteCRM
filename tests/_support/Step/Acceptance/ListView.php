<?php

namespace Step\Acceptance;

use \AcceptanceTester as Tester;

class ListView  extends Tester
{

    /**
     * Click on the name of a record
     */
    public function clickNameLink($name)
    {
        $I = $this;
        $I->waitForElementVisible('//*[@id="MassUpdate"]', 10);
        $I->click($name, '//*[@id="MassUpdate"]/div[3]/table');
    }

    /**
     * Click on the filter button
     */
    public function clickFilterButton()
    {
        $I = $this;
        $I->click('a.glyphicon-filter','.searchLink');
        $I->waitForFilterModalVisible();
    }

    /**
     * Clears the list-view filter
     */
    public function clearFilterButton()
    {
        $I = $this;
        $I->clickFilterButton();
        $I->click('Quick Filter');
        $I->fillField('#name_basic', '');
        $I->click('Search', '.submitButtons');
        $I->waitForListViewVisible();
    }

    /**
     * Wait for for the list view to become visible
     */

    public function waitForListViewVisible()
    {
        $I = $this;
        $I->waitForElementVisible('.listViewBody', 120);
    }

    public function waitForFilterModalVisible()
    {
        $I = $this;
        $I->waitForElementVisible('#searchDialog', 120);
    }

    public function waitForFilterModalNotVisible()
    {
        $I = $this;
        $I->waitForElementNotVisible('#searchDialog', 120);
    }
}