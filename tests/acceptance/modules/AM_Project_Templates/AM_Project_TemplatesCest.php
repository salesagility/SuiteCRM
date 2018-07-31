<?php

use Faker\Generator;

class AM_Project_TemplatesCest
{
    /**
     * @var Generator $fakeData
     */
    protected $fakeData;

    /**
     * @var integer $fakeDataSeed
     */
    protected $fakeDataSeed;

    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        if (!$this->fakeData) {
            $this->fakeData = Faker\Factory::create();
        }

        $this->fakeDataSeed = rand(0, 2048);
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\ProjectTemplates $projectTemplates
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As an administrator I want to view the projectTemplates module.
     */
    public function testScenarioViewProjectTemplatesModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\ProjectTemplates $projectTemplates,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('View the projectTemplates module for testing');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to projectTemplates list-view
        $I->loginAsAdmin();
        $projectTemplates->gotoProjectTemplates();
        $listView->waitForListViewVisible();

        $I->see('Projects - Templates', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\ProjectTemplates $projectTemplate
     * @param \Helper\WebDriverHelper $webDriverHelper
     *
     * As administrative user I want to create a project template so that I can test
     * the standard fields.
     */
    public function testScenarioCreateProjectTemplate(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\ProjectTemplates $projectTemplate,
        \Helper\WebDriverHelper $webDriverHelper
    ) {
        $I->wantTo('Create a project template');

        $I->amOnUrl(
            $webDriverHelper->getInstanceURL()
        );

        // Navigate to project templates list-view
        $I->loginAsAdmin();
        $projectTemplate->gotoProjectTemplates();
        $listView->waitForListViewVisible();

        // Create project template
        $this->fakeData->seed($this->fakeDataSeed);
        $projectTemplate->createProjectTemplate('Test_'. $this->fakeData->company());

        // Delete project template
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}
