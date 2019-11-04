<?php /** @noinspection InvisibleCharacter */
/** @noinspection InvisibleCharacter */

/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;
use SuiteCRM\StateSaver;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once __DIR__ . '/SugarPHPMailerMock.php';
require_once __DIR__ . '/NonGmailSentFolderHandlerMock.php';
require_once __DIR__ . '/EmailMock.php';

class EmailTest extends StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    /**
     *
     * @return StateSaver
     */
    protected function storeState()
    {
        $state = new StateSaver();
        $state->pushTable('inbound_email');
        $state->pushTable('emails');
        $state->pushTable('emails_text');
        $state->pushGlobals();
        return $state;
    }

    /**
     *
     * @param StateSaver $state
     */
    protected function restoreState(StateSaver $state)
    {
        $state->popGlobals();
        $state->popTable('emails_text');
        $state->popTable('emails');
        $state->popTable('inbound_email');
    }



    public function testSendSaveAndStoreInSentOk()
    {
        $state = $this->storeState();

        // handle non-gmail sent folder (mailbox is set)
        $mailer = new SugarPHPMailerMock();
        $ie = new InboundEmail();
        $ieId = $ie->save();
        $this->assertTrue((bool)$ieId);
        $_REQUEST['inbound_email_id'] = $ieId;
        $email = new EmailMock();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $email->saved_attachments = [];
        $nonGmailSentFolder = new NonGmailSentFolderHandlerMock();
        $ie->mailbox = 'testmailbox';
        $storedOption = $ie->getStoredOptions();
        $storedOption['sentFolder'] = 'testSentFolder';
        $ie->setStoredOptions($storedOption);
        $mailer->oe->mail_smtptype = 'foomail';
        $ret = $email->send($mailer, $nonGmailSentFolder, $ie);
        $this->assertTrue($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertNull($email->getTempEmailAtSend()->getNonGmailSentFolderHandler()->getLastError());
        $this->assertEquals(Email::NO_ERROR, $email->getTempEmailAtSend()->getLastSaveAndStoreInSentError());

        $this->restoreState($state);
    }


    public function testSendSaveAndStoreInSentOkButIEDoesntMatch()
    {
        $state = $this->storeState();

        // handle non-gmail sent folder (mailbox is set)
        $mailer = new SugarPHPMailerMock();
        $ie = new InboundEmail();
        $ieId = $ie->save();
        $this->assertTrue((bool)$ieId);
        $_REQUEST['inbound_email_id'] = $ieId;
        $email = new EmailMock();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $email->saved_attachments = [];
        $nonGmailSentFolder = new NonGmailSentFolderHandlerMock();
        $ie->mailbox = 'testmailbox';
        $storedOption = $ie->getStoredOptions();
        $storedOption['sentFolder'] = 'testSentFolder';
        $ie->setStoredOptions($storedOption);
        $mailer->oe->mail_smtptype = 'foomail';
        $ret = $email->send($mailer, $nonGmailSentFolder, $ie);
        $this->assertTrue($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertNull($email->getTempEmailAtSend()->getNonGmailSentFolderHandler()->getLastError());
        $this->assertEquals(Email::NO_ERROR, $email->getTempEmailAtSend()->getLastSaveAndStoreInSentError());

        $this->restoreState($state);
    }

    public function testSendSaveAndStoreInSentNoSentFolder()
    {
        $state = $this->storeState();

        // handle non-gmail sent folder (mailbox is set but no ie stored option: sentFolder)
        $mailer = new SugarPHPMailerMock();
        $ie = new InboundEmail();
        $ieId = $ie->save();
        $this->assertTrue((bool)$ieId);
        $_REQUEST['inbound_email_id'] = $ieId;
        $email = new EmailMock();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $email->saved_attachments = [];
        $nonGmailSentFolder = new NonGmailSentFolderHandlerMock();
        $ie->mailbox = 'testmailbox';
        $mailer->oe->mail_smtptype = 'foomail';
        $ret = $email->send($mailer, $nonGmailSentFolder, $ie);
        $this->assertTrue($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertEquals(Email::ERR_NOT_STORED_AS_SENT, $email->getTempEmailAtSend()->getLastSaveAndStoreInSentError());
        $this->assertEquals(
            NonGmailSentFolderHandler::ERR_NO_STORED_SENT_FOLDER,
            $email->getTempEmailAtSend()->getNonGmailSentFolderHandler()->getLastError()
        );
        
        $this->restoreState($state);
    }

    public function testSendSaveAndStoreInSentNoMailbox()
    {
        $state = $this->storeState();

        // mailbox is not set
        $mailer = new SugarPHPMailerMock();
        $ie = new InboundEmail();
        $ieId = $ie->save();
        $this->assertTrue((bool)$ieId);
        $_REQUEST['inbound_email_id'] = $ieId;
        $email = new EmailMock();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $email->saved_attachments = [];
        $mailer->oe->mail_smtptype = 'foomail';
        $ret = $email->send($mailer);
        $this->assertTrue($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertEquals(Email::ERR_NOT_STORED_AS_SENT, $email->getTempEmailAtSend()->getLastSaveAndStoreInSentError());
        $this->assertEquals(NonGmailSentFolderHandler::ERR_EMPTY_MAILBOX, $email->getTempEmailAtSend()->getNonGmailSentFolderHandler()->getLastError());

        $this->restoreState($state);
    }

    public function testSendSaveAndStoreInSentNoIE()
    {
        $state = $this->storeState();

        // no IE
        $mailer = new SugarPHPMailerMock();
        $_REQUEST['inbound_email_id'] = '123';
        $email = new Email();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $email->saved_attachments = [];
        $ret = $email->send($mailer);
        $this->assertTrue($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertEquals(Email::ERR_IE_RETRIEVE, $email->getTempEmailAtSend()->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getTempEmailAtSend()->getNonGmailSentFolderHandler());

        $this->restoreState($state);
    }

    public function testSendSaveAndStoreInSentSendFailedButItsOk()
    {
        $state = $this->storeState();

        // should send successfully
        $mailer = new SugarPHPMailerMock();
        $email = new Email();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $email->saved_attachments = [];
        $ret = $email->send($mailer);
        $this->assertTrue($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertNull($email->getTempEmailAtSend());

        $this->restoreState($state);
    }

    public function testSendSaveAndStoreInSentSendFailed()
    {
        $state = $this->storeState();

        // sending should failing
        $email = new Email();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $email->saved_attachments = [];
        $ret = $email->send();
        $this->assertFalse($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertNull($email->getTempEmailAtSend());

        $this->restoreState($state);
    }

    public function testSendSaveAndStoreInSentSendNoAttachment()
    {
        $state = $this->storeState();

        // attachenemt error
        $email = new Email();
        $email->to_addrs_arr = ['foo@bazz.bar'];
        $ret = $email->send();
        $this->assertFalse($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertNull($email->getTempEmailAtSend());

        $this->restoreState($state);
    }

    public function testSendSaveAndStoreInSentSendNoTo()
    {
        $state = $this->storeState();

        // "to" array is required
        $email = new Email();
        $ret = $email->send();
        $this->assertFalse($ret);
        $this->assertNull($email->getLastSaveAndStoreInSentError());
        $this->assertNull($email->getNonGmailSentFolderHandler());
        $this->assertNull($email->getTempEmailAtSend());

        $this->restoreState($state);
    }

    public function testSetLastSaveAndStoreInSentErrorNo()
    {
        $email = new EmailMock();
        try {
            $email->setLastSaveAndStoreInSentErrorPublic(null);
            $this->assertTrue(false);
        } catch (InvalidArgumentException $e) {
            $this->assertEquals(Email::ERR_CODE_SHOULD_BE_INT, $e->getCode());
        }
    }

    public function testSaveAndStoreInSentFolderIfNoGmailWithNoIE()
    {
        $email = new Email();
        $ie = new InboundEmail();
        $ieId = null;
        $mail = new SugarPHPMailer();
        $nonGmailSentFolder = new NonGmailSentFolderHandler();
        $ret = $email->saveAndStoreInSentFolderIfNoGmail($ie, $ieId, $mail, $nonGmailSentFolder);
        $this->assertNull($ret);
        $this->assertEquals(Email::ERR_IE_RETRIEVE, $email->getLastSaveAndStoreInSentError());
    }

    public function testEmail()
    {

        //execute the contructor and check for the Object type and  attributes
        $email = new Email();
        $this->assertInstanceOf('Email', $email);
        $this->assertInstanceOf('SugarBean', $email);

        $this->assertAttributeEquals('Emails', 'module_dir', $email);
        $this->assertAttributeEquals('Email', 'object_name', $email);
        $this->assertAttributeEquals('emails', 'table_name', $email);
        $this->assertAttributeEquals('Emails', 'module_name', $email);

        $this->assertAttributeEquals(true, 'new_schema', $email);
        $this->assertAttributeEquals('archived', 'type', $email);
    }

    public function testemail2init()
    {
        $state = new StateSaver();

        $email = new Email();
        $email->email2init();

        $this->assertInstanceOf('EmailUI', $email->et);
    }

    public function testbean_implements()
    {
        // save state

        $state = new StateSaver();
        $state->pushTable('aod_indexevent');

        // test

        $email = new Email();
        $this->assertEquals(false, $email->bean_implements('')); //test with blank value
        $this->assertEquals(false, $email->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $email->bean_implements('ACL')); //test with valid value

        // clean up

        $state->popTable('aod_indexevent');
    }

    public function testemail2saveAttachment()
    {
        $email = new Email();
        $result = $email->email2saveAttachment();
        $this->assertTrue(is_array($result));
    }

    public function testsafeAttachmentName()
    {
        $email = new Email();

        $this->assertEquals(false, $email->safeAttachmentName('test.ext'));
        $this->assertEquals(false, $email->safeAttachmentName('test.exe'));
        $this->assertEquals(true, $email->safeAttachmentName('test.cgi'));
    }

    public function testemail2ParseAddresses()
    {
        $email = new Email();

        $email->email2init();
        $addresses = 'abc<abc@xyz.com>,xyz<xyz@abc.com>';
        $expected = array(
            array('email' => 'abc@xyz.com', 'display' => 'abc'),
            array('email' => 'xyz@abc.com', 'display' => 'xyz')
        );

        $result = $email->email2ParseAddresses($addresses);
        $this->assertSame($expected, $result);
    }

    public function testemail2ParseAddressesForAddressesOnly()
    {
        $email = new Email();

        //test with simplest format
        $addresses = 'abc@xyz.com,xyz@abc.com';
        $result = $email->email2ParseAddressesForAddressesOnly($addresses);
        $this->assertEquals(array('abc@xyz.com', 'xyz@abc.com'), $result);

        //test with more used format
        $addresses = 'abc<abc@xyz.com>,xyz<xyz@abc.com>';
        $result = $email->email2ParseAddressesForAddressesOnly($addresses);
        $this->assertEquals(array('abc@xyz.com', 'xyz@abc.com'), $result);
    }

    public function testemail2GetMime()
    {
        $email = new Email();

        //test with a filename
        $result = $email->email2GetMime('config.php');
        $this->assertEquals('text/x-php', $result);
    }

    public function testdecodeDuringSend()
    {
        $email = new Email();

        $this->assertEquals('some text', $email->decodeDuringSend('some text'));
        $this->assertEquals(
            '&lt; some text &gt;',
            $email->decodeDuringSend('sugarLessThan some text sugarGreaterThan')
        );
    }

    public function testisDraftEmail()
    {
        $email = new Email();

        //test with required parametr set
        $this->assertEquals(true, $email->isDraftEmail(array('saveDraft' => '1')));

        //test with one of required attribute set
        $email->type = 'draft';
        $this->assertEquals(false, $email->isDraftEmail(array()));

        //test with both of required attribute set
        $email->status = 'draft';
        $this->assertEquals(true, $email->isDraftEmail(array()));
    }

    public function testgetNamePlusEmailAddressesForCompose()
    {
        $email = new Email();

        $result = $email->getNamePlusEmailAddressesForCompose('Users', array(1));
        $this->assertGreaterThanOrEqual(0, strlen($result));
    }

    public function test_arrayToDelimitedString()
    {
        $email = new Email();

        //test with empty array
        $result = $email->_arrayToDelimitedString(array());
        $this->assertEquals('', $result);

        //test with valid array
        $result = $email->_arrayToDelimitedString(array('value1', 'value2'));
        $this->assertEquals('value1,value2', $result);
    }

    public function testsendEmailTest()
    {
        $this->markTestIncomplete('Not testing sending email currently');
        /*
    	$email = new Email();

    	$result = $email->sendEmailTest('mail.someserver.com', 25, 425, false, '', '', 'admin@email.com', 'abc@email.com', 'smtp', 'admin');

    	$expected = array( "status"=>false, "errorMessage"=> "Error:SMTP connect() failed. https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting");
    	$this->assertSame($expected, $result);
    	*/
    }

    public function testemail2Send()
    {
        $this->markTestIncomplete('Not testing sending email currently');
        /*	$email = new Email();

            $_REQUEST['sendSubject'] = "test subject";
            $_REQUEST['sendDescription'] = "test text";
            $_REQUEST['fromAccount'] = "from@email.com";
            $_REQUEST['setEditor']  = 1;
            $_REQUEST['description_html']  = "test html";
            $_REQUEST['sendTo'] = "abc@email.com";

            $result = $email->email2Send($_REQUEST);

            $this->assertEquals(false, $result);
        */
    }

    public function testsend()
    {
        $this->markTestIncomplete('Not testing sending email currently');
        /*
    	$email = new Email();

    	$email->to_addrs_arr = array('email' =>'abc@xyz.com', 'display' => 'abc');
    	$email->cc_addrs_arr = array('email' =>'abc@xyz.com', 'display' => 'abc');
    	$email->bcc_addrs_arr = array('email' =>'abc@xyz.com', 'display' => 'abc');

    	$email->from_addr = "abc@xyz.com";
    	$email->from_name = "abc";
    	$email->reply_to_name = "xyz";

    	$result = $email->send();
    	$this->assertEquals(false, $result);
    	*/
    }

    public function testsaveAndOthers()
    {

    // save state

        $state = new StateSaver();
        $state->pushTable('email_addresses');
        $state->pushTable('emails');
        $state->pushTable('emails_email_addr_rel');
        $state->pushTable('emails_text');
        $state->pushTable('tracker');
        $state->pushTable('aod_index');
        $state->pushGlobals();

        // test


        $email = new Email();

        $email->from_addr = 'from@email.com';
        $email->to_addrs = 'to@email.com';
        $email->cc_addrs = 'cc@email.com';
        $email->bcc_addrs = 'bcc@email.com';

        $email->from_addr_name = 'from';
        $email->to_addrs_names = 'to';
        $email->cc_addrs_names = 'cc';
        $email->bcc_addrs_names = 'bcc';
        $email->reply_to_addr = 'reply@email.com';
        $email->description = 'test description';
        $email->description_html = 'test html description';
        $email->raw_source = 'test raw source';

        $result = $email->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($email->id));
        $this->assertEquals(36, strlen($email->id));

        //test retrieve method
        $this->retrieve($email->id);

        //test retrieveEmailAddresses method
        $this->retrieveEmailAddresses($email->id);

        //test retrieveEmailText method
        $this->retrieveEmailText($email->id);

        //test saveEmailAddresses method
        $this->saveEmailAddresses($email->id);

        //test linkEmailToAddres method
        $this->linkEmailToAddress($email->id);

        //test handleAttachments method
        $this->handleAttachments($email->id);

        //test delete method
        $this->delete($email->id);

        // clean up

        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('tracker');
        $state->popTable('emails_text');
        $state->popTable('emails_email_addr_rel');
        $state->popTable('emails');
        $state->popTable('email_addresses');
    }

    public function retrieve($id)
    {
        $email = new Email();

        $result = $email->retrieve($id);

        $this->assertTrue(isset($result->id));
        $this->assertEquals(36, strlen($result->id));

        $this->assertTrue(isset($result->from_addr_name));
        $this->assertTrue(isset($result->to_addrs_names));
        $this->assertTrue(isset($result->cc_addrs_names));
        $this->assertTrue(isset($result->bcc_addrs_names));

        $this->assertTrue(isset($result->raw_source));
        $this->assertTrue(isset($result->description_html));
    }

    public function saveEmailAddresses($id)
    {
        $email = new Email();

        $email->id = $id;
        $email->from_addr = 'from_test@email.com';
        $email->to_addrs = 'to_test@email.com';
        $email->cc_addrs = 'cc_test@email.com';
        $email->bcc_addrs = 'bcc_test@email.com';

        $email->saveEmailAddresses();

        //retrieve and verify that email addresses were saved properly
        $email->retrieveEmailAddresses();

        $this->assertNotSame(false, strpos($email->from_addr, 'from_test@email.com'));
        $this->assertNotSame(false, strpos($email->to_addrs, 'to_test@email.com'));
        $this->assertNotSame(false, strpos($email->cc_addrs, 'cc_test@email.com'));
        $this->assertNotSame(false, strpos($email->bcc_addrs, 'bcc_test@email.com'));
    }

    public function retrieveEmailAddresses($id)
    {
        $email = new Email();

        $email->id = $id;
        $email->retrieveEmailAddresses();

        $this->assertTrue(isset($email->from_addr_name));
        $this->assertTrue(isset($email->to_addrs_names));
        $this->assertTrue(isset($email->cc_addrs_names));
        $this->assertTrue(isset($email->bcc_addrs_names));
    }

    public function linkEmailToAddress($id)
    {
        $email = new Email();

        $email->id = $id;

        $result = $email->linkEmailToAddress(1, 'from');

        $this->assertTrue(isset($result));
        $this->assertEquals(36, strlen($result));
    }

    public function retrieveEmailText($id)
    {
        $email = new Email();

        $email->id = $id;

        $email->retrieveEmailText();

        $this->assertTrue(isset($email->from_addr_name));
        $this->assertTrue(isset($email->reply_to_addr));
        $this->assertTrue(isset($email->to_addrs_names));
        $this->assertTrue(isset($email->cc_addrs_names));
        $this->assertTrue(isset($email->bcc_addrs_names));

        $this->assertTrue(isset($email->raw_source));
        $this->assertTrue(isset($email->description_html));
    }

    public function handleAttachments($id)
    {
        $email = new Email();

        $email = $email->retrieve($id);

        $email->type = 'out';
        $email->status = 'draft';
        $_REQUEST['record'] = $id;

        $email->handleAttachments();

        $this->assertTrue(is_array($email->attachments));
    }

    public function delete($id)
    {
        $email = new Email();

        $email->delete($id);

        $result = $email->retrieve($id);
        $this->assertEquals(null, $result);
    }

    public function testSaveTempNoteAttachmentsAndGetNotesAndDoesImportedEmailHaveAttachment()
    {
        $email = new Email();

        $email->id = 1;

        //test saveTempNoteAttachments method to create a note for email
        $email->saveTempNoteAttachments('test_file', 'test', 'text/plain');

        //test doesImportedEmailHaveAttachment method to verify note created.
        $result = $email->doesImportedEmailHaveAttachment($email->id);
        $this->assertEquals(0, $result);

        //test getNotes method and verify that it retrieves the created note.
        $email->getNotes($email->id);
        $this->assertTrue(is_array($email->attachments));
        foreach ($email->attachments as $note) {
            $this->assertTrue(isset($note));
            $this->assertInstanceOf('Note', $note);
        }

        //finally cleanup
        $email->delete($email->id);
    }

    public function testgetNotesSqlEscape()
    {
        $email = new Email();
        $email->getNotes("'=");
        $this->assertFalse(DBManagerFactory::getInstance()->lastError());
    }

    public function testcleanEmails()
    {
        $email = new Email();

        //test with simplest format
        $addresses = 'abc@xyz.com,xyz@abc.com';
        $result = $email->cleanEmails($addresses);
        $this->assertEquals('abc@xyz.com, xyz@abc.com', $result);

        //test with more used format
        $addresses = 'abc<abc@xyz.com>,xyz<xyz@abc.com>';
        $result = $email->cleanEmails($addresses);
        $this->assertEquals('abc <abc@xyz.com>, xyz <xyz@abc.com>', $result);
    }

    public function testgetForwardHeader()
    {
        $email = new Email();

        $email->from_name = 'from test';
        $email->name = 'test';
        $email->date_sent_received = '2016-01-01';
        $email->to_addrs = 'to@email.com';
        $email->cc_addrs = 'cc@email.com';

        $expected = '<br /><br />>  from test<br />>  2016-01-01<br />>  to@email.com<br />>  cc@email.com<br />>  test<br />> <br />';

        $actual = $email->getForwardHeader();
        $this->assertSame($expected, $actual);
    }

    public function testgetReplyHeader()
    {
        $email = new Email();

        $email->from_name = 'from test';
        $email->time_start = '01:01:00';
        $email->date_start = '2016-01-01';

        $expected = '<br> 2016-01-01, 01:01:00, from test ';

        $actual = $email->getReplyHeader();
        $this->assertSame($expected, $actual);
    }

    public function testquotePlainTextEmail()
    {
        $email = new Email();

        //test with plain string containing no line breaks
        $expected = "\n> some text\r";
        $actual = $email->quotePlainTextEmail('some text');
        $this->assertSame($expected, $actual);

        //test with string containing line breaks
        $expected = "\n> some\r> text\r> with\r> new\r> lines\r";
        $actual = $email->quotePlainTextEmail("some\ntext\nwith\nnew\nlines");
        $this->assertSame($expected, $actual);
    }

    public function testquoteHtmlEmail()
    {
        $email = new Email();

        //test with empty string
        $expected = '';
        $actual = $email->quoteHtmlEmail('');
        $this->assertSame($expected, $actual);

        //test with plain string
        $expected = "<div style='border-left:1px solid #00c; padding:5px; margin-left:10px;'>some test</div>";
        $actual = $email->quoteHtmlEmail('some test');
        $this->assertSame($expected, $actual);

        //test with string containing special charecters
        $expected = "<div style='border-left:1px solid #00c; padding:5px; margin-left:10px;'>some test with <&</div>";
        $actual = $email->quoteHtmlEmail('some test with <&');
        $this->assertSame($expected, $actual);
    }

    public function testquoteHtmlEmailForNewEmailUI()
    {
        $email = new Email();

        //test with empty string
        $expected = '';
        $actual = $email->quoteHtmlEmailForNewEmailUI('');
        $this->assertSame($expected, $actual);

        //test with plain string
        $expected = "<div style='border-left:1px solid #00c; padding:5px; margin-left:10px;'>some test</div>";
        $actual = $email->quoteHtmlEmailForNewEmailUI('some test');
        $this->assertSame($expected, $actual);

        //test with string containing special charecters
        $expected = "<div style='border-left:1px solid #00c; padding:5px; margin-left:10px;'>some test with</div>";
        $actual = $email->quoteHtmlEmailForNewEmailUI("some test with \n");
        $this->assertSame($expected, $actual);
    }

    public function testcheck_email_settings()
    {
        global $current_user;

        $email = new Email();

        //test without a valid current user
        $result = $email->check_email_settings();
        $this->assertEquals(false, $result);

        //test with a valid current user
        $current_user = new User(1);
        $result = $email->check_email_settings();
        $this->assertEquals(false, $result);
    }

    public function testjs_set_archived()
    {
        $email = new Email();

        $actual = $email->js_set_archived();
        $this->assertGreaterThan(0, strlen($actual));
    }

    public function testu_get_clear_form_js()
    {
        self::markTestIncomplete('environment dependency (CRLF?)');
        $email = new Email();

        //with empty params
        $expected = "		<script type=\"text/javascript\" language=\"JavaScript\"><!-- Begin
			function clear_form(form) {
				var newLoc = \"index.php?action=\" + form.action.value + \"&module=\" + form.module.value + \"&query=true&clear_query=true\";
				if(typeof(form.advanced) != \"undefined\"){
					newLoc += \"&advanced=\" + form.advanced.value;
				}
				document.location.href= newLoc;
			}
		//  End --></script>";
        $actual = $email->u_get_clear_form_js('', '', '');
        $this->assertSame($expected, $actual, "exp:[" . print_r($expected, true) . "] act:[" . print_r($actual, true) . "]");

        //with valid params
        $expected = "\n		<script type=\"text/javascript\" language=\"JavaScript\"><!-- Begin\n			function clear_form(form) {\n				var newLoc = \"index.php?action=\" + form.action.value + \"&module=\" + form.module.value + \"&query=true&clear_query=true&type=out&assigned_user_id=1\";\n				if(typeof(form.advanced) != \"undefined\"){\n					newLoc += \"&advanced=\" + form.advanced.value;\n				}\n				document.location.href= newLoc;\n			}\n		//  End --></script>";
        $actual = $email->u_get_clear_form_js('out', '', '1');
        $this->assertSame($expected, $actual, "exp:[" . print_r($expected, true) . "] act:[" . print_r($actual, true) . "]");
    }

    public function testpickOneButton()
    {
        $email = new Email();

        $expected = "<div><input	title=\"\"
						class=\"button\"
						type=\"button\" name=\"button\"
						onClick=\"window.location='index.php?module=Emails&action=Grab';\"
						style=\"margin-bottom:2px\"
						value=\"    \"></div>";
        $actual = $email->pickOneButton();
        $this->assertSame($expected, $actual);
    }

    public function testgetUserEditorPreference()
    {
        $email = new Email();

        $result = $email->getUserEditorPreference();
        $this->assertEquals('html', $result);
    }

    public function testparse_addrs()
    {
        $email = new Email();

        $addrs = 'abc<abc@email.com>;xyz<xyz@email.com>';
        $addrs_ids = '1;2';
        $addrs_names = 'abc;xyz';
        $addrs_emails = 'abc@email.com;xyz@email.com';

        $expected = array(
            array('email' => 'abc@email.com', 'display' => 'abc', 'contact_id' => '1'),
            array('email' => 'xyz@email.com', 'display' => 'xyz', 'contact_id' => '2')
        );

        $actual = $email->parse_addrs($addrs, $addrs_ids, $addrs_names, $addrs_emails);

        $this->assertSame($expected, $actual);
    }

    public function testremove_empty_fields()
    {
        $email = new Email();

        //test for array with empty values
        $expected = array('val1', 'val2');
        $fields = array('val1', ' ', 'val2');
        $actual = $email->remove_empty_fields($fields);
        $this->assertSame($expected, $actual);

        //test for array without empty values
        $expected = array('val1', 'val2');
        $fields = array('val1', 'val2');
        $actual = $email->remove_empty_fields($fields);
        $this->assertSame($expected, $actual);
    }

    public function testhasSignatureInBody()
    {
        $email = new Email();

        $email->description_html = 'some html text with <b>sign</b>';
        $email->description = 'some text with sign';

        //test for strings with signature present
        $sig = array('signature_html' => 'sign', 'signature' => 'sign');
        $result = $email->hasSignatureInBody($sig);
        $this->assertEquals(true, $result);

        //test for strings with signature absent
        $sig = array('signature_html' => 'signature', 'signature' => 'signature');
        $result = $email->hasSignatureInBody($sig);
        $this->assertEquals(false, $result);
    }

    public function testremoveAllNewlines()
    {
        $email = new Email();

        $this->assertEquals('', $email->removeAllNewlines(''));
        $this->assertEquals('some text', $email->removeAllNewlines('some text'));
        $this->assertEquals('some text', $email->removeAllNewlines('some text<br>'));
        $this->assertEquals('some text', $email->removeAllNewlines("some\n text\n"));
        $this->assertEquals('some text', $email->removeAllNewlines("some\r\n text\r\n"));
    }

    public function testgetStartPage()
    {
        $email = new Email();

        //test without assigned_user_id in url
        $url = 'index.php?module=Users&offset=6&stamp=1453274421025259800&return_module=Users&action=DetailView&record=seed_max_id';
        $expected = array(
            'module' => 'Users',
            'action' => 'DetailView',
            'group' => '',
            'record' => 'seed_max_id',
            'type' => '',
            'offset' => '6',
            'stamp' => '1453274421025259800',
            'return_module' => 'Users',
        );
        $actual = $email->getStartPage($url);
        $this->assertSame($expected, $actual);

        //test with assigned_user_id in url
        $url = 'index.php?module=Users&offset=6&stamp=1453274421025259800&return_module=Users&action=DetailView&record=seed_max_id&assigned_user_id=1';
        $expected = array(
            'module' => 'Users',
            'action' => 'DetailView',
            'group' => '',
            'record' => 'seed_max_id',
            'type' => '',
            'offset' => '6',
            'stamp' => '1453274421025259800',
            'return_module' => 'Users',
            'assigned_user_id' => '1',
            'current_view' => 'DetailView&module=Users&assigned_user_id=1&type=',
        );
        $actual = $email->getStartPage($url);
        $this->assertSame($expected, $actual);
    }

    public function testsetMailer()
    {
        $email = new Email();

        $result = $email->setMailer(new SugarPHPMailer(), '', '');

        $this->assertInstanceOf('SugarPHPMailer', $result);
        $this->assertInstanceOf('OutboundEmail', $result->oe);
    }

    public function testhandleBody()
    {
        $email = new Email();

        //test without setting REQUEST parameters
        $email->description_html = "some email description containing email text &amp; &#39; <br>&nbsp;";
        $result = $email->handleBody(new SugarPHPMailer());
        $expected = "some email description containing email text & ' \n ";
        $actual = $email->description;
        $this->assertSame($expected, $actual);
        $expected = 'SugarPHPMailer';
        $actual = $result;
        $this->assertInstanceOf($expected, $result);

        // TODO: TASK: UNDEFINED - Refactor html body
        //test with REQUEST parameters set
//        $_REQUEST['setEditor'] = 1;
//        $_REQUEST['description_html'] = '1';
//        $email->description_html = 'some email description containing email text &amp; &#39; <br>&nbsp;';
//
//        $result = $email->handleBody(new SugarPHPMailer());
//
//        $expected = "some email description containing email text & ' \n ";
//        $actual = $email->description;
//        $this->assertEquals($expected, $actual);
//        $this->assertInstanceOf('SugarPHPMailer', $result);
    }

    public function testhandleBodyInHTMLformat()
    {
        // TODO: TASK: UNDEFINED - Refactor html body
//        $email = new Email();
//
//        $mailer = new SugarPHPMailer();
//        $email->description_html = 'some email description containing email text &amp; &#39; <br>&nbsp;';
//
//        $result = $email->handleBodyInHTMLformat($mailer);
//
//        $this->assertEquals("some email description containing email text & ' \n ", $email->description);
//        $this->assertEquals("some email description containing email text & ' <br> ", $mailer->Body);
    }

    public function testlistviewACLHelper()
    {
        self::markTestIncomplete('environment dependency (span os a?)');

        // save state

        $state = new StateSaver();
        $state->pushGlobals();

        // test

        $email = new Email();

        $expected = array('MAIN' => 'span', 'PARENT' => 'a', 'CONTACT' => 'span');
        $actual = $email->listviewACLHelper();
        $this->assertSame($expected, $actual);

        // clean up

        $state->popGlobals();
    }

    public function testgetSystemDefaultEmail()
    {
        $email = new Email();

        $expected = array('email', 'name');
        $actual = array_keys($email->getSystemDefaultEmail());

        $this->assertSame($expected, $actual);
    }

    public function testcreate_new_list_query()
    {
        $email = new Email();

        //test with empty string params
        $expected = "SELECT emails.*, users.user_name as assigned_user_name\n FROM emails\n LEFT JOIN users ON emails.assigned_user_id=users.id \nWHERE  emails.deleted=0 \n ORDER BY date_sent_received DESC";
        $actual = $email->create_new_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT emails.*, users.user_name as assigned_user_name\n FROM emails\n LEFT JOIN users ON emails.assigned_user_id=users.id \nWHERE users.user_name = \"\" AND  emails.deleted=0 \n ORDER BY emails.id";
        $actual = $email->create_new_list_query('emails.id', 'users.user_name = ""');
        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $email = new Email();

        $email->parent_id = '1';
        $email->parent_name = 'test';
        $email->parent_type = 'Contacts';

        $email->fill_in_additional_list_fields();

        $this->assertEquals('DetailView', $email->link_action);
        $this->assertEquals('', $email->attachment_image);
    }

    public function testfill_in_additional_detail_fields()
    {
        $email = new Email();

        $email->created_by = '1';
        $email->modified_user_id = '1';
        $email->type = 'out';
        $email->status = 'send_error';

        $email->fill_in_additional_list_fields();

        $this->assertEquals('Administrator', $email->created_by_name);
        $this->assertEquals('Administrator', $email->modified_by_name);
        $this->assertEquals('Send Error', $email->type_name);
        $this->assertEquals('(no subject)', $email->name);
        $this->assertEquals('DetailView', $email->link_action);
    }

    public function testcreate_export_query()
    {
        $email = new Email();

        //test with empty string params
        $expected = 'SELECT emails.* FROM emails where emails.deleted=0 ORDER BY emails.name';
        $actual = $email->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = 'SELECT emails.* FROM emails where users.user_name = "" AND emails.deleted=0 ORDER BY emails.id';
        $actual = $email->create_export_query('emails.id', 'users.user_name = ""');
        $this->assertSame($expected, $actual);
    }

    public function testget_list_view_data()
    {
        // TODO: TASK: UNDEFINED - Update to handle new list view
//        $email = new Email();
//        $current_theme = SugarThemeRegistry::current();
//
//        $email->from_addr_name = 'Admin';
//        $email->id = 1;
//        $email->intent = 'support';
//        $email->to_addrs = 'abc@email.com';
//        $email->link_action = 'DetailView';
//        $email->type_name = 'out';
//
//        $expected = array(
//                'ID' => 1,
//                'FROM_ADDR_NAME' => 'Admin',
//                'TYPE' => 'Archived',
//                'INTENT' => 'support',
//                'FROM_ADDR' => null,
//                'QUICK_REPLY' => '<a  href="index.php?module=Emails&action=Compose&replyForward=true&reply=reply&record=1&inbound_email_id=1">Reply</a>',
//                'STATUS' => null,
//                'CREATE_RELATED' => '~index.php\?module=Cases&action=EditView&inbound_email_id=1~',
//                'CONTACT_NAME' => '</a>abc@email.com<a>',
//                'CONTACT_ID' => '',
//                'ATTACHMENT_IMAGE' => null,
//                'LINK_ACTION' => 'DetailView',
//                'TYPE_NAME' => 'out',
//        );
//
//        $actual = $email->get_list_view_data();
//        foreach ($expected as $expectedKey => $expectedVal) {
//            if ($expectedKey == 'CREATE_RELATED') {
//                $this->assertRegExp($expected[$expectedKey], $actual[$expectedKey]);
//            } else {
//                $this->assertSame($expected[$expectedKey], $actual[$expectedKey]);
//            }
//        }
        $this->markTestIncomplete('Need to be updated');
    }

    public function testquickCreateForm()
    {
        $email = new Email();
        $sugar_theme = SugarThemeRegistry::current();

        $expected = '~/images/advanced_search~';

        $actual = $email->quickCreateForm();
        $this->assertRegExp($expected, $actual);
    }

    public function testsearchImportedEmails()
    {
        $email = new Email();

        $actual = $email->searchImportedEmails();
        $this->assertTrue(is_array($actual));
    }

    public function test_genereateSearchImportedEmailsQuery()
    {
        $email = new Email();

        $expected = "SELECT emails.id , emails.mailbox_id, emails.name, emails.date_sent_received, emails.status, emails.type, emails.flagged, emails.reply_to_status,
		                      emails_text.from_addr, emails_text.to_addrs  FROM emails   JOIN emails_text on emails.id = emails_text.email_id   WHERE (emails.type= 'inbound' OR emails.type='archived' OR emails.type='out') AND emails.deleted = 0 ";
        $actual = $email->_genereateSearchImportedEmailsQuery();
        $this->assertSame($expected, $actual);
    }

    public function test_generateSearchImportWhereClause()
    {

    // save state

        $state = new StateSaver();
        $state->pushGlobals();

        // test


        $email = new Email();

        //test without request params
        $expected = '';
        $actual = $email->_generateSearchImportWhereClause();
        $this->assertSame($expected, $actual);

        //test with searchDateFrom request param only
        $_REQUEST['searchDateFrom'] = '2015-01-01 00:00:00';
        $expected = "emails.date_sent_received >= '' ";
        $actual = $email->_generateSearchImportWhereClause();
        $this->assertSame($expected, $actual);

        //test with searchDateTo request param only
        $_REQUEST['searchDateFrom'] = '';
        $_REQUEST['searchDateTo'] = '2015-01-01 00:00:00';
        $expected = "emails.date_sent_received <= '' ";
        $actual = $email->_generateSearchImportWhereClause();
        $this->assertSame($expected, $actual);

        //test with both request params
        $_REQUEST['searchDateFrom'] = '2015-01-01 00:00:00';
        $_REQUEST['searchDateTo'] = '2015-01-01 00:00:00';
        $expected = "( emails.date_sent_received >= '' AND
                                          emails.date_sent_received <= '' )";
        $actual = $email->_generateSearchImportWhereClause();
        $this->assertSame($expected, $actual);


        // clean up

        $state->popGlobals();
    }

    public function testtrimLongTo()
    {
        $email = new Email();

        $this->assertEquals('test string', $email->trimLongTo('test string')); //test without any separator
        $this->assertEquals(
            'test string 1...',
            $email->trimLongTo('test string 1, test string2')
        ); //test with , separator
        $this->assertEquals(
            'test string 1...',
            $email->trimLongTo('test string 1; test string2')
        );//test with ; separator
    }

    public function testget_summary_text()
    {
        $email = new Email();

        //test without setting name
        $this->assertEquals(null, $email->get_summary_text());

        //test with name set
        $email->name = 'test';
        $this->assertEquals('test', $email->get_summary_text());
    }

    public function testdistributionForm()
    {

    // save state

        $state = new StateSaver();
        $state->pushGlobals();

        // test

        require_once 'include/utils/layout_utils.php';
        $email = new Email();

        //test with empty string
        $result = $email->distributionForm('');
        $this->assertGreaterThan(0, strlen($result));

        //test with valid string
        $result = $email->distributionForm('test');
        $this->assertGreaterThan(0, strlen($result));

        // clean up

        $state->popGlobals();
    }

    public function testuserSelectTable()
    {
        $email = new Email();

        $result = $email->userSelectTable();
        $this->assertGreaterThan(0, strlen($result));
    }

    public function testcheckInbox()
    {
        $email = new Email();

        //test with empty string
        $expected = "<div><input	title=\"\"
						class=\"button\"
						type=\"button\" name=\"button\"
						onClick=\"window.location='index.php?module=Emails&action=Check&type=';\"
						style=\"margin-bottom:2px\"
						value=\"    \"></div>";
        $actual = $email->checkInbox('');
        $this->assertSame($expected, $actual);

        //test with valid string
        $expected = "<div><input	title=\"\"
						class=\"button\"
						type=\"button\" name=\"button\"
						onClick=\"window.location='index.php?module=Emails&action=Check&type=test';\"
						style=\"margin-bottom:2px\"
						value=\"    \"></div>";
        $actual = $email->checkInbox('test');
        $this->assertSame($expected, $actual);
    }

    public function testfillPrimaryParentFields()
    {
        $state = new StateSaver();





        $email = new Email();

        //execute the method and test if it works and does not throws an exception.
        try {
            $email->fillPrimaryParentFields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // clean up
    }

    public function testcid2Link()
    {
        $state = new StateSaver();





        $email = new Email();

        $email->description_html = '<img class="image" src="cid:1">';
        $email->imagePrefix = 'prfx';

        //execute the method and test if it works and does not throws an exception.
        try {
            $email->cid2Link('1', 'image/png');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // clean up
    }

    public function testcids2Links()
    {
        $state = new StateSaver();





        $email = new Email();

        $email->description_html = '<img class="image" src="cid:1">';
        $email->imagePrefix = 'prfx';

        //execute the method and test if it works and does not throws an exception.
        try {
            $email->cids2Links();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // clean up
    }

    public function testsetFieldNullable()
    {
        $state = new StateSaver();





        $email = new Email();

        //execute the method and test if it works and does not throws an exception.
        try {
            $email->setFieldNullable('description');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // clean up
    }

    public function testrevertFieldNullable()
    {
        $state = new StateSaver();





        $email = new Email();

        //execute the method and test if it works and does not throws an exception.
        try {
            $email->revertFieldNullable('description');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // clean up
    }
}
