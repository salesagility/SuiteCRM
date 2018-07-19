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
        if ($packageExists === false) {
            // Create new package
            $I->click('#newPackageLink');

            $I->waitForElementVisible(['name' => 'author']);
            $I->fillField(['name' => 'name'], $packageName);
            $I->fillField(['name' => 'author'], 'Acceptance Tester');
            $I->fillField(['name' => 'key'], 'Test');
            $I->fillField(['name' => 'description'], 'test module');
            $I->click('Save');

            // Close confirmation window
            $I->closePopupSuccess();

            // Create new module
            $I->click('New Module');
            $I->waitForElement('[name="label"]');
            $I->fillField(['name' => 'name'], $moduleName);
            $I->fillField(['name' => 'label'], $moduleName);
            $I->checkOption('[name=importable]');


            switch ($moduleType) {
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

            $I->wait(1);
            $I->click('Save'); // Will this be an issue with languages?

            // Close popup
            $I->closePopupSuccess();

            // Deploy module

            $I->waitForElementVisible('[name="name"]');

            $I->deployPackage($packageName);
            // Redeploy @TODO seperate this out to new test
            $I->deployPackage($packageName, true);
        } else {
            $I->getScenario()->skip($packageName . ' already exists. Please remove package and module manually.');
        }
    }


    /**
     * @param string $packageName
     */
    public function selectPackage($packageName)
    {
        $I = $this;

        $I->gotoAdministration();

        // Go To Module Builder
        $I->click('#moduleBuilder');
        $I->waitForElementVisible('.bodywrapper', 30);
        $I->click($packageName, '.bodywrapper');
        $I->waitForElementVisible(['name' => 'author'], 30);
    }


    /**
     * @param string $packageName
     * @param string $moduleName
     */
    public function selectModule($packageName, $moduleName)
    {
        $I = $this;

        $I->gotoAdministration();

        // Go To Module Builder
        $I->click('#moduleBuilder');
        $I->waitForElementVisible('.bodywrapper', 30);
        $I->click($packageName, '.bodywrapper');
        $I->waitForElementVisible(['name' => 'author'], 30);
        $I->click($moduleName, '#package_modules');
        $I->waitForElementVisible(['name' => 'savebtn'], 30);
    }


    public function closePopupSuccess()
    {
        $I = $this;
        $I->waitForElementVisible('#sugarMsgWindow_mask', 30);
        $I->waitForText('This operation is completed successfully', 30, '#sugarMsgWindow_c');
        $I->click('.container-close');
    }

    /**
     * @param string $packageName
     * @param boolean $packageExists
     *
     */

    public function deployPackage($packageName, $packageExists = false)
    {
        $I = $this;

        $I->gotoAdministration();

        // Go To Module Builder
        $I->click('#moduleBuilder');
        $I->waitForElementVisible('.bodywrapper', 30);
        $I->click($packageName, '.bodywrapper');
        $I->waitForElementVisible('[name="name"]');
        $I->click('Deploy');

        if ($packageExists) {
            $I->acceptPopup();
        }

        // Close popup
        $I->closePopupSuccess();

        // Wait for page to refresh and look for new package link
        $I->waitForElement('#newPackageLink', 360);
    }
}
