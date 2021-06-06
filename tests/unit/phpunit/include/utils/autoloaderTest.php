<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SugarAutoLoaderTest extends SuitePHPUnitFrameworkTestCase
{
    public function testautoload()
    {
        // Execute the method and test that it returns expected values

        // Test with an invalid class.
        $result = SugarAutoLoader::autoload('foo');
        self::assertFalse($result);

        // Test with a valid class out of autoload mappings.
        $result = SugarAutoLoader::autoload('SugarArray');
        self::assertFalse($result);

        // Test with a valid class registered in autoload mappings.
        $result = SugarAutoLoader::autoload('User');
        self::assertTrue($result);
    }

    public function testloadAll()
    {
        // Execute the method and check that it works and doesn't throw an exception.
        // This method only includes file so there is no output to test.
        try {
            SugarAutoLoader::loadAll();
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }
}
