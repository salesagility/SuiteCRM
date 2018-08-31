<?php

class SugarModuleTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function testconstructor()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $this->assertAttributeEquals(null, '_moduleName', $sugarmodule);

        //test for valid input
        $sugarmodule_user = SugarModule::get('User');
        $this->assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }

    public function testget()
    {
        //test for invalid input
        $sugarmodule = SugarModule::get('');
        $this->assertInstanceOf('SugarModule', $sugarmodule);
        $this->assertAttributeEquals(null, '_moduleName', $sugarmodule);

        //test for valid input
        $sugarmodule_user = SugarModule::get('User');
        $this->assertInstanceOf('SugarModule', $sugarmodule_user);
        $this->assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }

    public function testmoduleImplements()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->moduleImplements('Basic');
        $this->assertEquals(false, $result);

        //test for invalid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('SugarModule');
        $this->assertFalse($result);

        //test for valid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('Basic');
        $this->assertEquals(true, $result);
    }

    public function testloadBean()
    {
        //test for invalid input
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->loadBean();
        $this->assertFalse($result);

        //test for valid input
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->loadBean();
        $this->assertInstanceOf('User', $result);
    }
}
