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




if( !isset( $install_script ) || !$install_script ){
	die($mod_strings['ERR_NO_DIRECT_SCRIPT']);
}
// $mod_strings come from calling page.

///////////////////////////////////////////////////////////////////////////////
////    START OUTPUT

$langHeader = get_language_header();
$out = <<<EOQ
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html {$langHeader}>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>{$mod_strings['LBL_WIZARD_TITLE']} {$mod_strings['LBL_TITLE_ARE_YOU_READY']}</title>
<link REL="SHORTCUT ICON" HREF="include/images/sugar_icon.ico">
<link rel="stylesheet" href="install/install.css" type="text/css">
</head>

<body>
	<form action="install.php" method="post" name="form" id="form">
		<table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
			<tr><td colspan="2" id="help"><a href="{$help_url}" target='_blank'>{$mod_strings['LBL_HELP']} </a></td></tr>
			<tr>
				<th id="title" width="500">
				<p>
				<img src="{$sugar_md}" alt="SugarCRM" border="0">
				</p>
				</th>
				<th width="200" height="30" style="text-align: right;">&nbsp;
				</th>
			</tr>
			<tr>
			    <td colspan="2" id="ready">{$mod_strings['LBL_TITLE_ARE_YOU_READY']} </td>
			</tr>
			<tr>
				<td colspan="2">
				    <p><strong>{$mod_strings['LBL_WELCOME_PLEASE_READ_BELOW']}</strong></p>

					<table width="100%" cellpadding="0" cellpadding="0" border="0" class="Welcome">
						<tr>
						   <th>
						      <span onclick="showtime('sys_comp');" style="cursor:pointer;cursor:hand">
						          <span id='basic_sys_comp'><img alt="{$mod_strings['LBL_BASIC_SEARCH']}" src="themes/default/images/basic_search.gif" border="0"></span>
						          <span id='adv_sys_comp' style='display:none'><img alt="{$mod_strings['LBL_ADVANCED_SEARCH']}" src="themes/default/images/advanced_search.gif" border="0"></span>
						          &nbsp;{$mod_strings['REQUIRED_SYS_COMP']}
						      </span>
						   </th>
						</tr>
						<td>
							<div id='sys_comp' >{$mod_strings['REQUIRED_SYS_COMP_MSG']}</div>
						</td>
					</table>

					<table width="100%" cellpadding="0" cellpadding="0" border="0" class="Welcome">
						<tr>
						    <th>
						        <span onclick="showtime('sys_check');" style="cursor:pointer;cursor:hand">
						            <span id='basic_sys_check'><img alt="{$mod_strings['LBL_BASIC_SEARCH']}" src="themes/default/images/basic_search.gif" border="0"></span>
						            <span id='adv_sys_check' style='display:none'><img alt="{$mod_strings['LBL_ADVANCED_SEARCH']}" src="themes/default/images/advanced_search.gif" border="0"></span>
						            &nbsp;{$mod_strings['REQUIRED_SYS_CHK']}
						        </span>
						    </th>
						</tr>
						<td>
						    <div id='sys_check' >{$mod_strings['REQUIRED_SYS_CHK_MSG']}</div>
						</td>
					</table>

					<table width="100%" cellpadding="0" cellpadding="0" border="0" class="Welcome">
						<tr>
						    <th>
							    <span onclick="showtime('installType');" style="cursor:pointer;cursor:hand">
								    <span id='basic_installType'><img alt="{$mod_strings['LBL_BASIC_TYPE']}" src="themes/default/images/basic_search.gif" border="0"></span>
								    <span id='adv_installType' style='display:none'><img alt="{$mod_strings['LBL_ADVANCED_TYPE']}" src="themes/default/images/advanced_search.gif" border="0"></span>
								    &nbsp;{$mod_strings['REQUIRED_INSTALLTYPE']}
							    </span>
						    </th>
						</tr>
						<td>
						    <div id='installType' >{$mod_strings['REQUIRED_INSTALLTYPE_MSG']}</div>
						</td>
					</table>
			    </td>
			</tr>

			<tr>
				<td align="right" colspan="2" height="20">
					<hr>
					<table cellspacing="0" cellpadding="0" border="0" class="stdTable">
						<tr>
							<td>
							    <input type="hidden" name="current_step" value="{$next_step}">
							</td>
						    <td>
								<input class="acceptButton" type="button" name="goto" value="{$mod_strings['LBL_BACK']}" id="button_back_ready" onclick="document.getElementById('form').submit();" />
								<input class="button" type="submit" name="goto" value="{$mod_strings['LBL_NEXT']}" id="button_next2" />
					        </td>
				        </tr>
			        </table>
			    </td>
		    </tr>
	    </table>
    </form>
    <script>
        function showtime(div){

            if(document.getElementById(div).style.display == ''){
                document.getElementById(div).style.display = 'none';
                document.getElementById('adv_'+div).style.display = '';
                document.getElementById('basic_'+div).style.display = 'none';
            }else{
                document.getElementById(div).style.display = '';
                document.getElementById('adv_'+div).style.display = 'none';
                document.getElementById('basic_'+div).style.display = '';
            }

        }
    </script>
</body>
</html>
EOQ;
echo $out;
?>