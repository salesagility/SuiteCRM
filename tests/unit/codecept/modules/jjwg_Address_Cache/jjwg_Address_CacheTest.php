<?php


class jjwg_Address_CacheTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function testjjwg_Address_Cache()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        

        //execute the contructor and check for the Object type and  attributes
        $jjwgAddressCache = new jjwg_Address_Cache();
        $this->assertInstanceOf('jjwg_Address_Cache', $jjwgAddressCache);
        $this->assertInstanceOf('Basic', $jjwgAddressCache);
        $this->assertInstanceOf('SugarBean', $jjwgAddressCache);

        $this->assertAttributeEquals('jjwg_Address_Cache', 'module_dir', $jjwgAddressCache);
        $this->assertAttributeEquals('jjwg_Address_Cache', 'object_name', $jjwgAddressCache);
        $this->assertAttributeEquals('jjwg_address_cache', 'table_name', $jjwgAddressCache);

        $this->assertAttributeEquals(true, 'new_schema', $jjwgAddressCache);
        $this->assertAttributeEquals(true, 'importable', $jjwgAddressCache);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $jjwgAddressCache);
        
        
        // clean up
        
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testconfiguration()
    {
        $jjwgAddressCache = new jjwg_Address_Cache();
        $jjwgAddressCache->configuration();

        $this->assertInstanceOf('jjwg_Maps', $jjwgAddressCache->jjwg_Maps);
        $this->assertTrue(is_array($jjwgAddressCache->settings));
        $this->assertGreaterThan(0, count($jjwgAddressCache->settings));
    }

    public function testSaveAndGetAddressCacheInfoAndDeleteAllAddressCache()
    {

    // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('jjwg_address_cache');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');

        // test
        
        $jjwgAddressCache = new jjwg_Address_Cache();

        //test saveAddressCacheInfo() with empty info array
        $ainfo = array();
        $result = $jjwgAddressCache->saveAddressCacheInfo($ainfo);
        $this->assertEquals(false, $result);

        //test saveAddressCacheInfo() with a valid info array
        $jjwgAddressCache->settings['address_cache_save_enabled'] = 1;
        $ainfo = array('address' => 'test', 'lat' => '24.861462', 'lng' => '67.009939', 'description' => 'test description');
        $result = $jjwgAddressCache->saveAddressCacheInfo($ainfo);
        $this->assertEquals(true, $result);

        //test getAddressCacheInfo() with empty info array
        $result = $jjwgAddressCache->getAddressCacheInfo(array());
        $this->assertEquals(false, $result);

        //test getAddressCacheInfo() with a valid info array
        $jjwgAddressCache->settings['address_cache_get_enabled'] = 1;
        $ainfo = array('address' => 'test', 'lat' => '24.861462', 'lng' => '67.009939', 'description' => 'test description');
        $result = $jjwgAddressCache->getAddressCacheInfo($ainfo);
        $this->assertTrue(is_array($result));

        //test deleteAllAddressCache
        $jjwgAddressCache->deleteAllAddressCache();

        //verify that record cannot be retrieved anynore
        $result = $jjwgAddressCache->getAddressCacheInfo($ainfo);
        $this->assertEquals(false, $result);
        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('jjwg_address_cache');
    }

    public function testis_valid_lng()
    {
        $jjwgAddressCache = new jjwg_Address_Cache();

        //test with invalid values
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lng(''));
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lng(181));
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lng(-181));

        //test with valid values
        $this->assertEquals(true, $jjwgAddressCache->is_valid_lng(180));
        $this->assertEquals(true, $jjwgAddressCache->is_valid_lng(-180));
    }

    public function testis_valid_lat()
    {
        self::markTestIncomplete('Incorrect state hash (in PHPUnitTest): Hash doesn\'t match at key "database::email_addresses".');
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        

        $jjwgAddressCache = new jjwg_Address_Cache();

        //test with invalid values
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lat(''));
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lat(91));
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lat(-91));

        //test with valid values
        $this->assertEquals(true, $jjwgAddressCache->is_valid_lat(90));
        $this->assertEquals(true, $jjwgAddressCache->is_valid_lat(-90));

        
        // clean up
        
        $state->popTable('email_addresses');
        $state->popGlobals();
    }
}
