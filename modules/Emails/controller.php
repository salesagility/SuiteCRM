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

class EmailsController extends SugarController
{
    public function action_index()
    {
        $this->view = 'list';
    }

    public function action_ComposeView()
    {
        $this->view = 'compose';
    }

    public function action_send()
    {
        if(empty($this->bean)) {
            $this->bean = BeanFactory::getBean('Emails');
        }

        $old = array('&lt;','&gt;');
        $new = array('<','>');

        if($_REQUEST['from_addr'] != $_REQUEST['from_addr_name'].' &lt;'.$_REQUEST['from_addr_email'].'&gt;') {
            if(false === strpos($_REQUEST['from_addr'], '&lt;')) { // we have an email only?
                $this->bean->from_addr = $_REQUEST['from_addr'];
                $this->bean->from_name = '';
            } else { // we have a compound string
                $newFromAddr =  str_replace($old, $new, $_REQUEST['from_addr']);
                $this->bean->from_addr = substr($newFromAddr, (1 + strpos($newFromAddr, '<')), (strpos($newFromAddr, '>') - strpos($newFromAddr, '<')) -1 );
                $this->bean->from_name = substr($newFromAddr, 0, (strpos($newFromAddr, '<') -1));
            }
        } elseif(!empty($_REQUEST['from_addr_email']) && isset($_REQUEST['from_addr_email'])) {
            $this->bean->from_addr = $_REQUEST['from_addr_email'];
            $this->bean->from_name = $_REQUEST['from_addr_name'];
        } else {
            $this->bean->from_addr = $this->bean->getSystemDefaultEmail();
        }


        if(empty($this->bean->to_addrs)) {
            if(!empty($_REQUEST['to_addrs_names'])) {
                $this->bean->to_addrs_names = $_REQUEST['to_addrs_names'];
            }

            if(!empty($this->bean->to_addrs_names)) {
                $this->bean->to_addrs = $this->bean->to_addrs_names;
            }
        }


        $toEmailAddresses = preg_split('/[,;]/', $this->bean->to_addrs, null, PREG_SPLIT_NO_EMPTY);
        $this->bean->to_addr_arr = array();
        foreach ($toEmailAddresses as $ea => $address) {
            $this->bean->to_addrs_arr[] = array(
                'email' => $address,
                'display' => $address,
            );
        }


        if(empty($this->bean->cc_addrs)) {
            if (!empty($_REQUEST['cc_addrs_names'])) {
                $this->bean->cc_addrs_names = $_REQUEST['cc_addrs_names'];
            }

            if (!empty($this->bean->cc_addrs_names)) {
                $this->bean->cc_addrs = $this->bean->cc_addrs_names;
            }
        }

        $ccEmailAddresses = preg_split('/[,;]/', $this->bean->cc_addrs, null, PREG_SPLIT_NO_EMPTY);
        $this->bean->cc_addrs_arr = array();
        foreach ($ccEmailAddresses as $ea => $address) {
            $this->bean->cc_addrs_arr[] = array(
                'email' => $address,
                'display' => $address,
            );
        }


        if(empty($this->bean->bcc_addrs)) {
            if (!empty($_REQUEST['bcc_addrs_names'])) {
                $this->bean->bcc_addrs_names = $_REQUEST['bcc_addrs_names'];
            }

            if (!empty($this->bean->bcc_addrs_names)) {
                $this->bean->bcc_addrs = $this->bean->bcc_addrs_names;
            }
        }

        $bccEmailAddresses = preg_split('/[,;]/', $this->bean->bcc_addrs, null, PREG_SPLIT_NO_EMPTY);
        $this->bean->bcc_addrs_arr = array();
        foreach ($bccEmailAddresses as $ea => $address) {
            $this->bean->bcc_addrs_arr[] = array(
                'email' => $address,
                'display' => $address,
            );
        }

        if(empty($this->bean->name)) {
            if(!empty($_REQUEST['name'])) {
                $this->bean->name = $_REQUEST['name'];
            }
        }

        if(empty($this->bean->description_html)) {
            if(!empty($_REQUEST['description_html'])) {
                $this->bean->description_html = $_REQUEST['description_html'];
            }
        }


        if(empty($this->bean->description)) {
            if(!empty($_REQUEST['description'])) {
                $this->bean->description = $_REQUEST['description'];
            }
        }


        if($this->bean->send()) {
            $this->bean->status = 'sent';
            // TODO save action
            $this->bean->save();
        } else {
            $this->bean->status = 'sent_error';
        }

        $this->view = 'sendemail';
    }

}