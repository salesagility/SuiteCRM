<?php

namespace Step\Acceptance;

use \AcceptanceTester as Tester;


class EditView extends Tester
{
    /**
     * Wait for for the edit view to become visible
     */
    public function waitForDetailViewVisible()
    {
        $I = $this;
        $I->waitForElementVisible('#EditView');
    }

    public function clickSaveButton()
    {
        $I = $this;
        $I->scrollTo('#pagecontent');
        $I->click('Save');
    }

}