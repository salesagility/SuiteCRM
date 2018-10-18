<?php

namespace Step\Acceptance;

class InboundEmailTester extends \AcceptanceTester
{
    /**
     * Go to inbound email
     */
    public function gotoEmailSettings()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('#admin_link');
        $I->click('#mailboxes');
    }

    /**
     * Populate bounce email account
     *
     */
    public function createBounceEmail()
    {
        // TODO: DO NOT, __NEVER__ USE NON-WORKING FUNCIOTNS LIKE IMAP IN TESTS (Even if it's using random fake data!!!)
//        $I = new NavigationBar($this->getScenario());
//        $EditView = new EditView($this->getScenario());
//        $sideBar = new SideBar($this->getScenario());
//        $faker = $this->getFaker();
//
//        $I->clickUserMenuItem('#admin_link');
//        $I->click('#mailboxes');
//        $sideBar->clickSideBarAction('New Bounce Handling Account');
//
//        $I->click('#prefill_gmail_defaults_link');
//        $I->fillField('#name', 'Test_BounceHandling');
//        $I->fillField('#email_user', $faker->name);
//        $I->fillField('#email_password', $faker->name);
//        $EditView->clickSaveButton();
    }
}
