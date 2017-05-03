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



class EmailsController extends SugarController
{
    public function action_index()
    {
        global $sugar_config, $current_user;
        $this->view = 'list';

    }

    public function action_ComposeView()
    {
        $this->view = 'compose';
    }

    public function action_send()
    {
        if (empty($this->bean)) {
            $this->bean = BeanFactory::getBean('Emails');
        }

        foreach ($_REQUEST as $fieldname => $field) {
            if (array_key_exists($fieldname, $this->bean->field_defs)) {
                $this->bean->$fieldname = $field;
            }
        }


        $old = array('&lt;', '&gt;');
        $new = array('<', '>');

        if (isset($_REQUEST['from_addr']) && $_REQUEST['from_addr'] != $_REQUEST['from_addr_name'] . ' &lt;' . $_REQUEST['from_addr_email'] . '&gt;') {
            if (false === strpos($_REQUEST['from_addr'], '&lt;')) { // we have an email only?
                $this->bean->from_addr = $_REQUEST['from_addr'];
                $this->bean->from_name = '';
                $this->bean->reply_to_addr = $this->bean->from_addr;
                $this->bean->reply_to_name = $this->bean->from_name;
            } else { // we have a compound string
                $newFromAddr = str_replace($old, $new, $_REQUEST['from_addr']);
                $this->bean->from_addr = substr($newFromAddr, (1 + strpos($newFromAddr, '<')),
                    (strpos($newFromAddr, '>') - strpos($newFromAddr, '<')) - 1);
                $this->bean->from_name = substr($newFromAddr, 0, (strpos($newFromAddr, '<') - 1));
                $this->bean->reply_to_addr = $this->bean->from_addr;
                $this->bean->reply_to_name = $this->bean->from_name;
            }
        } elseif (!empty($_REQUEST['from_addr_email']) && isset($_REQUEST['from_addr_email'])) {
            $this->bean->from_addr = $_REQUEST['from_addr_email'];
            $this->bean->from_name = $_REQUEST['from_addr_name'];
        } else {
            $this->bean->from_addr = $this->bean->getSystemDefaultEmail();
            $this->bean->reply_to_addr = $this->bean->from_addr['email'];
            $this->bean->reply_to_name = $this->bean->from_addr['name'];
        }


        if (empty($this->bean->to_addrs)) {
            if (!empty($_REQUEST['to_addrs_names'])) {
                $this->bean->to_addrs_names = htmlspecialchars_decode($_REQUEST['to_addrs_names']);
            }

            if (!empty($this->bean->to_addrs_names)) {
                $this->bean->to_addrs = htmlspecialchars_decode($this->bean->to_addrs_names);
            }
        }


        $toEmailAddresses = preg_split('/[,;]/', $this->bean->to_addrs, null, PREG_SPLIT_NO_EMPTY);
        $this->bean->to_addr_arr = array();
        foreach ($toEmailAddresses as $ea => $address) {

            $email = '';
            $display = '';
            preg_match(
                '/([a-zA-z0-9\!\#\$\%\&\'\*\+\-\/\ =\?\^\`\{\|\}\~\.\[\]\"\(\)\s]+)((<[a-zA-z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~\.\[\]\"\(\)]+)(@)([a-zA-z0-9\-\.]+\>))$/',
                $address,
                $matches
            );

            // Strip out name from email address
            // eg Angel Mcmahon <sales.vegan@example.it>
            if (count($matches) > 3) {
                $display = trim($matches[1]);
                $email = $matches[2];
            } else {
                $email = $address;
                $display = '';
            }

            $email = str_ireplace('<', '', $email);
            $email = str_ireplace('>', '', $email);
            $email = str_ireplace('&lt;', '', $email);
            $email = str_ireplace('&rt;', '', $email);


            $this->bean->to_addrs_arr[] = array(
                'email' => $email,
                'display' => $display,
            );
        }


        if (empty($this->bean->cc_addrs)) {
            if (!empty($_REQUEST['cc_addrs_names'])) {
                $this->bean->cc_addrs_names = htmlspecialchars_decode($_REQUEST['cc_addrs_names']);
            }

            if (!empty($this->bean->cc_addrs_names)) {
                $this->bean->cc_addrs = htmlspecialchars_decode($this->bean->cc_addrs_names);
            }
        }

        $ccEmailAddresses = preg_split('/[,;]/', $this->bean->cc_addrs, null, PREG_SPLIT_NO_EMPTY);
        $this->bean->cc_addrs_arr = array();
        foreach ($ccEmailAddresses as $ea => $address) {
            $email = '';
            $display = '';
            preg_match(
                '/([a-zA-z0-9\!\#\$\%\&\'\*\+\-\/\ =\?\^\`\{\|\}\~\.\[\]\"\(\)\s]+)((<[a-zA-z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~\.\[\]\"\(\)]+)(@)([a-zA-z0-9\-\.]+\>))$/',
                $address,
                $matches
            );

            // Strip out name from email address
            // eg Angel Mcmahon <sales.vegan@example.it>
            if (count($matches) > 3) {
                $display = trim($matches[1]);
                $email = $matches[2];
            } else {
                $email = $address;
                $display = '';
            }

            $email = str_ireplace('<', '', $email);
            $email = str_ireplace('>', '', $email);
            $email = str_ireplace('&lt;', '', $email);
            $email = str_ireplace('&rt;', '', $email);


            $this->bean->cc_addrs_arr[] = array(
                'email' => $email,
                'display' => $display,
            );
        }


        if (empty($this->bean->bcc_addrs)) {
            if (!empty($_REQUEST['bcc_addrs_names'])) {
                $this->bean->bcc_addrs_names = htmlspecialchars_decode($_REQUEST['bcc_addrs_names']);
            }

            if (!empty($this->bean->bcc_addrs_names)) {
                $this->bean->bcc_addrs = htmlspecialchars_decode($this->bean->bcc_addrs_names);
            }
        }

        $bccEmailAddresses = preg_split('/[,;]/', $this->bean->bcc_addrs, null, PREG_SPLIT_NO_EMPTY);
        $this->bean->bcc_addrs_arr = array();
        foreach ($bccEmailAddresses as $ea => $address) {
            $email = '';
            $display = '';
            preg_match(
                '/([a-zA-z0-9\!\#\$\%\&\'\*\+\-\/\ =\?\^\`\{\|\}\~\.\[\]\"\(\)\s]+)((<[a-zA-z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~\.\[\]\"\(\)]+)(@)([a-zA-z0-9\-\.]+\>))$/',
                $address,
                $matches
            );

            // Strip out name from email address
            // eg Angel Mcmahon <sales.vegan@example.it>
            if (count($matches) > 3) {
                $display = trim($matches[1]);
                $email = $matches[2];
            } else {
                $email = $address;
                $display = '';
            }

            $email = str_ireplace('<', '', $email);
            $email = str_ireplace('>', '', $email);
            $email = str_ireplace('&lt;', '', $email);
            $email = str_ireplace('&rt;', '', $email);


            $this->bean->bcc_addrs_arr[] = array(
                'email' => $email,
                'display' => $display,
            );
        }

        if (empty($this->bean->name)) {
            if (!empty($_REQUEST['name'])) {
                $this->bean->name = $_REQUEST['name'];
            }
        }

        if (empty($this->bean->description_html)) {
            if (!empty($_REQUEST['description_html'])) {
                $this->bean->description_html = $_REQUEST['description_html'];
            }
        }

        if (empty($this->bean->description)) {
            if (!empty($_REQUEST['description'])) {
                $this->bean->description = $_REQUEST['description'];
            }
        }

        $this->bean->save();

        $this->bean->handleMultipleFileAttachments();

        if ($this->bean->send()) {
            $this->bean->status = 'sent';
            // TODO save action
            $this->bean->save();
        } else {
            $this->bean->status = 'sent_error';
        }

        $this->view = 'sendemail';
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
        global $current_user;
        $email = new Email();
        $email->email2init();
        $ie = new InboundEmail();
        $ie->email = $email;
        $json = getJSONobj();
        $GLOBALS['log']->debug("********** EMAIL 2.0 - Asynchronous - at: refreshSugarFolders");
        $rootNode = new ExtNode('', '');
        $folderOpenState = $current_user->getPreference('folderOpenState', 'Emails');
        $folderOpenState = (empty($folderOpenState)) ? "" : $folderOpenState;
        $ret = $email->et->folder->getUserFolders($rootNode, sugar_unserialize($folderOpenState), $current_user, true);
        $out = json_encode(array('response' => $ret));
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