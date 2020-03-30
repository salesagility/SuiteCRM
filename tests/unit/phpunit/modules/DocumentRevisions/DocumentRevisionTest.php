<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class DocumentRevisionTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testDocumentRevision()
    {
        // Execute the constructor and check for the Object type and  attributes
        $documentRevision = BeanFactory::newBean('DocumentRevisions');
        $this->assertInstanceOf('DocumentRevision', $documentRevision);
        $this->assertInstanceOf('SugarBean', $documentRevision);

        $this->assertAttributeEquals('DocumentRevisions', 'module_dir', $documentRevision);
        $this->assertAttributeEquals('DocumentRevision', 'object_name', $documentRevision);
        $this->assertAttributeEquals('document_revisions', 'table_name', $documentRevision);
        $this->assertAttributeEquals(true, 'new_schema', $documentRevision);
    }

    public function testSaveAndRetrieve()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');

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
    }

    public function testget_summary_text()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');

        //test without setting name
        $this->assertEquals(null, $documentRevision->get_summary_text());

        //test with name set
        $documentRevision->filename = 'test';
        $this->assertEquals('test', $documentRevision->get_summary_text());
    }

    public function testis_authenticated()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');

        //test wihout setting attributes
        $this->assertEquals(null, $documentRevision->is_authenticated());

        //test with attributes preset
        $documentRevision->authenticated = true;
        $this->assertEquals(true, $documentRevision->is_authenticated());
    }

    public function testfill_in_additional_list_fields()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $documentRevision->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfill_in_additional_detail_fields()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $documentRevision->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testgetDocumentRevisionNameForDisplay()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');

        //test wihout setting attributes
        $result = $documentRevision->getDocumentRevisionNameForDisplay();
        $this->assertEquals('.', $result);

        //test with attributes preset
        $documentRevision->filename = 'test.ext';
        $documentRevision->revision = 1;
        $result = $documentRevision->getDocumentRevisionNameForDisplay();
        $this->assertEquals('-Revision_1.ext', $result);
    }

    public function testfill_document_name_revision()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $documentRevision->fill_document_name_revision('dummy_id');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testlist_view_parse_additional_sections()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');
        
        $xTemplateSection = null;

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $ss = new Sugar_Smarty();
            $documentRevision->list_view_parse_additional_sections($ss, $xTemplateSection);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testget_list_view_data()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');
        $result = $documentRevision->get_list_view_data();
        $this->assertEquals(array('DELETED' => 0), $result);
    }

    public function testget_document_revision_name()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');
        $result = $documentRevision->get_document_revision_name(1);
        $this->assertEquals(null, $result);
    }

    public function testget_document_revisions()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');
        $results = $documentRevision->get_document_revisions(1);
        $this->assertTrue(is_array($results));
    }

    public function testbean_implements()
    {
        $documentRevision = BeanFactory::newBean('DocumentRevisions');
        $this->assertEquals(false, $documentRevision->bean_implements('')); //test with blank value
        $this->assertEquals(false, $documentRevision->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $documentRevision->bean_implements('FILE')); //test with valid value
    }
}
