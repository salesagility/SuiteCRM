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
 * Class AOS_ProductsTest
 */
class AOS_ProductsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOS_Products()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aosProducts = new AOS_Products();
        $this->assertInstanceOf('AOS_Products', $aosProducts);
        $this->assertInstanceOf('Basic', $aosProducts);
        $this->assertInstanceOf('SugarBean', $aosProducts);
    
        $this->assertAttributeEquals('AOS_Products', 'module_dir', $aosProducts);
        $this->assertAttributeEquals('AOS_Products', 'object_name', $aosProducts);
        $this->assertAttributeEquals('aos_products', 'table_name', $aosProducts);
        $this->assertAttributeEquals(true, 'new_schema', $aosProducts);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosProducts);
        $this->assertAttributeEquals(true, 'importable', $aosProducts);
    }
    
    public function testsave()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aosProducts = new AOS_Products();
    
        $aosProducts->name = 'test';
        $aosProducts->category = 1;
        $aosProducts->product_image = 'test img';
        $_POST['deleteAttachment'] = '1';
    
        $aosProducts->save();
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosProducts->id));
        $this->assertEquals(36, strlen($aosProducts->id));
        $this->assertEquals('', $aosProducts->product_image);
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosProducts->mark_deleted($aosProducts->id);
        $result = $aosProducts->retrieve($aosProducts->id);
        $this->assertEquals(null, $result);
    }
    
    public function testgetCustomersPurchasedProductsQuery()
    {
        $aosProducts = new AOS_Products();
        $aosProducts->id = 1;
    
        //execute the method and verify that it returns expected results
        $expected = "SELECT * FROM (
 				SELECT
					aos_quotes.*,
					accounts.id AS account_id,
					accounts.name AS billing_account,

					opportunity_id AS opportunity,
					billing_contact_id AS billing_contact,
					'' AS created_by_name,
					'' AS modified_by_name,
					'' AS assigned_user_name
				FROM
					aos_products

				JOIN aos_products_quotes ON aos_products_quotes.product_id = aos_products.id AND aos_products.id = '1' AND aos_products_quotes.deleted = 0 AND aos_products.deleted = 0
				JOIN aos_quotes ON aos_quotes.id = aos_products_quotes.parent_id AND aos_quotes.stage = 'Closed Accepted' AND aos_quotes.deleted = 0
				JOIN accounts ON accounts.id = aos_quotes.billing_account_id -- AND accounts.deleted = 0

				GROUP BY accounts.id
			) AS aos_quotes";
        $actual = $aosProducts->getCustomersPurchasedProductsQuery();
        $this->assertSame(trim($expected), trim($actual));
    }
}
