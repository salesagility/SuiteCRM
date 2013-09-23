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

SUGAR.email2.templates['viewPrintable'] = '<html>' +
'<body onload="javascript:window.print();">' + 
'<style>' + 
'body {' + 
'	margin: 0px;' + 
'	font-family: helvetica, impact, sans-serif;' +
'	font-size : 12pt;' +
'} ' +
'table {' +
'	padding:10px;' +
'}' +
'</style>' +
'<div>' +
'<table cellpadding="0" cellspacing="0" border="0" width="100%">' +
'	<tr>' +
'		<td>' +
'			<table cellpadding="0" cellspacing="0" border="0" width="100%">' +
'				<tr>' +
'					<td NOWRAP valign="top" width="1%" class="displayEmailLabel">' +
'						{app_strings.LBL_EMAIL_FROM}:' +
'					</td>' +
'					<td width="99%" class="displayEmailValue">' +
'						{email.from_name} &lt;{email.from_addr}&gt;' +
'					</td>' +
'				</tr>' +
'				<tr>' +
'					<td NOWRAP valign="top" class="displayEmailLabel">' +
'						{app_strings.LBL_EMAIL_SUBJECT}:' +
'					</td>' +
'					<td NOWRAP valign="top" class="displayEmailValue">' +
'						<b>{email.name}</b>' +
'					</td>' +
'				</tr>' +
'				<tr>' +
'					<td NOWRAP valign="top" class="displayEmailLabel">' +
'						{app_strings.LBL_EMAIL_DATE_SENT_BY_SENDER}:' +
'					</td>' +
'					<td class="displayEmailValue">' +
'						{email.date_start} {email.time_start}' +
'					</td>' +
'				</tr>' +
'				<tr>' +
'					<td NOWRAP valign="top" class="displayEmailLabel">' +
'						{app_strings.LBL_EMAIL_TO}:' +
'					</td>' +
'					<td class="displayEmailValue">' +
'						{email.toaddrs}' +
'					</td>' +
'				</tr>' +
'				{email.cc}' +
'				{email.attachments}' +
'			</table>' +
'		</td>' +
'	</tr>' +
'	<tr>' +
'		<td>' +
'			<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">' +
'				<tr>' +
'					<td style="border-top: 1px solid #333;">' +
'						<div style="padding:5px;">' +
							'{email.description}' +
'						</div>' +
'					</td>' +
'				</tr>' +
'			</table>' +
'		</td>' +
'	</tr>' +
'</table>' +
'</div>' +
'</body></html>';
