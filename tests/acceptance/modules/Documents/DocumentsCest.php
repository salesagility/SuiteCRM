<?php

use Faker\Generator;

class DocumentsCest
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
     * @param \Step\Acceptance\Documents $documents
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the documents module.
     */
    public function testScenarioViewDocumentsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Documents $documents,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the documents module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to documents list-view
        $I->loginAsAdmin();
        $documents->gotoDocuments();
        $listView->waitForListViewVisible();

        $I->see('Documents', '.module-title-text');
    }
}
