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

// XSS rules

if ($_REQUEST['action'] === 'ComposeView') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'ComposeView';
}

if ($_REQUEST['action'] === 'Popup') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'Popup';
}

if ($_REQUEST['action'] === 'GetFolders') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'GetFolders';
}


if ($_REQUEST['action'] === 'CheckEmail') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'CheckEmail';
}


if ($_REQUEST['action'] === 'ImportAndShowDetailView') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'ImportAndShowDetailView';
}

if ($_REQUEST['action'] === 'GetCurrentUserID') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'GetCurrentUserID';
}

if ($_REQUEST['action'] === 'DisplayDetailView') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'DisplayDetailView';
}

if ($_REQUEST['action'] === 'ImportFromListView') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'ImportFromListView';
}

if ($_REQUEST['action'] === 'GetComposeViewFields') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'GetComposeViewFields';
}

if ($_REQUEST['action'] === 'SaveDraft') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'SaveDraft';
}

if ($_REQUEST['action'] === 'DetailDraftView') {
    $GLOBALS['sugar_config']['http_referer']['actions'][] = 'DetailDraftView';
}

class EmailsController extends SugarController
{
    public function action_index()
    {
        global $sugar_config, $current_user;
        $this->view = 'list';

    }

    public function action_DetailDraftView()
    {
        $this->view = 'detaildraft';
    }

    public function action_ComposeView()
    {
        $this->view = 'compose';
    }

    public function action_send()
    {
        $this->bean = $this->bean->populateBeanFromRequest($this->bean, $_REQUEST);
        $this->bean->save();

        $this->bean->handleMultipleFileAttachments();

        if ($this->bean->send()) {
            $this->bean->status = 'sent';
            $this->bean->save();
        } else {
            $this->bean->status = 'sent_error';
        }

        $this->view = 'sendemail';
    }



    public function action_SaveDraft()
    {
        $this->bean = $this->bean->populateBeanFromRequest($this->bean, $_REQUEST);
        $this->bean->mailbox_id = $_REQUEST['inbound_email_id'];
        $this->bean->status = 'draft';
        $this->bean->save();
        $this->bean->handleMultipleFileAttachments();
        $this->view = 'savedraftemail';
    }

    public function action_Popup()
    {
        $this->view = 'popup';
    }

    public function action_CheckEmail()
    {
        $inboundEmail = BeanFactory::getBean('InboundEmail');
        $inboundEmail->syncEmail();

        echo json_encode(array('response' => array()));
        $this->view('ajax');
    }

    public function action_GetFolders()
    {
        require_once 'include/SugarFolders/SugarFolders.php';
        global $current_user, $mod_strings;
        $email = new Email();
        $email->email2init();
        $ie = new InboundEmail();
        $ie->email = $email;
        $json = getJSONobj();
        $GLOBALS['log']->debug("********** EMAIL 2.0 - Asynchronous - at: refreshSugarFolders");
        $rootNode = new ExtNode('', '');
        $folderOpenState = $current_user->getPreference('folderOpenState', 'Emails');
        $folderOpenState = (empty($folderOpenState)) ? "" : $folderOpenState;

        try {
            $ret = $email->et->folder->getUserFolders($rootNode, sugar_unserialize($folderOpenState), $current_user, true);
            $out = json_encode(array('response' => $ret));
        } catch(SugarFolderEmptyException $e) {
            $GLOBALS['log']->fatal($e->getMessage());
            $out = json_encode(array('errors' => array($mod_strings['LBL_ERROR_NO_FOLDERS'])));
        }

        echo $out;
        $this->view = 'ajax';
    }


    public function action_DisplayDetailView()
    {
        global $db;
        $emails = BeanFactory::getBean("Emails");
        $result = $emails->get_full_list("", "uid = '{$db->quote($_REQUEST['uid'])}'");
        if(empty($result))
        {
            $this->view = 'detailnonimported';
        } else {
            header('location:index.php?module=Emails&action=DetailView&record='. $result[0]->id);
        }
    }

    public function action_ImportAndShowDetailView()
    {
        global $current_user, $db;
        if(isset($_REQUEST['inbound_email_record']) && !empty($_REQUEST['inbound_email_record'])) {
            $inboundEmail = BeanFactory::getBean('InboundEmail', $db->quote($_REQUEST['inbound_email_record']));
            $inboundEmail->connectMailserver();
            $importedEmailId = $inboundEmail->returnImportedEmail($_REQUEST['msgno'], $_REQUEST['uid']);
            if($importedEmailId !== false) {
                header('location:index.php?module=Emails&action=DetailView&record='. $importedEmailId);
            }
        } else {
            // When something fail redirect user to index
            header('location:index.php?module=Emails&action=index');
        }

    }

    public function action_GetCurrentUserID()
    {
        global $current_user;
        echo json_encode(array("response" => $current_user->id));
        $this->view = 'ajax';
    }

    public function action_ImportFromListView () {
        global $db;
        $response = false;

        if(isset($_REQUEST['inbound_email_record']) && !empty($_REQUEST['inbound_email_record'])) {
            $inboundEmail = BeanFactory::getBean('InboundEmail', $db->quote($_REQUEST['inbound_email_record']));
            if(isset($_REQUEST['folder']) && !empty($_REQUEST['folder'])) {
                $inboundEmail->mailbox = $_REQUEST['folder'];
            }
            $inboundEmail->connectMailserver();

            if(isset($_REQUEST['all']) && $_REQUEST['all'] === 'true') {
                // import all in folder
                $inboundEmail->importAllFromFolder();
                $response = true;
            } else {
                foreach ($_REQUEST['uid'] as $uid) {
                    $result = $inboundEmail->returnImportedEmail($_REQUEST['msgno'], $uid);
                    $response = true;
                }
            }

        } else {
            $GLOBALS['log']->fatal('EmailsController::action_ImportFromListView() missing inbound_email_record');
        }
        echo json_encode(array('response' => $response));
        $this->view = 'ajax';
    }
}