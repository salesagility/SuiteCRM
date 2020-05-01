<?php

use Faker\Generator;

class TargetListsCest
{
    /**
     * @var Generator
     */
    protected $fakeData;

    /**
     * @var int
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

        $this->fakeDataSeed = mt_rand(0, 2048);
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     *
     * As an administrator I want to view the targets module
     */
    public function testScenarioViewTargetsModule(
        AcceptanceTester $I,
        Step\Acceptance\ListView $listView
    ) {
        $I->wantTo('View the targets module for testing');

        // Navigate to targets list-view
        $I->loginAsAdmin();
        $I->visitPage('ProspectLists', 'index');
        $listView->waitForListViewVisible();

        $I->see('Targets', '.module-title-text');
    }
}
