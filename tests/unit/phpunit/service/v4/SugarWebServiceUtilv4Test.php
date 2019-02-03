<?php

namespace SuiteCRM;

use aCase;
use SugarWebServiceUtilv4_1;
use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;

class SugarWebServiceUtilv4Test extends StateCheckerPHPUnitTestCaseAbstract
{
    public function testGetFieldListParentenum()
    {
        require_once('service/v4_1/SugarWebServiceUtilv4_1.php');
        $helperObject = new SugarWebServiceUtilv4_1();
        require_once('modules/Cases/Case.php');
        $seed = new aCase();
        $module_name = 'Cases';
        $fields = array('status', 'state', 'name');
        $return = $helperObject->get_return_module_fields($seed, $module_name, $fields);
        $this->assertEquals($return['module_fields']['status']['parentenum'], 'state');
        $this->assertTrue(!isset($return['module_fields']['name']['parentenum']));
    }
}
