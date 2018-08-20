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

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Invoices $invoice
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create an invoice so that I can test
     * the standard fields.
     */
    public function testScenarioCreateInvoice(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Invoices $invoice,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create an Invoice');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to invoices list-view
        $I->loginAsAdmin();
        $invoice->gotoInvoices();
        $listView->waitForListViewVisible();

        // Create invoice
        $this->fakeData->seed($this->fakeDataSeed);
        $invoice->createInvoice('Test_'. $this->fakeData->company());

        // Delete invoice
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}