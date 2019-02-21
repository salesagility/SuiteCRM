<?php

use Faker\Generator;

class TargetsCest
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
     * @param \Step\Acceptance\Targets $targets
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the targets module.
     */
    public function testScenarioViewTargetsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Targets $targets,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the targets module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to targets list-view
        $I->loginAsAdmin();
        $targets->gotoTargets();
        $listView->waitForListViewVisible();

        $I->see('Targets', '.module-title-text');
    }
}
