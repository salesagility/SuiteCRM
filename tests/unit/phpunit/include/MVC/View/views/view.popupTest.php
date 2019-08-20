<?php

class ViewPopupTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewPopup()
    {

        //execute the contructor and check for the Object type and type attribute
        $view = new ViewPopup();
        $this->assertInstanceOf('ViewPopup', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);

        unset($view);
    }

    public function testdisplay()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        //execute the method with required child objects preset. it should return some html.
        $view = new ViewPopup();
        $view->module = 'Accounts';

        try {
            $view->bean = BeanFactory::getBean('Accounts');
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
        }

        // clean up

        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }

    public function testdisplayGetModulePopupPickerIfNoListviewsSearchDefs()
    {
        $view = new ViewPopup();
        $view->module = 'Audit'; // Confirms has no listview/searchdefs

        $customPath = 'custom/modules/' . $view->module . '/Popup_picker.php';
        $modulePath = 'modules/' . $view->module . '/Popup_picker.php';

        // test no custom module Popup picker
        // test module Popup picker exists

        $this->assertFileNotExists($customPath);

        $result = get_custom_file_if_exists($modulePath);

        $this->assertSame($modulePath, $result);

        // Now add a custom module Popup picker

        // Create mock file
        // @TODO set up vfsStream and test get_custom_file_if_exists

        $dirname = dirname($customPath);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        file_put_contents($customPath, '');

        $this->assertFileExists($customPath);

        $result = get_custom_file_if_exists($modulePath);

        $this->assertSame($customPath, $result);

        // Cleanup
        unlink($customPath);
        rmdir($dirname);
    }

    public function testdisplayGetCustomDefaultPopupPickerIdNoModulePopupPicker()
    {
        $view = new ViewPopup();
        $view->module = 'Accounts'; // Confirms has no Popup_picker

        $modulePath = 'modules/' . $view->module . '/Popup_picker.php';
        $customPath = 'custom/include/Popups/Popup_picker.php';
        $defaultPath = 'include/Popups/Popup_picker.php';

        // test no module Popup picker
        // test default Popup picker exists
        // test no custom default Popup picker exists

        $result1 = get_custom_file_if_exists($modulePath);
        $result2 = file_exists($result1);

        $this->assertFalse($result2);

        $this->assertFileNotExists($customPath);
        $this->assertFileExists($defaultPath);

        $result = get_custom_file_if_exists($defaultPath);

        $this->assertSame($defaultPath, $result);

        // Now add a custom Popup picker

        // Create mock file
        // @TODO set up vfsStream and test get_custom_file_if_exists

        $dirname = dirname($customPath);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        file_put_contents($customPath, '');

        $this->assertFileExists($customPath);

        $result = get_custom_file_if_exists($defaultPath);

        $this->assertSame($customPath, $result);

        // Cleanup
        unlink($customPath);
        rmdir($dirname);
    }
}
