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

    public function _beforeSuite()
    {
        $directories = array(
            "custom/modulebuilder/builds/CompanyTestModule",
            "custom/modulebuilder/packages/CompanyTestModule",
            "modules/Test_CompanyTestModule"
        );
        
        foreach ($directories as $_index => $directory) {
            if (is_dir($directory)) {
                $this->getModule('Filesystem')->deleteDir($directory);
            }
        }

        $files = array(
            "custom/application/Ext/Include/modules.ext.php",
            "custom/Extension/application/Ext/Include/CompanyTestModule.php"
        );

        foreach ($files as $_index => $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    public function _afterSuite()
    {
        $directories = array(
            "custom/modulebuilder/builds/CompanyTestModule/",
            "custom/modulebuilder/packages/CompanyTestModule/",
            "modules/Test_CompanyTestModule/"
        );

        foreach ($directories as $_index => $directory) {
            if (is_dir($directory)) {
                $this->getModule('Filesystem')->deleteDir($directory);
            }
        }

        $files = array(
            "custom/application/Ext/Include/modules.ext.php",
            "custom/Extension/application/Ext/Include/CompanyTestModule.php"
        );

        foreach ($files as $_index => $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
