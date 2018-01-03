<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/

/*********************************************************************************
 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
// User is used to store customer information.

/**
 * Class UserSignature
 */
class UserSignature extends SugarBean
{
    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $date_entered;

    /**
     * @var
     */
    public $date_modified;

    /**
     * @var
     */
    public $deleted;

    /**
     * @var
     */
    public $user_id;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $signature;

    /**
     * @var string
     */
    public $table_name = 'users_signatures';

    /**
     * @var string
     */
    public $module_dir = 'Users';

    /**
     * @var string
     */
    public $object_name = 'UserSignature';

    /**
     * @var bool
     */
    public $disable_custom_fields = true;

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8,
     *     please update your code, use __construct instead
     */
    public function UserSignature()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, ' .
            'please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * UserSignature constructor.
     */
    public function __construct()
    {
        //Ensure the vardefs get loaded.
        if (file_exists('custom/metadata/users_signaturesMetaData.php')) {
            require_once('custom/metadata/users_signaturesMetaData.php');
        } else {
            require_once('metadata/users_signaturesMetaData.php');
        }


        parent::__construct();
    }

    /**
     * returns the bean name - overrides SugarBean's
     */
    public function get_summary_text()
    {
        return $this->name;
    }

    /**
     * Override's SugarBean's
     * @param $order_by
     * @param $where
     * @param int $show_deleted
     * @return String
     */
    public function create_export_query($order_by, $where, $show_deleted = 0)
    {
        return $this->create_new_list_query($order_by, $where, array(), array(), $show_deleted);
    }

    /**
     * Override's SugarBean's
     */
    public function get_list_view_data()
    {
        global $app_list_strings;
        $temp_array = $this->get_list_view_array();
        $temp_array['MAILBOX_TYPE_NAME'] = $app_list_strings['dom_mailbox_type'][$this->mailbox_type];
        return $temp_array;
    }

    /**
     * Override's SugarBean's
     */
    public function fill_in_additional_list_fields()
    {
        $this->fill_in_additional_detail_fields();
    }

    /**
     * Override's SugarBean's
     */
    public function fill_in_additional_detail_fields()
    {
    }
}
