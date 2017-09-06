<?php


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
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $I = $this;

        // if snapshot exists - skipping login
        if ($I->loadSessionSnapshot('login')) {
            return;
        }

        // Loggin In
        $I->seeInTitle('SuiteCRM');
        $I->seeElement('#loginform');
        $I->fillField('#user_name', $username);
        $I->fillField('#user_password', $password);
        $I->click('Log In');

        // Saving snapshot
        $I->saveSessionSnapshot('login');
    }
}
