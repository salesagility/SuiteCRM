<?php

class ViewMetadataTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
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
        if (isset($_REQUEST)) {
            $request = $_REQUEST;
        }
        
        $state = new SuiteCRM\StateSaver();
        
        
        
        

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
        
        
        // clean up
        
        
        
        if (isset($request)) {
            $_REQUEST = $request;
        } else {
            unset($_REQUEST);
        }
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
