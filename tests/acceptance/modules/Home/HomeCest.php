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
     * As a user I want to see the due date on the activities module
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
        $I->waitForText('Charts');
        $I->click('Charts');
        $I->click('All Opportunities By Lead Source By Outcome');
        $I->click('Close');
        $dashboard->waitForDashboardVisible();
        $I->see('All Opportunities By Lead Source By Outcome');
    }
}
