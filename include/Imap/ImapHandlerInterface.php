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
 * ImapHandlerInterface
 *
 * @author gyula
 */
interface ImapHandlerInterface
{
    
    /**
     *
     * @return boolean
     */
    public function isAvailable();
    
    /**
     *
     * @return string|boolean
     */
    public function getLastError();
    
    /**
     *
     * @return array
     */
    public function getErrors();

    /**
     *
     * @return array
     */
    public function getAlerts();
    
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
    public function open($mailbox, $username, $password, $options = 0, $n_retries = 0, $params = null);
    
    /**
     *
     * @return boolean
     */
    public function close();
    
    /**
     *
     * @return boolean
     */
    public function ping();
    
    /**
     *
     * @param string $mailbox
     * @param int $options
     * @param int $n_retries
     * @return boolean
     */
    public function reopen($mailbox, $options = 0, $n_retries = 0);

    /**
     *
     * @return resource|boolean
     */
    public function getConnection();
    
    /**
     *
     * @param int $timeout_type
     * @param int $timeout
     * @return mixed
     */
    public function setTimeout($timeout_type, $timeout = -1);
    
    /**
     *
     * @param string $ref
     * @param string $pattern
     * @return array
     */
    public function getMailboxes($ref, $pattern);
    
    /**
     *
     * @param int $criteria
     * @param int $reverse
     * @param int $options
     * @param string $search_criteria
     * @param string $charset
     * @return array
     */
    public function sort($criteria, $reverse, $options = 0, $search_criteria = null, $charset = null);
    
    /**
     *
     * @param int $uid
     * @return int
     */
    public function getMessageNo($uid);
    
    /**
     *
     * @param int $msg_number
     * @param int $fromlength
     * @param int $subjectlength
     * @param string $defaulthost
     * @return bool|object Returns FALSE on error or, if successful, the information in an object
     */
    public function getHeaderInfo($msg_number, $fromlength = 0, $subjectlength = 0, $defaulthost = null);
    
    /**
     *
     * @param type $msg_number
     * @param type $options
     * @return string
     */
    public function fetchHeader($msg_number, $options = 0);
    
    /**
     *
     * @param string $mailbox
     * @param string $message
     * @param string $options
     * @param string $internal_date
     * @return bool
     */
    public function append($mailbox, $message, $options = null, $internal_date = null);
    
    /**
     *
     * @param int $msg_number
     * @return int
     */
    public function getUid($msg_number);
    
    /**
     * @return bool
     */
    public function expunge();
}
