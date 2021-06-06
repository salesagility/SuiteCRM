<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class NoteTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testNote()
    {
        // Execute the constructor and check for the Object type and  attributes
        $note = BeanFactory::newBean('Notes');

        self::assertInstanceOf('Note', $note);
        self::assertInstanceOf('SugarBean', $note);

        self::assertAttributeEquals('Notes', 'module_dir', $note);
        self::assertAttributeEquals('Note', 'object_name', $note);
        self::assertAttributeEquals('notes', 'table_name', $note);

        self::assertAttributeEquals(true, 'new_schema', $note);
        self::assertAttributeEquals(true, 'importable', $note);
    }

    public function testsafeAttachmentName()
    {
        $note = BeanFactory::newBean('Notes');

        //test with valid file name
        $note->filename = 'test.txt';
        $note->safeAttachmentName();
        self::assertEquals('test.txt', $note->filename);

        //test with invalid file name
        $note->filename = 'test.php';
        $note->safeAttachmentName();
        self::assertEquals('.txt', $note->name);
        self::assertEquals('test.php.txt', $note->filename);
    }

    public function testmark_deleted()
    {
        $note = BeanFactory::newBean('Notes');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $note->mark_deleted(1);
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testdeleteAttachment()
    {
        $note = BeanFactory::newBean('Notes');

        $note->id = 1;
        $result = $note->deleteAttachment();
        self::assertEquals(true, $result);
    }

    public function testget_summary_text()
    {
        $note = BeanFactory::newBean('Notes');

        //test without setting name
        self::assertEquals('', $note->get_summary_text());

        //test with name set
        $note->name = 'test';
        self::assertEquals('test', $note->get_summary_text());
    }

    public function testcreate_export_query()
    {
        $note = BeanFactory::newBean('Notes');

        //test with empty string params
        $expected = 'SELECT notes.*, contacts.first_name, contacts.last_name, users.user_name as assigned_user_name  FROM notes 	LEFT JOIN contacts ON notes.contact_id=contacts.id   LEFT JOIN users ON notes.assigned_user_id=users.id where  notes.deleted=0 AND (contacts.deleted IS NULL OR contacts.deleted=0) ORDER BY notes.name';
        $actual = $note->create_export_query('', '');
        self::assertSame($expected, $actual);

        //test with valid string params
        $expected = 'SELECT notes.*, contacts.first_name, contacts.last_name, users.user_name as assigned_user_name  FROM notes 	LEFT JOIN contacts ON notes.contact_id=contacts.id   LEFT JOIN users ON notes.assigned_user_id=users.id where users.user_name="" AND  notes.deleted=0 AND (contacts.deleted IS NULL OR contacts.deleted=0) ORDER BY notes.name';
        $actual = $note->create_export_query('notes.id', 'users.user_name=""');
        self::assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $note = BeanFactory::newBean('Notes');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $note->fill_in_additional_list_fields();
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfill_in_additional_detail_fields()
    {
        $note = BeanFactory::newBean('Notes');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $note->fill_in_additional_detail_fields();
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testget_list_view_data()
    {
        $note = BeanFactory::newBean('Notes');
        $id = 'abcdef12345';
        $note->id = $id;
        $note->parent_type = 'Account';
        $note->filename = 'test.txt';
        $note->contact_name = 'test contact';

        $expected = array(
                      'ID' => $id,
                      'FILENAME' => 'test.txt',
                      'PARENT_TYPE' => 'Account',
                      'EMBED_FLAG' => '0',
                      'DELETED' => 0,
                      'SHOW_PREVIEW' => true,
                      'CONTACT_NAME' => 'test contact',
                      'PARENT_MODULE' => 'Account',
                      'STATUS' => 'Note',
                    );

        $actual = $note->get_list_view_data();

        self::assertSame($expected, $actual);
    }

    public function testlistviewACLHelper()
    {
        $note = BeanFactory::newBean('Notes');

        $expected = array('MAIN' => 'a', 'PARENT' => 'a', 'CONTACT' => 'a');
        $actual = $note->listviewACLHelper();
        self::assertSame($expected, $actual);
    }

    public function testbean_implements()
    {
        $note = BeanFactory::newBean('Notes');

        self::assertEquals(false, $note->bean_implements('')); //test with blank value
        self::assertEquals(false, $note->bean_implements('test')); //test with invalid value
        self::assertEquals(true, $note->bean_implements('ACL')); //test with valid value
    }
}
