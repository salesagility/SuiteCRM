<?php

namespace Step\Acceptance;

class KnowledgeBase extends \AcceptanceTester
{
    /**
     * Navigate to targets module
     */
    public function gotoKnowledgeBase()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('Knowledge Base');
    }
}