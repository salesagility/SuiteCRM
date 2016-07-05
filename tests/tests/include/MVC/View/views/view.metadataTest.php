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
 * Class ViewMetadataTest
 */
class ViewMetadataTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testdisplayCheckBoxes()
    {
        $view = new ViewMetadata();
    
        //check with empty values array. it should return html sting
        ob_start();
        $values = array();
        $view->displayCheckBoxes('test', $values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));
    
        //check with prefilled values array. it should return html sting longer than earlier
        ob_start();
        $values = array('option1', 'option2');
        $view->displayCheckBoxes('test', $values);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(strlen($renderedContent1), strlen($renderedContent2));
    }
    
    public function testdisplaySelect()
    {
        $view = new ViewMetadata();
    
        //check with empty values array. it should return html sting
        ob_start();
        $values = array();
        $view->displaySelect('test', $values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));
    
        //check with prefilled values array. it should return html sting longer than earlier
        ob_start();
        $values = array('option1', 'option2');
        $view->displaySelect('test', $values);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(strlen($renderedContent1), strlen($renderedContent2));
    }
    
    public function testdisplayTextBoxes()
    {
        $view = new ViewMetadata();
    
        //check with empty values array. it should return html sting
        ob_start();
        $values = array();
        $view->displayTextBoxes($values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));
    
        //check with prefilled values array. it should return html sting longer than earlier
        ob_start();
        $values = array('option1', 'option2');
        $view->displayTextBoxes($values);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(strlen($renderedContent1), strlen($renderedContent2));
    }
    
    public function testprintValue()
    {
        $view = new ViewMetadata();
    
        ob_start();
        $values = array('option1', 'option2');
        $view->printValue($values);
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
    }
    
    public function testdisplay()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $view = new ViewMetadata();
    
        //test without setting REQUEST parameters
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
    
        //test with REQUEST parameters set
        $_REQUEST['modules'] = array('Calls', 'Meetings');
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
    }
    
    public function testgetModules()
    {
    
        //execute the method and test if it returns a array.
        $modules = VardefBrowser::getModules();
        $this->assertTrue(is_array($modules));
    }
    
    public function testfindFieldsWithAttributes()
    {
    
        //check with emptty attributes array
        $attributes = array();
        $fields1 = VardefBrowser::findFieldsWithAttributes($attributes);
        $this->assertTrue(is_array($fields1));
    
        //check with a very common attribute
        $attributes = array('id');
        $fields2 = VardefBrowser::findFieldsWithAttributes($attributes);
        $this->assertTrue(is_array($fields2));
    
        //check with a very specific attribute
        $attributes = array('category');
        $fields3 = VardefBrowser::findFieldsWithAttributes($attributes);
        $this->assertTrue(is_array($fields3));
    
        //check that all three arrays returned, are not same.
        $this->assertNotSame($fields1, $fields2);
        $this->assertNotSame($fields1, $fields3);
        $this->assertNotSame($fields2, $fields3);
    }
    
    public function testfindVardefs()
    {
    
        //check with empty modules array
        $modules = array();
        $defs1 = VardefBrowser::findVardefs($modules);
        $this->assertTrue(is_array($defs1));
    
        //check with modules array set.
        $modules = array('Calls');
        $defs2 = VardefBrowser::findVardefs($modules);
        $this->assertTrue(is_array($defs2));
    
        //check that two arrays returned, are not same.
        $this->assertNotSame($defs1, $defs2);
    }
    
    public function testfindFieldAttributes()
    {
    
        //check with emptty attributes array
        $attributes = array();
        $fields1 = VardefBrowser::findFieldAttributes();
        $this->assertTrue(is_array($fields1));
    
        //check with emptty attributes array and prefilled modules array.
        $attributes = array();
        $modules = array('Users');
        $fields2 = VardefBrowser::findFieldAttributes($attributes, $modules, true, true);
        $this->assertTrue(is_array($fields2));
    
        //check with a very specific attribute and empty modules array.
        $attributes = array('category');
        $fields3 = VardefBrowser::findFieldAttributes($attributes);
        $this->assertTrue(is_array($fields3));
    
        //check that all three arrays returned, are not same.
        $this->assertNotSame($fields1, $fields2);
        $this->assertNotSame($fields1, $fields3);
        $this->assertNotSame($fields2, $fields3);
    }
}
