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
}