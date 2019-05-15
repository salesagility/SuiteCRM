<?php

class Calls_RescheduleTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testCalls_Reschedule()
    {

        //execute the contructor and check for the Object type and  attributes
        $callsReschedule = new Calls_Reschedule();
        $this->assertInstanceOf('Calls_Reschedule', $callsReschedule);
        $this->assertInstanceOf('Basic', $callsReschedule);
        $this->assertInstanceOf('SugarBean', $callsReschedule);

        $this->assertAttributeEquals('Calls_Reschedule', 'module_dir', $callsReschedule);
        $this->assertAttributeEquals('Calls_Reschedule', 'object_name', $callsReschedule);
        $this->assertAttributeEquals('calls_reschedule', 'table_name', $callsReschedule);
        $this->assertAttributeEquals(true, 'new_schema', $callsReschedule);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $callsReschedule);
        $this->assertAttributeEquals(true, 'importable', $callsReschedule);
        $this->assertAttributeEquals(false, 'tracker_visibility', $callsReschedule);
    }
}
