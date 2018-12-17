<?php

use Faker\Generator;

class NotesCest
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
     * @param \Step\Acceptance\Notes $notes
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the notes module.
     */
    public function testScenarioViewNotesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Notes $notes,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the notes module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to notes list-view
        $I->loginAsAdmin();
        $notes->gotoNotes();
        $listView->waitForListViewVisible();

        $I->see('Notes', '.module-title-text');
    }
}
