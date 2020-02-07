<?php


class SugarAutoLoaderTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testautoload()
    {
        //execute the method and test if it returns expected values

        //test with a invalid class .
        $result = SugarAutoLoader::autoload('foo');
        $this->assertFalse($result);

        //test with a valid class out of autoload mappings.
        $result = SugarAutoLoader::autoload('SugarArray');
        $this->assertFalse($result);

        //test with a valid class registered in autoload mappings
        $result = SugarAutoLoader::autoload('User');
        $this->assertTrue($result);
    }

    public function testloadAll()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        

        //execute the method and check if it works and doesn't throws an exception
        //this method only includes file so there is no output to test.
        try {
            SugarAutoLoader::loadAll();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }
}
