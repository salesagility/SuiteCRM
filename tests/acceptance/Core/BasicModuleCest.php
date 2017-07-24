<?php

class BasicModuleCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I)
    {
    }

    // Tests
    /**
     * @param \Step\Acceptance\ModuleBuilder $I
     *
     */
    public function testScenarioCreateBasicModule(
       \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a basic module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $I->createModule(
            \Page\BasicModule::$PACKAGE_NAME,
            \Page\BasicModule::$NAME,
            \SuiteCRM\Enumerator\SugarObjectType::basic
        );
    }

    /**
     * @param \Step\Acceptance\ModuleBuilder $I
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to view my basic test module so that I can see if it has been
     * deployed correctly
     */
    public function testScenarioViewBasicTestModule(
        \Step\Acceptance\ModuleBuilder $I,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View Basic Test Module');
        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        $I->loginAsAdmin();

        $navigationBar = new \Page\NavigationBar($I);
        $navigationBar->clickAllMenuItem(\Page\BasicModule::$NAME);

        $I->see(\Page\BasicModule::$NAME);
        $I->seeElement('.listViewBody');
    }
}