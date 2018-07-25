<?php

class SugarWebServiceUtilv4Test extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {

    public function testGet_field_list_parentenum() {
        require_once('service/v4_1/SugarWebServiceUtilv4_1.php');
        $helperObject = new SugarWebServiceUtilv4_1();
        require_once('modules/Cases/Case.php');
        $seed = new aCase();
        $module_name = 'Cases';
        $fields = array('status', 'state');
        $return = $helperObject->get_return_module_fields($seed, $module_name, $fields);
        $this->assertEquals($return['module_fields']['status']['parentenum'], 'state');
    }

}
