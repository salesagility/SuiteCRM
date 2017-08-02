<?php
namespace Step\Acceptance;


use Helper\WebDriverHelper;
use SuiteCRM\Enumerator\SugarObjectType;

class ModuleBuilder extends Administration
{
    /**
     * @param string $packageName
     * @param string $moduleName
     * @param string $moduleType
     * @see SugarObjectType
     */
    public function createModule($packageName, $moduleName, $moduleType)
    {
        $I = $this;

        $I->gotoAdministration();

        // Go To Module Builder
        $I->click('#moduleBuilder');

        $packageExists = $I->seePageHas($packageName, '#Buttons');
        if($packageExists === false) {
            // Create new package
            $I->click('#newPackageLink');

            $I->waitForElementVisible(['name' => 'author']);
            $I->fillField(['name' => 'name'], $packageName);
            $I->fillField(['name' => 'author'], 'Acceptance Tester');
            $I->fillField(['name' => 'key'], 'Test');
            $I->fillField(['name' => 'description'], 'test module');
            $I->click('Save');

            // Close confirmation window
            $I->waitForElementVisible('#sugarMsgWindow_mask');
            $I->wait(3);
            $I->click('.container-close');

            // Create new module
            $I->click('New Module');
            $I->waitForElement('[name="label"]');
            $I->fillField(['name' => 'name'], $moduleName);
            $I->fillField(['name' => 'label'], $moduleName);
            $I->checkOption('[name=importable]');


            switch ($moduleType)
            {
                case SugarObjectType::basic:
                    $I->click('#type_basic');
                    break;
                case SugarObjectType::company:
                    $I->click('#type_company');
                    break;
                case SugarObjectType::file:
                    $I->click('#type_file');
                    break;
                case SugarObjectType::issue:
                    $I->click('#type_issue');
                    break;
                case SugarObjectType::person:
                    $I->click('#type_person');
                    break;
                case SugarObjectType::sale:
                    $I->click('#type_sale');
                    break;
            }

            $I->click('Save');

            // Close popup
            $I->waitForElementVisible('#sugarMsgWindow_mask');
            $I->wait(3);
            $I->click('.container-close');

            // Deploy module
            $I->waitForElementVisible('[name="name"]');
            $I->click('Module Builder');
            $I->waitForElementVisible('.bodywrapper');
            $I->click($moduleName, '.bodywrapper');
            $I->waitForElementVisible('[name="name"]');
            $I->click('Deploy');

            if($packageExists) {
                $I->acceptPopup();
            }

            // Close popup
            $I->waitForElementVisible('#sugarMsgWindow_mask');
            $I->wait(3);
            $I->click('.container-close');

            // Wait for page to refresh and look for new package link
            $I->waitForElement('#newPackageLink', 360);

        } else {
            $I->getScenario()->skip($packageName . ' already exists. Please remove package and module manually.');
        }
    }
}