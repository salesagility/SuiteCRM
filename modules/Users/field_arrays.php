<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

/*********************************************************************************

 * Description:  Contains field arrays that are used for caching
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
$fields_array['User'] = array(
    'column_fields' => array(
        'id',
        'full_name',
        'user_name'
        ,'user_hash'
        ,'first_name'
        ,'last_name'
        ,'description'
        ,'date_entered'
        ,'date_modified'
        ,'modified_user_id'
        , 'created_by'
        ,'title'
        ,'department'
        ,'is_admin'
        ,'phone_home'
        ,'phone_mobile'
        ,'phone_work'
        ,'phone_other'
        ,'phone_fax'
        ,'address_street'
        ,'address_city'
        ,'address_state'
        ,'address_postalcode'
        ,'address_country'
        ,'reports_to_id'
        ,'portal_only'
        ,'status'
        ,'receive_notifications'
        ,'employee_status'
        ,'messenger_id'
        ,'messenger_type'
        ,'is_group'

    ),
    'list_fields' => array(
        'full_name',
        'id',
        'first_name',
        'last_name',
        'user_name',
        'status',
        'department',
        'is_admin',
        'email1',
        'phone_work',
        'title',
        'reports_to_name',
        'reports_to_id',
        'is_group'

    ),
    'export_fields' => array(
        'id',
        'user_name'
        ,'first_name'
        ,'last_name'
        ,'description'
        ,'date_entered'
        ,'date_modified'
        ,'modified_user_id'
        ,'created_by'
        ,'title'
        ,'department'
        ,'is_admin'
        ,'phone_home'
        ,'phone_mobile'
        ,'phone_work'
        ,'phone_other'
        ,'phone_fax'
        ,'address_street'
        ,'address_city'
        ,'address_state'
        ,'address_postalcode'
        ,'address_country'
        ,'reports_to_id'
        ,'portal_only'
        ,'status'
        ,'receive_notifications'
        ,'employee_status'
        ,'messenger_id'
        ,'messenger_type'
        ,'is_group'

    ),
    'required_fields' =>   array("last_name"=>1,'user_name'=>2,'status'=>3),
);

$fields_array['UserSignature'] = array(
    'column_fields' => array(
        'id',
        'date_entered',
        'date_modified',
        'deleted',
        'user_id',
        'name',
        'signature',
    ),
    'list_fields' => array(
        'id',
        'date_entered',
        'date_modified',
        'deleted',
        'user_id',
        'name',
        'signature',
    ),
);
