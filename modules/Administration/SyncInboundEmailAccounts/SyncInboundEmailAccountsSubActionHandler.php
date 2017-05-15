<?php
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
    public function __construct(SyncInboundEmailAccountsPage $sync) {

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
            $ie = BeanFactory::getBean('InboundEmail', $ieId);
            echo "{$ie->name}...<br>";
            try {
                $IMAPHeaders = $this->getEmailHeadersOfIMAPServer($ie);

                $emailIds = $this->getEmailIdsOfInboundEmail($ieId);

                $updated = 0;
                foreach($emailIds as $emailId => $emailData) {
                    if($e = BeanFactory::getBean('Email', $emailId)) {
                        $e->orphaned = $this->isOrphanedEmail($e, $ie, $IMAPHeaders);
                        $e->save();
                        $updated++;
                    }
                }
            } catch (SyncInboundEmailAccountsIMapConnectionException $e) {
                echo "error: " . $e->getMessage();
            }
            echo " {$updated} record updated<br>";

        }
        echo "finished<br>";
/*
//        foreach($ieList as $ieId) {
//            $ie->retrieve($ieId);
//            // TODO: !@# show the currently syncing email name correctly via Smarty template
//            $imap = new SyncInboundEmailAccountsIMapConnection();
//            $imap->connect($ie);
//            $headers = $imap->getEmailHeaders($ie);
//            $imap->close();
//
//            $emails = BeanFactory::getBean('Email')->get_full_list("emails.last_sync", "emails.");
//
//            foreach($headers as $header) {
//                $mailbox_id = $this->getMailboxIdFromHeader($header);
//                $e->retrieve_by_string_fields(array('mailbox_id' => $mailbox_id));
//                $e->uid = $header->getUid();
//                $e->orphaned = $header->isOrphaned();
//                $e->save();
//            }
//
//
//        }
*/
    }

    protected function getEmailIdsOfInboundEmail($ieId) {
        $this->validateGUID($ieId);
        $query = "SELECT id FROM emails WHERE mailbox_id = '{$ieId}' AND deleted = 0;";
        $emailIds = $this->select($query);

        return $emailIds;
    }

    private function validateGUID($id) {
        // todo: regex validation for bean id
    }

    // TODO: this function already there somewhere...!!!
    private function select($query) {
        // todo: run sql select, grab results into an array and pass back in return
        $ret = array();
        $r = $this->sync->db->query($query);
        while($e = $this->sync->db->fetchByAssoc($r)) {
            $ret[$e['id']] = $e;
        }
        return $ret;
    }

    protected function getEmailHeadersOfIMAPServer(InboundEmail $ie, $test = false, $force = false, $useSsl = null) {

        // ---------- CONNECT TO IMAP ------------

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

        // ------------- READ IMAP EMAIL-HEADERS AND CALCULATE MD5 BASED MESSAGE_IDs ----------------

        // todo: error handle

        $imap_uids = imap_sort($ie->conn, SORTDATE, 0, SE_UID);
        foreach($imap_uids as $imap_uid) {
            $headers[$imap_uid] = imap_header($ie->conn, $imap_uid);
        }


        foreach($headers as &$header) {
            $header->message_id_md5 = $this->getCompoundMessageIdMD5($header, $ie);
        }


        // ------------ IMAP CLOSE -------------
        // todo: error handle
        imap_close($ie->conn);


        return $headers;

    }

    private function getCompoundMessageIdMD5($header, InboundEmail $ie) {
        $compoundMessageId = md5(trim($ie->getMessageId($header)) . trim($ie->id));
        return $compoundMessageId;
    }

    protected function isOrphanedEmail(Email $e, $IMAPheaders) {
        foreach($IMAPheaders as $header) {
            if($header->message_id_md5 == $e->message_id) {
                return false;
            }
        }
        return true;
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
