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

$dictionary['Alert'] = array(
	'table'=>'alerts',
    'audited'   =>  false,
    'unified_search' => false,
    'full_text_search' => false,
    'unified_search_default_enabled' => false,
    'optimistic_locking' => true,
    'duplicate_merge'=>false,
		'fields'=>array (
            'content_type' =>
                array(
                    'name'		=> 'content_type',
                    'vname'     => 'LBL_CONTENT_TYPE',
                    'type'		=> 'varchar',
                    'massupdate'=> false,
                    'studio'=> 'false',
                    'comment'   => 'Defines the type of content use in alert eg HTML, SMARTY, TEXT etc...',
                ),
            'delivery_datetime' =>
                array(
                    'name'		=> 'delivery_datetime',
                    'vname'     => 'LBL_DELIVERY_DATE',
                    'type'		=> 'datetime',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'Determines when a subscriber receives the alert.',
                ),
            'was_sent' =>
                array(
                    'name'		=> 'was_sent',
                    'vname'     => 'LBL_WAS_SENT',
                    'type'		=> 'bool',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'Determines if the alert has been sent.',
                ),
            'send_email' =>
                array(
                    'name'		=> 'send_email',
                    'vname'     => 'LBL_SEND_EMAIL',
                    'type'		=> 'bool',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'Determines if an email is sent to the subscriber',
                ),
            'send_popup' =>
                array(
                    'name'		=> 'send_popup',
                    'vname'     => 'LBL_SEND_POPUP',
                    'type'		=> 'bool',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'Determines if an a subscriber receives a popup / desktop notification.',
                ),
            'send_sms' =>
                array(
                    'name'		=> 'send_sms',
                    'vname'     => 'LBL_SEND_POPUP',
                    'type'		=> 'bool',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'Determines if an a subscriber receives text / sms message.',
                ),
            'send_to_manager' =>
                array(
                    'name'		=> 'send_to_manager',
                    'vname'     => 'LBL_SEND_TO_MANGER',
                    'type'		=> 'bool',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'Determines if an a subscriber receives text / sms message.',
                ),
            'target_module' =>
                array(
                    'name'		=> 'target_module',
                    'vname'     => 'LBL_TARGET_MODULE',
                    'type'		=> 'varchar',
                    'massupdate'=> false,
                    'studio'=> 'false',
                    'comment'   => 'The module related to the alert.',
                ),
            'target_module_id' =>
                array(
                    'name'		=> 'target_module_id',
                    'vname'     => 'LBL_TARGET_MODULE_ID',
                    'type'		=> 'id',
                    'length'    => 36,
                    'massupdate'=> false,
                    'studio'=> 'false',
                    'comment'   => 'The id of the module record related to the alert.',
                ),
            'type' =>
                array(
                    'name'		=> 'type',
                    'vname'     => 'LBL_TYPE',
                    'type'		=> 'varchar',
                    'massupdate'=> false,
                    'studio'=> 'false',
                    'comment'   => 'Type of alert eg info, warning, danger, success.',
                ),
            'url_redirect' =>
                array(
                    'name'		=> 'url_redirect',
                    'vname'     => 'LBL_URL_REDIRECT',
                    'type'		=> 'varchar',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'The url to redirect to on action (click/touch).',
                ),
            'subscribers' =>
                array(
                    'name'		=> 'subscribers',
                    'vname'     => 'LBL_SUBSCRIBERS',
                    'type'		=> 'varchar',
                    'len'       => '65534',
                    'massupdate'=> false,
                    'studio'    => 'false',
                    'comment'   => 'A serialized array of (SugarBean type => id) which can receive this alert.',
                ),
    ),
	'relationships'=>array (),

	);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Alerts','Alert', array('basic','assignable'));