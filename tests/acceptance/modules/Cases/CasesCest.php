<?php

use Faker\Generator;

class CasesCest
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
     * @param \Step\Acceptance\Cases $cases
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the cases module.
     */
    public function testScenarioViewCasesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Cases $cases,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the cases module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to cases list-view
        $I->loginAsAdmin();
        $cases->gotoCases();
        $listView->waitForListViewVisible();

        $I->see('Cases', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Cases $cases
     * @param \Step\Acceptance\Cases $account
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a case so that I can test
     * the standard fields.
     */
    public function testScenarioCreateCase(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Cases $cases,
        \Step\Acceptance\Accounts $account,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a Case');

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

        // Navigate to cases list-view
        $cases->gotoCases();
        $listView->waitForListViewVisible();

        // Create case
        $this->fakeData->seed($this->fakeDataSeed);
        $cases->createCase('Test_'. $this->fakeData->company(), $account_name);

        // Delete case
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
