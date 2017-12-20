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
class Basic extends SugarBean
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be removed in 8.0,
     *     please update your code, use __construct instead
     */
    public function Basic()
    {
        $deprecatedMessage =
            'PHP4 Style Constructors are deprecated and will be remove in 8.0, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * @see SugarBean::get_summary_text()
     */
    public function get_summary_text()
    {
        return "$this->name";
    }

    /**
     * edit view should show confirm opt in (only if enabled)
     *
     * @global array $sugar_config
     * @global array $app_strings
     * @param string $emailField
     * @return string
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function getEmailAddressConfirmOptInTick($emailField)
    {
        $this->getEmailAddressValidateArguments($emailField);

        global $sugar_config, $app_strings;

        $tickHtml = '';
        $confirmOptIn = $this->getEmailAddressConfirmOptIn($emailField);
        if ($confirmOptIn && $sugar_config['email_enable_confirm_opt_in']) {
            $tickTitle = $app_strings['LBL_CONFIRM_OPT_IN_TITLE'];
            $tickHtml = '<span class="confirm-opt-in-tick" title="' . $tickTitle . '">&#10004;</span>';
        }

        return $tickHtml;
    }

    /**
     *
     * @global array $sugar_config
     * @global \LoggerManager $log
     * @param string $emailField
     * @return boolean
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function getEmailAddressConfirmOptIn($emailField)
    {
        $this->getEmailAddressValidateArguments($emailField);

        global $sugar_config;

        if (!$sugar_config['email_enable_confirm_opt_in']) {
            global $log;
            $log->warn('Confirm Opt In is not enabled.');
            return true;
        }

        $emailAddressId = $this->getEmailAddressId($emailField);
        $emailAddress = BeanFactory::getBean('EmailAddresses', $emailAddressId);
        $confirmOptIn = $emailAddress->confirm_opt_in;

        return $confirmOptIn;
    }

    /**
     *
     * @global \LoggerManager $log
     * @param string $emailField
     * @return string|null EmailAddress ID or null on error
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    private function getEmailAddressId($emailField)
    {
        $this->getEmailAddressValidateArguments($emailField);

        $emailAddress = $this->cleanUpEmailAddress($this->{$emailField});

        if (!$emailAddress) {
            global $log;
            $log->warn('Trying to get an empty email address.');
            return null;
        }

        if (empty($this->emailAddress->addresses)) {
            $this->retrieve();
        }

        $found = false;
        foreach ($this->emailAddress->addresses as $address) {
            if ($this->cleanUpEmailAddress($address['email_address']) === $emailAddress) {
                $found = true;
                $emailAddressId = $address['email_address_id'];
                break;
            }
        }

        if (!$found) {
            throw new RuntimeException('A Basic bean has not selected email address. (' . $emailAddress . ')');
        }

        return $emailAddressId;
    }

    /**
     *
     * @param string $emailField
     * @throws InvalidArgumentException
     */
    private function getEmailAddressValidateArguments($emailField)
    {
        if (!is_string($emailField) || !preg_match('/^email\d+/', $emailField)) {
            throw new InvalidArgumentException('emailField string is invalid, "' . $emailField . '" given.');
        }
    }

    /**
     *
     * @param string $emailAddress
     * @return string
     */
    private function cleanUpEmailAddress($emailAddress)
    {
        $ret = $emailAddress;
        $ret = trim($ret);
        $ret = strtolower($ret);

        return $ret;
    }
}
