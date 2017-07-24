<?php
namespace Step\Acceptance;

use Page\NavigationBar;

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
        $tabletNavigationBar = new NavigationBar($this);
        $tabletNavigationBar->clickUserMenuItem('#admin_link');
    }
}