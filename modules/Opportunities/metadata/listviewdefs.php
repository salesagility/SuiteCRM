<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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




$listViewDefs['Opportunities'] = array(
	'NAME' => array(
		'width'   => '30',  
		'label'   => 'LBL_LIST_OPPORTUNITY_NAME', 
		'link'    => true,
        'default' => true),
	'ACCOUNT_NAME' => array(
		'width'   => '20', 
		'label'   => 'LBL_LIST_ACCOUNT_NAME', 
		'id'      => 'ACCOUNT_ID',
        'module'  => 'Accounts',
		'link'    => true,
        'default' => true,
        'sortable'=> true,
        'ACLTag' => 'ACCOUNT',
        'contextMenu' => array('objectType' => 'sugarAccount', 
                               'metaData' => array('return_module' => 'Contacts', 
                                                   'return_action' => 'ListView', 
                                                   'module' => 'Accounts',
                                                   'return_action' => 'ListView', 
                                                   'parent_id' => '{$ACCOUNT_ID}', 
                                                   'parent_name' => '{$ACCOUNT_NAME}', 
                                                   'account_id' => '{$ACCOUNT_ID}', 
                                                   'account_name' => '{$ACCOUNT_NAME}',
                                                   ),
                              ),
        'related_fields' => array('account_id')),
	'SALES_STAGE' => array(
		'width'   => '10',  
		'label'   => 'LBL_LIST_SALES_STAGE',
        'default' => true), 
	'AMOUNT_USDOLLAR' => array(
		'width'   => '10', 
		'label'   => 'LBL_LIST_AMOUNT_USDOLLAR',
        'align'   => 'right',
        'default' => true,
        'currency_format' => true,
	),  
    'OPPORTUNITY_TYPE' => array(
        'width' => '15', 
        'label' => 'LBL_TYPE'),
    'LEAD_SOURCE' => array(
        'width' => '15', 
        'label' => 'LBL_LEAD_SOURCE'),
    'NEXT_STEP' => array(
        'width' => '10', 
        'label' => 'LBL_NEXT_STEP'),
    'PROBABILITY' => array(
        'width' => '10', 
        'label' => 'LBL_PROBABILITY'),
	'DATE_CLOSED' => array(
		'width' => '10', 
		'label' => 'LBL_LIST_DATE_CLOSED',
        'default' => true),
    'CREATED_BY_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_CREATED'),
	'ASSIGNED_USER_NAME' => array(
		'width' => '5', 
		'label' => 'LBL_LIST_ASSIGNED_USER',
		'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true),
    'MODIFIED_BY_NAME' => array(
        'width' => '5', 
        'label' => 'LBL_MODIFIED'),
    'DATE_ENTERED' => array(
        'width' => '10', 
        'label' => 'LBL_DATE_ENTERED',
		'default' => true)
);

?>
