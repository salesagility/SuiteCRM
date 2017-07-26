<?php
namespace Step\Acceptance;

class Administration extends \AcceptanceTester
{

    public function gotoAdministration()
    {
        $I = new NavigationBar($this->getScenario());
        $I ->clickUserMenuItem('#admin_link');
    }
}