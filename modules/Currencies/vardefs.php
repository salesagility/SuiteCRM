<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

$dictionary['Currency'] = array('table' => 'currencies',
	'comment' => 'Currencies allow Sugar to store and display monetary values in various denominations'
                               ,'fields' => array (
  'id' =>
  array (
    'name' => 'id',
    'vname' => 'LBL_NAME',
    'type' => 'id',
    'required' => true,
    'reportable'=>false,
    'comment' => 'Unique identifer'
    ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_NAME',
    'type' => 'varchar',
    'len' => '36',
    'required' => true,
    'comment' => 'Name of the currency',
    'importable' => 'required',
  ),
  'symbol' =>
  array (
    'name' => 'symbol',
    'vname' => 'LBL_LIST_SYMBOL',
    'type' => 'varchar',
    'len' => '36',
     'required' => true,
     'comment' => 'Symbol representing the currency',
     'importable' => 'required',
  ),
  'iso4217' =>
  array (
    'name' => 'iso4217',
    'vname' => 'LBL_LIST_ISO4217',
    'type' => 'varchar',
    'len' => '3',
     'comment' => '3-letter identifier specified by ISO 4217 (ex: USD)',
  ),
  'conversion_rate' =>
  array (
    'name' => 'conversion_rate',
    'vname' => 'LBL_LIST_RATE',
    'type' => 'float',
    'dbType' => 'double',
    'default' => '0',
     'required' => true,
	 'comment' => 'Conversion rate factor (relative to stored value)',
	 'importable' => 'required',
  ),
  'status' =>
  array (
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'dbType'=>'varchar',
    'options' => 'currency_status_dom',
    'len' => 100,
    'comment' => 'Currency status',
    'importable' => 'required',
  ),
  'deleted' =>
  array (
    'name' => 'deleted',
    'vname' => 'LBL_DELETED',
    'type' => 'bool',
    'required' => false,
    'reportable'=>false,
    'comment' => 'Record deletion indicator'
  ),
  'date_entered' =>
  array (
    'name' => 'date_entered',
    'vname' => 'LBL_DATE_ENTERED',
    'type' => 'datetime',
     'required' => true,
    'comment' => 'Date record created'

  ),
  'date_modified' =>
  array (
    'name' => 'date_modified',
    'vname' => 'LBL_DATE_MODIFIED',
    'type' => 'datetime',
     'required' => true,
    'comment' => 'Date record last modified'
  ),
  'created_by' =>
  array (
    'name' => 'created_by',
    'reportable' => false,
    'vname' => 'LBL_CREATED_BY',
    'type' => 'id',
    'len'  => '36',
    'required' => true,
  	'comment' => 'User ID who created record'
  ),
)
                                                      , 'indices' => array (
   array('name' =>'currenciespk', 'type' =>'primary', 'fields'=>array('id')),
   array('name' =>'idx_currency_name', 'type' =>'index', 'fields'=>array('name','deleted'))
                                                      )

                            );
?>
