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



$suicide = true;
if(isset($install_script)) {
	if($install_script) {
		$suicide = false;
	}
}

if($suicide) {
   // mysterious suicide note
   die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}


if (!isset($_POST['confirm']) || !$_POST['confirm']) {
	include("sugar_version.php"); // provide $sugar_flavor
       global $sugar_config;
        $ik = '';
       if(isset($sugar_config['unique_key']) && !empty($sugar_config['unique_key']) ){
        $ik = $sugar_config['unique_key'];
       }

	//$regPhp = file_get_contents("http://www.sugarcrm.com/product-registration/registration_php.php?edition={$sugar_flavor}&instance_key=".$ik);
	//changing the reg form. placing in an iframe
	/*
	$regPhp="<iframe src='https://www.sugarcrm.com/product-registration/
	registration_php_080428.php?edition={$sugar_flavor}&instance_key=
	{$ik}' height='400px' width='700px' frameborder='0' scrolling='no'
	allowtransparency='true'</iframe>";
	*/
    $regPhp="<iframe src='https://www.sugarcrm.com/product-registration/registration_php_080428.php?edition={$sugar_flavor}&instance_key=
    {$ik}' height='595px' width='700px' frameborder='0' style='overflow-x:hidden; overflow-y: scroll;'
    allowtransparency='true'></iframe>";


	$notConfirmed =<<<CONF
		<!-- <p>{$mod_strings['LBL_REG_CONF_1']}</p> -->
		<!-- begin registration -->
		{$regPhp}
		<!-- end registration -->
CONF;

} else {
	$notConfirmed = $mod_strings['LBL_REG_CONF_3'];
}


///////////////////////////////////////////////////////////////////////////////
////	START OUTPUT
$langHeader = get_language_header();
$out =<<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Script-Type" content="text/javascript">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_REG_TITLE']}</title>
   <link REL="SHORTCUT ICON" HREF="$icon">
   <link rel="stylesheet" href="$css" type="text/css" />
   <script type="text/javascript" src="$common"></script>
</head>
<body onload="javascript:document.getElementById('button_next2').focus();">
<table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
      <tr><td colspan="2" id="help">&nbsp;</td></tr>
    <tr>
      <th width="500">
		<p>
		<img src="{$sugar_md}" alt="SugarCRM" border="0">
		</p>
		{$mod_strings['LBL_REG_TITLE']} <span style="font-size: 9px;"> (Optional)</span></th>
	<th width="200" style="text-align: right;"><a href="http://www.sugarcrm.com" target="_blank"><IMG src="$loginImage" alt="SugarCRM" border="0"></a></th>
</tr>
<tr>
    <td colspan="2">{$notConfirmed}</td>
</tr>
<tr>
	<td align="right" colspan="2">
	<hr>
	<table cellspacing="0" cellpadding="0" border="0" class="stdTable">
		<tr>
		<td>&nbsp;</td>
		    <td>
                <form action="index.php" method="post" name="appform" id="appform">
                    <input type="hidden" name="default_user_name" value="admin">
                    <input class="button" type="submit" name="next" value="{$mod_strings['LBL_NEXT']}" id="button_next2"/>
		    	</form>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>
<br>
</body>
</html>
EOQ;

echo $out;

?>