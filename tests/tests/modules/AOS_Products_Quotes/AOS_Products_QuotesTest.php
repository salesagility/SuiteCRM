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
 * Class AOS_Products_QuotesTest
 */
class AOS_Products_QuotesTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOS_Products_Quotes()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aosProductsQuotes = new AOS_Products_Quotes();
        $this->assertInstanceOf('AOS_Products_Quotes', $aosProductsQuotes);
        $this->assertInstanceOf('Basic', $aosProductsQuotes);
        $this->assertInstanceOf('SugarBean', $aosProductsQuotes);
    
        $this->assertAttributeEquals('AOS_Products_Quotes', 'module_dir', $aosProductsQuotes);
        $this->assertAttributeEquals('AOS_Products_Quotes', 'object_name', $aosProductsQuotes);
        $this->assertAttributeEquals('aos_products_quotes', 'table_name', $aosProductsQuotes);
        $this->assertAttributeEquals(true, 'new_schema', $aosProductsQuotes);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosProductsQuotes);
        $this->assertAttributeEquals(true, 'importable', $aosProductsQuotes);
    }
    
    public function testsave_lines()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aosProductsQuotes = new AOS_Products_Quotes();
    
        //populate required values
        $post_data = array();
        $post_data['name'] = array('test1', 'test2');
        $post_data['group_number'] = array('1', '2');
        $post_data['product_id'] = array('1', '1');
        $post_data['product_unit_price'] = array(100, 200);
    
        //create parent bean
        $aosQuote = new AOS_Quotes();
        $aosQuote->id = 1;
    
        $aosProductsQuotes->save_lines($post_data, $aosQuote);
    
        //get the linked beans and verify if records created
        $product_quote_lines = $aosQuote->get_linked_beans('aos_products_quotes', $aosQuote->object_name);
        $this->assertEquals(count($post_data['name']), count($product_quote_lines));
    }
    
    public function testmark_lines_deleted()
    {
        $aosProductsQuotes = new AOS_Products_Quotes();
    
        //create parent bean
        $aosQuote = new AOS_Quotes();
        $aosQuote->id = 1;
    
        //get the linked beans and get record count before deletion
        $product_quote_lines = $aosQuote->get_linked_beans('aos_products_quotes', $aosQuote->object_name);
        $expected = count($product_quote_lines);
        $product_quote_lines = null;
    
        $aosProductsQuotes->mark_lines_deleted($aosQuote);
        unset($aosQuote);
    
        //get the linked beans and get record count after deletion
        $aosQuote = new AOS_Quotes();
        $aosQuote->id = 1;
        $product_quote_lines = $aosQuote->get_linked_beans('aos_products_quotes', $aosQuote->object_name);
        $actual = count($product_quote_lines);
    
        $this->assertLessThan($expected, $actual);
    }
    
    public function testsave()
    {
        $aosProductsQuotes = new AOS_Products_Quotes();
    
        $aosProductsQuotes->name = 'test';
        $aosProductsQuotes->product_id = 1;
        $aosProductsQuotes->product_unit_price = 100;
    
        $aosProductsQuotes->save();
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosProductsQuotes->id));
        $this->assertEquals(36, strlen($aosProductsQuotes->id));
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosProductsQuotes->mark_deleted($aosProductsQuotes->id);
        $result = $aosProductsQuotes->retrieve($aosProductsQuotes->id);
        $this->assertEquals(null, $result);
    }
}
