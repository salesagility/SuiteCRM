<?php
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
$dictionary['EmailAddressAudit'] = array(
    'table' => 'email_addresses_audit',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
            'vname' => 'LBL_EMAIL_ADDRESS_AUDIT_ID',
            'required' => true,
        ),
        'emailAddressId' =>  array(
            'name' => 'emailAddressId',
            'vname' => 'LBL_EMAIL_ADDRESS_ID',
            'rname' => 'id',
            'id_name' => 'emailAddressId',
            'type' => 'id',
            'table' => 'email_adresses',
            'isnull' => 'true',
            'module' => 'EmailAddresses',
        ),
        'beanName' => array(
            'required' => false,
            'name' => 'beanName',
            'vname' => 'LBL_BEAN_NAME',
            'type' => 'varchar',
            'len' => 100,
        ),
        'beanId' => array(
            'required' => false,
            'name' => 'beanId',
            'vname' => 'LBL_BEAN_ID',
            'type' => 'varchar',
            'len' => 100,
        ),
        'fieldName' => array(
            'required' => false,
            'name' => 'fieldName',
            'vname' => 'LBL_FIELD_NAME',
            'type' => 'varchar',
            'len' => 150,
        ),
        'oldValue' => array(
            'required' => false,
            'name' => 'oldValue',
            'vname' => 'LBL_OLD_VALUE',
            'type' => 'varchar',
            'len' => 500,
        ),
        'newValue' => array(
            'required' => false,
            'name' => 'newValue',
            'vname' => 'LBL_NEW_VALUE',
            'type' => 'varchar',
            'len' => 500,
        ),
        'createdBy' => array(
            'name' => 'createdBy',
            'vname' => 'LBL_CREATED_BY_USER',
            'rname' => 'id',
            'id_name' => 'createdBy',
            'type' => 'id',
            'table' => 'users',
            'isnull' => 'true',
            'module' => 'Users'
        ),
        'created' => array(
            'name' => 'created',
            'vname' => 'LBL_CREATED',
            'type' => 'datetime'
        ),
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'default' => 0
        )
    ),
    'relationships'=>array (
    ),
);
