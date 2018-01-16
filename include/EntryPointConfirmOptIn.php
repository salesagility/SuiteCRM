<?php

/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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

/**
 * Class confirm_opt_in
 */
class EntryPointConfirmOptIn 
{

    /**
     * @var EmailAddress $emailAddress
     */
    private $emailAddress;

    /**
     * 
     * @param array $request
     * @param array $post
     */
    public function __construct($request = null, $post = null) {

        if (is_null($request)) {
            $request = $_REQUEST;
        }

        if (is_null($post)) {
            $post = $_POST;
        }

        $method = isset($request['method']) && $request['method'] ? $request['method'] : null;

        $output = $this->callMethod($method);

        echo $output;
        sugar_cleanup();
    }

    /**
     * 
     * @param string $method
     * @return string
     */
    protected function callMethod($method) {
        switch ($method) {
            case 'confirmOptInSelected':
                $output = $this->methodConfirmOptInSelected($post);
                break;
            default:
                $output = $this->methodConfirmOptInUser($request);
                break;
        }
        return $output;
    }

    /**
     * 
     * @global array $sugar_config
     * @param array $post
     * @return string|boolean
     */
    private function methodConfirmOptInSelected($post) {

        global $sugar_config;

        $confirmOptInEnabled = isset($sugar_config['email_enable_confirm_opt_in']) && $sugar_config['email_enable_confirm_opt_in'];

        if (!$confirmOptInEnabled) {
            $this->warn('Confirm Opt In disabled');
            return false;
        }


        $module = $post['module'];
        $uids = explode(',', $post['uid']);
        $emailMan = new EmailMan();
        $err = 0;
        $msg = '';
        foreach ($uids as $uid) {
            if (!$emailMan->addOptInEmailToEmailQueue($module, $uid)) {
                $err++;
            }
        }

        if ($err) {
            $msg = 'Incorrect Bean ID. ';
        } else {
            $msg = 'All ' . $module . ' added to email queue.';
        }

        return $msg;
    }

    /**
     * Confirm Opt In User
     * 
     * @param array $request
     * @return string
     */
    private function methodConfirmOptInUser($request) {
        $emailAddress = BeanFactory::getBean('EmailAddresses');
        $this->emailAddress = $emailAddress->retrieve_by_string_fields(
                array(
                    'email_address' => $request['from']
                )
        );

        if ($this->emailAddress) {
            $this->emailAddress->confirmOptIn();
            $this->emailAddress->save();
        }

        $template = new Sugar_Smarty();
        $template->assign('FOCUS', $this->emailAddress);

        return $template->fetch('include/EntryPointConfirmOptIn.tpl');
    }

}
