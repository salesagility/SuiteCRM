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
 * Class AOS_QuotesTest
 */
class AOS_QuotesTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOS_Quotes()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aosQuotes = new AOS_Quotes();
        $this->assertInstanceOf('AOS_Quotes', $aosQuotes);
        $this->assertInstanceOf('Basic', $aosQuotes);
        $this->assertInstanceOf('SugarBean', $aosQuotes);
    
        $this->assertAttributeEquals('AOS_Quotes', 'module_dir', $aosQuotes);
        $this->assertAttributeEquals('AOS_Quotes', 'object_name', $aosQuotes);
        $this->assertAttributeEquals('aos_quotes', 'table_name', $aosQuotes);
        $this->assertAttributeEquals(true, 'new_schema', $aosQuotes);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosQuotes);
        $this->assertAttributeEquals(true, 'importable', $aosQuotes);
        $this->assertAttributeEquals(true, 'lineItems', $aosQuotes);
    }
    
    public function testSaveAndMark_deleted()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aosQuotes = new AOS_Quotes();
    
        $aosQuotes->name = 'test';
        $aosQuotes->total_amt = 100;
        $aosQuotes->total_amt_usdollar = 100;
    
        $aosQuotes->save();
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosQuotes->id));
        $this->assertEquals(36, strlen($aosQuotes->id));
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosQuotes->mark_deleted($aosQuotes->id);
        $result = $aosQuotes->retrieve($aosQuotes->id);
        $this->assertEquals(null, $result);
    }
}
