<?php
/**
 * Class SyncInboundEmailAccountsSubActionHandler
 *
 * Separated methods specially for SyncInboundEmailAccounts sub-actions handling
 *
 */
class SyncInboundEmailAccountsSubActionHandler
{

    const PROCESS_OUTPUT_FILE = "modules/Administration/SyncInboundEmailAccounts/sync_output.html";

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
        $ieList = $this->getInboundEmailRows();

        // show sync-form
        $this->sync->showForm($ieList);

    }

    /**
     * Return all results for non-deleted active inbound email account
     * in an inbound email account id indexed array
     *
     * @return array
     * @throws SyncInboundEmailAccountsEmptyException
     */
    private function getInboundEmailRows() {

        $ret = $this->select("SELECT * FROM inbound_email WHERE status='Active' AND deleted = 0;");

        return $ret;
    }

    protected function action_Sync() {

        global $mod_strings;

        $this->cleanup();

        // todo: translate
        $this->output("Sync Inbound Email Account. This may take several minutes. Going away from this page will not cancel the process, so feel free to move on or wait for confirmation...");

        $ieList = $this->sync->getRequestedInboundEmailAccounts();

        /**
         * @var InboundEmail
         */
        $ie = BeanFactory::getBean('InboundEmail');

        /**
         * @var Email
         */
        $e = BeanFactory::getBean('Email');

        foreach ($ieList as $ieId) {
            $ie = BeanFactory::getBean('InboundEmail', $ieId);
            $this->output(sprintf($mod_strings['LBL_SYNC_PROCESSING'], $ie->name));
            try {
                $IMAPHeaders = $this->getEmailHeadersOfIMAPServer($ie);

                $emailIds = $this->getEmailIdsOfInboundEmail($ieId);

                $updated = 0;
                foreach ($emailIds as $emailId => $emailData) {
                    if ($e = BeanFactory::getBean('Email', $emailId)) {
                        $e->orphaned = $this->isOrphanedEmail($e, $ie, $IMAPHeaders);
                        $e->uid = $this->getIMAPUID($e->message_id, $IMAPHeaders);
                        $e->save();
                        $updated++;
                    }
                }
            } catch (SyncInboundEmailAccountsIMapConnectionException $e) {
                $GLOBALS['log']->warn($e->getMessage());
                $this->output($mod_strings['LBL_SYNC_ERROR_CONN']);
            }

            $this->output(sprintf($mod_strings['LBL_SYNC_UPDATED'], $updated));

        }
        $this->output($mod_strings['LBL_SYNC_DONE']);

        $output = file_get_contents(self::PROCESS_OUTPUT_FILE);

        $this->cleanup();

        echo $output;
        die();
    }

    private function cleanup() {
        // todo: handle error
        if(file_exists(self::PROCESS_OUTPUT_FILE)) {
            unlink(self::PROCESS_OUTPUT_FILE);
        }
    }

    private function output($msg) {
        $msg = "{$msg}<br>";
        // todo: handle error
        file_put_contents(self::PROCESS_OUTPUT_FILE, $msg, FILE_APPEND);
    }

    private function getIMAPUID($emailMD5, $IMAPHeaders) {
        foreach($IMAPHeaders as $header) {
            if($header->message_id_md5 == $emailMD5) {
                return $header->imap_uid;
            }
        }
        return null;
    }

    protected function getEmailIdsOfInboundEmail($ieId) {
        $this->validateGUID($ieId);
        $query = "SELECT id FROM emails WHERE mailbox_id = '{$ieId}' AND deleted = 0;";
        $emailIds = $this->select($query);

        return $emailIds;
    }

    private function isValidGUID($guid) {

        $valid = is_string($id) && preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', $guid);

        return $valid;
    }

    // TODO: this function already there somewhere...!!!
    private function select($query) {

        // run sql select, grab results into an array and pass back in return
        $ret = array();
        $r = $this->sync->db->query($query);
        while($e = $this->sync->db->fetchByAssoc($r)) {
            $ret[$e['id']] = $e;
        }
        if(empty($ret)) {
            throw new SyncInboundEmailAccountsEmptyException("No imported related Email to Inbound Email Accounts");
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
            $headers[$imap_uid]->imap_uid = $imap_uid;
        }


        foreach($headers as &$header) {
            $header->message_id_md5 = $this->getCompoundMessageIdMD5($header, $ie, $imap_uid);
        }


        // ------------ IMAP CLOSE -------------
        // todo: error handle
        imap_close($ie->conn);


        return $headers;

    }

    private function getCompoundMessageIdMD5($header, InboundEmail $ie, $uid, $msgNo = null) {

        if(empty($msgNo) and !empty($uid)) {
            $msgNo = imap_msgno ($ie->conn, (int)$uid);
        }

        $textHeader = imap_fetchheader($ie->conn, $msgNo);

        // generate "delivered-to" seed for email duplicate check
        $deliveredTo = $ie->id; // cn: bug 12236 - cc's failing dupe check
        $exHeader = explode("\n", $textHeader);

        foreach ($exHeader as $headerLine) {
            if (strpos(strtolower($headerLine), 'delivered-to:') !== false) {
                $deliveredTo = substr($headerLine, strpos($headerLine, " "), strlen($headerLine));
                //$GLOBALS['log']->debug('********* InboundEmail found [ ' . $deliveredTo . ' ] as the destination address for email [ ' . $message_id . ' ]');
            } elseif (strpos(strtolower($headerLine), 'x-real-to:') !== false) {
                $deliveredTo = substr($headerLine, strpos($headerLine, " "), strlen($headerLine));
                //$GLOBALS['log']->debug('********* InboundEmail found [ ' . $deliveredTo . ' ] for non-standards compliant email x-header [ ' . $message_id . ' ]');
            }
        }

        $compoundMessageId = md5(trim($ie->getMessageId($header)) . trim($deliveredTo));

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
            $ieSel = array_key($this->getInboundEmailRows());
        }

        return $ieSel;
    }

}
