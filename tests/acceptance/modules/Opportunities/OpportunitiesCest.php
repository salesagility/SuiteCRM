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

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Opportunities $opportunities
     * @param \Step\Acceptance\Accounts $account
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create an opportunity so that I can test
     * the standard fields.
     */
    public function testScenarioCreateOpportunity(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Opportunities $opportunities,
        \Step\Acceptance\Accounts $account,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create an opportunity');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to accounts list-view
        $I->loginAsAdmin();
        $account->gotoAccounts();
        $listView->waitForListViewVisible();

        // Create account
        $this->fakeData->seed($this->fakeDataSeed);
        $account_name = 'Test_'. $this->fakeData->company();
        $account->createAccount($account_name);

        // Navigate to opportunities list-view
        $opportunities->gotoOpportunities();
        $listView->waitForListViewVisible();

        // Create opportunity
        $this->fakeData->seed($this->fakeDataSeed);
        $opportunities->createOpportunity('Test_'. $this->fakeData->company(), $account_name);

        // Delete opportunity
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();

        // Delete account
        $account->gotoAccounts();
        $listView->waitForListViewVisible();
        $listView->clickFilterButton();
        $I->fillField('#name_basic', $account_name);
        $I->click('#search_form_submit');
        $listView->waitForListViewVisible();
        $listView->clickNameLink($account_name);
        $detailView->waitForDetailViewVisible();
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}
