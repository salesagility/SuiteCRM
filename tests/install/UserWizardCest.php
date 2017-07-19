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

    protected function _inject(\Helper\WebDriverHelper $webDriverHelper)
    {
        $this->webDriverHelper = $webDriverHelper;
    }

    // tests
    /**
     * @param InstallTester $I
     *
     * As an administrative user, I want to use the install wizard (web based) to install SuiteCRM.
     * Given that the php version is less than the recommended version I would
     * Expect to see the Old Php version detected.
     */
    public function testScenarioPHPVersion(InstallTester $I)
    {
        $I->wantTo('check the php version meets the recommended requirements.');
        $I->amOnUrl($this->webDriverHelper->getInstanceURL());
        $I->waitForText('Setup');
        $I->maySeeOldVersionDetected();
        $I->dontSeeMissingLabels();
        $I->acceptLicense();
        $I->dontSeeMissingLabels();
        $I->seeValidSystemEnvironment();
        $I->dontSeeMissingLabels();
        $I->configureInstaller();
        $I->dontSeeMissingLabels();
    }

}
