<?php


class RepairCest
{
    public function testScenarioRepairAndRebuild (
        AcceptanceTester $I,
        \Helper\WebDriverHelper $webDriverHelper,
        \Step\Acceptance\Repair $repair,
        \Page\Repair $repairPage
    ) {
        $I->wantTo('Login into SuiteCRM as an administrator');
        $I->amOnUrl($webDriverHelper->getInstanceURL());
        // Login as Administrator
        $I->login(
            $webDriverHelper->getAdminUser(),
            $webDriverHelper->getAdminPassword()
        );
        $repair->clickQuickRepairAndRebuild();

        if($repairPage->executeSqlButtonExists()) {
            $repair->clickExecuteSqlButton();
        }
    }
}
