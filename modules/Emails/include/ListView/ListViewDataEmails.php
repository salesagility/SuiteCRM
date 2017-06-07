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

require_once('include/ListView/ListViewData.php');

class SuiteException extends Exception {}

/**
 * Class Folder
 *
 * private model class for ListViewDataEmails::getListViewData()
 * represent a fake SugarBean:
 * in legacy logic, Folder ID equals to an Inbound Email ID
 */
class Folder extends SugarBean
{

    /**
     * private
     * @var DBManager $db
     */
    public $db;

    /**
     * private, use Folder::getId() instead
     * @var string UUID in folders table
     */
    public $id;

    /**
     * private, use Folder::getType() instead
     * @var string folder type
     */
    protected $type;

    /**
     * Folder constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->db = DBManagerFactory::getInstance();
        $this->id = null;
        $this->type = "inbound";
    }

    /**
     * @param int|string $folderId - (should be string, int type is legacy)
     * @param bool $encode (legacy, unused)
     * @param bool $deleted (legacy, unused)
     * @return null|string (folder ID)
     * @throws SuiteException
     */
    public function retrieve($folderId = -1, $encode = true, $deleted = true)
    {
        if(isValidId($folderId)) {

            // TODO: use parent::retrieve here
            $result = $this->db->query('SELECT * FROM folders WHERE id="' . $folderId . '"');
            $row = $this->db->fetchByAssoc($result);

            // get the root of the tree
            // is the id of the root node is the same as the inbound email id

            if (empty($row['parent_folder'])) {

                // root node (inbound)

                $this->id = $row['id'];

            } else {

                // child node

                $this->id = $row['parent_folder'];
                $this->type = $row['folder_type'];

            }

        } else {
            throw new SuiteException("Invalid or empty Email Folder ID");
        }

        return $this->id;
    }

