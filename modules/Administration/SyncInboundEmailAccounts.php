<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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


// include the the dependencies and related or used beans at least once to let IDE to see it
include_once('modules/InboundEmail/InboundEmail.php');
include_once('modules/Emails/Email.php');

class SyncInboundEmailAccountsEmptyException extends Exception {}

class SyncInboundEmailAccountsNoMethodException extends Exception {}

class SyncInboundEmailAccountsInvalidMethodTypeException extends Exception {}

/**
 * Class SyncInboundEmailAccountsInvalidSubActionArgumentsException
 *
 * Handle the action calls with incorrect argument(s)
 *
 * It is a simple exception with an additional message which
 * contains the incorrectly called action-method name
 *
 */
class SyncInboundEmailAccountsInvalidSubActionArgumentsException extends Exception
{

    /**
     * steps for get the caller method in the backtrace
     *
     * @var int
     */
    protected $callerMethodDistance = 2;

    /**
     * SyncInboundEmailAccountsInvalidSubActionArgumentsException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        parent::__construct(
            ($message ? $message . " - " : "") .
            "An action called with wrong parameters, incorrectly called action was: " .
            $this->getCallerMethod(), $code, $previous
        );

    }

    /**
     * Return the caller function/method name
     * call this function without argument
     * if you override this method may you have to change
     * the $this->callerMethodBackStep default value or
     * override it with step parameter
     *
     * @param int $step
     * @return mixed
     */
    protected function getCallerMethod($step = 2) {

        $trace = debug_backtrace();
        $function = $trace[$step ? $step : $this->callerMethodBackStep]['function'];

        return $function;
    }

}


class SyncInboundEmailAccountsEmailHeaderInfo
{

}


class SyncInboundEmailAccountsIMapConnectionException extends Exception {}

class SyncInboundEmailAccountsIMapConnection
{

    public function connect(InboundEmail $ie, $test = false, $force = false, $useSsl = null) {

        // override $_REQUEST['ssl'] as an argument for
        // old one method InboundEmails::connectMailserver()
        // to make sure the behavior is same

        if(null != $useSsl) {
            $_REQUEST['ssl'] = $useSsl;
        }

        // connect to mail server view old method

        // TODO: check first, may we have to restore the folder name to INBOX

        $results = $ie->connectMailserver($test, $force);

        // handle the error..

        if($results !== "true") {
            throw new SyncInboundEmailAccountsIMapConnectionException("Connection failed to IMap ({$ie->name}): " . $results);
        }

    }

    /**
     * @todo !@# rename this function to updateEmails();
     */
    public function getEmailHeaders(InboundEmail $ie) {

        //$ieUIDs = $this->getEmailUIDs($ie);
        //$ieUIDs = $this->validateUIDs($ieUIDs);

        // Returns an array of string formatted with header info.
        // One element per mail message.
        $headers = imap_headers($ie->conn);

        //$ieCurrent = BeanFactory::getBean('InboundEmails');

        $md5s = array();

        foreach($headers as $uid => $header) {
            $md5 = $ie->getMessageId($header);
            // TODO: $md5 = $this->validateMD5($md5); // TODO: clean up value before pass to sql query
            $md5s[$uid] = "'$md5'";
            //$ieCurrent->retrieve_by_string_fields(array('message_id' => $md5, 'message_id'));

                // TODO: make a simple update query emails table contains the message_id which is in $md5 variable,

            //$ieCurrent->save();
        }

        // TODO: testing: which is the correct query for update orphaned infos? :)
        //$q = "UPDATE emails SET orphaned = 1 WHERE emails.mailbox_id NOT IN (" . implode(", ", $md5s) . ");";
        //$q = "UPDATE emails SET orphaned = 0 WHERE emails.mailbox_id IN (" . implode(", ", $md5s) . ");";
        $q = "UPDATE emails SET orphaned = emails.mailbox_id IN (" . implode(", ", $md5s) . ");";

        $this->db->query($q);


        // TODO: update uid-s in emails table by (md5) mailbox_ids
        foreach($md5s as $uid => $md5) {
            // TODO: validate and escape values before pass to sql
            // TODO: $this->validate($uid);
            // TODO: $this->validateMD5($md5);
            $q = "UPDATE emails SET uid = {$uid} WHERE mailbox_id = '{$md5}'";
            $this->db->query($q);
        }

    }

