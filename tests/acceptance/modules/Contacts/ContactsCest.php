<?php

use Faker\Generator;

class ContactsCest
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
     * @param \Step\Acceptance\Contacts $contacts
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the contacts module.
     */
    public function testScenarioViewContactsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Contacts $contacts,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the contacts module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to contacts list-view
        $I->loginAsAdmin();
        $contacts->gotoContacts();
        $listView->waitForListViewVisible();

        $I->see('Contacts', '.module-title-text');
    }
}