<?php
namespace Step\Acceptance;

class ModuleBuilder extends \AcceptanceTester
{

    public function loginAsAdmin(\Helper\WebDriverHelper $webDriverHelper)
    {
        $I = $this;
        $I->login(
            $webDriverHelper->getAdminUser(),
            $webDriverHelper->getAdminPassword()
        );
    }
}