    protected function getEmailUIDs(InboundEmails $ie) {

        $ieUIDs = imap_sort($ie->conn, SORTDATE, 0, SE_UID);

        return $ieUIDs;
    }

    protected function validateUIDs($ieUIDs) {

        if($ieUIDs) {
            foreach ($ieUIDs as &$ieUID) {
                $ieUID = (int)$ieUID;
                if (!$ieUID) {
                    throw SyncInboundEmailAccountsInvalidException("Invalid email UID from IMap");
                }
            }
        } else {
            throw new SyncInboundEmailAccountsEmptyException("There is no any UID to validate");
        }

        return $ieUIDs;
    }

    public function close() {

    }


}


/**
 * Class SyncInboundEmailAccountsSubActionHandler
 *
 * Separated methods specially for SyncInboundEmailAccounts sub-actions handling
 *
 */
class SyncInboundEmailAccountsSubActionHandler
{

    /**
     * @var SyncInboundEmailAccounts
     */
    protected $sync;


    /**
     * SyncInboundEmailAccountsSubActionHandler constructor.
     *
     * Handle sub-action for Sync Inbound Email Accounts
     *
     * @param SyncInboundEmailAccounts $sync
     * @throws SyncInboundEmailAccountsInvalidMethodTypeException
     * @throws SyncInboundEmailAccountsNoMethodException
     */
    public function __construct(SyncInboundEmailAccounts $sync) {

        $this->sync = $sync;

        $subAction = $this->getRequestedSubAction();

        switch ($subAction) {

            case 'index' :
                $this->action_Index();
                break;

            case 'sync' :
                $this->action_Sync();
                break;

            default:
                throw new SyncInboundEmailAccountsNoMethodException(
                    "trying to call an unsupported method: " . $subAction);

        }

    }

    /**
     * Return the requested sub action, use $_REQUEST['method']
     * or an 'index' string by default if request was empty or incorrect
     *
     * @return string
     * @throws SyncInboundEmailAccountsInvalidMethodTypeException
     */
    protected function getRequestedSubAction() {

        $ret = "index";

        // handle requested sub-action in method parameter

        if(isset($_REQUEST['method']) && $_REQUEST['method']) {
            $ret = $_REQUEST['method'];

            // validate for correct method
            if(!is_string($ret)) {
                throw new SyncInboundEmailAccountsInvalidMethodTypeException(
                    "Method name should be a string but received type is: " . gettype($ret));
            }
        }

        return $ret;
    }

    /**
     * Default 'index' action, shows the main form
     *
     * @throws SyncInboundEmailAccountsNoAccountException
     */
    protected function action_Index() {

        // fetch data to view
        $ieList = $this->sync->getInboundEmailRows();

        // show sync-form
        $this->sync->showForm($ieList);

    }


    protected function action_Sync() {


        $ieList = $this->sync->getRequestedInboundEmailAccounts();

        /**
         * @var InboundEmail
         */
        $ie = BeanFactory::getBean('InboundEmail');

        /**
         * @var Email
         */
        $e = BeanFactory::getBean('Email');

        foreach($ieList as $ieId) {
            $ie->retrieve($ieId);
            // TODO: !@# show the currently syncing email name correctly via Smarty template
            $imap = new SyncInboundEmailAccountsIMapConnection();
            $imap->connect($ie);
            $headers = $imap->getEmailHeaders($ie);
            $imap->close();
            foreach($headers as $header) {
                $mailbox_id = $this->getMailboxIdFromHeader($header);
                $e->retrieve_by_string_fields(array('mailbox_id' => $mailbox_id));
                $e->uid = $header->getUid();
                $e->orphaned = $header->isOrphaned();
                $e->save();
            }


        }

    }



