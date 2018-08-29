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

$dictionary['custom_fields'] = array ( 'table' => 'custom_fields'
                                  , 'fields' => array (
       array('name' =>'bean_id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'set_num', 'type' =>'int', 'len'=>'11', 'default'=>'0')
      , array('name' =>'field0', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field1', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field2', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field3', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field4', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field5', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field6', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field7', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field8', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'field9', 'type' =>'varchar', 'len'=>'255')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0')
                                                      )                                  , 'indices' => array (
       array('name' =>'idx_beanid_set_num', 'type' =>'index', 'fields'=>array('bean_id','set_num'))
                                                      )
                                  );
