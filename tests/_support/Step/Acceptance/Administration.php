<?php
namespace Step\Acceptance;

class Administration extends \AcceptanceTester
{

    public function loginAsAdmin(\Helper\WebDriverHelper $webDriverHelper)
    {
        $I = $this;
        $I->login(
            $webDriverHelper->getAdminUser(),
            $webDriverHelper->getAdminPassword()
        );
    }

    public function gotoAdministration()
    {
        $I = $this;

        // TODO: TASK UNDEFINED - Add support for desktop, tablet, and mobile
        $I->click('.tablet-bar #toolbar .globalLinks-mobile');
        $I->click('.tablet-bar #toolbar .globalLinks-mobile #admin_link');
    }


}