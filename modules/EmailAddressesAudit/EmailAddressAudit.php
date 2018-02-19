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
if (! defined('sugarEntry') || ! sugarEntry) {
    die('Not A Valid Entry Point');
}

class EmailAddressAudit extends SugarBean
{

    public $table_name = 'email_addresses_audit';

    public $module_name = "EmailAddressesAudit";

    public $module_dir = 'EmailAddressesAudit';

    public $object_name = 'EmailAddressAudit';

    /**
     *
     * @var string
     */
    public $id;

    /**
     *
     * @var string
     */
    public $emailAddressId;

    /**
     *
     * @var string
     */
    public $beanName;

    /**
     *
     * @var string
     */
    public $beanId;

    /**
     *
     * @var string
     */
    public $fieldName;

    /**
     *
     * @var string
     */
    public $oldValue;

    /**
     *
     * @var string
     */
    public $newValue;

    /**
     *
     * @var string
     */
    public $createdBy;

    /**
     *
     * @var string
     */
    public $created;

    /**
     * Save EmailAddress Audit
     *
     * @param string $beanName
     * @param string $beanId
     * @param string $emailAddressId
     * @param string $fieldName
     * @param string $oldValue
     * @param string $newValue
     */
    public static function saveEmailAddressesAudit($beanName, $beanId, $emailAddressId, $fieldName, $oldValue, $newValue)
    {
        global $current_user;

        $emailAddressAudit = new EmailAddressAudit();
        $emailAddressAudit->beanId = $beanId;
        $emailAddressAudit->beanName = $beanName;
        $emailAddressAudit->emailAddressId = $emailAddressId;
        $emailAddressAudit->fieldName = $fieldName;
        $emailAddressAudit->oldValue = $oldValue;
        $emailAddressAudit->newValue = $newValue;
        $emailAddressAudit->createdBy = $current_user->id;
        $emailAddressAudit->created = (new DateTime())->format("Y-m-d H:i:s");
        $emailAddressAudit->save();
    }

    /**
     * Audit email adresses changelog
     *
     * @param string $beanName
     * @param string $beanId
     * @param array $emailAddressData
     * @param string $emailId
     *
     * @return boolean
     */
    public static function audit($beanName, $beanId, $emailAddressData = array(), $emailId = null)
    {
        if (empty($emailAddressData) || empty($emailId)) {
            return false;
        }
        $sugarEmailAddress = new SugarEmailAddress();
        $emailAddress = $sugarEmailAddress->getAddressByParentIdAndEmailId($beanId, $beanName, $emailId);

        $selectedEmailAddress = null;
        if (!empty($emailAddress)) {
            if (isset($emailAddressData["email_address"])) {
                if ($emailAddress["email_address"] != $emailAddressData["email_address"]) {
                    self::saveEmailAddressesAudit(
                        $beanName,
                        $beanId,
                        $emailId,
                        "email_address",
                        $emailAddress["email_address"],
                        $emailAddressData["email_address"]
                     );
                }
            }

            if (isset($emailAddressData["invalid_email"])) {
                if ($emailAddress["invalid_email"] != $emailAddressData["invalid_email"]) {
                    self::saveEmailAddressesAudit(
                        $beanName,
                        $beanId,
                        $emailId,
                        "invalid_email",
                        $emailAddress["invalid_email"],
                        $emailAddressData["invalid_email"]
                     );
                }
            }

            if (isset($emailAddressData["opt_out"])) {
                if ($emailAddress["opt_out"] != $emailAddressData["opt_out"]) {
                    self::saveEmailAddressesAudit(
                        $beanName,
                        $beanId,
                        $emailId,
                        "opt_out",
                        $emailAddress["opt_out"],
                        $emailAddressData["opt_out"]
                    );
                }
            }

            if (isset($emailAddressData["reply_to_address"])) {
                if ($emailAddress["reply_to_address"] != $emailAddressData["reply_to_address"]) {
                    self::saveEmailAddressesAudit(
                        $beanName,
                        $beanId,
                        $emailId,
                        "reply_to_address",
                        $emailAddress["reply_to_address"],
                        $emailAddressData["reply_to_address"]
                     );
                }
            }

            if (isset($emailAddressData["primary_address"])) {
                if ($emailAddress["primary_address"] != $emailAddressData["primary_address"]) {
                    self::saveEmailAddressesAudit(
                        $beanName,
                        $beanId,
                        $emailId,
                        "primary_address",
                        $emailAddress["primary_address"],
                        $emailAddressData["primary_address"]
                    );
                }
            }

            if (isset($emailAddressData["deleted"])) {
                if ($emailAddress["deleted"] == 1) {
                    self::saveEmailAddressesAudit($beanName, $beanId, $emailId, "deleted", 0, 1);
                }
            }
        }
    }
}