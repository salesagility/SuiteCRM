<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewMetadataTest extends SuitePHPUnitFrameworkTestCase
{
    public function testdisplayCheckBoxes(): void
    {
        $view = new ViewMetadata();

        //check with empty values array. it should return html sting
        ob_start();
        $values = array();
        $view->displayCheckBoxes('test', $values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent1));

        //check with prefilled values array. it should return html sting longer than earlier
        ob_start();
        $values = array('option1', 'option2');
        $view->displayCheckBoxes('test', $values);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(strlen($renderedContent1), strlen($renderedContent2));
    }

    public function testdisplaySelect(): void
    {
        $view = new ViewMetadata();

        //check with empty values array. it should return html sting
        ob_start();
        $values = array();
        $view->displaySelect('test', $values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent1));

        //check with prefilled values array. it should return html sting longer than earlier
        ob_start();
        $values = array('option1', 'option2');
        $view->displaySelect('test', $values);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(strlen($renderedContent1), strlen($renderedContent2));
    }

    public function testdisplayTextBoxes(): void
    {
        $view = new ViewMetadata();

        //check with empty values array. it should return html sting
        ob_start();
        $values = array();
        $view->displayTextBoxes($values);
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent1));

        //check with prefilled values array. it should return html sting longer than earlier
        ob_start();
        $values = array('option1', 'option2');
        $view->displayTextBoxes($values);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(strlen($renderedContent1), strlen($renderedContent2));
    }

    public function testprintValue(): void
    {
        $view = new ViewMetadata();

        ob_start();
        $values = array('option1', 'option2');
        $view->printValue($values);
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent));
    }

    public function testdisplay(): void
    {
        if (isset($_REQUEST)) {
            $request = $_REQUEST;
        }







        $view = new ViewMetadata();

        //test without setting REQUEST parameters
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent));

        //test with REQUEST parameters set
        $_REQUEST['modules'] = array('Calls', 'Meetings');
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent));

        if (isset($request)) {
            $_REQUEST = $request;
        } else {
            unset($_REQUEST);
        }
    }

    public function testgetModules(): void
    {
        //execute the method and test if it returns a array.
        $modules = VardefBrowser::getModules();
        self::assertIsArray($modules);
    }

    public function testfindFieldsWithAttributes(): void
    {
        //check with emptty attributes array
        $attributes = array();
        $fields1 = VardefBrowser::findFieldsWithAttributes($attributes);
        self::assertIsArray($fields1);

        //check with a very common attribute
        $attributes = array('id');
        $fields2 = VardefBrowser::findFieldsWithAttributes($attributes);
        self::assertIsArray($fields2);

        //check with a very specific attribute
        $attributes = array('category');
        $fields3 = VardefBrowser::findFieldsWithAttributes($attributes);
        self::assertIsArray($fields3);

        //check that all three arrays returned, are not same.
        self::assertNotSame($fields1, $fields2);
        self::assertNotSame($fields1, $fields3);
        self::assertNotSame($fields2, $fields3);
    }

    public function testfindVardefs(): void
    {
        //check with empty modules array
        $modules = array();
        $defs1 = VardefBrowser::findVardefs($modules);
        self::assertIsArray($defs1);

        //check with modules array set.
        $modules = array('Calls');
        $defs2 = VardefBrowser::findVardefs($modules);
        self::assertIsArray($defs2);

        //check that two arrays returned, are not same.
        self::assertNotSame($defs1, $defs2);
    }

    public function testfindFieldAttributes(): void
    {
        //check with emptty attributes array
        $attributes = array();
        $fields1 = VardefBrowser::findFieldAttributes();
        self::assertIsArray($fields1);

        //check with emptty attributes array and prefilled modules array.
        $attributes = array();
        $modules = array('Users');
        $fields2 = VardefBrowser::findFieldAttributes($attributes, $modules, true, true);
        self::assertIsArray($fields2);

        //check with a very specific attribute and empty modules array.
        $attributes = array('category');
        $fields3 = VardefBrowser::findFieldAttributes($attributes);
        self::assertIsArray($fields3);

        //check that all three arrays returned, are not same.
        self::assertNotSame($fields1, $fields2);
        self::assertNotSame($fields1, $fields3);
        self::assertNotSame($fields2, $fields3);
    }
}
