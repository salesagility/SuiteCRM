<?php

class DocumentRevisionTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testDocumentRevision()
    {
        //execute the contructor and check for the Object type and  attributes
        $documentRevision = new DocumentRevision();
        $this->assertInstanceOf('DocumentRevision', $documentRevision);
        $this->assertInstanceOf('SugarBean', $documentRevision);

        $this->assertAttributeEquals('DocumentRevisions', 'module_dir', $documentRevision);
        $this->assertAttributeEquals('DocumentRevision', 'object_name', $documentRevision);
        $this->assertAttributeEquals('document_revisions', 'table_name', $documentRevision);
        $this->assertAttributeEquals(true, 'new_schema', $documentRevision);
    }

    public function testSaveAndRetrieve()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        $state->pushTable('tracker');
        $state->pushGlobals();
        
        

        $documentRevision = new DocumentRevision();

        $documentRevision->document_id = '1';
        $documentRevision->doc_id = '1';
        $documentRevision->doc_type = 'text';
        $documentRevision->filename = 'test';
        $documentRevision->file_ext = 'ext';

        $documentRevision->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($documentRevision->id));
        $this->assertEquals(36, strlen($documentRevision->id));

        //test document retrieve method
        $docRev = $documentRevision->retrieve($documentRevision->id);
        $this->assertEquals('1', $docRev->document_id);
        $this->assertEquals('1', $docRev->doc_id);
        $this->assertEquals('text', $docRev->doc_type);
        $this->assertEquals('test', $docRev->filename);
        $this->assertEquals('ext', $docRev->file_ext);

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $docRev->mark_deleted($docRev->id);
        $result = $docRev->retrieve($docRev->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }

    public function testget_summary_text()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        
        $documentRevision = new DocumentRevision();

        //test without setting name
        $this->assertEquals(null, $documentRevision->get_summary_text());

        //test with name set
        $documentRevision->filename = 'test';
        $this->assertEquals('test', $documentRevision->get_summary_text());
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }

    public function testis_authenticated()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        
        $documentRevision = new DocumentRevision();

        //test wihout setting attributes
        $this->assertEquals(null, $documentRevision->is_authenticated());

        //test with attributes preset
        $documentRevision->authenticated = true;
        $this->assertEquals(true, $documentRevision->is_authenticated());
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }

    public function testfill_in_additional_list_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        
        
        
        $documentRevision = new DocumentRevision();

        //execute the method and test if it works and does not throws an exception.
        try {
            $documentRevision->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }

    public function testfill_in_additional_detail_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        
        
        
        $documentRevision = new DocumentRevision();

        //execute the method and test if it works and does not throws an exception.
        try {
            $documentRevision->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }

    public function testgetDocumentRevisionNameForDisplay()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        $documentRevision = new DocumentRevision();

        //test wihout setting attributes
        $result = $documentRevision->getDocumentRevisionNameForDisplay();
        $this->assertEquals('.', $result);

        //test with attributes preset
        $documentRevision->filename = 'test.ext';
        $documentRevision->revision = 1;
        $result = $documentRevision->getDocumentRevisionNameForDisplay();
        $this->assertEquals('-Revision_1.ext', $result);
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }

    public function testfill_document_name_revision()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        
        
        
        $documentRevision = new DocumentRevision();

        //execute the method and test if it works and does not throws an exception.
        try {
            $documentRevision->fill_document_name_revision('dummy_id');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }

    public function testlist_view_parse_additional_sections()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        
        
        
        $documentRevision = new DocumentRevision();
        
        $xTemplateSection = null;

        //execute the method and test if it works and does not throws an exception.
        try {
            $ss = new Sugar_Smarty();
            $documentRevision->list_view_parse_additional_sections($ss, $xTemplateSection);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }

    public function testget_list_view_data()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        
        $documentRevision = new DocumentRevision();
        $result = $documentRevision->get_list_view_data();
        $this->assertEquals(array('DELETED' => 0), $result);
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }

    public function testget_document_revision_name()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        $documentRevision = new DocumentRevision();
        $result = $documentRevision->get_document_revision_name(1);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }

    public function testget_document_revisions()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        $documentRevision = new DocumentRevision();
        $results = $documentRevision->get_document_revisions(1);
        $this->assertTrue(is_array($results));
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }

    public function testbean_implements()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('document_revisions');
        
        $documentRevision = new DocumentRevision();
        $this->assertEquals(false, $documentRevision->bean_implements('')); //test with blank value
        $this->assertEquals(false, $documentRevision->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $documentRevision->bean_implements('FILE')); //test with valid value
        
        // clean up
        
        $state->popTable('document_revisions');
        $state->popTable('cron_remove_documents');
        $state->popTable('aod_indexevent');
    }
}
