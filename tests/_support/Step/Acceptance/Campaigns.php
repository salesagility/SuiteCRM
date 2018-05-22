<?php

namespace Step\Acceptance;

class Campaigns extends \AcceptanceTester
{
    /**
     * Navigate to campaigns module
     */
    public function gotoCampaigns()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Campaigns');
    }

    /**
     * Create a non-emails campaign
     *
     * @param $name
     */
    public function createNonEmailCampaign($name)
    {
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());
        $faker = $this->getFaker();

        $I->see('Create Campaign', '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->see('Campaign Wizard');
        $I->click('A non email campaign is a campaign that does not send an email.');

        // Step 1
        $I->fillField('#name', $name);
        $I->fillField('#wiz_content', $faker->text());
        $I->selectOption('#status', 'Active');
        $I->selectOption('#campaign_type', 'Print');
        $I->seeElement('#assigned_user_name');
        $I->click('#next_button_div');

        // Step 2
        $I->fillField('#budget', $name);
        $I->fillField('#actual_cost', $name);
        $I->fillField('#expected_revenue', $name);
        $I->fillField('#expected_cost', $name);
        $I->fillField('#impressions', $name);
        $I->fillField('#objective', $faker->text());
        $I->selectOption('#currency_id', 'US Dollars : $');
        $I->click('#next_button_div');

        // Step 3
        $I->fillField('#target_list_name', 'DefaultTargetList');
        $I->executeJS('add_target(\'false\');');
        $I->fillField('#target_list_name', 'SeedTargetList');
        $I->executeJS('add_target(\'false\');');
        $I->fillField('#target_list_name', 'TestTargetList');
        $I->executeJS('add_target(\'false\');');
        $I->click('#wiz_submit_finish_button');

        // Step 4
        $I->see('You have no associated targets in your selected target list(s) for this campaign. You can populate your list after finishing.');
        $Sidebar->clickSideBarAction('View Campaigns');
    }
}