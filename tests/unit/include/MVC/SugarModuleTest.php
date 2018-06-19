<?php

class SugarModuleTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testconstructor()
    {
        
        $sugarmodule = new SugarModule('');
        $this->assertAttributeEquals(null, '_moduleName', $sugarmodule);

        
        $sugarmodule_user = SugarModule::get('User');
        $this->assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }

    public function testget()
    {
        
        $sugarmodule = SugarModule::get('');
        $this->assertInstanceOf('SugarModule', $sugarmodule);
        $this->assertAttributeEquals(null, '_moduleName', $sugarmodule);

        
        $sugarmodule_user = SugarModule::get('User');
        $this->assertInstanceOf('SugarModule', $sugarmodule_user);
        $this->assertAttributeEquals('User', '_moduleName', $sugarmodule_user);
    }

    public function testmoduleImplements()
    {
        
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->moduleImplements('Basic');
        $this->assertEquals(false, $result);

        
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('SugarModule');
        $this->assertFalse($result);

        
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->moduleImplements('Basic');
        $this->assertEquals(true, $result);
    }

    public function testloadBean()
    {
        
        $sugarmodule = new SugarModule('');
        $result = $sugarmodule->loadBean();
        $this->assertFalse($result);

        
        $sugarmodule_user = new SugarModule('Users');
        $result = $sugarmodule_user->loadBean();
        $this->assertInstanceOf('User', $result);
    }
}
