<?php

use Faker\Factory;
use Faker\Generator;
use Helper\WebDriverHelper;
use Step\Acceptance\AccountsTester;
use Step\Acceptance\DetailView;
use Step\Acceptance\EditView;
use Step\Acceptance\ListView;
use Step\Acceptance\UsersTester;
use Step\Acceptance\Administration;
use Step\Acceptance\SideBar;

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
            $this->fakeData = Factory::create();
        }

        $this->fakeDataSeed = rand(0, 2048);
        $this->fakeData->seed($this->fakeDataSeed);
    }
  
    public function testEmailSettingsMailAccountAdd(AcceptanceTester $I, UsersTester $Users, WebDriverHelper $webDriverHelper)
    {
        $instanceUrl = $webDriverHelper->getInstanceURL();
        $I->amOnUrl($instanceUrl);
        $I->loginAsAdmin();
        $Users->gotoProfile();
        $I->see('User Profile', '.panel-heading');
        $I->click('Settings');
        $I->see('Mail Accounts');
        $I->click('Mail Accounts');
        $I->click('Add');
        $I->executeJS('javascript:SUGAR.email2.accounts.fillInboundGmailDefaults();'); // <-- instead of $I->click('Prefill Gmail™ Defaults');
        $I->fillField('ie_name', 'testuser_acc');
        $I->fillField('email_user', 'testuser_name');
        $I->fillField('email_password', 'testuser_pass');
        $I->click('Test Settings');
        $I->wait(20);
        $I->see('Connection completed successfully.');
    }

    public function testShowCollapsedSubpanelHint(
        AcceptanceTester $I,
        DetailView $DetailView,
        UsersTester $Users,
        ListView $listView,
        EditView $EditView,
        AccountsTester $accounts,
        WebDriverHelper $webDriverHelper
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

    public function testScenarioCreateUser(
        AcceptanceTester $I,
        SideBar $sideBar,
        ListView $listView,
        EditView $editView,
        UsersTester $user,
        Administration $administration,
        WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a new user');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        // Navigate to user edit-view
        $administration->gotoAdministration();
        $user->gotoUsers();
        $listView->waitForListViewVisible();
        $sideBar->clickSideBarAction('Create New User');
        $editView->waitForEditViewVisible();

        // Create test user
        $I->fillField('user_name', 'TEST_USER');
        $I->fillField('last_name', 'TEST_USER');
        $I->executeJS('window.scrollTo(0,document.body.scrollHeight); return true;');
        $I->fillField('Users0emailAddress0', 'fakeemail@fakeaddress.com');
        $I->executeJS('window.scrollTo(0,0); return true;');
        $I->click('#tab2');
        $I->fillField('#new_password', 'TEST_USER');
        $I->fillField('#confirm_pwd', 'TEST_USER');
        $I->wait(1);
        $editView->clickSaveButton();

        // Logout
        $administration->logout();
        $I->wait(1);

        // Login
        $I->seeElement('#loginform');
        $I->fillField('#user_name', 'TEST_USER');
        $I->fillField('#username_password', 'TEST_USER');
        $I->click('Log In');
        $I->waitForElementNotVisible('#loginform', 120);

        $I->click('#next_tab_personalinfo');
        $I->fillField('#last_name', 'TEST_USER_MODIFIED');
        $I->click('#next_tab_locale');
        $I->click('#next_tab_finish');
        $I->click('save');
        $I->wait(10);
    }
}
