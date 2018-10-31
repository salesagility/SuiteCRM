<?php

class AOS_Line_Item_GroupsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOS_Line_Item_Groups()
    {

        //execute the contructor and check for the Object type and  attributes
        $aosLineItemGroup = new AOS_Line_Item_Groups();
        $this->assertInstanceOf('AOS_Line_Item_Groups', $aosLineItemGroup);
        $this->assertInstanceOf('Basic', $aosLineItemGroup);
        $this->assertInstanceOf('SugarBean', $aosLineItemGroup);

        $this->assertAttributeEquals('AOS_Line_Item_Groups', 'module_dir', $aosLineItemGroup);
        $this->assertAttributeEquals('AOS_Line_Item_Groups', 'object_name', $aosLineItemGroup);
        $this->assertAttributeEquals('aos_line_item_groups', 'table_name', $aosLineItemGroup);
        $this->assertAttributeEquals(true, 'new_schema', $aosLineItemGroup);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosLineItemGroup);
        $this->assertAttributeEquals(true, 'importable', $aosLineItemGroup);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aosLineItemGroup);
    }

    public function testsave_groups()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aos_line_item_groups');
        $state->pushTable('tracker');
        $state->pushTable('aod_index');
        
        //error_reporting(E_ERROR | E_PARSE);

        $aosLineItemGroup = new AOS_Line_Item_Groups();

        //populate required values
        $post_data = array();
        $post_data['group_number'] = array(0, 0);
        $post_data['name'] = array('test1', 'test2');
        $post_data['total_amount'] = array('100', '200');
        $post_data['total_amount_usdollar'] = array('100', '200');

        //create parent bean for line item groups
        $aosContract = new AOS_Contracts();
        $aosContract->id = 1;

        $aosLineItemGroup->save_groups($post_data, $aosContract);

        //get the linked beans and verify if records created
        $line_item_groups = $aosContract->get_linked_beans('aos_line_item_groups', $aosContract->object_name);

        //cleanup afterwards
        foreach ($line_item_groups as $lineItem) {
            $lineItem->mark_deleted($lineItem->id);
        }
        
        // clean up
        
        $state->popTable('aod_index');
        $state->popTable('tracker');
        $state->popTable('aos_line_item_groups');
    }

    public function testsave()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aos_line_item_groups');
        $state->pushTable('tracker');
        
        
        $aosLineItemGroup = new AOS_Line_Item_Groups();
        $aosLineItemGroup->name = 'test';
        $aosLineItemGroup->total_amount = 100;
        $aosLineItemGroup->total_amount_usdollar = 100;

        $aosLineItemGroup->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosLineItemGroup->id));
        $this->assertEquals(36, strlen($aosLineItemGroup->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosLineItemGroup->mark_deleted($aosLineItemGroup->id);
        $result = $aosLineItemGroup->retrieve($aosLineItemGroup->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('aos_line_item_groups');
    }
}
