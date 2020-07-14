<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'include/utils/activity_utils.php';

class activity_utilsTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        $current_user = BeanFactory::newBean('Users');
        get_sugar_config_defaults();
    }

    public function testbuild_related_list_by_user_id()
    {
        //execute the method and test if it returns true

        //with rel_users_table manually set
        $bean = BeanFactory::newBean('Users');
        $bean->rel_users_table = 'users_signatures';
        $list = build_related_list_by_user_id($bean, '1', '');
        $this->assertTrue(is_array($list));

        //with rel_users_table set by default
        $bean = BeanFactory::newBean('Meetings');
        $list = build_related_list_by_user_id($bean, '1', '');
        $this->assertTrue(is_array($list));
    }
}