    /**
     * This function only for main form handling,
     * calling by sync action to get selected inbound email accounts
     *
     * @return array
     * @throws SyncInboundEmailAccountsInvalidSubActionArgumentsException
     * @throws SyncInboundEmailAccountsNoAccountException
     */
    protected function getRequestedInboundEmailAccounts() {

        // validate for selected inbound email(s)

        if(!isset($_REQUEST['ie-sel'])) {
            // it's should be in the request
            throw new SyncInboundEmailAccountsInvalidSubActionArgumentsException("Invalid action parameter");
        }

        $ieSel = $_REQUEST['ie-sel'];

        if(!$ieSel) {
            // if there is not any selected, just fill out with all inbound email
            $ieSel = array_key($this->sync->getInboundEmailRows());
        }

        return $ieSel;
    }

}

/**
 * Class SyncInboundEmailAccounts
 *
 * Handle the page of 'Sync Inbound Email Accounts' menu item in Admin page / Repair section
 * - handle the current sub/ajax actions
 * - sync email-UID and orphaned field in email module
 *
 */
class SyncInboundEmailAccounts extends SyncInboundEmailAccountsSubActionHandler
{

    /**
     * @var array
     */
    protected $includeData;

    /**
     * @var DBManager
     */
    protected $db;

    /**
     * @var Sugar_Smarty
     */
    protected $tpl;

    /**
     * SyncInboundEmailAccounts constructor.
     *
     * The $includeData parameter should contains all variable
     * in php included file by action, use get_defined_vars()
     * The class handle a sub-action called method, use $_REQUEST['method']
     *
     * @param $includeData array
     */
    public function __construct($includeData) {
        try {
            // create object state

            $this->includeData = $includeData;
            $this->db = DBManagerFactory::getInstance();
            $this->tpl = new Sugar_Smarty();
            $this->tpl->assign('app_strings', $this->includeData['app_strings']);

            // handle the sub-action

            new SyncInboundEmailAccountsSubActionHandler($this);
        } catch(Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Return all results for non-deleted active inbound email account
     * in an inbound email account id indexed array
     *
     * @return array
     * @throws SyncInboundEmailAccountsEmptyException
     */
    public function getInboundEmailRows() {

        $ret = $this->select("SELECT * FROM inbound_email WHERE status='Active' AND deleted = 0;");

        return $ret;
    }


    /**
     * Retrieve all email focused for an Inbound Email Account (ID)
     * in return array indexed by email.id
     *
     * @param $ieId
     * @return array
     * @throws SyncInboundEmailAccountsEmptyException
     */
    public function getInboundEmailAccountEmails($ieId) {

        if(!$this->isValid($ieId)) {
            throw new SyncInboundEmailAccountsInvalidException("Invalid GUID requested");
        }

        $ret = $this->select("SELECT * FROM emails WHERE mailbox_id = '$ieId' AND deleted = 0;");

        return $ret;
    }

    private function isValidGUID($id) {

        $valid = is_string($id) && preg_match('/[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}/', $id);

        return $valid;
    }

    private function select($q) {

        $ret = array();
        $r = $this->db->query($q);
        while($e = $this->db->fetchByAssoc($r)) {
            $ret[$e['id']] = $e;
        }
        if(empty($ret)) {
            throw new SyncInboundEmailAccountsEmptyException("No imported related Email to Inbound Email Accounts");
        }

        return $ret;
    }

    /**
     * sync an email with inbound email account via IMAP
     * use email ID and inbound_email account ID.
     *
     * @param Email $email
     * @param InboundEmail $inboundEmail
     */
    public function syncEmailWithImap(Email $email, InboundEmail $inboundEmail) {
        $inboundEmail->syncEmail();
    }

    /**
     * Show basic UI for Sync Inbound Email Accounts
     *
     * @param $ieList
     */
    protected function showForm($ieList) {
        $this->tpl->assign('ieList', $ieList);
        $this->tpl->display('modules/Administration/templates/SyncInboundEmailAccounts.tpl');
    }

}

new SyncInboundEmailAccounts(get_defined_vars());