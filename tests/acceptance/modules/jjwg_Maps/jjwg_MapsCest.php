<?php

use Faker\Generator;

class jjwg_MapsCest
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
     * @param \Step\Acceptance\Maps $maps
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the maps module.
     */
    public function testScenarioViewMapsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Maps $maps,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the maps module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to maps list-view
        $I->loginAsAdmin();
        $maps->gotoMaps();
        $listView->waitForListViewVisible();

        $I->see('Maps', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Maps $map
     * @param \Step\Acceptance\Accounts $accounts
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a map so that I can test
     * the standard fields.
     */
    public function testScenarioCreateMap(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Maps $map,
        \Step\Acceptance\Accounts $accounts,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a Map');

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

        // Navigate to maps list-view
        $map->gotoMaps();
        $listView->waitForListViewVisible();

        // Create map
        $this->fakeData->seed($this->fakeDataSeed);
        $name = 'Test_'. $this->fakeData->company();
        $map->createMap($name, $account_name);

        // Delete map
        $listView->clickNameLink($account_name);
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();

        // Delete account
        $accounts->gotoAccounts();
        $listView->waitForListViewVisible();
        $I->wait(10);
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