    /**
     * @param array $request
     * @return Folder
     * @throws SuiteException
     */
    public function retrieveFromRequest($request) {

        if (isset($request['folders_id']) && !empty($request['folders_id'])) {

            $foldersId = $request['folders_id'];
            $this->retrieve($foldersId);
        } else {
            $GLOBALS['log']->warn("Empty or undefined Email Folder ID");
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return null|string
     */
    public function getId() {
        return $this->id;
    }

}

class ListViewDataEmails extends ListViewData
{
    /**
     * @var array
     * when searching the IMap filter map the crm fields
     * to the IMap fields.
     */
    protected static $mapServerFields = array(
        // bean field => IMap field
        'from_addr_name' => 'FROM',
        'to_addrs_names' => 'TO',
        'cc_addrs_names' => 'CC',
        'bcc_addrs_names' => 'BCC',
        'name' => 'SUBJECT',
        'subject' => 'SUBJECT',
        'description' => 'BODY',
        'imap_keywords' => 'KEYWORD'
    );

    /**
     * @var array
     * never select these fields during crm filter
     */
    protected static $mapIgnoreFields = array(
        'date_entered',
        'indicator',
        'flagged',
        'has_attachment',
        'imap_keywords'
    );

    /**
     * @var array
     * always include these fields during crm filter
     */
    protected static $alwaysIncludeSearchFields = array(
        'id',
        'flagged',
        'name',
        'subject',
        'has_attachment',
        'status',
    );

    /**
     * @var array
     * during crm filter map these fields so that the correct
     * SQL query is created
     */
    protected static $mapEmailFieldsToEmailTextFields = array(
        // emails field => email_text field
        'id' => 'emails.id',
        'from_addr_name' => 'emails_text.from_addr',
        'to_addrs_names' => 'emails_text.to_addrs',
        'cc_addrs_names' => 'emails_text.cc_addrs',
        'bcc_addrs_names' => 'emails_text.bcc_addrs',
        'description' => 'emails_text.description',
        'name' => 'name',
        'subject' => 'name',
        'has_attachment' => 'has_attachment',
        'status' => 'emails.status',
    );


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param User $currentUser
     * @param Folder $folder
     * @return InboundEmail
     * @throws SuiteException
     */
    protected function getInboundEmail(User $currentUser, Folder $folder) {

        $inboundEmailID = $currentUser->getPreference('defaultIEAccount', 'Emails');
        if (!empty($folder->getId())) {
            $inboundEmailID = $folder->getId();
        }

        if ($inboundEmailID && !isValidId($inboundEmailID)) {
            throw new SuiteException("Invalid Inbound Email ID" . ($inboundEmailID ? " ($inboundEmailID)" : ''));
        }

        /**
         * @var InboundEmail $inboundEmail
         */
        $inboundEmail = BeanFactory::getBean('InboundEmail', $inboundEmailID);

        if(!$inboundEmail) {
            throw new SuiteException("Error: InboundEmail not loaded");
        }

        return $inboundEmail;
    }

    /**
     * set $inboundEmail->mailbox and return searchType
     *
     * @param Folder $folder
     * @param InboundEmail $inboundEmail
     * @return string
     */
    protected function getSearchType(Folder $folder, InboundEmail $inboundEmail) {

        switch ($folder->getType()) {

            case "sent":
                $inboundEmail->mailbox = $inboundEmail->get_stored_options('sentFolder');
                $searchType = "imap";
                break;

            case "draft":
                $inboundEmail->mailbox = $inboundEmail->get_stored_options('draftFolder');
                $searchType = "crm";
                break;

            case "trash":
                $inboundEmail->mailbox = $inboundEmail->get_stored_options('trashFolder');
                $searchType = "imap";
                break;

            default:
                $GLOBALS['log']->warn("unknown or undefined folder type (we will use 'imap' instead): " . $folder->getType());
                $searchType = "imap";
                break;
        }

        return $searchType;
    }


    /**
     * it returns filter fields,
     * set searchType to 'crm' if any field is not IMap field
     *
     * @param array $filterFields
     * @param string $where
     * @param array $request
     * @param string $searchType
     * @return array
     */
    protected function getFilter($filterFields, $where, $request, &$searchType) {
        // Create a list of fields to filter and decide based on the field which type of filter to carry out

        $filter = array();

        // $searchType = "imap"; it searches the IMap headers and then searches the crm to see which messages are imported.
        // $searchType = "crm"; it uses the usual crm search and handles the indicator and attachment fields.

        if (!empty($where)) {
            foreach ($filterFields as $filteredField => $filteredFieldValue) {

                // Ignore blank fields
                if (empty($filteredField)) {
                    continue;
                }

                if (!isset($request[$filteredField.'_advanced']) && !isset($request[$filteredField.'_basic'])) {
                    continue;
                }

                if (empty($request[$filteredField.'_advanced']) && empty($request[$filteredField.'_basic'])) {
                    continue;
                }

                // strip out the suffix to the the field names
                if ((stristr($filteredField, 'advanced') !== false) || (stristr($filteredField, 'basic') !== false)) {
                    $f = str_ireplace('_advanced', '', $filteredField);
                    $f = str_ireplace('_basic', '', $f);
                    if (isset(self::$mapServerFields[$f])) {
                        $filter[self::$mapServerFields[$f]] = $filteredFieldValue;
                    }

                    if(array_key_exists($filteredField, $f)) {
                        continue;
                    }

                    // if field name is not an IMap field
                    if (!array_key_exists($f, self::$mapServerFields)) {
                        $searchType = 'crm';
                    }
                } else {
                    // use the field names
                    if(in_array($filteredField, self::$mapIgnoreFields)) {
                        continue;
                    }

                    // if field name is not an IMap field
                    if (!array_key_exists($filteredField, self::$mapServerFields)) {
                        $searchType = 'crm';
                    } else {
                        if (!empty($request[$filteredField.'_advanced'])) {
                            $filter[self::$mapServerFields[$filteredField]] = $request[$filteredField.'_advanced'];
                        } else if (!empty($request[$filteredField.'_basic'])) {
                            $filter[self::$mapServerFields[$filteredField]] = $request[$filteredField.'_basic'];
                        } else {
                            $f = str_ireplace('_advanced', '', $filteredField);
                            $f = str_ireplace('_basic', '', $f);
                            $filter[self::$mapServerFields[$filteredField]] = $f;
                        }
                    }
                }
            }
        }

        return $filter;
    }


    /**
     * Fix fields in filter fields and repair sql $where
     *
     * @param array $filterFields
     * @param array $request $_REQUEST
     * @param string $where
     * @return array
     */
    public function fixFieldsInFilter($filterFields, $request, &$where) {
        // Fix fields in filter fields
        foreach (self::$mapEmailFieldsToEmailTextFields as $EmailSearchField => $EmailTextSearchField) {
            if(array_search($EmailSearchField, self::$alwaysIncludeSearchFields) !== false) {
                $filterFields[$EmailSearchField] = true;
                continue;
            } else if(
                array_key_exists($EmailSearchField . '_advanced', $request) &&
                empty($request[$EmailSearchField . '_advanced'])
            ) {
                $pos = array_search($EmailSearchField, $filterFields);
                unset($filterFields[$pos]);
                continue;
            } else if(
                array_key_exists($EmailSearchField . '_basic', $request) &&
                empty($request[$EmailSearchField . '_basic'])
            ) {
                $pos = array_search($EmailSearchField, $filterFields);
                unset($filterFields[$pos]);
                continue;
            }

            if(!array_key_exists($EmailSearchField, $filterFields)) {
                $filterFields[$EmailTextSearchField] = true;
            } else {
                $pos = array_search($EmailSearchField, $filterFields);
                if($pos !== false) {
                    unset($filterFields[$pos]);
                    $filterFields[$EmailTextSearchField] = true;
                }
            }

            // since the where is hard coded at this point we need to map the fields in the where
            // clause of the SQL
            $where = str_replace($EmailSearchField, $EmailTextSearchField, $where );
        }

        return $filterFields;
    }


    /**
     * Populates CRM fields
     *
     * @param string $crmWhere
     * @param array $filterFields
     * @param array $params
     * @param Email $seed
     * @param bool $singleSelect
     * @return array
     */
    public function getCrmQueryArray($crmWhere, $filterFields, $params, Email $seed, $singleSelect) {

        $crmQueryArray = $seed->create_new_list_query(
            'id',
            $crmWhere,
            $filterFields,
            $params,
            0,
            '',
            true,
            $seed,
            $singleSelect
        );

        $crmQueryArray['inner_join'] = '';
        if (!empty($this->seed->listview_inner_join)) {
            $crmQueryArray['inner_join'] = ' ' . implode(' ', $this->seed->listview_inner_join) . ' ';
        }

        // force join with email_text
        $crmQueryArray['from'] .= ' LEFT JOIN emails_text ON emails_text.email_id = emails.id ';

        return $crmQueryArray;
    }


    /**
     * get crm emails query and fix params custom values
     *
     * @param array $crmQueryArray
     * @param array $params
     * @return string
     */
    public function getCrmEmailsQuery($crmQueryArray, &$params) {

        if (!is_array($params)) {
            $params = array();
        }

        if (!isset($params['custom_select'])) {
            $params['custom_select'] = '';
        }

        if (!isset($params['custom_from'])) {
            $params['custom_from'] = '';
        }

        if (!isset($params['custom_where'])) {
            $params['custom_where'] = '';
        }

        if (!isset($params['custom_order_by'])) {
            $params['custom_order_by'] = '';
        }

        $crmEmailsQuery = $crmQueryArray['select'] .
            $params['custom_select'] .
            $crmQueryArray['from'] .
            $params['custom_from'] .
            $crmQueryArray['inner_join'].
            $crmQueryArray['where'] .
            $params['custom_where'] .
            $crmQueryArray['order_by'] .
            $params['custom_order_by'];

        return $crmEmailsQuery;
    }


    /**
     * get email header status
     *
     * possible return variables:
     * enum('replied', 'draft', 'read', 'unread')
     *
     * @param array $emailHeader
     * @return string
     */
    protected function getEmailHeaderStatus($emailHeader)
    {
        if (isset($emailHeader['answered']) && $emailHeader['answered'] != 0) {
            $ret = 'replied';
        } else {
            if (isset($emailHeader['draft']) && $emailHeader['draft'] != 0) {
                $ret = 'draft';
            } else {
                if (isset($emailHeader['seen']) && $emailHeader['seen'] != 0) {
                    $ret = 'read';
                } else {
                    $ret = 'unread';
                }
            }
        }

        return $ret;
    }


    /**
     * @param string $field
     * @param array $emailHeader
     * @param InboundEmail $inboundEmail
     * @param User $currentUser
     * @param string $folder
     * @param Folder $folderObj
     * @return bool|string
     */
    protected function getEmailRecordFieldValue($field, $emailHeader, InboundEmail $inboundEmail, User $currentUser, $folder, Folder $folderObj) {

        switch ($field) {
            case 'from_addr_name':
                $ret = $emailHeader['from'];
                break;
            case 'to_addrs_names':
                $ret = $emailHeader['to'];
                break;
            case 'has_attachments':
                $ret = false;
                break;
            case 'flagged':
                $ret = $emailHeader['flagged'];
                break;
            case 'name':
                $ret = html_entity_decode($inboundEmail->handleMimeHeaderDecode($emailHeader['subject']));
                break;
            case 'date_entered':
                $date = preg_replace('/(\ \([A-Z]+\))/', '', $emailHeader['date']);

                $dateTime = DateTime::createFromFormat(
                    'D, d M Y H:i:s O',
                    $date
                );
                if ($dateTime == false) {
                    // TODO: TASK: UNDEFINED - This needs to be more generic to dealing with different formats from IMap
                    $dateTime = DateTime::createFromFormat(
                        'd M Y H:i:s O',
                        $date
                    );
                }

                if ($dateTime == false) {
                    $ret = '';
                } else {
                    $timeDate = new TimeDate();
                    $ret = $timeDate->asUser($dateTime, $currentUser);
                }
                break;
            case 'is_imported':
                $uid = $emailHeader['uid'];
                $importedEmailBeans = BeanFactory::getBean('Emails');
                $is_imported = $importedEmailBeans->get_full_list('',
                    'emails.uid LIKE "' . $uid . '"');
                if (count($is_imported) > 0) {
                    $ret = true;
                } else {
                    $ret = false;
                }
                break;
            case 'folder':
                $ret = $folder;
                break;
            case 'folder_type':
                $ret = $folderObj->getType();
                break;
            case 'inbound_email_record':
                $ret = $inboundEmail->id;
                break;
            case 'uid':
                $ret = $emailHeader['uid'];
                break;
            case 'msgno':
                $ret = $emailHeader['msgno'];
                break;
            case 'has_attachment':
                $ret = $emailHeader['has_attachment'];
                break;
            case 'status':
                $ret = $this->getEmailHeaderStatus($emailHeader);
                break;
            default:
                $ret = '';
                break;
        }

        return $ret;
    }


    /**
     * @param Folder $folderObj
     * @param array $emailHeader
     * @param Email $seed
     * @param InboundEmail $inboundEmail
     * @param User $currentUser
     * @param string $folder
     * @return array|bool
     */
    public function getEmailRecord(Folder $folderObj, $emailHeader, Email $seed, InboundEmail $inboundEmail, User $currentUser, $folder) {
        $emailRecord = array();

        if ($folderObj->getType() === 'draft' && $emailHeader['draft'] === 0) {
            return false;
        }

        foreach ($seed->column_fields as $c => $field) {

            $emailRecord[strtoupper($field)] = $this->getEmailRecordFieldValue($field, $emailHeader, $inboundEmail, $currentUser, $folder, $folderObj);

        }

        return $emailRecord;
    }

    /**
     * @param array $request $_REQUEST
     * @return bool
     */
    public function isRequestedSearchAdvanced($request) {
        return
            (isset($request["searchFormTab"]) && $request["searchFormTab"] == "advanced_search") ||
            (
                isset($request["type_basic"]) && count($request["type_basic"] > 1) ||
                $request["type_basic"][0] != ""
            ) ||
            (isset($request["module"]) && $request["module"] == "MergeRecords");
    }

    /**
     * @param array $request $_REQUEST
     * @return bool
     */
    public function isRequestedSearchBasic($request) {
        return isset($request["searchFormTab"]) && $request["searchFormTab"] == "basic_search";
    }



    /**
     * @param array $data
     * @return array
     */
    public function getEmailUIds($data) {
        $emailUIds = array();
        foreach ($data as $row) {
            $emailUIds[] = $row['UID'];
        }

        return $emailUIds;
    }

    /**
     * @inheritdoc
     */
    public function getListViewData(
        $seed,
        $where,
        $offset = -1,
        $limit = -1,
        $filter_fields = array(),
        $params = array(),
        $id_field = 'id',
        $singleSelect = true,
        $id = null
    ) {
        global $current_user;
        global $sugar_config;
        global $mod_strings;

        $data = array();
        $pageData = array();
        $queryString = 'basic_search';
        $ret = array(
            'data' => $data,
            'pageData' => $pageData,
            'query' => $queryString,
            'message' => $mod_strings['WARNING_SETTINGS_NOT_CONF'],
        );

        $request = $_REQUEST;

        try {

            $folderObj = new Folder();
            $folderObj->retrieveFromRequest($request);

            $inboundEmail = $this->getInboundEmail($current_user, $folderObj);


            $searchType = $this->getSearchType($folderObj, $inboundEmail);


            // search in draft in CRM db?

            if($folderObj->getType() === 'draft' && !array_key_exists('status', $filter_fields)) {
                if (!empty($where)) {
                    $where .= ' AND ';
                }
                $where .= ' emails.status LIKE "draft" ';
            }


            $folder = $inboundEmail->mailbox;

            $filter = $this->getFilter($filter_fields, $where, $request, $searchType);


            // carry out the filter type
            switch ($searchType) {
                case 'crm':


                    $limit = $sugar_config['list_max_entries_per_page'];

                    $search = new ListViewDataEmailsSearchOnCrm($this);
                    $ret = $search->search($filter_fields, $request, $where, $inboundEmail, $params, $seed, $singleSelect, $id, $limit, $current_user, $id_field, $offset);



                    break;
                case 'imap':


                    $limitPerPage = isset($sugar_config['list_max_entries_per_page']) && (int)$sugar_config['list_max_entries_per_page'] ? $sugar_config['list_max_entries_per_page'] : 10;


                    $search = new ListViewDataEmailsSearchOnIMap($this);
                    $ret = $search->search($seed, $where, $id, $inboundEmail, $filter, $folderObj, $current_user, $folder, $limit, $limitPerPage);

                    break;


                default:

                    // handle default case

                    $GLOBALS['log']->fatal("Unknown or undefined search type" . ($searchType ? " ($searchType)" : ''));

                    break;
            }




        } catch (SuiteException $e) {
            $GLOBALS['log']->fatal($e->getMessage());
            $GLOBALS['log']->debug("trace info:\n" . $e->getTraceAsString());
        }

        // TODO: don't override the superglobals!!!!
        $_REQUEST = $request;

        return $ret;
    }

    /**
     * generates queries for use by the display layer
     *
     * @param int $sortOrder
     * @param int $offset
     * @param int $prevOffset
     * @param int $nextOffset
     * @param int $endOffset
     * @param int $totalCounted
     * @return array of queries orderBy and baseURL are always returned the others are only returned  according to values passed in.
     */
    public function callGenerateQueries($sortOrder, $offset, $prevOffset, $nextOffset, $endOffset, $totalCounted) {
        return $this->generateQueries($sortOrder, $offset, $prevOffset, $nextOffset, $endOffset, $totalCounted);
    }

    /**
     * generates urls as a string for use by the display layer
     *
     * @param array $queries
     * @return array of urls orderBy and baseURL are always returned the others are only returned  according to values passed in.
     */
    public function callGenerateURLS($queries) {
        return $this->generateURLS($queries);
    }

}

abstract class ListViewDataEmailsSearchAbstract {

    /**
     * @var ListViewDataEmails
     */
    protected $lvde;

    public function __construct(ListViewDataEmails $listViewDataEmails) {
        $this->lvde = $listViewDataEmails;
    }

}

class ListViewDataEmailsSearchOnCrm extends ListViewDataEmailsSearchAbstract {

    /**
     * @param array $filterFields
     * @param array $request $_REQUEST
     * @param string $where
     * @param InboundEmail $inboundEmail
     * @param array $params
     * @param Email $seed
     * @param bool $singleSelect
     * @param ??? $id
     * @param int $limit
     * @param User $currentUser
     * @param string $idField
     * @param int $offset
     * @return array
     */
    public function search($filterFields, $request, $where, InboundEmail $inboundEmail, $params, Email $seed, $singleSelect, $id, $limit, User $currentUser, $idField, $offset) {
        // Fix fields in filter fields

        $filterFields = $this->lvde->fixFieldsInFilter($filterFields, $request, $where);


        // Filter imported emails based on the UID of the results from the IMap server

        if(!empty($where)) {
            $where .= ' AND ';
        }
        $crmWhere = $where . 'mailbox_id LIKE ' .'"' . $inboundEmail->id . '"';


        // Populates CRM fields

        $crmQueryArray = $this->lvde->getCrmQueryArray($crmWhere, $filterFields, $params, $seed, $singleSelect);


        // get crm emails query

        $crmEmailsQuery = $this->lvde->getCrmEmailsQuery($crmQueryArray, $params);



        $crmEmails = $this->lvde->db->query($crmEmailsQuery);

        $this->lvde->setVariableName($seed->object_name, $crmWhere, $this->lvde->listviewName, $id);

        SugarVCR::erase($seed->module_dir);
        $this->lvde->seed =& $seed;
        $totalCounted = empty($GLOBALS['sugar_config']['disable_count_query']);
        $_SESSION['MAILMERGE_MODULE_FROM_LISTVIEW'] = $seed->module_dir;
        if(empty($request['action']) || $request['action'] != 'Popup'){
            $_SESSION['MAILMERGE_MODULE'] = $seed->module_dir;
        }

        $this->lvde->setVariableName($seed->object_name, $where, $this->lvde->listviewName, $id);

        $this->lvde->seed->id = '[SELECT_ID_LIST]';

        // if $params tell us to override all ordering
        if(!empty($params['overrideOrder']) && !empty($params['orderBy'])) {
            $order = $this->lvde->getOrderBy(strtolower($params['orderBy']), (empty($params['sortOrder']) ? '' : $params['sortOrder'])); // retreive from $_REQUEST
        }
        else {
            $order = $this->lvde->getOrderBy(); // retreive from $_REQUEST
        }

        // still empty? try to use settings passed in $param
        if(empty($order['orderBy']) && !empty($params['orderBy'])) {
            $order['orderBy'] = $params['orderBy'];
            $order['sortOrder'] =  (empty($params['sortOrder']) ? '' : $params['sortOrder']);
        }

        if (empty($params['skipOrderSave'])) { // don't save preferences if told so
            $currentUser->setPreference('listviewOrder', $order, 0, $this->lvde->var_name); // save preference
        }

        $data = array();

        $temp = clone $seed;

        $rows = array();
        $count = 0;
        $idIndex = array();
        $id_list = '';

        while(($row = $this->lvde->db->fetchByAssoc($crmEmails)) != null)
        {
            if($count < $limit)
            {
                $id_list .= ',\''.$row[$idField].'\'';
                $idIndex[$row[$idField]][] = count($rows);
                $rows[] = $seed->convertRow($row);
            }
            $count++;
        }

        if (!empty($id_list))
        {
            $id_list = '('.substr($id_list, 1).')';
        }

        SugarVCR::store($this->lvde->seed->module_dir,  $crmEmailsQuery);
        if($count != 0) {
            //NOW HANDLE SECONDARY QUERIES
            if(!empty($ret_array['secondary_select'])) {
                $secondary_query = $ret_array['secondary_select'] . $ret_array['secondary_from'] . ' WHERE '.$this->lvde->seed->table_name.'.id IN ' .$id_list;
                if(isset($ret_array['order_by']))
                {
                    $secondary_query .= ' ' . $ret_array['order_by'];
                }

                $secondary_result = $this->lvde->db->query($secondary_query);

                $ref_id_count = array();
                while($row = $this->lvde->db->fetchByAssoc($secondary_result)) {

                    $ref_id_count[$row['ref_id']][] = true;
                    foreach($row as $name=>$value) {
                        //add it to every row with the given id
                        foreach($idIndex[$row['ref_id']] as $index){
                            $rows[$index][$name]=$value;
                        }
                    }
                }

                $rows_keys = array_keys($rows);
                foreach($rows_keys as $key)
                {
                    $rows[$key]['secondary_select_count'] = count($ref_id_count[$rows[$key]['ref_id']]);
                }
            }

            // retrieve parent names
            if(!empty($filter_fields['parent_name']) && !empty($filter_fields['parent_id']) && !empty($filter_fields['parent_type'])) {
                foreach($idIndex as $id => $rowIndex) {
                    if(!isset($post_retrieve[$rows[$rowIndex[0]]['parent_type']])) {
                        $post_retrieve[$rows[$rowIndex[0]]['parent_type']] = array();
                    }
                    if(!empty($rows[$rowIndex[0]]['parent_id'])) $post_retrieve[$rows[$rowIndex[0]]['parent_type']][] = array('child_id' => $id , 'parent_id'=> $rows[$rowIndex[0]]['parent_id'], 'parent_type' => $rows[$rowIndex[0]]['parent_type'], 'type' => 'parent');
                }
                if(isset($post_retrieve)) {
                    $parent_fields = $seed->retrieve_parent_fields($post_retrieve);
                    foreach($parent_fields as $child_id => $parent_data) {
                        //add it to every row with the given id
                        foreach($idIndex[$child_id] as $index){
                            $rows[$index]['parent_name']= $parent_data['parent_name'];
                        }
                    }
                }
            }

            $pageData = array();

            reset($rows);
            while($row = current($rows)){

                $temp = clone $seed;
                $dataIndex = count($data);

                $temp->setupCustomFields($temp->module_dir);
                $temp->loadFromRow($row);
                if (empty($this->lvde->seed->assigned_user_id) && !empty($temp->assigned_user_id)) {
                    $this->lvde->seed->assigned_user_id = $temp->assigned_user_id;
                }
                if($idIndex[$row[$idField]][0] == $dataIndex){
                    $pageData['tag'][$dataIndex] = $temp->listviewACLHelper();
                }else{
                    $pageData['tag'][$dataIndex] = $pageData['tag'][$idIndex[$row[$idField]][0]];
                }
                $data[$dataIndex] = $temp->get_list_view_data();
                $detailViewAccess = $temp->ACLAccess('DetailView');
                $editViewAccess = $temp->ACLAccess('EditView');
                $pageData['rowAccess'][$dataIndex] = array('view' => $detailViewAccess, 'edit' => $editViewAccess);
                $additionalDetailsAllow = $this->lvde->additionalDetails && $detailViewAccess && (file_exists(
                            'modules/' . $temp->module_dir . '/metadata/additionalDetails.php'
                        ) || file_exists('custom/modules/' . $temp->module_dir . '/metadata/additionalDetails.php'));
                $additionalDetailsEdit = $editViewAccess;
                if($additionalDetailsAllow) {
                    if($this->lvde->additionalDetailsAjax) {
                        $ar = $this->lvde->getAdditionalDetailsAjax($data[$dataIndex]['ID']);
                    }
                    else {
                        $additionalDetailsFile = 'modules/' . $this->lvde->seed->module_dir . '/metadata/additionalDetails.php';
                        if(file_exists('custom/modules/' . $this->lvde->seed->module_dir . '/metadata/additionalDetails.php')){
                            $additionalDetailsFile = 'custom/modules/' . $this->lvde->seed->module_dir . '/metadata/additionalDetails.php';
                        }
                        require_once($additionalDetailsFile);
                        $ar = $this->lvde->getAdditionalDetails($data[$dataIndex],
                            (empty($this->lvde->additionalDetailsFunction) ? 'additionalDetails' : $this->lvde->additionalDetailsFunction) . $this->lvde->seed->object_name,
                            $additionalDetailsEdit);
                    }
                    $pageData['additionalDetails'][$dataIndex] = $ar['string'];
                    $pageData['additionalDetails']['fieldToAddTo'] = $ar['fieldToAddTo'];
                }
                next($rows);
            }
        }
        $nextOffset = -1;
        $prevOffset = -1;
        $endOffset = -1;
        if($count > $limit) {
            $nextOffset = $offset + $limit;
        }

        if($offset > 0) {
            $prevOffset = $offset - $limit;
            if($prevOffset < 0)$prevOffset = 0;
        }
        $totalCount = $count + $offset;

        if( $count >= $limit && $totalCounted){
            $totalCount  = $this->lvde->getTotalCount($crmEmailsQuery);
        }
        SugarVCR::recordIDs($this->lvde->seed->module_dir, array_keys($idIndex), $offset, $totalCount);
        $module_names = array(
            'Prospects' => 'Targets'
        );
        $endOffset = (floor(($totalCount - 1) / $limit)) * $limit;
        $pageData['ordering'] = $order;
        $pageData['ordering']['sortOrder'] = $this->lvde->getReverseSortOrder($pageData['ordering']['sortOrder']);
        //get url parameters as an array
        $pageData['queries'] = $this->lvde->callGenerateQueries($pageData['ordering']['sortOrder'], $offset, $prevOffset, $nextOffset,  $endOffset, $totalCounted);
        //join url parameters from array to a string
        $pageData['urls'] = $this->lvde->callGenerateURLS($pageData['queries']);
        $pageData['offsets'] = array( 'current'=>$offset, 'next'=>$nextOffset, 'prev'=>$prevOffset, 'end'=>$endOffset, 'total'=>$totalCount, 'totalCounted'=>$totalCounted);
        $pageData['bean'] = array('objectName' => $seed->object_name, 'moduleDir' => $seed->module_dir, 'moduleName' => strtr($seed->module_dir, $module_names));
        $pageData['stamp'] = $this->lvde->stamp;
        $pageData['access'] = array('view' => $this->lvde->seed->ACLAccess('DetailView'), 'edit' => $this->lvde->seed->ACLAccess('EditView'));
        $pageData['idIndex'] = $idIndex;
        if(!$this->lvde->seed->ACLAccess('ListView')) {
            $pageData['error'] = 'ACL restricted access';
        }

        $queryString = '';

        if( isset($request["searchFormTab"]) && $request["searchFormTab"] == "advanced_search" ||
            isset($request["type_basic"]) && (count($request["type_basic"] > 1) || $request["type_basic"][0] != "") ||
            isset($request["module"]) && $request["module"] == "MergeRecords")
        {
            $queryString = "-advanced_search";
        }
        else if (isset($request["searchFormTab"]) && $request["searchFormTab"] == "basic_search")
        {
            // TODO: figure out what was the SearchFormReports???
            if($seed->module_dir == "Reports") $searchMetaData = SearchFormReports::retrieveReportsSearchDefs();
            else $searchMetaData = SearchForm::retrieveSearchDefs($seed->module_dir); // TODO: figure out which SearchForm is it?

            $basicSearchFields = array();

            if( isset($searchMetaData['searchdefs']) && isset($searchMetaData['searchdefs'][$seed->module_dir]['layout']['basic_search']) )
                $basicSearchFields = $searchMetaData['searchdefs'][$seed->module_dir]['layout']['basic_search'];

            foreach( $basicSearchFields as $basicSearchField)
            {
                $field_name = (is_array($basicSearchField) && isset($basicSearchField['name'])) ? $basicSearchField['name'] : $basicSearchField;
                $field_name .= "_basic";
                if( isset($request[$field_name])  && ( !is_array($basicSearchField) || !isset($basicSearchField['type']) || $basicSearchField['type'] == 'text' || $basicSearchField['type'] == 'name') )
                {
                    // Ensure the encoding is UTF-8
                    $queryString = htmlentities($request[$field_name], null, 'UTF-8');
                    break;
                }
            }
        }

        $ret =  array('data'=>$data , 'pageData'=>$pageData, 'query' => $queryString);

        return $ret;
    }

}

class ListViewDataEmailsSearchOnIMap extends ListViewDataEmailsSearchAbstract {



    /**
     * @param Email $seed
     * @param string $where
     * @param string $id
     * @param InboundEmail $inboundEmail
     * @param array $filter
     * @param Folder $folderObj
     * @param User $currentUser
     * @param string $folder
     * @param int $limit
     * @param ??? $limitPerPage
     * @return array
     */
    public function search(Email $seed, $where, $id, InboundEmail $inboundEmail, $filter, Folder $folderObj, User $currentUser, $folder, $limit, $limitPerPage) {


        // Create the data structure which are required to view a list view.
        require_once 'include/SearchForm/SearchForm2.php';
        $this->lvde->seed =& $seed;
        $this->lvde->setVariableName($seed->object_name, $where, $this->lvde->listviewName, $id);
        $this->lvde->seed->id = '[SELECT_ID_LIST]';

        if (!empty($params['overrideOrder']) && !empty($params['orderBy'])) {
            $order = $this->lvde->getOrderBy(
                strtolower($params['orderBy']),
                (empty($params['sortOrder']) ? '' : $params['sortOrder'])
            );
        } else {
            $order = $this->lvde->getOrderBy();
        }

        // still empty? try to use settings passed in $param
        if (empty($order['orderBy']) && !empty($params['orderBy'])) {
            $order['orderBy'] = $params['orderBy'];
            $order['sortOrder'] = (empty($params['sortOrder']) ? '' : $params['sortOrder']);
        }

        // TODO: figure out why was it for?
        $orderby = $order['orderBy'];
        if (strpos($order['orderBy'], '.') && ($order['orderBy'] != "report_cache.date_modified")) {
            $orderby = substr($order['orderBy'], strpos($order['orderBy'], '.') + 1);
        }


        $page = 0;
        $offset = 0;
        if (isset($request['Emails2_EMAIL_offset'])) {
            if ($request['Emails2_EMAIL_offset'] !== "end") {
                $offset = $request['Emails2_EMAIL_offset'];
                $page = $offset / $limitPerPage;
            }
        }

        // Get emails from email server
        $emailServerEmails = $inboundEmail->checkWithPagination($offset, $limitPerPage, $order, $filter);

        $total = $emailServerEmails['mailbox_info']['Nmsgs']; // + count($importedEmails['data']);
        if ($page === "end") {
            $offset = $total - $limitPerPage;
        }


        /// Populate the data and its fields from the email server
        $request['uids'] = array();

        foreach ($emailServerEmails['data'] as $h => $emailHeader) {


            $emailRecord = $this->lvde->getEmailRecord($folderObj, $emailHeader, $seed, $inboundEmail, $currentUser, $folder);
            if($emailRecord === false) {
                continue;
            }

            $data[] = $emailRecord;
            $pageData['rowAccess'][$h] = array('edit' => true, 'view' => true);
            $pageData['additionalDetails'][$h] = '';
            $pageData['tag'][$h]['MAIN'] = 'a';
        }


        // Filter imported emails based on the UID of the results from the IMap server
        $crmWhere = $where . ' AND mailbox_id LIKE ' . '"' . $inboundEmail->id . '"';

        $ret_array['inner_join'] = '';
        if (!empty($this->lvde->seed->listview_inner_join)) {
            $ret_array['inner_join'] = ' ' . implode(' ', $this->lvde->seed->listview_inner_join) . ' ';
        }

        if (!is_array($params)) {
            $params = array();
        }
        if (!isset($params['custom_select'])) {
            $params['custom_select'] = '';
        }
        if (!isset($params['custom_from'])) {
            $params['custom_from'] = '';
        }
        if (!isset($params['custom_where'])) {
            $params['custom_where'] = '';
        }
        if (!isset($params['custom_order_by'])) {
            $params['custom_order_by'] = '';
        }

        $this->lvde->setVariableName($seed->object_name, $crmWhere, $this->lvde->listviewName, $id);

        $this->lvde->seed->id = '[SELECT_ID_LIST]';

        $nextOffset = -1;
        $prevOffset = -1;
        $endOffset = 0;


        if ($total > $limitPerPage) {
            $nextOffset = $offset + $limitPerPage;
        }

        if ($nextOffset >= $total) {
            $nextOffset = $total;
        }

        if ($page > 0) {
            $prevOffset = $offset - $limitPerPage;
            if ($prevOffset < 0) {
                $prevOffset = 0;
            }
        }

        if ($total < $limitPerPage) {
            $prevOffset = -1;
            $nextOffset = -1;
        }

        if ($total > 0) {
            $endOffset = $total / $limitPerPage;
        }

        $pageData['offsets']['current'] = $offset;
        $pageData['offsets']['total'] = $total;
        $pageData['offsets']['next'] = $nextOffset;
        $pageData['offsets']['prev'] = $prevOffset;
        $pageData['offsets']['end'] = ceil($endOffset);

        $queries = array('baseUrl', 'endPage', 'nextPage', 'orderBy');

        if ((int)$pageData['offsets']['current'] >= $limitPerPage) {
            $queries[] = 'prevPage';
            $queries[] = 'startPage';
        }

        foreach ($queries as $query) {

            if ($total < $limitPerPage || $nextOffset >= $total) {
                if (isset($pageData['queries'][$query])) {
                    unset($pageData['queries'][$query]);
                }
            } else {
                $pageData['queries'][$query]['module'] = "Emails";
                $pageData['queries'][$query]['action'] = "index";
                $pageData['queries'][$query]['parentTab'] = "Activities";
                $pageData['queries'][$query]['ajax_load'] = "0";
                $pageData['queries'][$query]['loadLanguageJS'] = "1";
                $pageData['queries'][$query]['searchFormTab'] = "advanced_search";
                $pageData['queries'][$query]['lvso'] = "DESC";

                $pageData['urls'][$query] = 'index.php?module=Emails&action=index&parentTab=Activities&searchFormTab=advanced_search&query=true&current_user_only_basic=0&button=Search&lvso=DESC';

            }
        }

        // TODO: UNDEFINED: refactor current_query_by_page in the list view
        // inject post values
        $request['folder'] = $folder;
        $request['folder_type'] = $folderObj->getType();
        $request['inbound_email_record'] = $inboundEmail->id;


        // TODO: TASK: UNDEFINED - HANDLE in second filter after IMap
        $endOffset = floor(($total - 1) / $limit) * $limit;
        $pageData['queries'] = $this->lvde->callGenerateQueries(
            $pageData['ordering']['sortOrder'],
            $offset,
            $prevOffset,
            $nextOffset,
            $endOffset,
            $total
        );
        $pageData['offsets'] = array(
            'current' => $offset,
            'next' => $nextOffset,
            'prev' => $prevOffset,
            'end' => $endOffset,
            'total' => $total,
            'totalCounted' => $total
        );

        $pageData['ordering'] = $order;
        $pageData['ordering']['sortOrder'] = $this->lvde->getReverseSortOrder($pageData['ordering']['sortOrder']);
        //get url parameters as an array
        //join url parameters from array to a string
        $pageData['urls'] = $this->lvde->callGenerateURLS($pageData['queries']);
        $module_names = array(
            'Prospects' => 'Targets'
        );
        $pageData['bean'] = array(
            'objectName' => $seed->object_name,
            'moduleDir' => $seed->module_dir,
            'moduleName' => strtr($seed->module_dir, $module_names)
        );
        $pageData['stamp'] = $this->lvde->stamp;
        $pageData['access'] = array(
            'view' => $this->lvde->seed->ACLAccess('DetailView'),
            'edit' => $this->lvde->seed->ACLAccess('EditView')
        );
        if (!$this->lvde->seed->ACLAccess('ListView')) {
            $pageData['error'] = 'ACL restricted access';
        }


        if ( $this->lvde->isRequestedSearchAdvanced($request) ) {
            $queryString = "-advanced_search";
        } else {
            if ( $this->lvde->isRequestedSearchBasic($request) ) {

                // SearchForm is a (SearchForm2)
                $searchMetaData = SearchForm::retrieveSearchDefs($seed->module_dir);

                $basicSearchFields = array();

                if (
                    isset($searchMetaData['searchdefs']) &&
                    isset($searchMetaData['searchdefs'][$seed->module_dir]['layout']['basic_search'])
                ) {
                    $basicSearchFields = $searchMetaData['searchdefs'][$seed->module_dir]['layout']['basic_search'];
                }

                foreach ($basicSearchFields as $basicSearchField) {
                    $field_name = (is_array($basicSearchField) && isset($basicSearchField['name']))
                        ? $basicSearchField['name'] : $basicSearchField;
                    $field_name .= "_basic";
                    if (
                        isset($request[$field_name]) &&
                        (
                            !is_array($basicSearchField) ||
                            !isset($basicSearchField['type']) ||
                            $basicSearchField['type'] == 'text' ||
                            $basicSearchField['type'] == 'name'
                        )
                    ) {
                        // Ensure the encoding is UTF-8
                        $queryString = htmlentities($request[$field_name], null, 'UTF-8');
                        break;
                    }
                }
            } else {
                $GLOBALS['log']->warn("Unknown requested search type");
            }
        }

        $request['email_uids'] = $this->lvde->getEmailUIds($data);


        $ret = array('data' => $data, 'pageData' => $pageData, 'query' => $queryString);

        return $ret;
    }

}
