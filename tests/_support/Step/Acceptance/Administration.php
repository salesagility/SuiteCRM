<?php
namespace Step\Acceptance;

use Page\NavigationBar;

class Administration extends \AcceptanceTester
{

    public function loginAsAdmin()
    {
        $I = $this;

        $I->login(
            $I->getAdminUser(),
            $I->getAdminPassword()
        );
    }

    public function gotoAdministration()
    {
        $tabletNavigationBar = new NavigationBar($this);
        $tabletNavigationBar->clickUserMenuItem('#admin_link');
    }
}