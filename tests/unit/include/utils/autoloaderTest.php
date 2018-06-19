<?php


class SugarAutoLoaderTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testautoload()
    {
        

        
        $result = SugarAutoLoader::autoload('foo');
        $this->assertFalse($result);

        
        $result = SugarAutoLoader::autoload('SugarArray');
        $this->assertFalse($result);

        
        $result = SugarAutoLoader::autoload('User');
        $this->assertTrue($result);
    }

    public function testloadAll()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        

        
        
        try {
            SugarAutoLoader::loadAll();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }
}
