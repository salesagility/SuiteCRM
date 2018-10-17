<?php

use Faker\Generator;

class UsersCest
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

    public function testShowCollapsedSubpanelHint(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $DetailView,
        \Step\Acceptance\Users $Users,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\EditView $EditView,
        \Step\Acceptance\Accounts $accounts,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the collapsed subpanel hints on Accounts');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to Users list-view
        $I->loginAsAdmin();

        $Users->gotoProfile();

        $I->see('User Profile', '.panel-heading');

        $I->click("Layout Options");
        $I->wait(5);
        $I->seeElement('input', ['name' => 'user_count_collapsed_subpanels']);
        $I->checkOption(['name' => 'user_count_collapsed_subpanels']);
        $EditView->clickSaveButton();
        $DetailView->waitForDetailViewVisible();

        // Create & Navigate to Accounts
        // @TODO - Need to include dummy data to utilise these tests efficiently
        $I->wantTo('Create an Account');

        // Navigate to accounts list-view
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();

        // Create account
        $this->fakeData->seed($this->fakeDataSeed);
        $accounts->createAccount('Test_'. $this->fakeData->company());

        // View the Subpanels Hint
        $I->see('Leads (0)', '//*[@id="subpanel_title_leads"]/div/div');

        // Delete account
        $DetailView->clickActionMenuItem('Delete');
        $DetailView->acceptPopup();
        $listView->waitForListViewVisible();

        // Reset the collapsed subpanels
        $Users->gotoProfile();
        $I->see('User Profile', '.panel-heading');
        $I->click("Layout Options");
        $I->seeElement('input', ['name' => 'user_count_collapsed_subpanels']);
        $I->uncheckOption(['name' => 'user_count_collapsed_subpanels']);
        $EditView->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }
}
