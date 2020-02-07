<?php

use Faker\Factory;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;
    /**
     * Define custom actions here
     */

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return Factory::create();
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $I = $this;

        $I->amOnUrl($I->getInstanceURL());
        $I->waitForElementVisible('#loginform');
        $I->fillField('#user_name', $username);
        $I->fillField('#username_password', $password);
        $I->click('Log In');
        $I->waitForElementNotVisible('#loginform');
    }

    public function loginAsAdmin()
    {
        $I = $this;

        $I->login(
            $I->getAdminUser(),
            $I->getAdminPassword()
        );
    }

    /**
     * Clicks the logout link in the users menu
     */
    public function logout()
    {
        $I = $this;
        $I->clickUserMenuItem('#logout_link');
    }

    public function dontSeeMissingLabels()
    {
        $I = $this;
        $I->dontSee('LBL_');
    }

    public function dontSeeErrors()
    {
        $I = $this;
        $I->dontSee('Warning');
        $I->dontSee('Notice');
        $I->dontSee('Error');
        $I->dontSee('error');
        $I->dontSee('PHP');
    }

    /**
     * Helper for navigating to a page.
     *
     * @param string $module SuiteCRM module name
     * @param string $action View action name, e.g. index, EditView, DetailView.
     * @param string|null $record The id of a record, used for EditView and DetailView routes.
     */
    public function visitPage($module, $action, $record = null)
    {
        $I = $this;
        $url = $I->getInstanceURL();
        if ($record !== null) {
            $url .= "/index.php?module={$module}&action={$action}&record={$record}";
        } else {
            $url .= "/index.php?module={$module}&action={$action}";
        }
        $I->amOnUrl($url);
    }
}
