<?php


class ControllerFactoryTest  extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testgetController()
    {

        //execute the method with invalid input
        $controller = ControllerFactory::getController('');
        $this->assertInstanceOf('SugarController', $controller);

        //execute the method with valid input and check if it returns correct instance
        $controller = ControllerFactory::getController('Users');
        $this->assertInstanceOf('UsersController', $controller);
        $this->assertInstanceOf('SugarController', $controller);
    }
}
