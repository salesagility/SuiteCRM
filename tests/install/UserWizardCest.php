<?php
/**
 * Class UserWizardCest
 * As an administrative user, I want to use the install wizard (web based) to install SuiteCRM.
 */
class UserWizardCest
{

    /**
     * @var \Helper\WebDriverHelper $webDriverHelper
     */
    protected $webDriverHelper;

    /**
     * @param InstallTester $I
     */
    public function _before(InstallTester $I)
    {
    }

    /**
     * @param InstallTester $I
     */
    public function _after(InstallTester $I)
    {
    }

    /**
     * @param \Helper\WebDriverHelper $webDriverHelper
     * Dependency injection
     */
    protected function _inject(\Helper\WebDriverHelper $webDriverHelper)
    {
        $this->webDriverHelper = $webDriverHelper;
    }

    // tests
    /**
     * @param InstallTester $I
     *
     * As an administrative user, I want to use the install wizard (web based) to install SuiteCRM.
     * Given that that I install SuiteCRM with the default configuration settings I
     * Expect to be able to login as an administrator.
     */
    public function testScenarioInstallSuiteCRMWithDefaultConfiguration(InstallTester $I)
    {
        $I->wantTo('check the php version meets the recommended requirements.');
        $I->amOnUrl($this->webDriverHelper->getInstanceURL());
        $I->waitForText('Setup');
        $I->maySeeOldVersionDetected();
        $I->acceptLicense();
        $I->seeValidSystemEnvironment();
        $I->configureInstaller($this->webDriverHelper);
        $I->waitForInstallerToFinish();
    }

}
