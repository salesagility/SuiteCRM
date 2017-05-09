<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/ListView/ListViewData.php');

class ListViewDataEmails extends ListViewData
{
    protected static $mapServerFields = array(
        // bean field => IMAP field
        'from_addr_name' => 'FROM',
        'to_addrs_names' => 'TO',
        'cc_addrs_names' => 'CC',
        'bcc_addrs_names' => 'BCC',
        'name' => 'SUBJECT',
        'description' => 'BODY',
    );
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getListViewCachedData()
    {
    }


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
        global $current_user, $sugar_config, $db, $mod_strings;

        $data = array();
        $pageData = array();
        $queryString = '';
        // Create the data structure which are required to view a list view.
        // start parent::getListViewData
        require_once 'include/SearchForm/SearchForm2.php';
        $this->seed =& $seed;
        $this->setVariableName($seed->object_name, $where, $this->listviewName, $id);
        $this->seed->id = '[SELECT_ID_LIST]';

        if (!empty($params['overrideOrder']) && !empty($params['orderBy'])) {
            $order = $this->getOrderBy(
                strtolower($params['orderBy']),
                (empty($params['sortOrder']) ? '' : $params['sortOrder'])
            );
        } else {
            $order = $this->getOrderBy();
        }

        // still empty? try to use settings passed in $param
        if (empty($order['orderBy']) && !empty($params['orderBy'])) {
            $order['orderBy'] = $params['orderBy'];
            $order['sortOrder'] = (empty($params['sortOrder']) ? '' : $params['sortOrder']);
        }

