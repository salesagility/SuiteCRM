<?php

/**
 * Class LoginCest
 *
 * Test login page
 */
class AOW_WorkflowCest
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
            $this->fakeData->addProvider(new Faker\Provider\en_US\Address($this->fakeData));
            $this->fakeData->addProvider(new Faker\Provider\en_US\PhoneNumber($this->fakeData));
            $this->fakeData->addProvider(new Faker\Provider\en_US\Company($this->fakeData));
            $this->fakeDataSeed = mt_rand(0, 2048);
        }
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function testScenarioCreateWorkflow(
        AcceptanceTester $I,
        \Step\Acceptance\NavigationBarTester $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\SideBar $sideBar,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Dashboard $dashboard,
        \Step\Acceptance\Workflow $workflow
    ) {
        $I->wantTo('Create a workflow for accounts');

        // Login as Administrator
        $I->loginAsAdmin();

        $dashboard->waitForDashboardVisible();
        $workflow->navigateToWorkflow($navigationBar, $listView);
        $sideBar->clickSideBarAction('Create WorkFlow');
        $editView->waitForEditViewVisible();
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->fillField('#name', $this->fakeData->randomAscii);
        $workflow->selectWorkflowModule('Accounts');

        $I->wantTo('set date created condition');

        // TODO: Fix AOW Dates
//        $workflow->addCondition();
//        $lastCondition = $workflow->getLastConditionRowNumber();
//        $module = 'Accounts';
//        $field = 'Date Created';
//        $operator = 'Greater Than or Equal To';
//        $operatorType = 'Value';
//        $workflow->setConditionModuleField($lastCondition, $module, $field);
//        $workflow->setConditionOperator($lastCondition, $operator, $operatorType);
//        $workflow->setConditionOperatorDateTimeValue($lastCondition);
//        $workflow->wait(1);
//
//        $workflow->addCondition();
//        $lastCondition1 = $workflow->getLastConditionRowNumber();
//        $module1 = 'Accounts';
//        $field1 = 'Date Created';
//        $operator1 = 'Less Than or Equal To';
//        $operatorType1 = 'Value';
//        $workflow->setConditionModuleField($lastCondition1, $module1, $field1);
//        $workflow->setConditionOperator($lastCondition1, $operator1, $operatorType1);
//        $workflow->setConditionOperatorDateTimeValue($lastCondition1);
//        $workflow->wait(1);
//
//        $workflow->addCondition();
//        $lastCondition3 = $workflow->getLastConditionRowNumber();
//        $module3 = 'Accounts';
//        $field3 = 'Date Modified';
//        $operator3 = 'Greater Than or Equal To';
//        $operatorType3 = 'Value';
//        $workflow->setConditionModuleField($lastCondition3, $module3, $field3);
//        $workflow->setConditionOperator($lastCondition3, $operator3, $operatorType3);
//        $workflow->setConditionOperatorDateTimeValue($lastCondition3);
//

        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
    }

    // TODO: This test relied on state from the previous test, so it breaks when
    // the test order is randomized or cookies are cleared between tests. This should
    // be fixed.
    //
    // public function testScenarioDeleteWorkflow(
    //     AcceptanceTester $I,
    //     \Step\Acceptance\NavigationBar $navigationBar,
    //     \Step\Acceptance\ListView $listView,
    //     \Step\Acceptance\SideBar $sideBar,
    //     \Step\Acceptance\DetailView $detailView,
    //     \Step\Acceptance\EditView $editView,
    //     \Step\Acceptance\Dashboard $dashboard,
    //     \Step\Acceptance\Workflow $workflow
    // ) {
    //     $I->wantTo('Delete workflow');
    //     $I->loginAsAdmin();
    //
    //     $dashboard->waitForDashboardVisible();
    //     // TODO: Create a workflow and navigate to its DetailView here.
    //
    //     // Delete Record
    //     $detailView->clickActionMenuItem('Delete');
    //     $detailView->acceptPopup();
    //
    //     $listView->waitForListViewVisible();
    // }
}
