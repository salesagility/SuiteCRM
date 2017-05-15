<?php

/**
 * Class SyncInboundEmailAccounts
 *
 * Handle the page of 'Sync Inbound Email Accounts' menu item in Admin page / Repair section
 * - handle the current sub/ajax actions
 * - sync email-UID and orphaned field in email module
 *
 */
class SyncInboundEmailAccountsPage extends SyncInboundEmailAccountsSubActionHandler
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
