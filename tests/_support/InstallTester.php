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
class InstallTester extends \Codeception\Actor
{
    use _generated\InstallTesterActions;

    /**
     * Tests the old version detected screen and moves to the next stage in the wizard
     */
    public function maySeeOldVersionDetected()
    {
        $I = $this;
        $scenario = $I->getScenario();

        if (!$this->isOldPhpVersionDetected()) {
            $scenario->comment('PHP Version '. PHP_VERSION .' meets the recommended requirements.');
        } else {
            $scenario->comment('PHP Version '. PHP_VERSION .' does not meet the recommended requirements.');
            $I->see('Old PHP Version Detected');
            $I->dontSeeMissingLabels();
            $I->checkOption('setup_old_php');
            $I->click('Next');
            $I->waitForText('GNU AFFERO GENERAL PUBLIC LICENSE');
        }
    }

    /**
     * Accept the license agreement and moves to the next stage of the wizard
     */
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


    /**
     * Tests the System Environment Stage and moves to the next stage of the wizard
     */
    public function seeValidSystemEnvironment()
    {
        $I = $this;
        $I->comment('View System Environment.');
        $I->see('System Environment');
        $I->dontSeeMissingLabels();
        $I->click('Next');
        $I->waitForText('Database Configuration');
    }

    /**
     * @param \Helper\WebDriverHelper $webDriverHelper
     * @throws Exception
     * Configures the installer based on the webdriver configuration and moves to the next stage of the wizard
     */
    public function configureInstaller(\Helper\WebDriverHelper $webDriverHelper)
    {
        $I = $this;
        $I->comment('Configure installer using Web Driver configuration.');
        $I->see('Database Configuration');
        $I->dontSeeMissingLabels();

        // TODO: TASK: UNDEFINED - Add mocha testing here
        // TODO: TASK: UNDEFINED - Add tests for form validation

        // Select Database type
        switch ($webDriverHelper->getDatabaseDriver()) {
            case \SuiteCRM\Enumerator\DatabaseDriver::MYSQL:
                $I->checkOption('#setup_db_type[value=mysql]');
                break;
            case \SuiteCRM\Enumerator\DatabaseDriver::MSSQL:
                $I->checkOption('#setup_db_type[value=mssql]');
                // clear instance field
                $I->fillField('#setup_db_host_instance', '');
                break;
            default:
                throw new Exception('No Database Driver Specified');
        }

        // Fill in database configuration
        $I->fillField('#setup_db_database_name', $webDriverHelper->getDatabaseName());
        $I->fillField('#setup_db_host_name', $webDriverHelper->getDatabaseHost());
        $I->fillField('#setup_db_admin_user_name', $webDriverHelper->getDatabaseUser());
        $I->fillField('#setup_db_admin_password_entry', $webDriverHelper->getDatabasePassword());

        // Fill In Site Configuration
        $I->fillField('[name=setup_site_admin_user_name]', $webDriverHelper->getAdminUser());
        $I->fillField('[name=setup_site_admin_password]', $webDriverHelper->getAdminPassword());
        $I->fillField('[name=setup_site_admin_password_retype]', $webDriverHelper->getAdminPassword());
        $I->fillField('[name=setup_site_url]', $webDriverHelper->getInstanceURL());
        $I->fillField('[name=email1]', 'install.tester@example.com');


        $I->click('Next');
        $I->waitForText('Install', 120);
    }

    /**
     * Waits for the login screen after the installer has finished and moves to the next stage of the wizard
     */
    public function waitForInstallerToFinish()
    {
        $I = $this;
        $I->comment('wait for installer progress to finish');
        $I->waitForElement('[type=submit]', 90);
        $I->dontSeeMissingLabels();
        $I->dontSeeErrors();
    }

    /**
     *
     */
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
    }

    protected function isOldPhpVersionDetected()
    {
        return $this->executeJS('return document.getElementsByName(\'setup_old_php\').length > 0;');
    }
}
