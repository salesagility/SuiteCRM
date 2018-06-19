<?php


class ControllerFactoryTest  extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testgetController()
    {

        
        $controller = ControllerFactory::getController('');
        $this->assertInstanceOf('SugarController', $controller);

        
        $controller = ControllerFactory::getController('Users');
        $this->assertInstanceOf('UsersController', $controller);
        $this->assertInstanceOf('SugarController', $controller);
    }
}
