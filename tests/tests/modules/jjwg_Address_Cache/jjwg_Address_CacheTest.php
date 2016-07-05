<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * Class jjwg_Address_CacheTest
 */
class jjwg_Address_CacheTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testjjwg_Address_Cache()
    {
        error_reporting(E_ERROR | E_PARSE);
    
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
        $jjwgAddressCache = new jjwg_Address_Cache();
    
        //test saveAddressCacheInfo() with empty info array
        $ainfo = array();
        $result = $jjwgAddressCache->saveAddressCacheInfo($ainfo);
        $this->assertEquals(false, $result);
    
        //test saveAddressCacheInfo() with a valid info array
        $jjwgAddressCache->settings['address_cache_save_enabled'] = 1;
        $ainfo =
            array('address' => 'test', 'lat' => '24.861462', 'lng' => '67.009939', 'description' => 'test description');
        $result = $jjwgAddressCache->saveAddressCacheInfo($ainfo);
        $this->assertEquals(true, $result);
    
        //test getAddressCacheInfo() with empty info array
        $result = $jjwgAddressCache->getAddressCacheInfo(array());
        $this->assertEquals(false, $result);
    
        //test getAddressCacheInfo() with a valid info array
        $jjwgAddressCache->settings['address_cache_get_enabled'] = 1;
        $ainfo =
            array('address' => 'test', 'lat' => '24.861462', 'lng' => '67.009939', 'description' => 'test description');
        $result = $jjwgAddressCache->getAddressCacheInfo($ainfo);
        $this->assertTrue(is_array($result));
    
        //test deleteAllAddressCache
        $jjwgAddressCache->deleteAllAddressCache();
    
        //verify that record cannot be retrieved anynore
        $result = $jjwgAddressCache->getAddressCacheInfo($ainfo);
        $this->assertEquals(false, $result);
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
        $jjwgAddressCache = new jjwg_Address_Cache();
    
        //test with invalid values
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lat(''));
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lat(91));
        $this->assertEquals(false, $jjwgAddressCache->is_valid_lat(-91));
    
        //test with valid values
        $this->assertEquals(true, $jjwgAddressCache->is_valid_lat(90));
        $this->assertEquals(true, $jjwgAddressCache->is_valid_lat(-90));
    }
}
