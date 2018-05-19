<?php

namespace Step\Acceptance;

class Products extends \AcceptanceTester
{
    /**
     * Navigate to products module
     */
    public function gotoProducts()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Products');
    }
}