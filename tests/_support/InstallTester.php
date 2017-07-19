<?php


use Codeception\Configuration;

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
class InstallTester extends \Codeception\Actor
{
    use _generated\InstallTesterActions;

    /**
     *
     */
    public function maySeeOldVersionDetected()
    {
        $I = $this;
        $scenario = $I->getScenario();

        if(version_compare(phpversion(), SUITECRM_PHP_REC_VERSION, '>=')) {
            $scenario->skip('PHP Version '. PHP_VERSION .' meets the recommended requirements.');
        } else {
            $scenario->comment('PHP Version '. PHP_VERSION .' does not meet the recommended requirements.');
            $I->dontSeeMissingLabels();
            $I->see('Old PHP Version Detected');
            $I->checkOption('setup_old_php');
            $I->click('Next');
            $I->waitForText('GNU AFFERO GENERAL PUBLIC LICENSE');
        }
    }

    public function acceptLicense()
    {
        $I = $this;
        $I->comment('Accept the license agreement.');
        $I->seeElement('.licensetext');
        $I->seeElement('#licenseaccept');
        $I->seeElement('#button_print_license');
        $I->dontSeeMissingLabels();
        $I->click('I Accept');
        $I->click('Next');

        // Wait for next screen. Fail if next button doesn't work
        $I->waitForText('System Environment');
    }


    public function seeValidSystemEnvironment()
    {
        $I = $this;
        $I->comment('View System Environment.');
        $I->see('System Environment');
        $I->click('Next');
        $I->waitForText('Database Configuration');
    }

    public function configureInstaller()
    {
        $I = $this;
        $I->comment('View System Environment.');
        $I->see('Database Configuration');
    }
    /**
     *
     */
    public function dontSeeMissingLabels()
    {
        $I = $this;
        $I->dontSee('LBL');
    }
}
