<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ControllerFactoryTest extends SuitePHPUnitFrameworkTestCase
{
    public function testgetController()
    {
        //execute the method with invalid input
        $controller = ControllerFactory::getController('');
        self::assertInstanceOf('SugarController', $controller);

        //execute the method with valid input and check if it returns correct instance
        $controller = ControllerFactory::getController('Users');
        self::assertInstanceOf('UsersController', $controller);
        self::assertInstanceOf('SugarController', $controller);
    }
}
