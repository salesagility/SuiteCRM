<?php

use Faker\Generator;

class AOK_KnowledgeBaseCest
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
     * @param \Step\Acceptance\KnowledgeBase $knowledgeBase
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the knowledgeBase module.
     */
    public function testScenarioViewKnowledgeBaseModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\KnowledgeBase $knowledgeBase,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the knowledgeBase module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to knowledgeBase list-view
        $I->loginAsAdmin();
        $knowledgeBase->gotoKnowledgeBase();
        $listView->waitForListViewVisible();

        $I->see('Knowledge Base', '.module-title-text');
    }
}