<?php

use Faker\Generator;

class CampaignsCest
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
     * @param \Step\Acceptance\Campaigns $campaigns
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the campaigns module.
     */
    public function testScenarioViewCampaignsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Campaigns $campaigns,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the campaigns module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to campaigns list-view
        $I->loginAsAdmin();
        $campaigns->gotoCampaigns();
        $listView->waitForListViewVisible();

        $I->see('Campaigns', '.module-title-text');
    }
}