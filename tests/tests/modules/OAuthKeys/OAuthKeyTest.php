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
 * Class OAuthKeyTest
 */
class OAuthKeyTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testOAuthKey()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $oauthKey = new OAuthKey();
    
        $this->assertInstanceOf('OAuthKey', $oauthKey);
        $this->assertInstanceOf('Basic', $oauthKey);
        $this->assertInstanceOf('SugarBean', $oauthKey);
    
        $this->assertAttributeEquals('OAuthKeys', 'module_dir', $oauthKey);
        $this->assertAttributeEquals('OAuthKey', 'object_name', $oauthKey);
        $this->assertAttributeEquals('oauth_consumer', 'table_name', $oauthKey);
    
        $this->assertAttributeEquals(true, 'disable_row_level_security', $oauthKey);
    }
    
    public function testMain()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $oauthKey = new OAuthKey();
    
        //preset required attributes
        $oauthKey->name = 'test';
        $oauthKey->c_key = 'key';
        $oauthKey->c_secret = 'secret';
    
        $oauthKey->save();
    
        //test getByKey method
        $this->getByKey($oauthKey->c_key);
    
        //test fetchKey method
        $this->fetchKey($oauthKey->c_key);
    
        //test mark_deleted method
        $this->mark_deleted($oauthKey->id);
    }
    
    public function getByKey($key)
    {
        $oauthKey = new OAuthKey();
    
        //test with a invalid id
        $result = $oauthKey->getByKey('');
        $this->assertEquals(false, $result);
    
        //test with a valid id
        $result = $oauthKey->getByKey($key);
        $this->assertInstanceOf('OAuthKey', $result);
    }
    
    public function fetchKey($key)
    {
    
        //test with a invalid id
        $result = OAuthKey::fetchKey('');
        $this->assertEquals(false, $result);
    
        //test with a valid id
        $result = OAuthKey::fetchKey($key);
        $this->assertInstanceOf('OAuthKey', $result);
    }
    
    public function mark_deleted($id)
    {
        $oauthKey = new OAuthKey();
    
        $oauthKey->mark_deleted($id);
    
        //verify that record is deleted
        $result = $oauthKey->getByKey($id);
        $this->assertEquals(false, $result);
    }
}
