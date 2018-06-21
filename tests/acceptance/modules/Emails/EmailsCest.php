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

    /**
     * @param \AcceptanceTester $I
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view an email body and check that it's not cached.
     */
    public function testScenarioViewEmailBodyHTML(
        \AcceptanceTester $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {

        // TODO: Refactor

        $I->wantTo('View the HTML of two emails');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Check for HTML caching issue
        $I->amOnUrl($webDriverHelper->getInstanceURL() . 'index.php?module=Emails&action=DetailView&record=eae65b87-6852-e43c-4213-5b213b39f2aa');
        $I->see('Test Description 1');
        $I->amOnUrl($webDriverHelper->getInstanceURL() . 'index.php?module=Emails&action=DetailView&record=eae65b87-6852-e43c-4213-5b213b39f2ab');
        $I->see('Test Description 2');
    }
}