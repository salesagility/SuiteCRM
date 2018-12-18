<?php

use Faker\Generator;

class ActivitiesCest
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
     * @param \Step\Acceptance\Accounts $accounts
     * @param \Step\Acceptance\Calls $calls
     * @param \Step\Acceptance\NavigationBar $NavigationBar
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As a user I want to see the due date on the activities module
     */
    public function testSeeDueDateSubpanelView(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\Accounts $accounts,
        \Step\Acceptance\Calls $calls,
        \Step\Acceptance\NavigationBar $NavigationBar,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('See the due date field on Account Activities subpanel');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to accounts list-view
        $I->loginAsAdmin();
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();

        // Create account
        $this->fakeData->seed($this->fakeDataSeed);
        $account_name = 'Test_'. $this->fakeData->company();
        $accounts->createAccount($account_name);

        // Create a Call and relate to an Account
        $NavigationBar->clickAllMenuItem('Calls');

        // Create call
        $this->fakeData->seed($this->fakeDataSeed);
        $callName = 'Test_'. $this->fakeData->company();
        $calls->createCallRelateModule($callName, $account_name, "Account");

        // Navigate to the Account's Detail View and confirm the due date contains data
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $listView->fillField('#name_basic', $account_name);
        $listView->click('Search', '.submitButtons');
        $listView->waitForListViewVisible();
        $listView->clickNameLink($account_name);

        //Click on Activites subpanel
        $I->click(['id'=>'subpanel_title_activities']);
        $I->waitForElementVisible('#Activities_createtask_button', 60);
        $I->expect('the due date is visible');
        $I->see('01/19/2038', '//*[@id="list_subpanel_activities"]/table/tbody/tr/td[6]');

        // Delete the Account
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();

        // Delete the Call
        $NavigationBar->clickAllMenuItem('Calls');
        $listView->waitForListViewVisible();

        // Select record from list view
        $I->wait(4);
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $listView->fillField('#name_basic', $callName);
        $listView->click('Search', '.submitButtons');
        $listView->waitForListViewVisible();
        $listView->clickNameLink($callName);

        // Delete record from detail view
        $detailView->waitForDetailViewVisible();

        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}
