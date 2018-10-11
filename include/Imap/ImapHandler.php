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


/**
 * ImapHandler
 *
 * @author gyula
 */
class ImapHandler implements ImapHandlerInterface {
    
    /**
     *
     * @var resource|boolean
     */
    protected $stream;
    
    /**
     * 
     * @return boolean
     */
    public function close() {
        $ret = imap_close($this->stream);
        return $ret;
    }

    /**
     * 
     * @return array
     */
    public function getAlerts() {
        $ret = imap_alerts();        
        return $ret;
    }

    /**
     * 
     * @return resource|boolean
     */
    public function getConnection() {
        $ret = $this->stream;
        return $ret;
    }

    /**
     * 
     * @return array
     */
    public function getErrors() {
        $ret = imap_errors();
        return $ret;
    }

    /**
     * 
     * @return string|boolean
     */
    public function getLastError() {
        $ret = imap_last_error();
        return $ret;
    }

    /**
     * 
     * @param string $ref
     * @param string $pattern
     * @return array
     */
    public function getMailboxes($ref, $pattern) {
        $ret = imap_getmailboxes($this->stream, $ref, $pattern);
        return $ret;
    }

    /**
     * 
     * @return boolean
     */
    public function isAvailable() {
        $ret = function_exists("imap_open") && function_exists("imap_timeout");
        return $ret;
    }

    /**
     * 
     * @param string $mailbox
     * @param string $username
     * @param string $password
     * @param int $options
     * @param int $n_retries
     * @param array|null $params
     * @return resource|boolean
     */
    public function open($mailbox, $username, $password, $options = 0, $n_retries = 0, $params = null) {
        $this->stream = imap_open($mailbox, $username, $password, $options, $n_retries, $params);
        return $this->stream;
    }

    /**
     * 
     * @return boolean
     */
    public function ping() {
        $ret = imap_ping($this->stream);
        return $ret;
    }
    
    /**
     * 
     * @param string $mailbox
     * @param int $options
     * @param int $n_retries
     * @return boolean
     */
    public function reopen($mailbox, $options = 0, $n_retries = 0) {
        $ret = imap_reopen($this->stream, $mailbox, $options, $n_retries);
        return $ret;
    }

    /**
     * 
     * @param int $timeout_type
     * @param int $timeout
     * @return mixed
     */
    public function setTimeout($timeout_type, $timeout = -1) {
        $ret = imap_timeout($timeout_type, $timeout);
        return $ret;
    }

}
