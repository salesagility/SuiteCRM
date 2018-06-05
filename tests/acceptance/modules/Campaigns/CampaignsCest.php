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

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Campaigns $campaign
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a non-emails campaign so that I can test
     * the standard fields.
     */
    public function testScenarioCreateNonEmailCampaign(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Campaigns $campaign,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create Non-Email Campaign');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to campaigns list-view
        $I->loginAsAdmin();
        $campaign->gotoCampaigns();
        $listView->waitForListViewVisible();

        // Create campaign
        $this->fakeData->seed($this->fakeDataSeed);
        $name = 'Test_'. $this->fakeData->company();
        $campaign->createNonEmailCampaign($name);

        // Delete campaign
        $listView->waitForListViewVisible();
        $listView->clickFilterButton();
        $I->fillField('name_basic', $name);
        $I->click('#search_form_submit');
        $listView->waitForListViewVisible();
        $listView->clickNameLink($name);
        $detailView->waitForDetailViewVisible();
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}