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
}