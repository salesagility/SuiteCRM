<?php

use \Faker\Factory;
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
        if(!$this->fakeData) {
            $this->fakeData = Faker\Factory::create();
            $this->fakeData->addProvider(new Faker\Provider\en_US\Address($this->fakeData));
            $this->fakeData->addProvider(new Faker\Provider\en_US\PhoneNumber($this->fakeData));
            $this->fakeData->addProvider(new Faker\Provider\en_US\Company($this->fakeData));
            $this->fakeDataSeed = rand(0, 2048);
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
        \Helper\WebDriverHelper $webDriverHelper,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\SideBar $sideBar,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Dashboard $dashboard,
        \Step\Acceptance\Workflow $workflow
    ) {
        $I->wantTo('Create a workflow for accounts');
        $I->amOnUrl($webDriverHelper->getInstanceURL());

        // Login as Administrator
        $I->login(
            $webDriverHelper->getAdminUser(),
            $webDriverHelper->getAdminPassword()
        );

        $dashboard->waitForDashboardVisible();
        $workflow->navigateToWorkflow($navigationBar, $listView);
        $sideBar->clickSideBarAction('Create WorkFlow');
        $editView->waitForEditViewVisible();
        $this->fakeData->seed($this->fakeDataSeed);
        $editView->fillField('#name', $this->fakeData->randomAscii);
        $workflow->selectWorkflowModule('Accounts');

        $I->wantTo('set date created condition');

        $workflow->addCondition();
        $lastCondition = $workflow->getLastConditionRowNumber();
        $module = 'Accounts';
        $field = 'Date Created';
        $operator = 'Greater Than or Equal To';
        $operatorType = 'Value';
        $workflow->setConditionModuleField($lastCondition, $module, $field);
        $workflow->setConditionOperator($lastCondition, $operator, $operatorType);
        $workflow->setConditionOperatorDateTimeValue($lastCondition);

        $workflow->addCondition();
        $lastCondition = $workflow->getLastConditionRowNumber();
        $module = 'Accounts';
        $field = 'Date Modified';
        $operator = 'Greater Than or Equal To';
        $operatorType = 'Value';
        $workflow->setConditionModuleField($lastCondition, $module, $field);
        $workflow->setConditionOperator($lastCondition, $operator, $operatorType);
        $workflow->setConditionOperatorDateTimeValue($lastCondition);


        $editView->clickSaveButton();
        $detailView->waitForDetailViewVisible();
    }

    public function testScenarioDeleteWorkflow(
        AcceptanceTester $I,
        \Helper\WebDriverHelper $webDriverHelper,
        \Step\Acceptance\NavigationBar $navigationBar,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\SideBar $sideBar,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\EditView $editView,
        \Step\Acceptance\Dashboard $dashboard,
        \Step\Acceptance\Workflow $workflow
    ) {
        $I->wantTo('Delete workflow');

        // Delete Record
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();

        $listView->waitForListViewVisible();
        $this->lastView = 'ListView';
    }
}
