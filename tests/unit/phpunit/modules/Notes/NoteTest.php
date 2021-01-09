<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class NoteTest extends SuitePHPUnitFrameworkTestCase
{
    public function setUp()
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

        $this->assertInstanceOf('Note', $note);
        $this->assertInstanceOf('SugarBean', $note);

        $this->assertAttributeEquals('Notes', 'module_dir', $note);
        $this->assertAttributeEquals('Note', 'object_name', $note);
        $this->assertAttributeEquals('notes', 'table_name', $note);

        $this->assertAttributeEquals(true, 'new_schema', $note);
        $this->assertAttributeEquals(true, 'importable', $note);
    }

    public function testsafeAttachmentName()
    {
        $note = BeanFactory::newBean('Notes');

        //test with valid file name
        $note->filename = 'test.txt';
        $note->safeAttachmentName();
        $this->assertEquals('test.txt', $note->filename);

        //test with invalid file name
        $note->filename = 'test.php';
        $note->safeAttachmentName();
        $this->assertEquals('.txt', $note->name);
        $this->assertEquals('test.php.txt', $note->filename);
    }

    public function testmark_deleted()
    {
        $note = BeanFactory::newBean('Notes');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $note->mark_deleted(1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testdeleteAttachment()
    {
        $note = BeanFactory::newBean('Notes');

        $note->id = 1;
        $result = $note->deleteAttachment();
        $this->assertEquals(true, $result);
    }

    public function testget_summary_text()
    {
        $note = BeanFactory::newBean('Notes');

        //test without setting name
        $this->assertEquals('', $note->get_summary_text());

        //test with name set
        $note->name = 'test';
        $this->assertEquals('test', $note->get_summary_text());
    }

    public function testcreate_export_query()
    {
        $note = BeanFactory::newBean('Notes');

        //test with empty string params
        $expected = " SELECT  notes.*  , jt0.user_name assigned_user_name , jt0.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod , jt1.user_name modified_by_name , jt1.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt2.user_name created_by_name , jt2.created_by created_by_name_owner  , 'Users' created_by_name_mod , LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),' ',IFNULL(contacts.last_name,'')))) contact_name , contacts.assigned_user_id contact_name_owner  , 'Contacts' contact_name_mod FROM notes   LEFT JOIN  users jt0 ON notes.assigned_user_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0  LEFT JOIN  users jt1 ON notes.modified_user_id=jt1.id AND jt1.deleted=0

 AND jt1.deleted=0  LEFT JOIN  users jt2 ON notes.created_by=jt2.id AND jt2.deleted=0

 AND jt2.deleted=0  LEFT JOIN  contacts contacts ON notes.contact_id=contacts.id AND contacts.deleted=0

 AND contacts.deleted=0 where notes.deleted=0 ORDER BY notes.name";
        $actual = $note->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = " SELECT  notes.*  , jt0.user_name assigned_user_name , jt0.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod , jt1.user_name modified_by_name , jt1.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt2.user_name created_by_name , jt2.created_by created_by_name_owner  , 'Users' created_by_name_mod , LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),' ',IFNULL(contacts.last_name,'')))) contact_name , contacts.assigned_user_id contact_name_owner  , 'Contacts' contact_name_mod FROM notes   LEFT JOIN  users jt0 ON notes.assigned_user_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0  LEFT JOIN  users jt1 ON notes.modified_user_id=jt1.id AND jt1.deleted=0

 AND jt1.deleted=0  LEFT JOIN  users jt2 ON notes.created_by=jt2.id AND jt2.deleted=0

 AND jt2.deleted=0  LEFT JOIN  contacts contacts ON notes.contact_id=contacts.id AND contacts.deleted=0

 AND contacts.deleted=0 where (jt0.user_name= \"\") AND notes.deleted=0 ORDER BY notes.id";
        $actual = $note->create_export_query('id', 'assigned_user_name= ""');
        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $note = BeanFactory::newBean('Notes');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $note->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfill_in_additional_detail_fields()
    {
        $note = BeanFactory::newBean('Notes');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $note->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
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
                      'CONTACT_NAME' => 'test contact',
                      'PARENT_MODULE' => 'Account',
                      'STATUS' => 'Note',
                    );

        $actual = $note->get_list_view_data();

        $this->assertSame($expected, $actual);
    }

    public function testlistviewACLHelper()
    {
        $note = BeanFactory::newBean('Notes');

        $expected = array('MAIN' => 'a', 'PARENT' => 'a', 'CONTACT' => 'a');
        $actual = $note->listviewACLHelper();
        $this->assertSame($expected, $actual);
    }

    public function testbean_implements()
    {
        $note = BeanFactory::newBean('Notes');

        $this->assertEquals(false, $note->bean_implements('')); //test with blank value
        $this->assertEquals(false, $note->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $note->bean_implements('ACL')); //test with valid value
    }
}
