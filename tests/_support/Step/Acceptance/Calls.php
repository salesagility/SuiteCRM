<?php

namespace Step\Acceptance;

class Calls extends \AcceptanceTester
{
    /**
     * Navigate to calls module
     */
    public function gotoCalls()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Calls');
    }

    /**
     * Create a call
     *
     * @param $name
     */
    public function createCall($name)
    {
        $I = new EditView($this->getScenario());
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
    }
}