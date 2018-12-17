<?php

use Faker\Generator;

class TasksCest
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
     * @param \Step\Acceptance\Tasks $tasks
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the tasks module.
     */
    public function testScenarioViewTasksModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Tasks $tasks,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the tasks module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to tasks list-view
        $I->loginAsAdmin();
        $tasks->gotoTasks();
        $listView->waitForListViewVisible();

        $I->see('Tasks', '.module-title-text');
    }
}
