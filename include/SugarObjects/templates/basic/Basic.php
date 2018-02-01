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
     * @var array
     */
    protected static $doNotDisplayOptInTickForModule = array(
        'Users',
        'Employees'
    );

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
     * @param string $emailField
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getConfirmOptInTickFromSugarEmailAddressField($emailField)
    {
        $this->validateSugarEmailAddressField($emailField);

        return $this->displayOptInFromSugarEmailAddressField($emailField);
    }


    /**
     * @param string $emailField
     * @return string
     */
    public function getOptInStatusFromSugarField($emailField) {
        $emailAddress = $this->fromSugarEmailAddressField($emailField);
        $configurator = new Configurator();
        $enableConfirmedOptIn = $configurator->config['email_enable_confirm_opt_in'];

        if (empty($emailAddress)) {
            LoggerManager::getLogger()->warn('Empty email address');
            return '';
        }

        return $emailAddress->getOptInIndication();
    }

    /**
     * Return Email address from an email address field eg email1
     * @param string $emailField
     * @return \EmailAddress|null
     * @throws InvalidArgumentException
     */
    public function fromSugarEmailAddressField($emailField)
    {
        $this->validateSugarEmailAddressField($emailField);
        $configurator = new Configurator();
        $sugar_config = $configurator->config;

        /** @var EmailAddress $emailAddressBean */
        $emailAddressBean = BeanFactory::getBean('EmailAddresses');

        if (!$sugar_config['email_enable_confirm_opt_in']) {
            $log = LoggerManager::getLogger();
            $log->warn('Confirm Opt In is not enabled.');
            $emailAddressBean->confirm_opt_in = self::CONFIRMED_OPT_IN;
            return $emailAddressBean;
        }

        $emailAddressId = $this->getIdFromSugarEmailAddressField($emailField);
        return $emailAddressBean->retrieve($emailAddressId);
    }

    /**
     *
     * @param string $emailField
     * @return string|null EmailAddress ID or null on error
     * @throws \InvalidArgumentException
     */
    protected function getIdFromSugarEmailAddressField($emailField)
    {
        $log = LoggerManager::getLogger();

        $this->validateSugarEmailAddressField($emailField);
        $emailAddress = $this->cleanUpEmailAddress($this->{$emailField});

        if (!$emailAddress) {

            $log->warn('Trying to get an empty email address.');
            return null;
        }

        // List view requires us to retrieve the mail so we can see the email addresses
        $this->retrieve();

        $found = false;
        $addresses = $this->emailAddress->addresses;
        foreach ($addresses as $address) {
            if ($this->cleanUpEmailAddress($address['email_address']) === $emailAddress) {
                $found = true;
                $emailAddressId = $address['email_address_id'];
                break;
            }
        }

        if (!$found) {
            // Changed exception to error as demo data is never selected.
            $log->fatal('A Basic bean has not selected email address. (' . $emailAddress . ')');
            return null;
        }

        return $emailAddressId;
    }

    /**
     * @param string $emailField
     * @return string
     */
    protected function displayOptInFromSugarEmailAddressField($emailField)
    {
        global $app_strings;
        
        $configurator = new Configurator();
        $sugar_config = $configurator->config;

        $tickHtml = '';

        if(isset($sugar_config['email_enable_confirm_opt_in'])) {
            $emailConfigEnableConfirmOptIn = $sugar_config['email_enable_confirm_opt_in'];

            if ($emailConfigEnableConfirmOptIn !== EmailAddress::COI_STAT_DISABLED) {
                $template = new Sugar_Smarty();
                
                $optInStatus = $this->getOptInStatusFromSugarField($emailField);
                switch($optInStatus) {
                    case EmailAddress::COI_FLAG_OPT_IN:
                        $optInFlagClass = 'hidden';
                        $optInFlagTitle = '';
                        $optInFlagText = '';
                        break;
                    case EmailAddress::COI_FLAG_OPT_IN:
                        $optInFlagClass = 'email-opt-in-confirmed';
                        $optInFlagTitle = $app_strings['LBL_OPT_IN'];
                        $optInFlagText = '&#10004;';
                    case EmailAddress::COI_FLAG_OPT_IN_PENDING_EMAIL_CONFIRMED:
                        $optInFlagClass = 'email-opt-in-confirmed';
                        $optInFlagTitle = $app_strings['LBL_OPT_IN_CONFIRMED'];
                        $optInFlagText = '&#10004;&#10004;';
                        break;
                    case EmailAddress::COI_FLAG_OPT_IN_PENDING_EMAIL_SENT:
                        $optInFlagClass = 'email-opt-in-sent';
                        $optInFlagTitle = $app_strings['LBL_OPT_IN_PENDING_EMAIL_SENT'];
                        $optInFlagText = '&#10004;';
                        break;
                    case EmailAddress::COI_FLAG_OPT_IN_PENDING_EMAIL_NOT_SENT:
                        $optInFlagClass = 'email-opt-in-not-sent';
                        $optInFlagTitle = $app_strings['LBL_OPT_IN_PENDING_EMAIL_NOT_SENT'];
                        $optInFlagText = '&#10004;';
                        break;
                    case EmailAddress::COI_FLAG_OPT_IN_PENDING_EMAIL_FAILED:
                        $optInFlagClass = 'email-opt-in-failed';
                        $optInFlagTitle = $app_strings['LBL_OPT_IN_PENDING_EMAIL_FAILED'];
                        $optInFlagText = '&#10004;';
                        break;
                    case EmailAddress::COI_FLAG_OPT_OUT:
                        $optInFlagClass = 'email-opt-in-opt-out';
                        $optInFlagTitle = $app_strings['LBL_OPT_IN_OPT_OUT'];
                        $optInFlagText = '❌';
                        break;
                    case EmailAddress::COI_FLAG_INVALID:
                        $optInFlagClass = 'email-opt-in-invalid';
                        $optInFlagTitle = $app_strings['LBL_OPT_IN_INVALID'];
                        $optInFlagText = '?';
                        break;
                    default:
                        $optInFlagClass = 'hidden';
                        $optInFlagTitle = '';
                        $optInFlagText = '';
                        break;
                }
                
                $template->assign('optInFlagClass', $optInFlagClass);
                $template->assign('optInFlagTitle', $optInFlagTitle);
                $template->assign('optInFlagText', $optInFlagText);
                $tickHtml = $template->fetch('include/SugarEmailAddress/templates/displayEmailAddressOptInField.tpl');
            }
        }

        return $tickHtml;
    }

    /**
     *
     * @param string $emailField
     * @throws InvalidArgumentException
     */
    protected function validateSugarEmailAddressField($emailField)
    {
        if (!is_string($emailField)) {
            throw new InvalidArgumentException('Invalid type. $emailField must be a string value, eg. email1');
        }

        if (!preg_match('/^email\d+/', $emailField)) {
            throw new InvalidArgumentException(
                '$emailField is invalid, "' . $emailField . '" given. Expected valid name eg. email1'
            );
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
