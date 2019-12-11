<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;
use Codeception\Module;
use PHPUnit_Framework_AssertionFailedError;
use SuiteCRM\Test\Driver\WebDriver;

class Acceptance extends Module
{
    public function seePageHas($text, $selector = null)
    {
        try {
            $this->getModule(WebDriver::class)->see($text, $selector);
        } catch (PHPUnit_Framework_AssertionFailedError $f) {
            return false;
        } catch (ModuleException $e) {
            return false;
        }

        return true;
    }

    // Clean up any files left behind by module builder tests.
    // This needs to be run both before _and_ after to handle the case where
    // the test run is cancelled or fails and the afterSuite() hook isn't run.
    public function _beforeSuite($settings = [])
    {
        $this->deleteModulesHelper();
    }

    // Clean up any files left behind by module builder tests.
    public function _afterSuite()
    {
        $this->deleteModulesHelper();
    }

    // Clean up any files left behind by module builder tests.
    private function deleteModulesHelper()
    {
        $modules = [
            'BasicTestModule',
            'CompanyTestModule',
            'FileTestModule',
            'IssueTestModule',
            'PersonTestModule',
            'SaleTestModule',
            'TestModuleFields'
        ];

        foreach ($modules as $module) {
            try {
                $this->deleteModuleFiles($module);
            } catch (ModuleException $e) {
                return false;
            }
        }
    }

    /**
     * Deletes module files and directories created by the module builder.
     * This allows the acceptance tests to be re-run.
     * @param string $module
     * @throws ModuleException
     */
    private function deleteModuleFiles($module)
    {
        $directories = [
            "custom/modulebuilder/builds/{$module}",
            "custom/modulebuilder/packages/{$module}",
            "modules/Test_{$module}"
        ];

        $files = [
            "custom/application/Ext/Include/modules.ext.php",
            "custom/Extension/application/Ext/Include/{$module}.php"
        ];

        foreach ($directories as $_index => $directory) {
            if (is_dir($directory)) {
                $this->getModule('Filesystem')->deleteDir($directory);
            }
        }

        foreach ($files as $_index => $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