        $orderby = $order['orderBy'];
        if (strpos($order['orderBy'], '.') && ($order['orderBy'] != "report_cache.date_modified")) {
            $orderby = substr($order['orderBy'], strpos($order['orderBy'], '.') + 1);
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
        // End of parent::getListViewData data structure


        // Workout the id for the folder or user the default
        $folderType = "inbound";
        $inboundEmailID = '';
        if (isset($_REQUEST['folders_id']) && !empty($_REQUEST['folders_id'])) {
            $foldersId = $_REQUEST['folders_id'];
            $result = $db->query('SELECT * FROM folders WHERE id="' . $foldersId . '"');
            $row = $db->fetchByAssoc($result);
            // get the root of the tree
            // is the the id of the root node is the same as the inbound email id
            if (empty($row['parent_folder'])) {
                // root node (inbound)
                $inboundEmailID = $row['id'];
            } else {
                // child node
                $inboundEmailID = $row['parent_folder'];
                $folderType = $row['folder_type'];
            }

        }

        $limitPerPage = $sugar_config['list_max_entries_per_page'];

        if (isset($importedEmails['queryString']) && !empty($importedEmails['queryString'])) {
            $queryString = $importedEmails['queryString'];
        } else {
            $queryString = 'basic_search';
        }

        $page = 0;
        $offset = 0;
        if (isset($_REQUEST['Emails2_EMAIL_offset'])) {
            if ($_REQUEST['Emails2_EMAIL_offset'] !== "end") {
                $offset = $_REQUEST['Emails2_EMAIL_offset'];
                $page = $offset / $limitPerPage;
            }
        }

        if (empty($inboundEmailID)) {
            $inboundEmailID = $current_user->getPreference('defaultIEAccount', 'Emails');
            $inboundEmail = BeanFactory::getBean('InboundEmail', $inboundEmailID);
        } else {
            $inboundEmail = BeanFactory::getBean('InboundEmail', $inboundEmailID);
        }


        if ($inboundEmail !== false) {
            $storedOptions = unserialize(base64_decode($inboundEmail->stored_options));

            switch ($folderType) {
                case "sent":
                    $inboundEmail->mailbox = $storedOptions['sentFolder'];
                    break;
                case "draft":
                    $inboundEmail->mailbox = $storedOptions['sentFolder'];
                    break;
                case "trash":
                    $inboundEmail->mailbox = $storedOptions['trashFolder'];
                    break;
                default:
                    break;
            }

            $folder = $inboundEmail->mailbox;

            // Process filter
            $filter = array();
            foreach ($_REQUEST as $r => $request) {

                if(empty($request)) {
                    continue;
                }

                if((stristr($r, 'advanced') !== false) || (stristr($r, 'basic') !== false)) {
                    $f = str_ireplace('_advanced', '', $r);
                    $f = str_ireplace('_basic', '', $f);
                    if(isset(self::$mapServerFields[$f]))
                    {
                        $filter[ self::$mapServerFields[$f] ] = $request;
                    }
                }
            }

            // Get emails from IMAP server
            $emailServerEmails = $inboundEmail->checkWithPagination($offset, $limitPerPage, $order, $filter);
            // order by DESC
            $sortDESC = function ($a, $b) {
                if ($a['date'] == $b['date']) {
                    return 0;
                }

                return -1;
            };

            $total = $emailServerEmails['mailbox_info']['Nmsgs'] + count($importedEmails['data']);
            if ($page === "end") {
                $offset = $total - $limitPerPage;
            }


            $_REQUEST['uids'] = array();
            foreach ($emailServerEmails['data'] as $h => $emailHeader) {
                $emailRecord = array();

                if ($folderType === 'draft' && $emailHeader['draft'] === 0) {
                    continue;
                }

                foreach ($seed->column_fields as $c => $field) {
                    switch ($field) {
                        case 'from_addr_name':
                            $emailRecord[strtoupper($field)] = $emailHeader['from'];
                            break;
                        case 'to_addrs_names':
                            $emailRecord[strtoupper($field)] = $emailHeader['to'];
                            break;
                        case 'has_attachments':
                            $emailRecord[strtoupper($field)] = false;
                            break;
                        case 'flagged':
                            $emailRecord[strtoupper($field)] = $emailHeader['flagged'];
                            break;
                        case 'name':
                            $emailRecord[strtoupper($field)] = html_entity_decode($inboundEmail->handleMimeHeaderDecode($emailHeader['subject']));
                            break;
                        case 'date_entered':
                            $date = preg_replace('/(\ \([A-Z]+\))/', '', $emailHeader['date']);

                            $dateTime = DateTime::createFromFormat(
                                'D, d M Y H:i:s O',
                                $date
                            );
                            if ($dateTime == false) {
                                // TODO: TASK: UNDEFINED - This needs to be more generic to dealing with different formats from IMAP
                                $dateTime = DateTime::createFromFormat(
                                    'd M Y H:i:s O',
                                    $date
                                );
                            }

                            if ($dateTime == false) {
                                $emailRecord[strtoupper($field)] = '';
                            } else {
                                $timeDate = new TimeDate();
                                $emailRecord[strtoupper($field)] = $timeDate->asUser($dateTime, $current_user);
                            }
                            break;
                        case 'is_imported':
                            $uid = $emailHeader['uid'];
                            $importedEmailBeans = BeanFactory::getBean('Emails');
                            $is_imported = $importedEmailBeans->get_full_list('', 'emails.uid LIKE "' . $uid . '"');
                            if (count($is_imported) > 0) {
                                $emailRecord['IS_IMPORTED'] = true;
                            } else {
                                $emailRecord['IS_IMPORTED'] = false;
                            }
                            break;
                        case 'folder':
                            $emailRecord['FOLDER'] = $folder;
                            break;
                        case 'folder_type':
                            $emailRecord['FOLDER_TYPE'] = $folderType;
                            break;
                        case 'inbound_email_record':
                            $emailRecord['INBOUND_EMAIL_RECORD'] = $inboundEmail->id;
                            break;
                        case 'uid':
                            $emailRecord[strtoupper($field)] = $emailHeader['uid'];
                            $_REQUEST['email_uids'][] = $emailHeader['uid'];
                            break;
                        case 'msgno':
                            $emailRecord[strtoupper($field)] = $emailHeader['msgno'];
                            break;
                        case 'has_attachment':
                            $emailRecord[strtoupper($field)] = $emailHeader['has_attachment'];
                            break;
                        case 'status':
                            if ($emailHeader['answered'] != 0) {
                                $emailRecord[strtoupper($field)] = 'replied';
                            } else {
                                if ($emailHeader['draft'] != 0) {
                                    $emailRecord[strtoupper($field)] = 'draft';
                                } else {
                                    if ($emailHeader['seen'] != 0) {
                                        $emailRecord[strtoupper($field)] = 'read';
                                    } else {
                                        $emailRecord[strtoupper($field)] = 'unread';
                                    }
                                }
                            }

                            if ($emailHeader['deleted'] != 0) {
                                // TODO: TASK: UNDEFINED - Handle deleted

                            }

                            if ($emailHeader['recent'] != 0) {
                                // TODO: TASK: UNDEFINED - Add recent flag to SuiteCRM
                            }
                            break;
                        default:
                            $emailRecord[strtoupper($field)] = '';
                            break;
                    }
                }

                $data[] = $emailRecord;
                $pageData['rowAccess'][$h] = array('edit' => true, view => true);
                $pageData['additionalDetails'][$h] = '';
                $pageData['tag'][$h]['MAIN'] = 'a';
            }


            // Filter imported emails based on the UID of the results from the IMAP server

            $this->setVariableName($seed->object_name, $where, $this->listviewName, $id);

            $this->seed->id = '[SELECT_ID_LIST]';

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

            // inject post values
            $_REQUEST['folder'] = $folder;
            $_REQUEST['folder'] = $folder;
            $_REQUEST['folder_type'] = $folderType;
            $_REQUEST['inbound_email_record'] = $inboundEmailID;


            // TODO: TASK: UNDEFINED - HANDLE in second filter after IMAP
            $endOffset = floor(($total - 1) / $limit) * $limit;
            $pageData['queries'] = $this->generateQueries(
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
            $pageData['ordering']['sortOrder'] = $this->getReverseSortOrder($pageData['ordering']['sortOrder']);
            //get url parameters as an array
            //join url parameters from array to a string
            $pageData['urls'] = $this->generateURLS($pageData['queries']);
            $module_names = array(
                'Prospects' => 'Targets'
            );
            $pageData['bean'] = array(
                'objectName' => $seed->object_name,
                'moduleDir' => $seed->module_dir,
                'moduleName' => strtr($seed->module_dir, $module_names)
            );
            $pageData['stamp'] = $this->stamp;
            $pageData['access'] = array(
                'view' => $this->seed->ACLAccess('DetailView'),
                'edit' => $this->seed->ACLAccess('EditView')
            );
            if (!$this->seed->ACLAccess('ListView')) {
                $pageData['error'] = 'ACL restricted access';
            }


            if (
                (isset($_REQUEST["searchFormTab"]) && $_REQUEST["searchFormTab"] == "advanced_search") ||
                (
                    isset($_REQUEST["type_basic"]) && count($_REQUEST["type_basic"] > 1) ||
                    $_REQUEST["type_basic"][0] != ""
                ) ||
                (isset($_REQUEST["module"]) && $_REQUEST["module"] == "MergeRecords")
            ) {
                $queryString = "-advanced_search";
            } else {
                if (isset($_REQUEST["searchFormTab"]) && $_REQUEST["searchFormTab"] == "basic_search") {
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
                            isset($_REQUEST[$field_name]) &&
                            (
                                !is_array($basicSearchField) ||
                                !isset($basicSearchField['type']) ||
                                $basicSearchField['type'] == 'text' ||
                                $basicSearchField['type'] == 'name'
                            )
                        ) {
                            // Ensure the encoding is UTF-8
                            $queryString = htmlentities($_REQUEST[$field_name], null, 'UTF-8');
                            break;
                        }
                    }
                }
            }

            return array('data' => $data, 'pageData' => $pageData, 'query' => $queryString);
        } else {

            return array(
                'data' => $data,
                'pageData' => $pageData,
                'query' => $queryString,
                'message' => $mod_strings['WARNING_SETTINGS_NOT_CONF']
            );
        }

    }
}
