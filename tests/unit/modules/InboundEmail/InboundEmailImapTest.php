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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class InboundEmailImapTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {
    
    public function testSavePersonalEmailAccount() {
        
    }
    
    public function testSetSessionInboundFoldersString() {
        // TODO ...
    }
    
    public function testSetSessionConnectionString() {
        // TODO ...
    }
    
    public function testSetSessionInboundDelimiterString() {
        // TODO ...
    }
    
    public function testIsPop3Protocol() {
        // TODO ...
    }
    
    public function testGetStoredOptions() {
        // TODO ...
    }
    
    public function testGetConnectString() {
        // TODO ...
    }
    
    public function testGetServiceString() {
        // TODO ...
    }
    
    public function testGetImapConnection() {
        // TODO ...
    }
    
    public function testFindOptimumSettings() {
        $ie = new InboundEmail();
        
        // should success
        $useSsl = false;
        $user = 'sa.tester2';
        $pass = 'chilisauce';
        $server = 'smtp.gmail.com';
        $port = '587';
        $prot = 'imap';
        $mailbox = 'INBOX';
        $result = $ie->findOptimumSettings($useSsl, $user, $pass, $server, $port, $prot, $mailbox);
        $this->assertEquals(null, $result);
        $this->assertEquals(null, $this->email_password);
        $this->assertEquals(null, $this->email_user);
        $this->assertEquals(null, $this->server_url);
        $this->assertEquals(null, $this->port);
        $this->assertEquals(null, $this->protocol);
        $this->assertEquals(null, $this->mailbox);
        $this->assertEquals(null, $this->conn);    
        
        // with no data
        $result = $ie->findOptimumSettings();
        $this->assertEquals(null, $result);
        $this->assertTrue(!isset($this->email_password));
        $this->assertTrue(!isset($this->email_user));
        $this->assertTrue(!isset($this->server_url));
        $this->assertTrue(!isset($this->port));
        $this->assertTrue(!isset($this->protocol));
        $this->assertTrue(!isset($this->mailbox));
        $this->assertTrue(!isset($this->conn));  
        
        // with wrong data
        $useSsl = false;
        $user = 'foo';
        $pass = 'bar';
        $server = 'bazz';
        $port = '123';
        $prot = 'proto';
        $mailbox = 'mbox';
        $result = $ie->findOptimumSettings($useSsl, $user, $pass, $server, $port, $prot, $mailbox);        
        $this->assertEquals(null, $result);
        $this->assertTrue(!isset($this->email_password));
        $this->assertTrue(!isset($this->email_user));
        $this->assertTrue(!isset($this->server_url));
        $this->assertTrue(!isset($this->port));
        $this->assertTrue(!isset($this->protocol));
        $this->assertTrue(!isset($this->mailbox));
        $this->assertTrue(!isset($this->conn));           
    }
    
    public function testConnectMailServerWithFolderIsInbound() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        $ie = new InboundEmail();
        
        $_REQUEST['folder'] = 'inbound';
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result); 
        $this->assertEquals('INBOX', $ie->mailbox);
        $this->assertEquals(null, $ie->conn);
                
        $_REQUEST['folder'] = 'inbound';
        $ie->mailboxarray = [0 => 'bar'];
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result); 
        $this->assertEquals('bar', $ie->mailbox);
        
        $_REQUEST['folder'] = 'inbound';
        $_REQUEST['folder_name'] = 'foo';
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result); 
        $this->assertEquals('foo', $ie->mailbox);
        
        $state->popGlobals();
    }
    
    public function testConnectMailServerWithFolder() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        $ie = new InboundEmail();
        
        $_REQUEST['folder'] = 'foo';
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result); 
        
        $_REQUEST['folder'] = 'sent';
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result); 
        $this->assertEquals(null, $ie->mailbox);
        
        $state->popGlobals();
    }
    
    public function testConnectMailserverWithSSL() {
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        $ie = new InboundEmail();
        
        $_REQUEST['ssl'] = true;
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result); 
        
        $_REQUEST['ssl'] = 'true';
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result);
        
        $state->popGlobals();
    }
        
    public function testConnectMailserver() {
        $ie = new InboundEmail();
        
        $result = $ie->connectMailserver(false, false);
        $this->assertEquals('false', $result);
        
        $result = $ie->connectMailserver(true, false);
        // result sould contains an error message, 
        // e.g: 'Can't open mailbox {:/service=}: invalid remote specification<p><p><p>' matches expected null.
        $this->assertTrue(is_string($result) || !empty($result)); 
        
        $result = $ie->connectMailserver(false, true);
        $this->assertEquals('false', $result);
        
        $result = $ie->connectMailserver(true, true);
        // result sould contains an error message, 
        // e.g: 'Can't open mailbox {:/service=}: invalid remote specification<p><p><p>' matches expected null.
        $this->assertTrue(is_string($result) || !empty($result)); 
    }
    
    public function testRenameFolder() {
        // TODO ...
    }
    
    public function testInboundEmail() {
        global $sugar_config;
        $ie = new InboundEmail();
        $this->assertEquals(sugar_cached('modules/InboundEmail'), $ie->InboundEmailCachePath);
        $this->assertEquals(sugar_cached('modules/Emails'), $ie->EmailCachePath);
        $this->assertTrue($ie->smarty instanceof Sugar_Smarty);
        $this->assertTrue($ie->overview instanceof Overview);
        $this->assertEquals("{$sugar_config['site_url']}/cache/images/", $ie->imagePrefix);
    }
    
}
