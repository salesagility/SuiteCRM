<?php

use Faker\Generator;

class InvoicesCest
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
     * @param \Step\Acceptance\Invoices $invoices
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the invoices module.
     */
    public function testScenarioViewInvoicesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Invoices $invoices,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the invoices module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to invoices list-view
        $I->loginAsAdmin();
        $invoices->gotoInvoices();
        $listView->waitForListViewVisible();

        $I->see('Invoices', '.module-title-text');
    }
}