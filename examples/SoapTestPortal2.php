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

$portal_name ='';
$portal_password = '';
$user_name ='lead';
$user_password = 'lead';
foreach($_POST as $name=>$value){
		$$name = $value;
}
echo <<<EOQ
<form name='test' method='POST'>
<table width ='800'><tr>
<tr><th colspan='6'>Enter  SugarCRM Portal User Information (to configure this login to SugarCRM as an admin and go the administration panel then select a user from user management)</th></tr>
<td >PORTAL NAME:</td><td><input type='text' name='portal_name' value='$portal_name'></td><td>PORTAL PASSWORD:</td><td><input type='password' name='portal_password' value='$portal_password'></td>
</tr>
<tr><th colspan='6'>Use the name 'lead' and password 'lead' for portal lead generation</th></tr>
<tr>
<td>CONTACT NAME:</td><td><input type='text' name='user_name' value='$user_name'></td></td>
</tr>
<tr><td><input type='submit' value='Submit'></td></tr>
</table>
</form>


EOQ;
if(!empty($portal_name)){
$portal_password = md5($portal_password);
require_once('include/nusoap/nusoap.php');  //must also have the nusoap code on the Client Side.
$soapclient = new nusoapclient($GLOBALS['sugar_config']['site_url'].'/soap.php');  //define the SOAP Client an

echo '<b>LOGIN:</b><BR>';
$result = $soapclient->call('portal_login',array('portal_auth'=>array('user_name'=>$portal_name,'password'=>$portal_password, 'version'=>'.01'),'user_name'=>$user_name, 'application_name'=>'SoapTestPortal'));
echo '<b>HERE IS ERRORS:</b><BR>';
echo $soapclient->error_str;

echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
echo $soapclient->response;

echo '<BR><BR><b>HERE IS RESULT:</b><BR>';
echo print_r($result);
$session = $result['id'];


echo '<br><br><b>CREATE LEAD:</b><BR>';
$result = $soapclient->call('portal_set_entry',array('session'=>$session , 'module_name'=>'Leads', 'name_value_list'=>array(array('name'=>'first_name', 'value'=>'Test'), array('name'=>'last_name', 'value'=>'Lead'),  array('name'=>'portal_name', 'value'=>'portal_name'),  array('name'=>'portal_app', 'value'=>'SoapTestPortal'), array('name'=>'description', 'value'=>'A lead created through webservices'))));
echo '<b>HERE IS ERRORS:</b><BR>';
echo $soapclient->error_str;

echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
echo $soapclient->response;

echo '<BR><BR><b>HERE IS RESULT:</b><BR>';
echo print_r($result);




echo '<br><br><b>LOGOUT:</b><BR>';
$result = $soapclient->call('portal_logout',array('session'=>$session));
echo '<b>HERE IS ERRORS:</b><BR>';
echo $soapclient->error_str;

echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
echo $soapclient->response;

echo '<BR><BR><b>HERE IS RESULT:</b><BR>';
echo print_r($result);
}

?>
