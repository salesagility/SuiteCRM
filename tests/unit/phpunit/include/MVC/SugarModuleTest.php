<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SugarModuleTest extends SuitePHPUnitFrameworkTestCase
{
    public function testconstructor()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        self::assertAttributeEquals(null, '_moduleName', $sugarmodule);

        //test for valid input
        $sugarmodule_user = SugarModule::get('User');
        self::assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }

    public function testget()
    {
        //test for invalid input
        $sugarmodule = SugarModule::get('');
        self::assertInstanceOf('SugarModule', $sugarmodule);
        self::assertAttributeEquals(null, '_moduleName', $sugarmodule);

        //test for valid input
        $sugarmodule_user = SugarModule::get('User');
        self::assertInstanceOf('SugarModule', $sugarmodule_user);
        self::assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }

    public function testmoduleImplements()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->moduleImplements('Basic');
        self::assertEquals(false, $result);

        //test for invalid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('SugarModule');
        self::assertFalse($result);

        //test for valid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('Basic');
        self::assertEquals(true, $result);
    }

    public function testloadBean()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->loadBean();
        self::assertFalse($result);

        //test for valid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->loadBean();
        self::assertInstanceOf('User', $result);
    }
}
