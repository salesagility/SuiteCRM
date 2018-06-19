<?php

class AOW_WorkFlowTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOW_WorkFlow()
    {

        
        $aowWorkFlow = new AOW_WorkFlow();
        $this->assertInstanceOf('AOW_WorkFlow', $aowWorkFlow);
        $this->assertInstanceOf('Basic', $aowWorkFlow);
        $this->assertInstanceOf('SugarBean', $aowWorkFlow);

        $this->assertAttributeEquals('AOW_WorkFlow', 'module_dir', $aowWorkFlow);
        $this->assertAttributeEquals('AOW_WorkFlow', 'object_name', $aowWorkFlow);
        $this->assertAttributeEquals('aow_workflow', 'table_name', $aowWorkFlow);
        $this->assertAttributeEquals(true, 'new_schema', $aowWorkFlow);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aowWorkFlow);
        $this->assertAttributeEquals(false, 'importable', $aowWorkFlow);
    }

    public function testbean_implements()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $aowWorkFlow = new AOW_WorkFlow();
        $this->assertEquals(false, $aowWorkFlow->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aowWorkFlow->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $aowWorkFlow->bean_implements('ACL')); //test with valid value
        
        
        
        
    }

    public function testsave()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aow_conditions');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aow_workflow');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        $state->pushGlobals();
        
        
        $aowWorkFlow = new AOW_WorkFlow();

        $aowWorkFlow->name = 'test';
        $aowWorkFlow->flow_module = 'test';

        $aowWorkFlow->save();

        
        $this->assertTrue(isset($aowWorkFlow->id));
        $this->assertEquals(36, strlen($aowWorkFlow->id));

        
        $aowWorkFlow->mark_deleted($aowWorkFlow->id);
        $result = $aowWorkFlow->retrieve($aowWorkFlow->id);
        $this->assertEquals(null, $result);
        
        
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('aow_workflow');
        $state->popTable('aod_indexevent');
        $state->popTable('aow_conditions');
    }

    public function testload_flow_beans()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $aowWorkFlow = new AOW_WorkFlow();

        
        try {
            $aowWorkFlow->load_flow_beans();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testrun_flows()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        
        $aowWorkFlow = new AOW_WorkFlow();

        $result = $aowWorkFlow->run_flows();
        $this->assertTrue($result);
        
        
        
        $state->popGlobals();
    }

    public function testrun_flow()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $aowWorkFlow = new AOW_WorkFlow();

        
        try {
            $aowWorkFlow->run_flow();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testrun_bean_flows()
    {
        $aowWorkFlow = new AOW_WorkFlow();

        

        $result = $aowWorkFlow->run_bean_flows(new AOS_Quotes());
        $this->assertTrue($result);

        $result = $aowWorkFlow->run_bean_flows(new Call());
        $this->assertTrue($result);
    }

    public function testget_flow_beans()
    {        
        
        $aowWorkFlow = new AOW_WorkFlow();
        
        
        $aowWorkFlow->flow_module = 'AOS_Quotes';
        $result = $aowWorkFlow->get_flow_beans();
        $this->assertGreaterThanOrEqual(0, count((array)$result));
    }

    public function testbuild_flow_query_join()
    {
        $aowWorkFlow = new AOW_WorkFlow();
        $query = array();

        
        $result = $aowWorkFlow->build_flow_query_join('aos_products_quotes', new AOS_Quotes(), '', array());
        $this->assertSame(array(), $result);

        
        $expected = array('join' => array('c' => 'LEFT JOIN calls_cstm c ON calls.id = c.id_c '));
        $result = $aowWorkFlow->build_flow_query_join('c', new Call(), 'custom', array());
        $this->assertSame($expected, $result);

        
        $expected = array(
                'join' => array('aos_products_quotes' => "LEFT JOIN aos_products_quotes aos_products_quotes ON aos_quotes.id=aos_products_quotes.parent_id AND aos_products_quotes.deleted=0\n\n"),
                'select' => array("aos_products_quotes.id AS 'aos_products_quotes_id'"),
        );
        $result = $aowWorkFlow->build_flow_query_join('aos_products_quotes', new AOS_Quotes(), 'relationship', array());
        $this->assertSame($expected, $result);
    }

    public function testbuild_flow_query_where()
    {
        $aowWorkFlow = new AOW_WorkFlow();

        
        $expected = array();
        $query = $aowWorkFlow->build_flow_query_where();
        $this->assertSame($expected, $query);

        
        $aowWorkFlow->id = '1';
        $aowWorkFlow->flow_module = 'Calls';
        $expected = array(
                'where' => array('NOT EXISTS (SELECT * FROM aow_processed WHERE aow_processed.aow_workflow_id=\'1\' AND aow_processed.parent_id=calls.id AND aow_processed.status = \'Complete\' AND aow_processed.deleted = 0)',
                'calls.deleted = 0 ', ),
                );
        $query = $aowWorkFlow->build_flow_query_where();
        $this->assertSame($expected, $query);

        
        $expected = array(
                        'where' => array('calls.date_entered > \'\'', 'calls.deleted = 0 '),
                    );
        $aowWorkFlow->flow_run_on = 'New_Records';
        $aowWorkFlow->multiple_runs = 1;
        $query = $aowWorkFlow->build_flow_query_where();
        $this->assertSame($expected, $query);
    }

    public function testbuild_query_where()
    {
        self::markTestIncomplete('[PHPUnit_Framework_Exception] unserialize(): Error at offset 0 of 5 bytes');
        $aowWorkFlow = new AOW_WorkFlow();

        
        $call = new Call();
        $aowCondition = new AOW_Condition();
        $aowCondition->name = 'test';
        $aowCondition->module_path = base64_encode(serialize(array('')));
        $aowCondition->field = 'name';
        $aowCondition->value = 'testval';

        
        $aowCondition->operator = 'Contains';
        $aowCondition->value_type = 'Value';
        $expected = array(
                'where' => array(".name LIKE CONCAT('%', 'testval' ,'%')"),
        );
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);

        
        $aowCondition->operator = 'Starts_With';
        $aowCondition->value_type = 'Value';

        $expected = array(
            'where' => array(".name LIKE CONCAT('testval' ,'%')"),
        );
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);

        
        $aowCondition->operator = 'Equal_To';
        $aowCondition->value_type = 'Value';

        $expected = array(
                'where' => array(".name = 'testval'"),
        );
        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);

        
        $aowCondition->operator = 'Equal_To';
        $aowCondition->value_type = 'Date';

        $expected = array(
                'where' => array('.name = DATE_ADD(calls., INTERVAL   )'),
        );
        
        



        $query = $aowWorkFlow->build_query_where($aowCondition, $call);

        
        $this->assertEquals($expected, $query);

        
        $aowCondition->operator = 'Equal_To';
        $aowCondition->value_type = 'Field';

        $expected = array(
                'where' => array('.name = calls.testval'),
        );

        $query = $aowWorkFlow->build_query_where($aowCondition, $call);
        $this->assertEquals($expected, $query);
    }

    public function testcheck_valid_bean()
    {
        $aowWorkFlow = new AOW_WorkFlow();
        $aowWorkFlow->flow_run_on = 'New_Records';

        $aosQuotes = new AOS_Quotes();

        $result = $aowWorkFlow->check_valid_bean($aosQuotes);
        $this->assertTrue($result);
    }

    public function testcompare_condition()
    {
        $aowWorkFlow = new AOW_WorkFlow();

        

        $this->assertTrue($aowWorkFlow->compare_condition(1, 1));
        $this->assertTrue($aowWorkFlow->compare_condition(1, 2, 'Not_Equal_To'));
        $this->assertTrue($aowWorkFlow->compare_condition(2, 1, 'Greater_Than'));
        $this->assertTrue($aowWorkFlow->compare_condition(1, 2, 'Less_Than'));
        $this->assertTrue($aowWorkFlow->compare_condition(5, 4, 'Greater_Than_or_Equal_To'));
        $this->assertTrue($aowWorkFlow->compare_condition(2, 3, 'Less_Than_or_Equal_To'));
        $this->assertTrue($aowWorkFlow->compare_condition('', '', 'is_null'));
        $this->assertTrue($aowWorkFlow->compare_condition('test2', array('test1', 'test2'), 'One_of'));
        $this->assertTrue($aowWorkFlow->compare_condition('test', array('test1', 'test2'), 'Not_One_of'));

        
        
        $this->assertEquals(0, $aowWorkFlow->compare_condition('test1', 'test', 'Contains'));

        
        $this->assertEquals(0, $aowWorkFlow->compare_condition('test1', 'test', 'Starts_With'));

        
        $this->assertEquals(4, $aowWorkFlow->compare_condition('test1', '1', 'Ends_With'));
    }

    public function testcheck_in_group()
    {
        $aowWorkFlow = new AOW_WorkFlow();

        
        $this->assertFalse($aowWorkFlow->check_in_group(1, 'Users', 1));
        $this->assertFalse($aowWorkFlow->check_in_group(1, 'Calls', 1));
    }

    public function testrun_actions()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aow_processed');
        $state->pushTable('tracker');
                
                
        $aowWorkFlow = new AOW_WorkFlow();

        
        $aowWorkFlow->id = 1;

        $call = new Call();
        $call->id = 1;

        
        $result = $aowWorkFlow->run_actions($call);

        
        $processed = new AOW_Processed();
        $processed->retrieve_by_string_fields(array('aow_workflow_id' => 1, 'parent_id' => 1));

        
        $this->assertTrue(isset($processed->id));
        $this->assertEquals(36, strlen($processed->id));

        
        $processed->mark_deleted($processed->id);
        $result = $processed->retrieve($processed->id);
        $this->assertEquals(null, $result);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aow_processed');
    }
}
