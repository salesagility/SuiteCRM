<?php

use Faker\Generator;

class CasesCest
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
     * @param \Step\Acceptance\Cases $cases
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the cases module.
     */
    public function testScenarioViewCasesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Cases $cases,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the cases module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to cases list-view
        $I->loginAsAdmin();
        $cases->gotoCases();
        $listView->waitForListViewVisible();

        $I->see('Cases', '.module-title-text');
    }
}