<?php

class FP_Event_LocationsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testFP_Event_Locations()
    {
        //execute the contructor and check for the Object type and  attributes
        $fpEventLoc = new FP_Event_Locations();
        $this->assertInstanceOf('FP_Event_Locations', $fpEventLoc);
        $this->assertInstanceOf('Basic', $fpEventLoc);
        $this->assertInstanceOf('SugarBean', $fpEventLoc);

        $this->assertAttributeEquals('FP_Event_Locations', 'module_dir', $fpEventLoc);
        $this->assertAttributeEquals('FP_Event_Locations', 'object_name', $fpEventLoc);
        $this->assertAttributeEquals('fp_event_locations', 'table_name', $fpEventLoc);
        $this->assertAttributeEquals(true, 'new_schema', $fpEventLoc);
        $this->assertAttributeEquals(false, 'importable', $fpEventLoc);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $fpEventLoc);
    }
}
