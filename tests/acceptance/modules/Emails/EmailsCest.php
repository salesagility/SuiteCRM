<?php

use Faker\Generator;

class EmailsCest
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
     * @param \Step\Acceptance\Emails $emails
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the emails module.
     */
    public function testScenarioViewEmailsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Emails $emails,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the emails module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to emails list-view
        $I->loginAsAdmin();
        $emails->gotoEmails();
        $listView->waitForListViewVisible();

        $I->see('Emails', '.module-title-text');
    }
}