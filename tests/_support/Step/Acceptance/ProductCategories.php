<?php

namespace Step\Acceptance;

class ProductCategories extends \AcceptanceTester
{
    /**
     * Navigate to product categories module
     */
    public function gotoProductCategories()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('ProductCategories');
    }
}