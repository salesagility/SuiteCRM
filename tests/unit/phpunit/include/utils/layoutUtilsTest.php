<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'include/utils/layout_utils.php';
class layout_utilsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testget_form_header(): void
    {
        //execute the method and test if it returns html and contains the values provided in parameters

        //help param true
        $html1 = get_form_header('test Header', 'test subheader', true);
        self::assertGreaterThan(0, strlen($html1));
        self::assertStringContainsString('test Header', $html1);
        self::assertStringContainsString('test subheader', $html1);

        // help param false
        $html2 = get_form_header('new test Header', 'new test subheader', false);
        self::assertGreaterThan(0, strlen($html2));
        self::assertStringContainsString('new test Header', $html2);
        self::assertStringContainsString('new test subheader', $html2);
        self::assertGreaterThan(strlen($html2), strlen($html1));
    }

    public function testget_module_title(): void
    {
        //execute the method and test if it returns html and contains the values provided in parameters

        //with show_create true, generates more html
        $html1 = get_module_title('Users', 'Users Home', true);
        self::assertGreaterThan(0, strlen($html1));
        self::assertStringContainsString('Users', $html1);
        self::assertStringContainsString('Users Home', $html1);

        //with show_create false, generates less html
        $html2 = get_module_title('Users', 'Users Home', false);
        self::assertGreaterThan(0, strlen($html2));
        self::assertStringContainsString('Users', $html2);
        self::assertStringContainsString('Users Home', $html2);
        self::assertGreaterThan(strlen($html2), strlen($html1));

        //with show_create flase and count > 1, generates more html compared to count =0
        $html3 = get_module_title('Users', 'Users Home', false, 2);
        self::assertGreaterThan(0, strlen($html3));
        self::assertStringContainsString('Users', $html3);
        self::assertStringContainsString('Users Home', $html3);
        self::assertGreaterThan(strlen($html2), strlen($html3));
        self::assertGreaterThan(strlen($html3), strlen($html1));
    }

    public function testgetClassicModuleTitle(): void
    {
        //execute the method and test if it returns html and contains the values provided in parameters

        //with show_create false, generates less html
        $html1 = getClassicModuleTitle('users', array('Users Home'));
        self::assertGreaterThan(0, strlen($html1));
        self::assertStringContainsString('Users Home', $html1);

        //with show_create true, generates more html
        $html2 = getClassicModuleTitle('users', array('Users Home'), true);
        self::assertGreaterThan(0, strlen($html2));
        self::assertStringContainsString('Users Home', $html2);
        self::assertGreaterThan(strlen($html1), strlen($html2));
    }

    public function testinsert_popup_header(): void
    {
        //execute the method and test if it returns html/JS

        //with includeJS true, generates more html
        ob_start();
        insert_popup_header();
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent1));

        //with includeJS false, generates less html
        ob_start();
        insert_popup_header('', false);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent2));

        self::assertGreaterThan(strlen($renderedContent2), strlen($renderedContent1));
    }

    public function testinsert_popup_footer(): void
    {
        //execute the method and test if it returns html

        ob_start();
        insert_popup_footer();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent));
    }
}
