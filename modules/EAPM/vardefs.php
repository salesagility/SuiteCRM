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

$dictionary['EAPM'] = array(
	'table'=>'eapm',
	'audited'=>false,
	'fields'=>array (
  'password' =>
  array (
    'required' => true,
    'name' => 'password',
    'vname' => 'LBL_PASSWORD',
    'type' => 'encrypt',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => false,
    'len' => '255',
    'size' => '20',
  ),
  'url' =>
  array (
    'required' => true,
    'name' => 'url',
    'vname' => 'LBL_URL',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
  ),
  'application' =>
  array (
    'required' => true,
    'name' => 'application',
    'vname' => 'LBL_APPLICATION',
    'type' => 'enum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => 100,
    'size' => '20',
    'function' => 'getEAPMExternalApiDropDown',
    'studio' => 'visible',
    'default' => 'webex',
  ),
  'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'dbType' => 'varchar',
    'len' => '255',
    'unified_search' => true,
    'full_text_search' => array('boost' => 3),
    'importable' => 'required',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'size' => '20',
  ),
	  'api_data' =>
	  array (
	    'name' => 'api_data',
	    'vname' => 'LBL_API_DATA',
	    'type' => 'text',
	    'comment' => 'Any API data that the external API may wish to store on a per-user basis',
	    'rows' => 6,
	    'cols' => 80,
	  ),
	  'consumer_key' => array(
	  	'name' => 'consumer_key',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_CONSKEY',
//        'required' => true,
        'importable' => 'required',
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
        'studio' => 'hidden',
	  ),
	  'consumer_secret' => array(
	  	'name' => 'consumer_secret',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_CONSSECRET',
//        'required' => true,
        'importable' => 'required',
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
        'studio' => 'hidden',
	  ),
	  'oauth_token' => array(
	  	'name' => 'oauth_token',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_OAUTHTOKEN',
        'importable' => false,
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
    	'required' => false,
        'studio' => 'hidden',
	  ),
	  'oauth_secret' => array(
	  	'name' => 'oauth_secret',
	    'type' => 'varchar',
	    'vname' => 'LBL_API_OAUTHSECRET',
        'importable' => false,
        'massupdate' => 0,
        'audited' => false,
        'reportable' => false,
    	'required' => false,
        'studio' => 'hidden',
	  ),
	  'validated' => array(
        'required' => false,
        'name' => 'validated',
        'vname' => 'LBL_VALIDATED',
        'type' => 'bool',
	    'default' => false,
	  ),
      'note' => array(
          'name' => 'note',
          'vname' => 'LBL_NOTE',
          'required' => false,
          'reportable' => false,
          'importable' => false,
          'massupdate' => false,
          'studio' => 'hidden',
          'type' => 'varchar',
          'source' => 'non-db',
      ),

),
	'relationships'=>array (
    ),
    'indices' => array(
        array(
                'name' => 'idx_app_active',
                'type' => 'index',
                'fields'=> array('assigned_user_id', 'application', 'validated'),
        ),
),
	'optimistic_locking'=>true,
);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('EAPM','EAPM', array('basic','assignable'));
