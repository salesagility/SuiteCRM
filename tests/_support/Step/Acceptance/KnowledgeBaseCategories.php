<?php

namespace Step\Acceptance;

class KnowledgeBaseCategories extends \AcceptanceTester
{
    /**
     * Navigate to knowledge base categories module
     */
    public function gotoKnowledgeBaseCategories()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickAllMenuItem('KB - Categories');
    }
}