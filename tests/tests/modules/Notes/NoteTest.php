<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * Class NoteTest
 */
class NoteTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testNote()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $note = new Note();
    
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
        error_reporting(E_ERROR | E_PARSE);
    
        $note = new Note();
    
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
        $note = new Note();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $note->mark_deleted(1);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testdeleteAttachment()
    {
        $note = new Note();
    
        $note->id = 1;
        $result = $note->deleteAttachment();
        $this->assertEquals(true, $result);
    }
    
    public function testget_summary_text()
    {
        $note = new Note();
    
        //test without setting name
        $this->assertEquals('', $note->get_summary_text());
    
        //test with name set
        $note->name = 'test';
        $this->assertEquals('test', $note->get_summary_text());
    }
    
    public function testcreate_export_query()
    {
        $note = new Note();
    
        //test with empty string params
        $expected =
            'SELECT notes.*, contacts.first_name, contacts.last_name, users.user_name as assigned_user_name  FROM notes 	LEFT JOIN contacts ON notes.contact_id=contacts.id   LEFT JOIN users ON notes.assigned_user_id=users.id where  notes.deleted=0 AND (contacts.deleted IS NULL OR contacts.deleted=0) ORDER BY notes.name';
        $actual = $note->create_export_query('', '');
        $this->assertSame($expected, $actual);
    
        //test with valid string params
        $expected =
            'SELECT notes.*, contacts.first_name, contacts.last_name, users.user_name as assigned_user_name  FROM notes 	LEFT JOIN contacts ON notes.contact_id=contacts.id   LEFT JOIN users ON notes.assigned_user_id=users.id where users.user_name="" AND  notes.deleted=0 AND (contacts.deleted IS NULL OR contacts.deleted=0) ORDER BY notes.name';
        $actual = $note->create_export_query('notes.id', 'users.user_name=""');
        $this->assertSame($expected, $actual);
    }
    
    public function testfill_in_additional_list_fields()
    {
        $note = new Note();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $note->fill_in_additional_list_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testfill_in_additional_detail_fields()
    {
        $note = new Note();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $note->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testget_list_view_data()
    {
        $note = new Note();
        $id = 'abcdef12345';
        $note->id = $id;
        $note->parent_type = 'Account';
        $note->filename = 'test.txt';
        $note->contact_name = 'test contact';
    
        $expected = array(
            'ID'            => $id,
            'FILENAME'      => 'test.txt',
            'PARENT_TYPE'   => 'Account',
            'EMBED_FLAG'    => '0',
            'DELETED'       => 0,
            'CONTACT_NAME'  => 'test contact',
            'PARENT_MODULE' => 'Account',
            'STATUS'        => 'Note',
        );
        
        $actual = $note->get_list_view_data();
    
        $this->assertSame($expected, $actual);
    }
    
    public function testlistviewACLHelper()
    {
        $note = new Note();
    
        $expected = array('MAIN' => 'a', 'PARENT' => 'a', 'CONTACT' => 'a');
        $actual = $note->listviewACLHelper();
        $this->assertSame($expected, $actual);
    }
    
    public function testbean_implements()
    {
        $note = new Note();
    
        $this->assertEquals(false, $note->bean_implements('')); //test with blank value
        $this->assertEquals(false, $note->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $note->bean_implements('ACL')); //test with valid value
    }
}
