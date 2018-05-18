<?php

use Faker\Generator;

class OpportunitiesCest
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
     * @param \Step\Acceptance\Opportunities $opportunities
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the opportunities module.
     */
    public function testScenarioViewOpportunitiesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Opportunities $opportunities,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the opportunities module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to opportunities list-view
        $I->loginAsAdmin();
        $opportunities->gotoOpportunities();
        $listView->waitForListViewVisible();

        $I->see('Opportunities', '.module-title-text');
    }
}