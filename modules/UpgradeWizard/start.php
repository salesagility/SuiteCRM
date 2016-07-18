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

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/
logThis('-----------------------------------------------------------------------------');
logThis('Upgrade started. At start.php');

//set the upgrade progress status.
set_upgrade_progress('start','in_progress');

unlinkUWTempFiles();
resetUwSession();

if(isset($_REQUEST['showUpdateWizardMessage']) && $_REQUEST['showUpdateWizardMessage'] == true) {
	// set a flag to skip the upload screen
	$_SESSION['skip_zip_upload'] = true;

	$newUWMsg =<<<eoq
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<th>
				{$mod_strings['LBL_UW_START_UPGRADED_UW_TITLE']}
			</th>
		</tr>
		<tr>
			<td>
				{$mod_strings['LBL_UW_START_UPGRADED_UW_DESC']}
			</td>
		</tr>
	</table>
eoq;
	echo $newUWMsg;
}


$uwMain =<<<eoq
<table cellpadding="3" cellspacing="0" border="0">
	<tr>
		<th align="left">
			{$mod_strings['LBL_UW_TITLE_START']}
		</th>
	</tr>
	<tr>
		<td align="left">
			<p>
		    {$mod_strings['LBL_UW_START_DESC']}
			</p>
			<BR>
			<p>
			<span class="error nonPaddedError">
			{$mod_strings['LBL_UW_START_DESC2']}
			</span>
			</p>
			<BR>
			<p>
			{$mod_strings['LBL_UW_START_DESC3']}
			</p>
			</td>
	</tr>
</table>
<div id="upgradeDiv" style="display:none">
    <table cellspacing="0" cellpadding="0" border="0">
        <tr><td>
           <p><!--not_in_theme!--><img src='modules/UpgradeWizard/processing.gif' alt='Processing'> <br></p>
        </td></tr>
     </table>
 </div>
eoq;

$showBack		= false;
$showCancel		= true;
$showRecheck	= false;
$showNext		= true;

$stepBack		= 0;
$stepNext		= 1;
$stepCancel	= 0;
$stepRecheck	= 0;

?>
