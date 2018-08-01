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


$dictionary['SchedulersJob'] = array('table' => 'job_queue',
    'comment' => 'Job queue keeps the list of the jobs executed by this instance',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_NAME',
            'type' => 'id',
            'len' => '36',
            'required' => true,
            'reportable'=>false,
        ),
       'name'=>
        array(
            'name'=>'name',
            'vname'=> 'LBL_NAME',
            'type'=>'name',
            'link' => true, // bug 39288
            'dbType' => 'varchar',
            'len'=>255,
            'required'=>true,
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
        'scheduler_id' => array(
            'name' => 'scheduler_id',
            'vname' => 'LBL_SCHEDULER',
            'type' => 'id',
            'required' => false,
            'reportable' => false,
        ),
        'execute_time' => array(
            'name' => 'execute_time',
            'vname' => 'LBL_EXECUTE_TIME',
            'type' => 'datetime',
            'required' => true,
        ),
        'status' => array(
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'options'	=> 'schedulers_times_dom',
            'len' => 20,
            'required' => true,
            'reportable' => true,
            'readonly' => true,
        ),
        'resolution' => array(
            'name' => 'resolution',
            'vname' => 'LBL_RESOLUTION',
            'type' => 'enum',
            'options'	=> 'schedulers_resolution_dom',
            'len' => 20,
            'required' => true,
            'reportable' => true,
            'readonly' => true,
        ),
        'message' => array(
            'name' => 'message',
            'vname' => 'LBL_MESSAGE',
            'type' => 'text',
            'required' => false,
            'reportable' => false,
        ),
        'target' => array(
            'name' => 'target',
            'vname' => 'LBL_TARGET',
            'type' => 'varchar',
            'len' => 255,
            'required' => true,
            'reportable' => true,
        ),
        'data' => array(
            'name' => 'data',
            'vname' => 'LBL_DATA',
            'type' => 'text',
            'required' => false,
            'reportable' => true,
        ),
        'requeue' => array(
            'name' => 'requeue',
            'vname' => 'LBL_REQUEUE',
            'type' => 'bool',
            'default' => 0,
            'required' => false,
            'reportable' => true,
        ),
        'retry_count' => array(
            'name' => 'retry_count',
            'vname' => 'LBL_RETRY_COUNT',
            'type' => 'tinyint',
            'required' => false,
            'reportable' => true,
        ),
        'failure_count' => array(
            'name' => 'failure_count',
            'vname' => 'LBL_FAIL_COUNT',
            'type' => 'tinyint',
            'required' => false,
            'reportable' => true,
            'readonly' => true,
        ),
        'job_delay' => array(
            'name' => 'job_delay',
            'vname' => 'LBL_INTERVAL',
            'type' => 'int',
            'required' => false,
            'reportable' => false,
        ),
        'client' => array(
            'name' => 'client',
            'vname' => 'LBL_CLIENT',
            'type' => 'varchar',
            'len' => 255,
            'required' => true,
            'reportable' => true,
        ),
        'percent_complete' => array(
            'name' => 'percent_complete',
            'vname' => 'LBL_PERCENT',
            'type' => 'int',
            'required' => false,
            ),
        'schedulers' => array(
            'name'            => 'schedulers',
            'vname'            => 'LBL_SCHEDULER_ID',
            'type'            => 'link',
            'relationship'    => 'schedulers_jobs_rel',
            'source'        => 'non-db',
            'link_type' => 'one',
       ),
        ),
    'indices' => array(
        array(
            'name' =>'job_queuepk',
            'type' =>'primary',
            'fields' => array(
                'id'
            )
        ),
        array(
            'name' =>'idx_status_scheduler',
            'type'=>'index',
            'fields' => array(
                'status',
                'scheduler_id',
            )
        ),
        array(
            'name' =>'idx_status_time',
            'type'=>'index',
            'fields' => array(
                'status',
                'execute_time',
                'date_entered',
            )
        ),
        array(
            'name' =>'idx_status_entered',
            'type'=>'index',
            'fields' => array(
                'status',
                'date_entered',
            )
        ),
        array(
            'name' =>'idx_status_modified',
            'type'=>'index',
            'fields' => array(
                'status',
                'date_modified',
            )
        ),
    ),
);

VardefManager::createVardef('SchedulersJobs', 'SchedulersJob', array('assignable'));
