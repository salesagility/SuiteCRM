<?php

use Faker\Generator;

class EmailTemplatesCest
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
     * @param \Step\Acceptance\EmailTemplates $emailTemplate
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the emailTemplate module.
     */
    public function testScenarioViewEmailTemplatesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\EmailTemplates $emailTemplate,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the emailTemplate module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to emailTemplate list-view
        $I->loginAsAdmin();
        $emailTemplate->gotoEmailTemplates();
        $listView->waitForListViewVisible();

        $I->see('Email - Templates', '.module-title-text');
    }
}