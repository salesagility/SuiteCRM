<?php

/**
 * Class configTest
 */
class configTest extends \SuiteCRM\Tests\SuiteCRMUnitTest
{
    public function test_config()
    {
        global $sugar_config;
        $this->assertNotEmpty($sugar_config, 'SuiteCRM config is empty');
    
        $this->assertInternalType('array', $sugar_config, 'SuiteCRM config is not an array');
        
    }
    
    public function testImportantConfigValues()
    {
        global $sugar_config;
        
        $this->assertEquals('7.7beta2', $sugar_config['suitecrm_version']);
    }
    
    public function testDatabaseConfigValues()
    {
        global $sugar_config;
        
        $this->assertArrayHasKey('dbconfig', $sugar_config);
        $this->assertInternalType('array', $sugar_config['dbconfig']);
        
        $keys = [
            'db_host_name',
            'db_host_instance',
            'db_user_name',
            'db_password',
            'db_name',
            'db_type',
            'db_port',
            'db_manager',
        ];
        foreach ($keys as $key)
        {
            $this->assertArrayHasKey($key, $sugar_config['dbconfig']);
        }
    }
}

