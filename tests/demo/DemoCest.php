<?php

/**
 * Class DemoCest
 * Demonstrate login into the SuiteCRM Demo site
 * This is used to check your configuration works.
 */
class DemoCest
{
    public function _before(DemoTester $I)
    {
    }

    public function _after(DemoTester $I)
    {
    }

    // tests
    public function testScenarioLogin(DemoTester $I)
    {
        $I->wantTo('Test codeception configuration');
        $I->amOnUrl('https://demo.suiteondemand.com/');
    }
}
