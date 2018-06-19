<?php

class ViewMetadataTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testdisplayCheckBoxes()
    {
        $view = new ViewMetadata();

        
        ob_start();
        $values = array();
        $view->displayCheckBoxes('test', $values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));

        
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

        
        ob_start();
        $values = array();
        $view->displaySelect('test', $values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));

        
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

        
        ob_start();
        $values = array();
        $view->displayTextBoxes($values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));

        
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
        
        if(isset($_REQUEST)) {
            $request = $_REQUEST;
        }
        
        $state = new SuiteCRM\StateSaver();
        
        
        
        

        $view = new ViewMetadata();

        
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));

        
        $_REQUEST['modules'] = array('Calls', 'Meetings');
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
        
        
        
        
        
        
        if(isset($request)) {
            $_REQUEST = $request;
        } else {
            unset($_REQUEST);
        }
    }

    public function testgetModules()
    {

        
        $modules = VardefBrowser::getModules();
        $this->assertTrue(is_array($modules));
    }

    public function testfindFieldsWithAttributes()
    {

        
        $attributes = array();
        $fields1 = VardefBrowser::findFieldsWithAttributes($attributes);
        $this->assertTrue(is_array($fields1));

        
        $attributes = array('id');
        $fields2 = VardefBrowser::findFieldsWithAttributes($attributes);
        $this->assertTrue(is_array($fields2));

        
        $attributes = array('category');
        $fields3 = VardefBrowser::findFieldsWithAttributes($attributes);
        $this->assertTrue(is_array($fields3));

        
        $this->assertNotSame($fields1, $fields2);
        $this->assertNotSame($fields1, $fields3);
        $this->assertNotSame($fields2, $fields3);
    }

    public function testfindVardefs()
    {

        
        $modules = array();
        $defs1 = VardefBrowser::findVardefs($modules);
        $this->assertTrue(is_array($defs1));

        
        $modules = array('Calls');
        $defs2 = VardefBrowser::findVardefs($modules);
        $this->assertTrue(is_array($defs2));

        
        $this->assertNotSame($defs1, $defs2);
    }

    public function testfindFieldAttributes()
    {

        
        $attributes = array();
        $fields1 = VardefBrowser::findFieldAttributes();
        $this->assertTrue(is_array($fields1));

        
        $attributes = array();
        $modules = array('Users');
        $fields2 = VardefBrowser::findFieldAttributes($attributes, $modules, true, true);
        $this->assertTrue(is_array($fields2));

        
        $attributes = array('category');
        $fields3 = VardefBrowser::findFieldAttributes($attributes);
        $this->assertTrue(is_array($fields3));

        
        $this->assertNotSame($fields1, $fields2);
        $this->assertNotSame($fields1, $fields3);
        $this->assertNotSame($fields2, $fields3);
    }
}
