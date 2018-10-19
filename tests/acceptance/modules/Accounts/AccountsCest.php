<?php

use Faker\Generator;

class AccountsCest
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
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the accounts module.
     */
    public function testScenarioViewAccountsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Accounts $accounts,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the accounts module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to accounts list-view
        $I->loginAsAdmin();
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();

        $I->see('Accounts', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Accounts $accounts
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a report with the reports module so that I can test
     * the standard fields.
     */
    public function testScenarioCreateAccount(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Accounts $accounts,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create an Account');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to accounts list-view
        $I->loginAsAdmin();
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();

        // Create account
        $this->fakeData->seed($this->fakeDataSeed);
        $accounts->createAccount('Test_'. $this->fakeData->company());

        // Delete account
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Accounts $accounts
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to inline edit a field on the list-view
     */
    public function testScenarioInlineEditListView(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Accounts $accounts,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Inline edit an account on the list-view');

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

        // Inline edit
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();
        $I->doubleClick('.inlineEdit');
        $I->fillField('#name', 'InlineAccountNameEdit');
        $I->clickWithLeftButton('.suitepicon-action-confirm');
        $I->see('InlineAccountNameEdit');
    }

    public function testScenarioCreateAccountChild(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Accounts $accounts,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create an Account');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to accounts list-view
        $I->loginAsAdmin();
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();

        // Create account
        $this->fakeData->seed($this->fakeDataSeed);
        $parentAccountName = 'Test_' . $this->fakeData->company();
        $accounts->createAccount($parentAccountName);

        // Click on Member Organizations subpanel
        $I->click(['id' => 'subpanel_title_accounts']);
        $I->waitForElementVisible('#member_accounts_create_button', 60);

        // Add child account
        $accountName = 'Test_' . $this->fakeData->company();
        $I->click('#member_accounts_create_button');
        $I->click('#Accounts_subpanel_full_form_button');
        $editView->waitForEditViewVisible();
        $I->fillfield('#name', $accountName);
        $editView->clickSaveButton();

        // View child account in parent account subpanel
        $detailView->waitForDetailViewVisible();
        $I->see($accountName, '//*[@id="list_subpanel_accounts"]/table/tbody/tr/td[2]/a');

        // Delete account
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();

        // Select record from list view
        $listView->clickFilterButton();
        $listView->click('Quick Filter');
        $listView->fillField('#name_basic', $accountName);
        $listView->click('Search', '.submitButtons');
        $listView->waitForListViewVisible();
        $listView->clickNameLink($accountName);
        $detailView->waitForDetailViewVisible();

        // Delete account
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}
