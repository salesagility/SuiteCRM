<?php
use Faker\Generator;

class EmailManCest
{
    /**
     * @var Generator $fakeData
     */
    protected $fakeData;
    /**
     * @var integer $fakeDataSeed
     */
    protected $fakeDataSeed;
    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        if (!$this->fakeData) {
            $this->fakeData = Faker\Factory::create();
        }
        $this->fakeDataSeed = rand(0, 2048);
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\EmailMan $emailMan
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to test outgoing mail configuration.
     */
    public function testScenarioAdminEmailSettings(
        \AcceptanceTester $I,
        \Step\Acceptance\EmailMan $emailMan,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Save an outgoing email configuration');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to email configuration and save settings
        $I->loginAsAdmin();
        $emailMan->createEmailSettings();

        $I->dontSee('Note: To send record assignment notifications, an SMTP server must be configured in Email Settings.');
    }
}
