<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewPopupTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testViewPopup(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewPopup();
        self::assertInstanceOf('ViewPopup', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertEquals('list', $view->type);

        unset($view);
    }

    public function testdisplay(): void
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

        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }

    public function testdisplayGetModulePopupPickerIfNoListviewsSearchDefs(): void
    {
        $view = new ViewPopup();
        $view->module = 'Audit'; // Confirms has no listview/searchdefs

        $customPath = 'custom/modules/' . $view->module . '/Popup_picker.php';
        $modulePath = 'modules/' . $view->module . '/Popup_picker.php';

        // test no custom module Popup picker
        // test module Popup picker exists

        self::assertFileNotExists($customPath);

        $result = get_custom_file_if_exists($modulePath);

        self::assertSame($modulePath, $result);

        // Now add a custom module Popup picker

        // Create mock file
        // @TODO set up vfsStream and test get_custom_file_if_exists

        $dirname = dirname($customPath);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        file_put_contents($customPath, '');

        self::assertFileExists($customPath);

        $result = get_custom_file_if_exists($modulePath);

        self::assertSame($customPath, $result);

        // Cleanup
        unlink($customPath);
        rmdir($dirname);
    }

    public function testdisplayGetCustomDefaultPopupPickerIdNoModulePopupPicker(): void
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

        self::assertFalse($result2);

        self::assertFileNotExists($customPath);
        self::assertFileExists($defaultPath);

        $result = get_custom_file_if_exists($defaultPath);

        self::assertSame($defaultPath, $result);

        // Now add a custom Popup picker

        // Create mock file
        // @TODO set up vfsStream and test get_custom_file_if_exists

        $dirname = dirname($customPath);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        file_put_contents($customPath, '');

        self::assertFileExists($customPath);

        $result = get_custom_file_if_exists($defaultPath);

        self::assertSame($customPath, $result);

        // Cleanup
        unlink($customPath);
        rmdir($dirname);
    }
}
