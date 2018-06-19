<?php

class jjwg_MapsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testjjwg_Maps()
    {

        
        $jjwgMaps = new jjwg_Maps();

        $this->assertInstanceOf('jjwg_Maps', $jjwgMaps);
        $this->assertInstanceOf('Basic', $jjwgMaps);
        $this->assertInstanceOf('SugarBean', $jjwgMaps);

        $this->assertAttributeEquals('jjwg_Maps', 'module_dir', $jjwgMaps);
        $this->assertAttributeEquals('jjwg_Maps', 'object_name', $jjwgMaps);
        $this->assertAttributeEquals('jjwg_maps', 'table_name', $jjwgMaps);

        $this->assertAttributeEquals(true, 'new_schema', $jjwgMaps);
        $this->assertAttributeEquals(true, 'importable', $jjwgMaps);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $jjwgMaps);
    }

    public function testconfiguration()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $jjwgMaps = new jjwg_Maps();

        
        try {
            $jjwgMaps->configuration();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testsaveConfiguration()
    {
        self::markTestIncomplete('environment dependency');
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('config');
        $state->pushTable('tracker');

	
        
        $jjwgMaps = new jjwg_Maps();

        
        $result = $jjwgMaps->saveConfiguration();
        $this->assertEquals(false, $result);

        
        $result = $jjwgMaps->saveConfiguration(array('test' => 1));
        $this->assertEquals(true, $result);
        
        
        
        $state->popTable('tracker');
        $state->popTable('config');

    }

    public function testupdateGeocodeInfo()
    {
        $jjwgMaps = new jjwg_Maps();
        $bean = new Meeting();

        
        $result = $jjwgMaps->updateGeocodeInfo($bean);
        $this->assertSame(false, $result);

        
        $bean->id = 1;
        $bean->jjwg_maps_lat_c = '100';
        $bean->jjwg_maps_lng_c = '40';

        $result = $jjwgMaps->updateGeocodeInfo($bean);

        $this->assertEquals(null, $result);
        $this->assertEquals(100, $bean->jjwg_maps_lat_c);
        $this->assertEquals(40, $bean->jjwg_maps_lng_c);
        
        
        if (!isset($bean->jjwg_maps_geocode_status_c)) {
            $beanJjwgMapsGeocodeStatusC = null;
        } else {
            $beanJjwgMapsGeocodeStatusC = $bean->jjwg_maps_geocode_status_c;
        }
        
        $this->assertEquals('', $beanJjwgMapsGeocodeStatusC);
        
        
        if (!isset($bean->jjwg_maps_address_c)) {
            $beanJjwgMapsAddressC = null;
        } else {
            $beanJjwgMapsAddressC = $bean->jjwg_maps_address_c;
        }
        
        $this->assertEquals('', $beanJjwgMapsAddressC);
    }

    public function testupdateRelatedMeetingsGeocodeInfo()
    {
        $jjwgMaps = new jjwg_Maps();
        $bean = new Account();

        
        $result = $jjwgMaps->updateRelatedMeetingsGeocodeInfo($bean);
        $this->assertEquals(false, $result);

        
        $bean->id = 1;
        $bean->jjwg_maps_lat_c = '100';
        $bean->jjwg_maps_lng_c = '40';

        $result = $jjwgMaps->updateRelatedMeetingsGeocodeInfo($bean);
        $this->assertSame(null, $result);
        $this->assertInstanceOf('jjwg_Address_Cache', $jjwgMaps->jjwg_Address_Cache);
    }

    public function testupdateMeetingGeocodeInfo()
    {
        $jjwgMaps = new jjwg_Maps();

        
        $bean = new Meeting();
        $bean->id = 1;
        $bean->jjwg_maps_lat_c = '100';
        $bean->jjwg_maps_lng_c = '40';

        $result = $jjwgMaps->updateMeetingGeocodeInfo($bean);
        $this->assertSame(null, $result);
    }

    public function testupdateGeocodeInfoByAssocQuery()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('accounts_cstm');

	
        
        $jjwgMaps = new jjwg_Maps();

        
        $result = $jjwgMaps->updateGeocodeInfoByAssocQuery('', array(), array());
        $this->assertSame(false, $result);

        
        $result = $jjwgMaps->updateGeocodeInfoByAssocQuery('test', array(), array());
        $this->assertSame(false, $result);

        
        $result = $jjwgMaps->updateGeocodeInfoByAssocQuery('accounts', array('id' => 1), array());
        $this->assertSame(null, $result);
        
        
        
        $state->popTable('accounts_cstm');
    }

    public function testupdateGeocodeInfoByBeanQuery()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('accounts_cstm');

	
        
        $jjwgMaps = new jjwg_Maps();
        $bean = new Account();

        
        $result = $jjwgMaps->updateGeocodeInfoByBeanQuery($bean);
        $this->assertSame(false, $result);

        
        $bean->id = 1;
        $result = $jjwgMaps->updateGeocodeInfoByBeanQuery($bean);
        $this->assertSame(null, $result);
        
        
        
        $state->popTable('accounts_cstm');
    }

    public function testdeleteAllGeocodeInfoByBeanQuery()
    {
        $jjwgMaps = new jjwg_Maps();
        $bean = new Call();

        
        $result = $jjwgMaps->deleteAllGeocodeInfoByBeanQuery($bean);
        $this->assertSame(false, $result);

        
        $bean = new Account();
        $result = $jjwgMaps->deleteAllGeocodeInfoByBeanQuery($bean);
        $this->assertSame(null, $result);
    }

    public function testgetGeocodeAddressesResult()
    {
        $jjwgMaps = new jjwg_Maps();

        
        $result = $jjwgMaps->getGeocodeAddressesResult('calls');
        $this->assertSame(false, $result);

        
        $result = $jjwgMaps->getGeocodeAddressesResult('accounts');
        $this->assertInstanceOf('mysqli_result', $result);
    }

    public function testdefineMapsAddress()
    {
        $jjwgMaps = new jjwg_Maps();

        
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Account', $address);
        
        $this->assertEquals(array('address' => 'addr 1, addr 2, addr 3, addr 4, addr 5'), $result);

        
        $address = array('id' => 1, 'primary_address_street' => 'addr 1', 'primary_address_city' => 'addr 2', 'primary_address_state' => 'addr 3', 'primary_address_postalcode' => 'addr 4', 'primary_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Contact', $address);
        $this->assertEquals(array('address' => 'addr 1, addr 2, addr 3, addr 4, addr 5'), $result);

        
        $address = array('id' => 1, 'primary_address_street' => 'addr 1', 'primary_address_city' => 'addr 2', 'primary_address_state' => 'addr 3', 'primary_address_postalcode' => 'addr 4', 'primary_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Lead', $address);
        $this->assertEquals(array('address' => 'addr 1, addr 2, addr 3, addr 4, addr 5'), $result);

        
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Opportunity', $address);
        $this->assertEquals(false, $result);

        
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Case', $address);
        $this->assertEquals(false, $result);

        
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Project', $address);
        $this->assertEquals(false, $result);

        
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Meeting', $address);
        $this->assertEquals(false, $result);
    }

    public function testdefineMapsFormattedAddress()
    {
        $jjwgMaps = new jjwg_Maps();

        $result = $jjwgMaps->defineMapsFormattedAddress(array());
        $this->assertEquals(false, $result);

        
        $address = array('billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'billing');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        
        $address = array('shipping_address_street' => 'addr 1', 'shipping_address_city' => 'addr 2', 'shipping_address_state' => 'addr 3', 'shipping_address_postalcode' => 'addr 4', 'shipping_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'shipping');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        
        $address = array('primary_address_street' => 'addr 1', 'primary_address_city' => 'addr 2', 'primary_address_state' => 'addr 3', 'primary_address_postalcode' => 'addr 4', 'primary_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'primary');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        
        $address = array('alt_address_street' => 'addr 1', 'alt_address_city' => 'addr 2', 'alt_address_state' => 'addr 3', 'alt_address_postalcode' => 'addr 4', 'alt_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'alt');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        
        $address = array('address_street' => 'addr 1', 'address_city' => 'addr 2', 'address_state' => 'addr 3', 'address_postalcode' => 'addr 4');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'address');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4', $result);
    }

    public function testis_valid_lng()
    {
        $jjwgMaps = new jjwg_Maps();

        
        $this->assertEquals(false, $jjwgMaps->is_valid_lng(''));
        $this->assertEquals(false, $jjwgMaps->is_valid_lng(181));
        $this->assertEquals(false, $jjwgMaps->is_valid_lng(-181));

        
        $this->assertEquals(true, $jjwgMaps->is_valid_lng(180));
        $this->assertEquals(true, $jjwgMaps->is_valid_lng(-180));
    }

    public function testis_valid_lat()
    {
        $jjwgMaps = new jjwg_Maps();

        
        $this->assertEquals(false, $jjwgMaps->is_valid_lat(''));
        $this->assertEquals(false, $jjwgMaps->is_valid_lat(91));
        $this->assertEquals(false, $jjwgMaps->is_valid_lat(-91));

        
        $this->assertEquals(true, $jjwgMaps->is_valid_lat(90));
        $this->assertEquals(true, $jjwgMaps->is_valid_lat(-90));
    }

    public function testlogGeocodeInfo()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $jjwgMaps = new jjwg_Maps();

        $bean = new Meeting();
        $bean->jjwg_maps_lat_c = '100';
        $bean->jjwg_maps_lng_c = '40';

        
        try {
            $jjwgMaps->logGeocodeInfo($bean);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testgetProspectLists()
    {
        $result = getProspectLists();
        $this->assertTrue(is_array($result));
    }
}
