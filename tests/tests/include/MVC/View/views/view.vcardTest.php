<?php


class ViewVcardTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testdisplay()
    {
        //execute the method with required child objects preset and check for the Object type and type attribute

        $view = new ViewVcard();
        $view->module = 'Contacts';
        $view->bean = new Contact();

        //execute the method and test if it works and does not throws an exception other than headers output exception.
        
        ob_start();
        
        try {
            $view->display();
        } catch (Exception $e) {
            $this->assertStringStartsWith('Cannot modify header information', $e->getMessage());
        }
        
        $contents = ob_get_clean();
        $this->assertEquals($contents, 'BEGIN:VCARD
N;CHARSET=utf-8:;;;
FN;CHARSET=utf-8:  
TEL;WORK;FAX:
TEL;HOME:
TEL;CELL:
TEL;WORK:
EMAIL;INTERNET:
ADR;WORK;CHARSET=utf-8:;;;;;;
ORG;CHARSET=utf-8:;
TITLE:
END:VCARD
');

        $this->assertInstanceOf('ViewVcard', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
    }
}
