<?php

require_once 'include/utils/activity_utils.php';

class activity_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{

    public function setUp()
    {
        parent::setUp();

        global $current_user;
        $current_user = new User();
        get_sugar_config_defaults();
    }

    public function testbuild_related_list_by_user_id()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        
        

        

        
        $bean = new User();
        $bean->rel_users_table = 'users_signatures';
        $list = build_related_list_by_user_id($bean, '1', '');
        $this->assertTrue(is_array($list));

        
        $bean = new Meeting();
        $list = build_related_list_by_user_id($bean, '1', '');
        $this->assertTrue(is_array($list));
        
        
        $state->popGlobals();
        
    }
}
