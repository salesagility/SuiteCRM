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
 * Class SugarModuleTest
 */
class SugarModuleTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testconstructor()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $this->assertAttributeEquals(null, '_moduleName', $sugarmodule);
    
        //test for valid input
        $sugarmodule_user = SugarModule::get('User');
        $this->assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }
    
    public function testget()
    {
        //test for invalid input
        $sugarmodule = SugarModule::get('');
        $this->assertInstanceOf('SugarModule', $sugarmodule);
        $this->assertAttributeEquals(null, '_moduleName', $sugarmodule);
    
        //test for valid input
        $sugarmodule_user = SugarModule::get('User');
        $this->assertInstanceOf('SugarModule', $sugarmodule_user);
        $this->assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }
    
    public function testmoduleImplements()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->moduleImplements('Basic');
        $this->assertEquals(false, $result);
    
        //test for invalid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('SugarModule');
        $this->assertFalse($result);
    
        //test for valid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('Basic');
        $this->assertEquals(true, $result);
    }
    
    public function testloadBean()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->loadBean();
        $this->assertFalse($result);
    
        //test for valid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->loadBean();
        $this->assertInstanceOf('User', $result);
    }
}
