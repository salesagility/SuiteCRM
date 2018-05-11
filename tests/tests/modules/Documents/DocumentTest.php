<?php


class DocumentTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testDocument()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        

        //execute the contructor and check for the Object type and  attributes
        $document = new Document();
        $this->assertInstanceOf('Document', $document);
        $this->assertInstanceOf('File', $document);
        $this->assertInstanceOf('SugarBean', $document);

        $this->assertAttributeEquals('Documents', 'module_dir', $document);
        $this->assertAttributeEquals('Document', 'object_name', $document);
        $this->assertAttributeEquals('documents', 'table_name', $document);
        $this->assertAttributeEquals(true, 'new_schema', $document);
        $this->assertAttributeEquals(false, 'disable_row_level_security', $document);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testSaveAndGet_document_name()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushTable('cron_remove_documents');
        $state->pushTable('documents');
        $state->pushGlobals();
        
        // test
        

        $document = new Document();

        $document->filename = 'test';
        $document->file_url = 'test_url';
        $document->file_url_noimage = 'test_image_url';
        $document->last_rev_created_name = 'test';
        $document->category_id = '1';
        $document->subcategory_id = '1';
        $document->document_name = 'test';

        $document->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($document->id));
        $this->assertEquals(36, strlen($document->id));

        //execute Get_document_name() method and verify it gets the name correctly
        $this->assertEquals(null, $document->get_document_name(1));
        $this->assertEquals('test', $document->get_document_name($document->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $document->mark_deleted($document->id);
        $result = $document->retrieve($document->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('documents');
        $state->popTable('cron_remove_documents');
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testget_summary_text()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();

        //test without setting name
        $this->assertEquals(null, $document->get_summary_text());

        //test with name set
        $document->document_name = 'test';
        $this->assertEquals('test', $document->get_summary_text());
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testis_authenticated()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();

        //test without presetting attributes
        $this->assertEquals(null, $document->is_authenticated());

        //test with attributes preset
        $document->authenticated = true;
        $this->assertEquals(true, $document->is_authenticated());
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testfill_in_additional_list_fields()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();

        //execute the method and test if it works and does not throws an exception.
        try {
            $document->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testfill_in_additional_detail_fields()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();
        $current_theme = SugarThemeRegistry::current();
        $document->id = 'abcde-12345';

        //execute the method with attributes preset and verify attributes are set accordingly
        $document->fill_in_additional_detail_fields();

        // test the urls instead of the a tag itself
        $this->assertRegExp('~/images/def_image_inline~', $document->file_url);
        $this->assertRegExp('~index.php\?entryPoint=download&id=&type=Documents~', $document->file_url);
        //
        $this->assertEquals('index.php?entryPoint=download&type=Documents&id=', $document->file_url_noimage);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testlist_view_parse_additional_sections()
    {
        $this->markTestIncomplete('Undefined variable: xTemplateSection');
        
        $document = new Document();

        //execute the method and test if it works and does not throws an exception.
        try {
            $ss = new Sugar_Smarty();
            $document->list_view_parse_additional_sections($ss, $xTemplateSection);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
    }

    public function testcreate_export_query()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();

        //test with empty string parameters
        $expected = "SELECT\n						documents.* FROM documents  WHERE  documents.deleted = 0 ORDER BY documents.document_name";
        $actual = $document->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string parameters
        $expected = "SELECT\n						documents.* FROM documents  WHERE documents.document_name = \"\" AND  documents.deleted = 0 ORDER BY documents.id";
        $actual = $document->create_export_query('documents.id', 'documents.document_name = ""');
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testget_list_view_data()
    {
        $this->markTestIncomplete('environment dependency');
        
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();
        $current_theme = SugarThemeRegistry::current();
        //execute the method and verify that it retunrs expected results

        $document->filename = 'test';
        $document->file_url = 'test_url';
        $document->file_url_noimage = 'test_image_url';
        $document->last_rev_created_name = 'test';
        $document->category_id = '1';
        $document->subcategory_id = '1';
        $document->document_name = 'test';

        $expected = array(
            'DELETED' => 0,
            'DOCUMENT_NAME' => 'test',
            'DOC_TYPE' => 'Sugar',
            'FILENAME' => 'test',
            'ACTIVE_DATE' => date('m/d/Y'),
            'CATEGORY_ID' => null,
            'SUBCATEGORY_ID' => null,
            'REVISION' => '1',
            'LAST_REV_CREATED_NAME' => 'test',
            'IS_TEMPLATE' => '0',
            'FILE_URL' => '<a href=\'index.php?entryPoint=download&id=&type=Documents\' target=\'_blank\'><img src="themes/default/images/def_image_inline.gif?v=qtRdmWYs1D4iOsi8lLl9Tw"    border="0" alt="View" /></a>',
            'FILE_URL_NOIMAGE' => 'index.php?entryPoint=download&type=Documents&id=',
            'LAST_REV_CREATED_BY' => 'test',
            'NAME' => 'test',
            'DOCUMENT_NAME_JAVASCRIPT' => 'test',
        );

        $actual = $document->get_list_view_data();
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testmark_relationships_deleted()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();

        //execute the method and test if it works and does not throws an exception.
        try {
            $document->mark_relationships_deleted(1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }

    public function testbean_implements()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_indexevent');
        $state->pushTable('emails');
        $state->pushGlobals();
        
        // test
        
        $document = new Document();
        $this->assertEquals(false, $document->bean_implements('')); //test with blank value
        $this->assertEquals(false, $document->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $document->bean_implements('ACL')); //test with valid value
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('emails');
        $state->popTable('aod_indexevent');
    }
}
