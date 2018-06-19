<?php


require_once 'include/utils/layout_utils.php';
class layout_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testget_form_header()
    {
        

        

        
        $html1 = get_form_header('test Header', 'test subheader', true);
        $this->assertGreaterThan(0, strlen($html1));
        $this->assertContains('test Header', $html1);
        $this->assertContains('test subheader', $html1);


        
        $html2 = get_form_header('new test Header', 'new test subheader', false);
        $this->assertGreaterThan(0, strlen($html2));
        $this->assertContains('new test Header', $html2);
        $this->assertContains('new test subheader', $html2);
        $this->assertGreaterThan(strlen($html2), strlen($html1));
    }

    public function testget_module_title()
    {
        

        
        $html1 = get_module_title('Users', 'Users Home', true);
        $this->assertGreaterThan(0, strlen($html1));
        $this->assertContains('Users', $html1);
        $this->assertContains('Users Home', $html1);

        
        $html2 = get_module_title('Users', 'Users Home', false);
        $this->assertGreaterThan(0, strlen($html2));
        $this->assertContains('Users', $html2);
        $this->assertContains('Users Home', $html2);
        $this->assertGreaterThan(strlen($html2), strlen($html1));

        
        $html3 = get_module_title('Users', 'Users Home', false, 2);
        $this->assertGreaterThan(0, strlen($html3));
        $this->assertContains('Users', $html3);
        $this->assertContains('Users Home', $html3);
        $this->assertGreaterThan(strlen($html2), strlen($html3));
        $this->assertGreaterThan(strlen($html3), strlen($html1));
    }

    public function testgetClassicModuleTitle()
    {
        

        
        $html1 = getClassicModuleTitle('users', array('Users Home'));
        $this->assertGreaterThan(0, strlen($html1));
        $this->assertContains('Users Home', $html1);

        
        $html2 = getClassicModuleTitle('users', array('Users Home'), true);
        $this->assertGreaterThan(0, strlen($html2));
        $this->assertContains('Users Home', $html2);
        $this->assertGreaterThan(strlen($html1), strlen($html2));
    }

    public function testinsert_popup_header()
    {
        

        
        ob_start();
        insert_popup_header();
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));

        
        ob_start();
        insert_popup_header('', false);
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent2));

        $this->assertGreaterThan(strlen($renderedContent2), strlen($renderedContent1));
    }

    public function testinsert_popup_footer()
    {
        

        ob_start();
        insert_popup_footer();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
    }
}
