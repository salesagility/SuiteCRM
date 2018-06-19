<?php

class ViewImportvcardsaveTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function test__construct()
    {
        
        $view = new ViewImportvcardsave();
        $this->assertInstanceOf('ViewImportvcardsave', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('save', 'type', $view);
    }

    
    public function testdisplay()
    {
        
        $state = new SuiteCRM\StateSaver();
        
        
        

        $view = new ViewImportvcardsave();

        
        
        /*
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0,strlen($renderedContent));
        */

        $this->markTestIncomplete('Can Not be implemented');
        
        
        
        
        
    }
}
