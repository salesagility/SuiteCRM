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
        
        
        

        
        $audit = new Audit();
        $this->assertInstanceOf('Audit', $audit);
        $this->assertInstanceOf('SugarBean', $audit);
        $this->assertAttributeEquals('Audit', 'module_dir', $audit);
        $this->assertAttributeEquals('Audit', 'object_name', $audit);
        
        
        
        
    }

    public function testget_summary_text()
    {
        $audit = new Audit();

        
        $this->assertEquals(null, $audit->get_summary_text());

        
        $audit->name = 'test';
        $this->assertEquals('test', $audit->get_summary_text());
    }

    public function testcreate_export_query()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $audit = new Audit();

        
        try {
            $audit->create_export_query('', '');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        
        
        
    }

    public function testfill_in_additional_list_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $audit = new Audit();
        
        try {
            $audit->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        
        
        
    }

    public function testfill_in_additional_detail_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $audit = new Audit();
        
        try {
            $audit->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        
        
        
    }

    public function testfill_in_additional_parent_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $audit = new Audit();
        
        try {
            $audit->fill_in_additional_parent_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        
        
        
    }

    public function testget_list_view_data()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $audit = new Audit();
        
        try {
            $audit->get_list_view_data();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        
        
        
    }

    public function testget_audit_link()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $audit = new Audit();
        
        try {
            $audit->get_audit_link();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('method has no implementation');
        
        
        
        
    }

    public function testget_audit_list()
    {
        global $focus;
        $focus = new Account(); //use audit enabbled module object

        $audit = new Audit();

        
        $result = $audit->get_audit_list();
        $this->assertTrue(is_array($result));
    }

    public function testgetAssociatedFieldName()
    {
        global $focus;
        $focus = new Account(); //use audit enabbled module object

        $audit = new Audit();

        
        $result = $audit->getAssociatedFieldName('name', '1');
        $this->assertEquals('1', $result);

        
        $result = $audit->getAssociatedFieldName('parent_id', '1');
        $this->assertEquals(null, $result);
    }
}
