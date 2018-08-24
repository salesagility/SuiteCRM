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

$dictionary['queues_queue'] = array('table' => 'queues_queue',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_QUEUES_QUEUE_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
        ),
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => true,
            'default' => '0',
            'reportable'=>false,
        ),
        'date_entered' => array(
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'required' => true,
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'required' => true,
        ),
        'queue_id' => array(
            'name' => 'queue_id',
            'vname' => 'LBL_QUEUE_ID',
            'type' => 'id',
            'required' => true,
            'reportable'=>false,
        ),
        'parent_id' => array(
            'name' => 'parent_id',
            'vname' => 'LBL_PARENT_ID',
            'type' => 'id',
            'required' => true,
            'reportable'=>false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'queues_queuepk',
            'type' =>'primary',
            'fields' => array(
                'id'
            )
        ),
        array(
        'name' =>'idx_queue_id',
        'type'=>'index',
        'fields' => array(
            'queue_id'
            )
        ),
        array(
        'name' =>'idx_parent_id',
        'type'=>'index',
        'fields' => array(
            'parent_id'
            )
        ),
        array(
        'name' => 'compidx_queue_id_parent_id',
        'type' => 'alternate_key',
        'fields' => array(
            'queue_id',
            'parent_id'
            ),
        ),
    ), /* end indices */
    'relationships' => array(
        'child_queues_rel'	=> array(
            'lhs_module'		=> 'Queues',
            'lhs_table'			=> 'queues',
            'lhs_key'			=> 'id',
            'rhs_module'		=> 'Queues',
            'rhs_table'			=> 'queues',
            'rhs_key'			=> 'id',
            'relationship_type' => 'many-to-many',
            'join_table'		=> 'queues_queue',
            'join_key_lhs'		=> 'queue_id',
            'join_key_rhs'		=> 'parent_id'
        ),
        'parent_queues_rel' => array(
            'lhs_module'		=> 'Queues',
            'lhs_table'			=> 'queues',
            'lhs_key' 			=> 'id',
            'rhs_module'		=> 'Queues',
            'rhs_table'			=> 'queues',
            'rhs_key' 			=> 'id',
            'relationship_type' => 'many-to-many',
            'join_table'		=> 'queues_queue',
            'join_key_rhs'		=> 'queue_id',
            'join_key_lhs'		=> 'parent_id'
        ),
    ), /* end relationships */
);
