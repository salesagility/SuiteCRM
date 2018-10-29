<?php

require_once 'modules/Audit/Audit.php';
class AuditTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAudit()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        //execute the contructor and check for the Object type and  attributes
        $audit = new Audit();
        $this->assertInstanceOf('Audit', $audit);
        $this->assertInstanceOf('SugarBean', $audit);
        $this->assertAttributeEquals('Audit', 'module_dir', $audit);
        $this->assertAttributeEquals('Audit', 'object_name', $audit);
        
        // clean up
        
        
    }

    public function testget_summary_text()
    {
        $audit = new Audit();

        //test without setting name
        $this->assertEquals(null, $audit->get_summary_text());

        //test with name set
        $audit->name = 'test';
        $this->assertEquals('test', $audit->get_summary_text());
    }

    public function testcreate_export_query()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $audit = new Audit();

        //execute the method and test if it works and does not throws an exception.
        try {
            $audit->create_export_query('', '');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        // clean up
        
        
    }

    public function testfill_in_additional_list_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try {
            $audit->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        // clean up
        
        
    }

    public function testfill_in_additional_detail_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try {
            $audit->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        // clean up
        
        
    }

    public function testfill_in_additional_parent_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try {
            $audit->fill_in_additional_parent_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        // clean up
        
        
    }

    public function testget_list_view_data()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try {
            $audit->get_list_view_data();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        // clean up
        
        
    }

    public function testget_audit_link()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try {
            $audit->get_audit_link();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        // clean up
        
        
    }

    public function testget_audit_list()
    {
        global $focus;
        $focus = new Account(); //use audit enabbled module object

        $audit = new Audit();

        //execute the method and verify that it returns an array
        $result = $audit->get_audit_list();
        $this->assertTrue(is_array($result));
    }

    public function testgetAssociatedFieldName()
    {
        global $focus;
        $focus = new Account(); //use audit enabbled module object

        $audit = new Audit();

        //test with name field
        $result = $audit->getAssociatedFieldName('name', '1');
        $this->assertEquals('1', $result);

        //test with parent_id field
        $result = $audit->getAssociatedFieldName('parent_id', '1');
        $this->assertEquals(null, $result);
    }
}
