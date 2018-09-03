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

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\KnowledgeBaseCategories $knowledgeBaseCategories
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a knowledge base category so that I can test
     * the standard fields.
     */
    public function testScenarioCreateKnowledgeBaseCategory(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\KnowledgeBaseCategories $knowledgeBaseCategories,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create KnowledgeBaseCategory');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to knowledge base category list-view
        $I->loginAsAdmin();
        $knowledgeBaseCategories->gotoKnowledgeBaseCategories();
        $listView->waitForListViewVisible();

        // Create knowledge base category
        $this->fakeData->seed($this->fakeDataSeed);
        $knowledgeBaseCategories->createKnowledgeBaseCategory('Test_'. $this->fakeData->company());

        // Delete knowledge base category
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}