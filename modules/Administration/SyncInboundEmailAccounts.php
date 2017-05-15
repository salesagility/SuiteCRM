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


class SyncInboundEmailAccountsIMapConnectionException extends Exception {}

//class SyncInboundEmailAccountsIMapConnection
//{
//
//    public function connect(InboundEmail $ie, $test = false, $force = false, $useSsl = null) {
//
//        // override $_REQUEST['ssl'] as an argument for
//        // old one method InboundEmails::connectMailserver()
//        // to make sure the behavior is same
//
//        if(null != $useSsl) {
//            $_REQUEST['ssl'] = $useSsl;
//        }
//
//        // connect to mail server view old method
//
//        // TODO: check first, may we have to restore the folder name to INBOX
//
//        $results = $ie->connectMailserver($test, $force);
//
//        // handle the error..
//
//        if($results !== "true") {
//            throw new SyncInboundEmailAccountsIMapConnectionException("Connection failed to IMap ({$ie->name}): " . $results);
//        }
//
//    }
//
//    /**
//     * @todo !@# rename this function to updateEmails();
//     */
//    public function getEmailHeaders(InboundEmail $ie) {
//
//        $results = array();
//
//        $headers = imap_headers($ie->conn);
//        foreach($headers as $header) {
//            $mailbox_id = $this->getCompoundMessageIdMD5($header, $ie);
//            $results[$mailbox_id] = array(
//                'orphaned' => false,
//                'uid' => $ie->uid,
//            );
//        }
//
//        return $results;
//
///*
//        //$ieUIDs = $this->getEmailUIDs($ie);
//        //$ieUIDs = $this->validateUIDs($ieUIDs);
//
//        // Returns an array of string formatted with header info.
//        // One element per mail message.
//        $headers = imap_headers($ie->conn);
//
//        //$ieCurrent = BeanFactory::getBean('InboundEmails');
//
//        $md5s = array();
//
//        foreach($headers as $uid => $header) {
//            $md5 = $this->getCompoundMessageIdMD5($header, $ie->id);
//            // TODO: $md5 = $this->validateMD5($md5); // TODO: clean up value before pass to sql query
//            $md5s[$uid] = "'$md5'";
//            //$ieCurrent->retrieve_by_string_fields(array('message_id' => $md5, 'message_id'));
//
//                // TODO: make a simple update query emails table contains the message_id which is in $md5 variable,
//
//            //$ieCurrent->save();
//            // TODO: max 100 rows handled make it a configurable constant
//            if(count($md5s) > 100) {
//                $this->updateOrphaned($md5s);
//                $md5s = array();
//            }
//        }
//
//        if(!empty($md5s)) {
//            $this->updateOrphaned($md5s);
//        }
//
//        // TODO: update uid-s in emails table by (md5) mailbox_ids
//        foreach($md5s as $uid => $md5) {
//            // TODO: validate and escape values before pass to sql
//            // TODO: $this->validate($uid);
//            // TODO: $this->validateMD5($md5);
//            $q = "UPDATE emails SET uid = {$uid} WHERE mailbox_id = '{$md5}'";
//            $this->db->query($q);
//        }
//*/
//    }
//
//    private function getCompoundMessageIdMD5($header, InboundEmail $ie) {
//        $compoundMessageId = trim($ie->getMessageId($header)) . trim($ie->id);
//        return $compoundMessageId;
//    }
//
//    private function updateOrphaned($md5s) {
//        // TODO: testing: which is the correct query for update orphaned infos? :)
//        //$q = "UPDATE emails SET orphaned = 1 WHERE emails.mailbox_id NOT IN (" . implode(", ", $md5s) . ");";
//        //$q = "UPDATE emails SET orphaned = 0 WHERE emails.mailbox_id IN (" . implode(", ", $md5s) . ");";
//
//        $q = "SELECT id, mailbox_id FROM emails WHERE mailbox_id IN (" . implode(", ", $md5s) . ");";
//        $results = $this->select($q);
//
//
//        BeanFactory::getBean('email');
//        foreach($results as $row) {
//            // TODO: !@#
//        }
//
//        $q = "UPDATE emails SET orphaned = (SELECT emails.mailbox_id IN (" . implode(", ", $md5s) . "));";
//        echo '<pre>';
//        print_r($q);
//        echo '</pre>';
//
//        $this->db->query($q);
//
//    }
//
//    // TODO: this function already there somewhere...!!!
//    private function select($q) {
//        $ret = array();
//        $r = $this->db->query($q);
//        while($e = $this->db->fetchByAssoc($r)) {
//            $ret[$e['id']] = $e;
//        }
//        if(empty($ret)) {
//            throw new SyncInboundEmailAccountsEmptyException("No imported related Email to Inbound Email Accounts");
//        }
//        return $ret;
//    }
//
//    protected function getEmailUIDs(InboundEmails $ie) {
//
//        $ieUIDs = imap_sort($ie->conn, SORTDATE, 0, SE_UID);
//
//        return $ieUIDs;
//    }
//
//    protected function validateUIDs($ieUIDs) {
//
//        if($ieUIDs) {
//            foreach ($ieUIDs as &$ieUID) {
//                $ieUID = (int)$ieUID;
//                if (!$ieUID) {
//                    throw SyncInboundEmailAccountsInvalidException("Invalid email UID from IMap");
//                }
//            }
//        } else {
//            throw new SyncInboundEmailAccountsEmptyException("There is no any UID to validate");
//        }
//
//        return $ieUIDs;
//    }
//
//    public function close() {
//
//    }
//
//
//}



include_once "SyncInboundEmailAccounts/SyncInboundEmailAccountsSubActionHandler.php";
include_once "SyncInboundEmailAccounts/SyncInboundEmailAccountsPage.php";

new SyncInboundEmailAccountsPage(get_defined_vars());