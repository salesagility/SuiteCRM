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

$error_defs = array(
'no_error'=>array('number'=>0 , 'name'=>'No Error', 'description'=>'No Error'),
'invalid_login'=>array('number'=>10 , 'name'=>'Invalid Login', 'description'=>'Login attempt failed please check the username and password'),
'invalid_session'=>array('number'=>11 , 'name'=>'Invalid Session ID', 'description'=>'The session ID is invalid'),
'user_not_configure'=>array('number'=>12 , 'name'=>'User Not Configured', 'description'=>'Please log into your instance of SugarCRM to configure your user. '),
'no_portal'=>array('number'=>12 , 'name'=>'Invalid Portal Client', 'description'=>'Portal Client does not have authorized access'),
'no_module'=>array('number'=>20 , 'name'=>'Module Does Not Exist', 'description'=>'This module is not available on this server'),
'no_file'=>array('number'=>21 , 'name'=>'File Does Not Exist', 'description'=>'The desired file does not exist on the server'),
'no_module_support'=>array('number'=>30 , 'name'=>'Module Not Supported', 'description'=>'This module does not support this feature'),
'no_relationship_support'=>array('number'=>31 , 'name'=>'Relationship Not Supported', 'description'=>'This module does not support this relationship'),
'no_access'=>array('number'=>40 , 'name'=>'Access Denied', 'description'=>'You do not have access'),
'duplicates'=>array('number'=>50 , 'name'=>'Duplicate Records', 'description'=>'Duplicate records have been found. Please be more specific.'),
'no_records'=>array('number'=>51 , 'name'=>'No Records', 'description'=>'No records were found.'),
'cannot_add_client'=>array('number'=>52 , 'name'=>'Cannot Add Offline Client', 'description'=>'Unable to add Offline Client.'),
'client_deactivated'=>array('number'=>53 , 'name'=>'Client Deactivated', 'description'=>'Your Offline Client instance has been deactivated.  Please contact your Administrator in order to resolve.'),
'sessions_exceeded'=>array('number'=>60 , 'name'=>'Number of sessions exceeded.'),
'upgrade_client'=>array('number'=>61 , 'name'=>'Upgrade Client', 'description'=>'Please contact your Administrator in order to upgrade your Offline Client'),
'no_admin' => array('number' => 70, 'name' => 'Admin credentials are required', 'description' => 'The logged-in user is not an administrator'),
'custom_field_type_not_supported' => array('number' => 80, 'name' => 'Custom field type not supported', 'description' => 'The custom field type you supplied is not currently supported'),
'custom_field_property_not_supplied' => array('number' => 81, 'name' => 'Custom field property not supplied', 'description' => 'You are missing one or more properties for the supplied custom field type'),
'resource_management_error' => array('number'=>90, 'name'=>'Resource Management Error', 'description'=>'The resource query limit specified in config.php has been exceeded during execution of the SOAP method'),
'invalid_call_error' => array('number'=>1000, 'name'=>'Invalid call for this module', 'description'=>'This is an invalid call for this module. Please look at WSDL file for details'),
'invalid_data_format' => array('number'=>1001, 'name'=>'Invalid data sent', 'description'=>'The data sent for this function is invalid. Please look at WSDL file for details'),
'invalid_set_campaign_merge_data' => array('number'=>1005, 'name'=>'Invalid set_campaign_merge data', 'description'=>'set_campaign_merge: Merge action status will not be updated, because, campaign_id is null or no targets were selected'),
'password_expired'     => array('number'=>1008, 'name'=> 'Password Expired', 'description'=>'Your password has expired. Please provide a new password.'),
'lockout_reached'     => array('number'=>1009, 'name'=> 'Password Expired', 'description'=>'You have been locked out of the Sugar application and cannot log in using existing password. Please contact your Administrator.'),
'ldap_error' => array('number'=>1012, 'name'=> 'LDAP Authentication Failed', 'description'=>'LDAP Authentication failed but supplied password was already encrypted.'),
);

?>