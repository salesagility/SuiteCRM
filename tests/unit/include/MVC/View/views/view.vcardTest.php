<?php


class ViewVcardTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testdisplay()
    {
        

        $view = new ViewVcard();
        $view->module = 'Contacts';
        $view->bean = new Contact();

        
        try {
            $view->display();
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $this->assertStringStartsWith('Cannot modify header information', $msg, $msg . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertInstanceOf('ViewVcard', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
    }
}
