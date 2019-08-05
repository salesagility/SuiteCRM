<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Test\Metadata;
use Codeception\TestInterface;

class Acceptance extends \Codeception\Module
{
    public function seePageHas($text, $selector = null)
    {
        try {
            $this->getModule('\SuiteCRM\Test\Driver\WebDriver')->see($text, $selector);
        } catch (\PHPUnit_Framework_AssertionFailedError $f) {
            return false;
        }
        return true;
    }

    // Clean up any files left behind by module builder tests.
    // This needs to be run both before _and_ after to handle the case where
    // the test run is cancelled or fails and the afterSuite() hook isn't run.
    public function _beforeSuite($settings = array())
    {
        $this->deleteModulesHelper();
    }

    // Clean up any files left behind by module builder tests.
    public function _afterSuite()
    {
        $this->deleteModulesHelper();
    }

    // Clean up any files left behind by module builder tests.
    private function deleteModulesHelper() {
        $modules = array(
            'BasicTestModule',
            'CompanyTestModule',
            'FileTestModule',
            'IssueTestModule',
            'PersonTestModule',
            'SaleTestModule',
            'TestModuleFields'
        );
        
        foreach ($modules as $module) {
            $this->deleteModuleFiles($module);
        }
    }

    /**
     * Deletes module files and directories created by the module builder.
     * This allows the acceptance tests to be re-run.
     * @param string $module
     */
    private function deleteModuleFiles($module) {
        $directories = array(
            "custom/modulebuilder/builds/{$module}",
            "custom/modulebuilder/packages/{$module}",
            "modules/Test_{$module}"
        );
        
        $files = array(
            "custom/application/Ext/Include/modules.ext.php",
            "custom/Extension/application/Ext/Include/{$module}.php"
        );

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
