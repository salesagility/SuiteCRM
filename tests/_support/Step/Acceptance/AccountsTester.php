<?php

namespace Step\Acceptance;

use InvalidArgumentException;

class AccountsTester extends \AcceptanceTester
{
    /**
     * Create an account
     *
     * @param string $name
     * @return string Account ID
     */
    public function createAccount($name)
    {
        global $db;
        $id = create_guid();
        $accountType = 'Customer';
        $query = "INSERT INTO accounts (id, name, account_type, date_entered) VALUES ('?', '?', '?', '?')";
        $db->pQuery($query, array(
            $id,
            $name,
            $accountType,
            date('Y-m-d H:i:s')
        ));
        return $id;
    }

    /**
     * Creates accounts that can be indexed by elasticsearch
     * @param $name
     */
    public function createAccountForElasticSearch($name)
    {
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());

        $I->waitForText('Create Account', 5, '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);

        $I->seeElement('#assigned_user_name');
        $I->seeElement('#parent_name');
        $I->seeElement('#campaign_name');

        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }
    
    /**
     *
     * @return Scenario
     */
    public function getPublicScenario()
    {
        return $this->getScenario();
    }
}
