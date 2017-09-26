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

/**
 * Class OptInConfirmationEmailSender
 */
class OptInConfirmationEmailSender {

    /**
     * @return bool
     */
    private function isOptInConfirmationEmailEnabled() {
        global $sugar_config;

        if(
            isset($sugar_config['opt_in_confirmation_email_enabled']) &&
            $sugar_config['opt_in_confirmation_email_enabled']
        ) {

            return true;
        }

        return false;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    private function getOptInConfirmationEmailTemplateId() {
        global $sugar_config, $log;

        if(
            !isset($sugar_config['opt_in_confirmation_email_template_id']) ||
            !$sugar_config['opt_in_confirmation_email_template_id']
        ) {
            $msg = 'Opt In Confirmation email template is not set.';
            $log->fatal($msg);
            throw new RuntimeException($msg);
        }

        return $sugar_config['opt_in_confirmation_email_template_id'];
    }

    /**
     * @param Person $person
     * @return bool
     * @throws \RuntimeException
     */
    public function sendOptInConfirmationEmail($person)
    {
        global $log;

        if($this->isOptInConfirmationEmailEnabled()) {
            require_once get_custom_file_if_exists('include/SugarPHPMailer.php');
            $mailer = new SugarPHPMailer();
            $mailer->prepForOutbound();
            $mailer->setMailerForSystem();
            $emailTemplate = new EmailTemplate();
            $emailTemplate->retrieve($this->getOptInConfirmationEmailTemplateId());
            if(!$emailTemplate) {
                $msg = 'optInConfirmationEmail template is empty';
                $log->fatal($msg);
                throw new RuntimeException($msg);
            }

            $mailer->Subject = $emailTemplate->subject;
            $mailer->Body = $emailTemplate->body_html;
            $mailer->isHTML(true);
            $mailer->AltBody = $emailTemplate->body;
            $mailer->From = $emailTemplate->from_address;
            $mailer->FromName = $emailTemplate->from_name;
            $mailer->addAddress($person->email1);

            try {
                if ($mailer->send()) {
                    $this->logEmail($person->email1, $mailer, $person->id);

                    return true;
                }
            } catch (phpmailerException $exception) {
                $msg = 'OptInConfirmationEmailSender: sending email Failed:  ' . $exception->getMessage();
                $log->fatal($msg);
                throw new RuntimeException($msg);
            }
        } else {
            $msg = 'Opt In Confirmation Email is not enabled';
            $log->fatal($msg);
            throw new RuntimeException($msg);
        }

        return false;
    }

}