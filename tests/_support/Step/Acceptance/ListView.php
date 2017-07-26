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
     * Wait for for the list view to become visible
     */
    public function waitForListViewVisible()
    {
        $I = $this;
        $I->waitForElementVisible('.listViewBody');
    }

    public function waitForFilterModalVisible()
    {
        $I = $this;
        $I->waitForElementVisible('#searchDialog');
    }
}