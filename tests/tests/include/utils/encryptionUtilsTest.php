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

require_once 'include/utils/encryption_utils.php';

/**
 * Class encryption_utilsTest
 */
class encryption_utilsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testsugarEncode()
    {
    
        //execute the method and test if it returns expected values
        //key param does nothing currently.
    
        //blank key and data
        $expected = '';
        $actual = sugarEncode('', '');
        $this->assertSame($expected, $actual);
    
        //blank key and valid data
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('', 'Data');
        $this->assertSame($expected, $actual);
    
        //valid key and data
        $expected = 'RGF0YQ==';
        $actual = sugarEncode('key', 'Data');
        $this->assertSame($expected, $actual);
    }
    
    public function testsugarDecode()
    {
    
        //execute the method and test if it returns expected values
        //key param does nothing currently.
    
        //blank key and data
        $expected = '';
        $actual = sugarDecode('', '');
        $this->assertSame($expected, $actual);
    
        //blank key and valid data
        $expected = 'Data';
        $actual = sugarDecode('', 'RGF0YQ==');
        $this->assertSame($expected, $actual);
    
        //valid key and data
        $expected = 'Data';
        $actual = sugarDecode('key', 'RGF0YQ==');
        $this->assertSame($expected, $actual);
    }
    
    public function testblowfishGetKey()
    {
    
        //execute the method and test if it returns expected length string
    
        //test key
        $actual = blowfishGetKey('test');
        $this->assertGreaterThanOrEqual(36, strlen($actual));
        //var_dump($actual);
    
        //default key
        $actual = blowfishGetKey('rapelcg_svryq');
        $this->assertGreaterThanOrEqual(36, strlen($actual));
    }
    
    public function testblowfishEncode()
    {
    
        //execute the method and test if it returns expected values
        //it won't work with blank key, will throw an error
    
        //valid key and blank data
        $expected = '';
        $actual = blowfishEncode('test', '');
        $this->assertSame($expected, $actual);
    
        //valid key and valid data
        $expected = 'HI1/88NJJss=';
        $actual = blowfishEncode('test', 'Data');
        $this->assertSame($expected, $actual);
    }
    
    public function testblowfishDecode()
    {
    
        //execute the method and test if it returns expected values
        //it won't work with blank key, will throw an error.
    
        //valid key and blank data
        $expected = '';
        $actual = blowfishDecode('test', '');
        $this->assertSame($expected, $actual);
    
        //valid key and valid data
        $expected = 'Data';
        $actual = blowfishDecode('test', 'HI1/88NJJss=');
        $this->assertSame($expected, $actual);
    }
}
