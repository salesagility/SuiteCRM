<?php

use Faker\Generator;

class SurveysCest
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
     * @param \Step\Acceptance\Surveys $surveys
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the surveys module.
     */
    public function testScenarioViewSurveysModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Surveys $surveys,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the surveys module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to surveys list-view
        $I->loginAsAdmin();
        $surveys->gotoSurveys();
        $listView->waitForListViewVisible();

        $I->see('Surveys', '.module-title-text');
    }
}