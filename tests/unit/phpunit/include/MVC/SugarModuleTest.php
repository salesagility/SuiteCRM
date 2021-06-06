<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SugarModuleTest extends SuitePHPUnitFrameworkTestCase
{
    public function testconstructor(): void
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        self::assertAttributeEquals(null, '_moduleName', $sugarmodule);

        //test for valid input
        $sugarmodule_user = SugarModule::get('User');
        self::assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }

    public function testget(): void
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

    public function testmoduleImplements(): void
    {
        //test for invalid input
        $result = (new SugarModule(''))->moduleImplements('Basic');
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

    public function testloadBean(): void
    {
        //test for invalid input
        $result = (new SugarModule(''))->loadBean();
        self::assertFalse($result);

        //test for valid input
        $result = (new SugarModule('Users'))->loadBean();
        self::assertInstanceOf('User', $result);
    }
}
