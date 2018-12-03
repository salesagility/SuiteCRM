<?php

use Faker\Generator;

class LeadsCest
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
     * @param \Step\Acceptance\Leads $leads
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the leads module.
     */
    public function testScenarioViewLeadsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Leads $leads,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the leads module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to leads list-view
        $I->loginAsAdmin();
        $leads->gotoLeads();
        $listView->waitForListViewVisible();

        $I->see('Leads', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Leads $lead
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a laed so that I can test
     * the standard fields.
     */
    public function testScenarioCreateLead(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Leads $lead,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a Lead');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to leads list-view
        $I->loginAsAdmin();
        $lead->gotoLeads();
        $listView->waitForListViewVisible();

        // Create lead
        $this->fakeData->seed($this->fakeDataSeed);
        $lead->createLead('Test_'. $this->fakeData->company());

        // Delete lead
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}