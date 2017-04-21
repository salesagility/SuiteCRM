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
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getListViewCachedData() {}


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
        global $current_user, $sugar_config, $db;
        require_once 'include/SearchForm/SearchForm2.php';

        $importedEmails = parent::getListViewData(
            $seed,
            $where,
            $offset,
            $limit,
            $filter_fields,
            $params = array(),
            $id_field,
            $singleSelect,
            $id
        );

        $folderType = "inbound";

        if (isset($_REQUEST['folders_id']) and !empty($_REQUEST['folders_id'])) {
            $foldersId = $_REQUEST['folders_id'];
            $result = $db->query('SELECT * FROM folders WHERE id="'.$foldersId.'"');
            $row = $db->fetchByAssoc($result);
            // get the root of the tree
            // is the the id of the root node is the same as the inbound email id
            if(empty($row['parent_folder'])) {
                // root node (inbound)
                $inboundEmailID = $row['id'];
            } else {
                // child node
                $inboundEmailID = $row['parent_folder'];
                $folderType =  $row['folder_type'];
            }

            $inboundEmailIDs = sugar_unserialize(base64_decode($current_user->getPreference('showFolders', 'Emails')));
            $inboundEmailID = '';
            foreach ($inboundEmailIDs as $f) {
                if(!empty($f)) {
                    $inboundEmailID = $f;
                    break;
                }
            }
        } else {

            $inboundEmailIDs = sugar_unserialize(base64_decode($current_user->getPreference('showFolders', 'Emails')));
            $inboundEmailID = '';
            foreach ($inboundEmailIDs as $f) {
                if(!empty($f)) {
                    $inboundEmailID = $f;
                    break;
                }
            }

        }

        $limitPerPage = $sugar_config['list_max_entries_per_page'];
        $pageData = $importedEmails['pageData'];

        if(isset($importedEmails['queryString']) and !empty( $importedEmails['queryString'])) {
            $queryString = $importedEmails['queryString'];
        } else {
            $queryString = 'basic_search';
        }

        $page = 0;
        $offset = 0;
        if(isset($_REQUEST['Emails2_EMAIL_offset'])) {
            if($_REQUEST['Emails2_EMAIL_offset'] !== "end") {
                $offset = $_REQUEST['Emails2_EMAIL_offset'];
                $page = $offset / $limitPerPage;
            }
        }

        $inboundEmail = BeanFactory::getBean('InboundEmail', $inboundEmailID);
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

        $cachedEmails = $inboundEmail->checkWithPagination($page, $limitPerPage);
        $total = $cachedEmails['mailbox_info']['Nmsgs'] + count($importedEmails['data']);

        if($page === "end") {
            $offset = $total - $limitPerPage;
        }



        $data = $importedEmails['data'];
        foreach ($cachedEmails['data'] as $h => $emailHeader) {
            $emailRecord = array();

            if($folderType === 'draft' and $emailHeader['draft'] === 0)
            {
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

                        $timeDate = new TimeDate();
                        $emailRecord[strtoupper($field)] = $timeDate->asUser($dateTime, $current_user);
                        break;
                    case 'is_imported':
                        $emailRecord['IS_IMPORTED'] = false;
                        break;
                    case 'folder':
                        $emailRecord['FOLDER'] = $folder;
                        break;
                    case 'folder_type':
                        $emailRecord['FOLDER_TYPE'] = $folderType;
                        break;
                    case 'inbound_email_record':
                        $emailRecord['INBOUND_EMAIL_RECORD'] = $inboundEmailID;
                        break;
                    case 'uid':
                        $emailRecord[strtoupper($field)] = $emailHeader['uid'];
                        break;
                    case 'msgno':
                        $emailRecord[strtoupper($field)] = $emailHeader['msgno'];
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

        $this->setVariableName($seed->object_name, $where, $this->listviewName, $id);

        $this->seed->id = '[SELECT_ID_LIST]';

        $nextOffset = -1;
        $prevOffset = -1;
        $endOffset = 0;



        if ($total > $limitPerPage) {
            $nextOffset = $offset + $limitPerPage;
        }

        if($nextOffset >= $total) {
            $nextOffset = $total;
        }

        if ($page > 0) {
            $prevOffset = $offset - $limitPerPage;
            if ($prevOffset < 0) {
                $prevOffset = 0;
            }
        }

        if($total < $limitPerPage) {
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

        foreach ($queries as $query) {

            if($total < $limitPerPage || $nextOffset >= $total) {
                if(isset($pageData['queries'][$query])) {
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

                $pageData['urls'][$query] = 'index.php?module=Emails&action=index&parentTab=Activities&searchFormTab=advanced_search&query=true&name_basic=&current_user_only_basic=0&button=Search&lvso=ASC';

            }
         }

        // inject post values
        $_REQUEST['folder'] = $folder;
        $_REQUEST['folder'] = $folder;
        $_REQUEST['folder_type'] = $folderType;
        $_REQUEST['inbound_email_record='] = $inboundEmailID;

        return array('data' => $data, 'pageData' => $pageData, 'query' => $queryString);
    }
}
