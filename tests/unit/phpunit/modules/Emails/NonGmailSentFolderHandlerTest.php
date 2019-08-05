<?php
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once __DIR__ . '/InboundEmailMock.php';

/**
 * NonGmailSentFolderHandlerTest
 *
 * @author gyula
 */
class NonGmailSentFolderHandlerTest extends StateCheckerPHPUnitTestCaseAbstract
{
    public function testClearLastError()
    {
        $handler = new NonGmailSentFolderHandler();
        $handler->clearLastError();
        $err = $handler->getLastError();
        $this->assertNull($err);
    }
    
    public function testSetLastErrorNoInt()
    {
        $handler = new NonGmailSentFolderHandler();
        
        try {
            $handler->setLastError(null);
            $this->assertTrue(false);
        } catch (InvalidArgumentException $e) {
            $this->assertEquals(NonGmailSentFolderHandler::ERR_SHOULD_BE_INT, $e->getCode());
        }
    }
    
    public function storeInSentFolderNoIEIsNull()
    {
        $handler = new NonGmailSentFolderHandler();
        $ret = $handler->storeInSentFolder(null, null);
        $this->assertFalse($ret);
        $this->assertEquals(NonGmailSentFolderHandler::ERR_NO_IE_FOUND, $handler->getLastError());
    }
    
    public function storeInSentFolderNoIE()
    {
        $handler = new NonGmailSentFolderHandler();
        $ret = $handler->storeInSentFolder(new InboundEmail(), null);
        $this->assertFalse($ret);
        $this->assertEquals(NonGmailSentFolderHandler::ERR_NO_IE_FOUND, $handler->getLastError());
    }
    
    public function storeInSentFolderIsPop3()
    {
        $handler = new NonGmailSentFolderHandler();
        $ie = new InboundEmail();
        $ie->id = '123';
        $ie->protocol = 'pop3';
        $ret = $handler->storeInSentFolder($ie, null);
        $this->assertFalse($ret);
        $this->assertEquals(NonGmailSentFolderHandler::ERR_IS_POP3, $handler->getLastError());
    }
    
    public function storeInSentFolderIsGmail()
    {
        $handler = new NonGmailSentFolderHandler();
        $ie = new InboundEmail();
        $ie->id = '123';
        $ie->protocol = 'smtp';
        $mail = new SugarPHPMailer();
        $mail->oe->mail_smtptype = 'gmail';
        $ret = $handler->storeInSentFolder($ie, $mail);
        $this->assertFalse($ret);
        $this->assertEquals(NonGmailSentFolderHandler::ERR_IS_GMAIL, $handler->getLastError());
    }
    
    public function storeInSentFolderOk()
    {
        $handler = new NonGmailSentFolderHandler();
        $ie = new InboundEmail();
        $ie->id = '123';
        $ie->protocol = 'smtp';
        $mail = new SugarPHPMailer();
        $mail->oe->mail_smtptype = 'foo';
        $ret = $handler->storeInSentFolder($ie, $mail);
        $this->assertFalse($ret);
        $this->assertEquals(NonGmailSentFolderHandler::NO_ERROR, $handler->getLastError());
    }
    
    public function testGetProblemOfStoringInNonGmailSentFolderNoIEID()
    {
        $handler = new NonGmailSentFolderHandlerMock();
        $ie = new InboundEmail();
        $mail = new SugarPHPMailer();
        unset($ie->id);
        $ret = $handler->getProblemOfStoringInNonGmailSentFolderPublic($ie, $mail);
        $this->assertContains('IE ID is not set.', $ret);
    }
    
    public function testGetProblemOfStoringInNonGmailSentFolderNoIEIDValue()
    {
        $handler = new NonGmailSentFolderHandlerMock();
        $ie = new InboundEmail();
        $mail = new SugarPHPMailer();
        $ie->id = '';
        $ret = $handler->getProblemOfStoringInNonGmailSentFolderPublic($ie, $mail);
        $this->assertContains('IE ID is set but no value.', $ret);
    }
    
    public function testGetProblemOfStoringInNonGmailSentFolderIsPop3()
    {
        $handler = new NonGmailSentFolderHandlerMock();
        $ie = new InboundEmail();
        $mail = new SugarPHPMailer();
        $ie->id = 123;
        $ie->protocol = 'pop3';
        $ret = $handler->getProblemOfStoringInNonGmailSentFolderPublic($ie, $mail);
        $this->assertContains('It is a pop3 protocoll.', $ret);
    }
    
    public function testGetProblemOfStoringInNonGmailSentFolderIsGmail()
    {
        $handler = new NonGmailSentFolderHandlerMock();
        $ie = new InboundEmail();
        $mail = new SugarPHPMailer();
        $ie->id = 123;
        $ie->protocol = 'pop3';
        $mail->oe->mail_smtptype = 'gmail';
        $ret = $handler->getProblemOfStoringInNonGmailSentFolderPublic($ie, $mail);
        $this->assertContains('It is a gmail.', $ret);
    }
    
    
    public function testConnectToNonGmailServer()
    {
        $handler = new NonGmailSentFolderHandlerMock();
        $ie = new InboundEmail();
        $mail = new SugarPHPMailer();
        $sentFolder = null;
        try {
            $handler->connectToNonGmailServerPublic($ie, $mail, $sentFolder);
            $this->assertTrue(false);
        } catch (InvalidArgumentException $e) {
            $this->assertEquals(NonGmailSentFolderHandler::ERR_SHOULD_BE_STRING, $e->getCode());
        }
        
        
        // positive test imposible until using imap_xxx fucntions.. (valid imap resource needed)
//        $sentFolder = 'foo';
//        $ret = $handler->connectToNonGmailServerPublic($ie, $mail, $sentFolder);
//        $this->assertFalse($ret);
  
//        $ie = new InboundEmailMock();
//        $ret = $handler->connectToNonGmailServerPublic($ie, $mail, $sentFolder);
//        $this->assertTrue($ret);
    }
}
