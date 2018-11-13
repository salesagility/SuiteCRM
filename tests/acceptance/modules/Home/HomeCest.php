<?php

use Faker\Generator;

class HomeCest
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
     * @param \Step\Acceptance\Dashboard $dashboard
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As a user I want to see a chart added to my dashboard
     */
    public function testCreateChartsDashlet(
        \AcceptanceTester $I,
        \Step\Acceptance\Dashboard $dashboard,
        \Step\Acceptance\DetailView $detailView,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a chart dashlet on the dashboard');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to dashboard
        $I->loginAsAdmin();
        $dashboard->waitForDashboardVisible();
        $detailView->clickActionMenuItem('Add Dashlets');
        $I->wait(1);
        $I->click('#chartCategory');
        $I->click('All Opportunities By Lead Source By Outcome');
        $I->click('Close');
        $dashboard->waitForDashboardVisible();
        $I->wait(1);
        $I->see('All Opportunities By Lead Source By Outcome');
        $dashboardID = $I->grabAttributeFrom('descendant-or-self::div[@class="dashletPanel"]', 'id');
        if ($dashboardID != "") {
            $dashboardID = str_replace("dashlet_entire_", "", $dashboardID);
        }
        $I->comment("The All Opportunities By Lead Source By Outcome dashboard ID is: ".$dashboardID);
        $I->click('//*[@id="dashlet_header_'.$dashboardID.'"]/div[2]/table/tbody/tr/td[2]/div/a[3]/span');
        $I->wait(1);
        $detailView->acceptPopup();
        $I->wait(1);
        $I->dontSee('All Opportunities By Lead Source By Outcome');
    }
}
