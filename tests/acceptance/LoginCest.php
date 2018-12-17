<?php

/**
 * Class LoginCest
 *
 * Test login page
 */
class LoginCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function testScenarioLoginAsAdministrator(AcceptanceTester $I, \Helper\WebDriverHelper $webDriverHelper)
    {
        $I->wantTo('Login into SuiteCRM as an administrator');
        $I->amOnUrl($webDriverHelper->getInstanceURL());
        // Login as Administrator
        $I->login(
            $webDriverHelper->getAdminUser(),
            $webDriverHelper->getAdminPassword()
        );
    }
}
