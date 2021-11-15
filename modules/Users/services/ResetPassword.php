<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Class ResetPassword
 */
class ResetPassword
{
    /**
     * @param string|null $username
     * @param string|null $useremail
     * @throws InvalidArgumentException
     * @throws BadFunctionCallException
     */
    public function reset(?string $username, ?string $useremail): void
    {
        if (!defined('sugarEntry') || !sugarEntry) {
            die('Not A Valid Entry Point');
        }

        global $current_user;

        $mod_strings = return_module_language('', 'Users');
        $res = $GLOBALS['sugar_config']['passwordsetting'];

        $this->validateInput($username, $useremail, $mod_strings);

        $usr = $this->loadUser($username, $useremail, $mod_strings);

        $password = User::generatePassword();

        $emailTemp_id = $res['generatepasswordtmpl'];

        $additionalData = array(
            'password' => $password
        );

        $result = $usr->sendEmailForPassword($emailTemp_id, $additionalData);

        $this->handleResult($result, $current_user, $mod_strings);
    }

    /**
     * @param string|null $username
     * @param string|null $useremail
     * @throws InvalidArgumentException
     * @throws BadFunctionCallException
     */
    public function sendResetLink(?string $username, ?string $useremail): void
    {
        if (!defined('sugarEntry') || !sugarEntry) {
            die('Not A Valid Entry Point');
        }

        global $current_user;

        $mod_strings = return_module_language('', 'Users');
        $res = $GLOBALS['sugar_config']['passwordsetting'];

        $this->validateInput($username, $useremail, $mod_strings);

        $usr = $this->loadUser($username, $useremail, $mod_strings);

        $url = $this->generateLink($username, $usr);

        $emailTemp_id = $res['lostpasswordtmpl'];

        $additionalData = array(
            'link' => true,
            'password' => ''
        );

        if (isset($url)) {
            $additionalData['url'] = $url;
        }

        $result = $usr->sendEmailForPassword($emailTemp_id, $additionalData);

        $this->handleResult($result, $current_user, $mod_strings);
    }

    /**
     * @param string $username
     * @param string $useremail
     * @param array $mod_strings
     * @throws InvalidArgumentException
     */
    protected function validateInput(?string $username, ?string $useremail, array $mod_strings): void
    {
        if (empty($username) || empty($useremail)) {
            throw new InvalidArgumentException($mod_strings['LBL_PROVIDE_USERNAME_AND_EMAIL']);
        }
    }

    /**
     * @param string|null $useremail
     * @param User|null $user
     * @param array $mod_strings
     * @throws InvalidArgumentException
     */
    protected function validateUser(?string $useremail, ?User $user, array $mod_strings): void
    {
        if (!$user->isPrimaryEmail($useremail)) {
            throw new InvalidArgumentException($mod_strings['LBL_PROVIDE_USERNAME_AND_EMAIL']);
        }

        if ($user->portal_only || $user->is_group) {
            throw new InvalidArgumentException($mod_strings['LBL_PROVIDE_USERNAME_AND_EMAIL']);
        }

        $regexmail = "/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+\$/";

        if (!preg_match($regexmail, $user->emailAddress->getPrimaryAddress($user))) {
            throw new InvalidArgumentException($mod_strings['ERR_EMAIL_INCORRECT']);
        }
    }

    /**
     * @param string $type
     * @param string $message
     */
    protected function logError(string $type, string $message): void
    {
        global $log;

        $log->$type('ResetPassword: ' . $message);
    }

    /**
     * Load user
     * @param string|null $username
     * @param string|null $useremail
     * @param array $mod_strings
     * @return User
     */
    protected function loadUser(?string $username, ?string $useremail, array $mod_strings): User
    {
        $usr = new User();

        $usr_id = $usr->retrieve_user_id($username);
        $usr->retrieve($usr_id);

        $this->validateUser($useremail, $usr, $mod_strings);

        return $usr;
    }

    /**
     * @param array $result
     * @param User|null $current_user
     * @param array $mod_strings
     * @throws BadFunctionCallException
     */
    protected function handleResult(array $result, ?User $current_user, array $mod_strings): void
    {
        if ($result['status'] === true) {
            return;
        }

        if ($result['status'] === false && !empty($result['message'])) {
            $this->logError('error', $result['message']);
            throw new BadFunctionCallException($result['message']);
        }

        if ($current_user->is_admin) {
            $email_errors = $mod_strings['ERR_EMAIL_NOT_SENT_ADMIN'];
            $email_errors .= "\n-" . $mod_strings['ERR_RECIPIENT_EMAIL'];
            $email_errors .= "\n-" . $mod_strings['ERR_SERVER_STATUS'];

            $this->logError('error', $email_errors);

            throw new BadFunctionCallException($email_errors);
        }

        $this->logError('error', $mod_strings['LBL_EMAIL_NOT_SENT']);
        throw new BadFunctionCallException($mod_strings['LBL_EMAIL_NOT_SENT']);
    }

    /**
     * Generate Link
     * @param string|null $username
     * @param User $usr
     * @return string
     */
    protected function generateLink(?string $username, User $usr): string
    {
        global $timedate;
        $guid = create_guid();
        $userId = $usr->id ?? '';
        $url = $GLOBALS['sugar_config']['site_url'] . "/index.php?entryPoint=Changenewpassword&guid=$guid";
        $time_now = TimeDate::getInstance()->nowDb();
        $q = "INSERT INTO users_password_link (id, username, date_generated, user_id) VALUES('" . $guid . "','" . $username . "','" . $time_now . "','" . $userId . "') ";
        $usr->db->query($q);

        return $url;
    }
}
