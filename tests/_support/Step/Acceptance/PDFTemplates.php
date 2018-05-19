<?php

namespace Step\Acceptance;

class PDFTemplates extends \AcceptanceTester
{
    /**
     * Navigate to pdf templates module
     */
    public function gotoPDFTemplates()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('PDF - Templates');
    }
}