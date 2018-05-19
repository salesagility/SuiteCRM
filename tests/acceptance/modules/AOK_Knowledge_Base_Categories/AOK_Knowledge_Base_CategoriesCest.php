<?php

use Faker\Generator;

class AOK_Knowledge_Base_CategoriesCest
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
     * @param \Step\Acceptance\KnowledgeBaseCategories $knowledgeBaseCategory
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the knowledgeBaseCategory module.
     */
    public function testScenarioViewKnowledgeBaseCategoriesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\KnowledgeBaseCategories $knowledgeBaseCategory,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the knowledgeBaseCategory module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to knowledgeBaseCategory list-view
        $I->loginAsAdmin();
        $knowledgeBaseCategory->gotoKnowledgeBaseCategories();
        $listView->waitForListViewVisible();

        $I->see('KB - Categories', '.module-title-text');
    }
}