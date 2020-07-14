<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class jjwg_MapsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testjjwg_Maps()
    {
        // Execute the constructor and check for the Object type and  attributes
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

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
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        // Execute the method and test that it works and doesn't throw an exception.
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
        
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        //test with empty array/default
        $result = $jjwgMaps->saveConfiguration();
        $this->assertEquals(false, $result);

        //test with data array
        $result = $jjwgMaps->saveConfiguration(array('test' => 1));
        $this->assertEquals(true, $result);
    }

    public function testupdateGeocodeInfo()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');
        $bean = BeanFactory::newBean('Meetings');

        //test without bean attributes set
        $result = $jjwgMaps->updateGeocodeInfo($bean);
        $this->assertSame(false, $result);

        //test with required attributes set
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
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');
        $bean = BeanFactory::newBean('Accounts');

        //test without setting bean attributes
        $result = $jjwgMaps->updateRelatedMeetingsGeocodeInfo($bean);
        $this->assertEquals(false, $result);

        //test with required attributes set
        $bean->id = 1;
        $bean->jjwg_maps_lat_c = '100';
        $bean->jjwg_maps_lng_c = '40';

        $result = $jjwgMaps->updateRelatedMeetingsGeocodeInfo($bean);
        $this->assertSame(null, $result);
        $this->assertInstanceOf('jjwg_Address_Cache', $jjwgMaps->jjwg_Address_Cache);
    }

    public function testupdateMeetingGeocodeInfo()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        //test with required attributes set
        $bean = BeanFactory::newBean('Meetings');
        $bean->id = 1;
        $bean->jjwg_maps_lat_c = '100';
        $bean->jjwg_maps_lng_c = '40';

        $result = $jjwgMaps->updateMeetingGeocodeInfo($bean);
        $this->assertSame(null, $result);
    }

    public function testupdateGeocodeInfoByAssocQuery()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        //test with empty parameters
        $result = $jjwgMaps->updateGeocodeInfoByAssocQuery('', array(), array());
        $this->assertSame(false, $result);

        //test with non empty but invalid parameters
        $result = $jjwgMaps->updateGeocodeInfoByAssocQuery('test', array(), array());
        $this->assertSame(false, $result);

        //test with non empty valid parameters
        $result = $jjwgMaps->updateGeocodeInfoByAssocQuery('accounts', array('id' => 1), array());
        $this->assertSame(null, $result);
    }

    public function testupdateGeocodeInfoByBeanQuery()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');
        $bean = BeanFactory::newBean('Accounts');

        //test without setting bean attributes
        $result = $jjwgMaps->updateGeocodeInfoByBeanQuery($bean);
        $this->assertSame(false, $result);

        //test with required attributes set
        $bean->id = 1;
        $result = $jjwgMaps->updateGeocodeInfoByBeanQuery($bean);
        $this->assertSame(null, $result);
    }

    public function testdeleteAllGeocodeInfoByBeanQuery()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');
        $bean = BeanFactory::newBean('Calls');

        //test with invalid geocode bean
        $result = $jjwgMaps->deleteAllGeocodeInfoByBeanQuery($bean);
        $this->assertSame(false, $result);

        //test with invalid geocode bean
        $bean = BeanFactory::newBean('Accounts');
        $result = $jjwgMaps->deleteAllGeocodeInfoByBeanQuery($bean);
        $this->assertSame(null, $result);
    }

    public function testgetGeocodeAddressesResult()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        //test with invalid geocode bean
        $result = $jjwgMaps->getGeocodeAddressesResult('calls');
        $this->assertSame(false, $result);

        //test with invalid geocode bean
        $result = $jjwgMaps->getGeocodeAddressesResult('accounts');
        $this->assertInstanceOf('mysqli_result', $result);
    }

    public function testdefineMapsAddress()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        //test for Account Object type
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Account', $address);
        //var_dump($result);
        $this->assertEquals(array('address' => 'addr 1, addr 2, addr 3, addr 4, addr 5'), $result);

        //test for Contact Object type
        $address = array('id' => 1, 'primary_address_street' => 'addr 1', 'primary_address_city' => 'addr 2', 'primary_address_state' => 'addr 3', 'primary_address_postalcode' => 'addr 4', 'primary_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Contact', $address);
        $this->assertEquals(array('address' => 'addr 1, addr 2, addr 3, addr 4, addr 5'), $result);

        //test for Leads Object type
        $address = array('id' => 1, 'primary_address_street' => 'addr 1', 'primary_address_city' => 'addr 2', 'primary_address_state' => 'addr 3', 'primary_address_postalcode' => 'addr 4', 'primary_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Lead', $address);
        $this->assertEquals(array('address' => 'addr 1, addr 2, addr 3, addr 4, addr 5'), $result);

        //test for Opportunities Object type
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Opportunity', $address);
        $this->assertEquals(false, $result);

        //test for Case Object type
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Case', $address);
        $this->assertEquals(false, $result);

        //test for Project Object type
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Project', $address);
        $this->assertEquals(false, $result);

        //test for Project Meetings type
        $address = array('id' => 1, 'billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsAddress('Meeting', $address);
        $this->assertEquals(false, $result);
    }

    public function testdefineMapsFormattedAddress()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        $result = $jjwgMaps->defineMapsFormattedAddress(array());
        $this->assertEquals(false, $result);

        //test for type billing
        $address = array('billing_address_street' => 'addr 1', 'billing_address_city' => 'addr 2', 'billing_address_state' => 'addr 3', 'billing_address_postalcode' => 'addr 4', 'billing_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'billing');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        //test for type shipping
        $address = array('shipping_address_street' => 'addr 1', 'shipping_address_city' => 'addr 2', 'shipping_address_state' => 'addr 3', 'shipping_address_postalcode' => 'addr 4', 'shipping_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'shipping');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        //test for type primary
        $address = array('primary_address_street' => 'addr 1', 'primary_address_city' => 'addr 2', 'primary_address_state' => 'addr 3', 'primary_address_postalcode' => 'addr 4', 'primary_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'primary');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        //test for type alt
        $address = array('alt_address_street' => 'addr 1', 'alt_address_city' => 'addr 2', 'alt_address_state' => 'addr 3', 'alt_address_postalcode' => 'addr 4', 'alt_address_country' => 'addr 5');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'alt');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4, addr 5', $result);

        //test for type address
        $address = array('address_street' => 'addr 1', 'address_city' => 'addr 2', 'address_state' => 'addr 3', 'address_postalcode' => 'addr 4');
        $result = $jjwgMaps->defineMapsFormattedAddress($address, 'address');
        $this->assertEquals('addr 1, addr 2, addr 3, addr 4', $result);
    }

    public function testis_valid_lng()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        //test with invalid values
        $this->assertEquals(false, $jjwgMaps->is_valid_lng(''));
        $this->assertEquals(false, $jjwgMaps->is_valid_lng(181));
        $this->assertEquals(false, $jjwgMaps->is_valid_lng(-181));

        //test with valid values
        $this->assertEquals(true, $jjwgMaps->is_valid_lng(180));
        $this->assertEquals(true, $jjwgMaps->is_valid_lng(-180));
    }

    public function testis_valid_lat()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        //test with invalid values
        $this->assertEquals(false, $jjwgMaps->is_valid_lat(''));
        $this->assertEquals(false, $jjwgMaps->is_valid_lat(91));
        $this->assertEquals(false, $jjwgMaps->is_valid_lat(-91));

        //test with valid values
        $this->assertEquals(true, $jjwgMaps->is_valid_lat(90));
        $this->assertEquals(true, $jjwgMaps->is_valid_lat(-90));
    }

    public function testlogGeocodeInfo()
    {
        $jjwgMaps = BeanFactory::newBean('jjwg_Maps');

        $bean = BeanFactory::newBean('Meetings');
        $bean->jjwg_maps_lat_c = '100';
        $bean->jjwg_maps_lng_c = '40';

        // Execute the method and test that it works and doesn't throw an exception.
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
