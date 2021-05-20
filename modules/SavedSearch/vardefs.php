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

$dictionary['SavedSearch'] = array('table' => 'saved_search',
'fields' => array(
  'id' =>
  array(
    'name' => 'id',
    'vname' => 'LBL_NAME',
    'type' => 'id',
    'required'=>true,
    'reportable'=>false,
  ),
  'name' =>
  array(
    'name' => 'name',
    'type' => 'varchar',
      'vname' => 'LBL_NAME',
      'len' => 150,
  ),
    'search_module' =>
        array(
            'name' => 'search_module',
            'type' => 'varchar',
            'vname' => 'LBL_MODULE',
            'len' => 150,
        ),
    'orderBy' =>
        array(
            'name' => 'orderBy',
            'type' => 'enum',
            'displayType' => 'dropdown',
            'vname' => 'LBL_ORDER_BY_COLUMNS',
            'len' => 150,
            'source' => 'non-db',
        ),
    'sortOrder' =>
        array(
            'name' => 'sortOrder',
            'type' => 'enum',
            'displayType' => 'radio',
            'displayDirection' => 'row',
            'options' => 'sort_order',
            'vname' => 'LBL_DIRECTION',
            'source' => 'non-db',
        ),
    'deleted' =>
        array(
            'name' => 'deleted',
            'vname' => 'LBL_CREATED_BY',
            'type' => 'bool',
            'required' => true,
            'reportable' => false,
        ),
    'date_entered' =>
        array(
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
    'required'=>true,
  ),
  'date_modified' =>
  array(
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
    'required'=>true,
  ),
  'assigned_user_id' =>
  array(
    'name' => 'assigned_user_id',
    'rname' => 'user_name',
    'id_name' => 'assigned_user_id',
    'vname' => 'LBL_ASSIGNED_TO',
    'type' => 'assigned_user_name',
    'table' => 'users',
    'isnull' => 'false',
    'dbType' => 'id',
    'reportable'=>true,
    'massupdate' => false,
  ),
  'assigned_user_name' =>
  array(
    'name' => 'assigned_user_name',
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'type' => 'varchar',
    'reportable'=>false,
    'massupdate' => false,
    'source'=>'non-db',
    'table' => 'users',
  ),
  'contents' =>
  array(
    'name' => 'contents',
    'type' => 'text',
    'vname' => 'LBL_DESCRIPTION',
    'isnull' => true,
  ),
  'description' =>
  array(
    'name' => 'description',
    'type' => 'text',
    'vname' => 'LBL_DESCRIPTION',
    'isnull' => true,
  ),
  'assigned_user_link' =>
  array(
        'name' => 'assigned_user_link',
    'type' => 'link',
    'relationship' => 'saved_search_assigned_user',
    'vname' => 'LBL_ASSIGNED_TO_USER',
    'link_type' => 'one',
    'module'=>'Users',
    'bean_name'=>'User',
    'source'=>'non-db',
  ),
),
'relationships' => array(
  'saved_search_assigned_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'SavedSearch', 'rhs_table'=> 'saved_search', 'rhs_key' => 'assigned_user_id',
   'relationship_type'=>'one-to-many')
),

'indices' => array(
       array('name' =>'savedsearchpk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_desc', 'type'=>'index', 'fields'=>array('name','deleted')))
);

VardefManager::createVardef('SavedSearch', 'SavedSearch', array(
));
