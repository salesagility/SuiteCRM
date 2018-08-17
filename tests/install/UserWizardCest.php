<?php
/**
 * Class UserWizardCest
 * As an administrative user, I want to use the install wizard (web based) to install SuiteCRM.
 */
class UserWizardCest
{

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
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrative user, I want to use the install wizard (web based) to install SuiteCRM.
     * Given that that I install SuiteCRM with the default configuration settings I
     * Expect to be able to login as an administrator.
     */
    public function testScenarioInstallSuiteCRMWithDefaultConfiguration(InstallTester $I, AcceptanceTester $I2,
        \Step\Acceptance\EmailMan $emailMan, \Helper\WebDriverHelper $webDriverHelper)
    {
        
        // -------- Install and setup CRM ----------
        
        $I->wantTo('check the php version meets the recommended requirements.');
        $I->amOnUrl($webDriverHelper->getInstanceURL());
        $I->waitForText('Setup');
        $I->maySeeOldVersionDetected();
        $I->acceptLicense();
        $I->seeValidSystemEnvironment();
        $I->configureInstaller($webDriverHelper);
        $I->waitForInstallerToFinish();
        
        // ---------- Email Settings ---------------
        
        $I2->wantTo('Save an outgoing email configuration');
        $I2->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to email configuration and save settings
        $I2->loginAsAdmin();
        $emailMan->createEmailSettings();

        $I2->dontSee('Note: To send record assignment notifications, an SMTP server must be configured in Email Settings.');
        
        // --------- Email Outbound Account Settings --------------
        
        $I2->wantTo('Email Outbound Account Settings');
        $I2->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );
        $I2->click('Profile');
        $I2->click('Settings');
        $I2->waitForJS("$('#accountSettings').click(); SUGAR.email2.accounts.showEditInboundAccountDialogue();");
        $I2->click('Prefill Gmail™ Defaults');
        $I2->fillField('ie_name', 'test gmail account');
        $I2->fillField('email_user', 'sa.tester2');
        $I2->fillField('email_password', 'chilisauce');
        $I2->fillField('trashFolder', '[Gmail]/Bin');
        $I2->fillField('sentFolder', '[Gmail]/Sent Mail');
        $I2->waitForJS('SUGAR.email2.accounts.saveIeAccount(getUserEditViewUserId());');
        $I2->see('Set up Mail Accounts to view incoming emails from your email accounts');
        $I2->see('test gmail account');
    }
}
