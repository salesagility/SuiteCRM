/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

SUGAR.email2.templates['displayOneEmail'] = 
'<div class="emailDetailTable" style="height:100%">' +
'<div id="viewMenuDiv{idx}"></div>' + 
'<div width="100%" class="displayEmailValue">' +
'					<button type="button" class="button" onclick="SUGAR.email2.composeLayout.c0_replyForwardEmail(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\', \'reply\');"><img src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=icon_email_reply.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_REPLY}</button>' +
'					<button type="button" class="button" onclick="SUGAR.email2.composeLayout.c0_replyForwardEmail(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\', \'replyAll\');"><img src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=icon_email_replyall.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_REPLY_ALL}</button>' +
'					<button type="button" class="button" onclick="SUGAR.email2.composeLayout.c0_replyForwardEmail(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\', \'forward\');"><img src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=icon_email_forward.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_FORWARD}</button>' +
'					<button type="button" class="button" onclick="SUGAR.email2.detailView.emailDeleteSingle(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\');"><img src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=icon_email_delete.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_DELETE}</button>' +
'					<button type="button" class="button" onclick="SUGAR.email2.detailView.viewPrintable(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\');"><img src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=Print_Email.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_PRINT}</button>' +
'					<button id="btnEmailView{idx}" type="button" class="button" onclick="SUGAR.email2.detailView.showViewMenu(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\');"><img src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=icon_email_view.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_VIEW} <img src="themes/default/images/more.gif" align="absmiddle" border="0"></button>' +
'					<button id="archiveEmail{idx}" type="button" class="button" onclick="SUGAR.email2.detailView.importEmail(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\');"><img src="themes/default/images/icon_email_archive.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_IMPORT_EMAIL}</button>' +
'					<button id="quickCreateSpan{meta.panelId}" type="button" class="button" onclick="SUGAR.email2.detailView.showQuickCreate(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\');"><img src="themes/default/images/icon_email_create.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_QUICK_CREATE} <img src="themes/default/images/more.gif" align="absmiddle" border="0"></button>' +
'					<button type="button" id="showDeialViewForEmail{meta.panelId}" class="button" onclick="SUGAR.email2.contextMenus.showEmailDetailViewInPopup(\'{meta.ieId}\', \'{meta.uid}\', \'{meta.mbox}\');"><img src="themes/default/images/icon_email_relate.gif" align="absmiddle" border="0"> {app_strings.LBL_EMAIL_VIEW_RELATIONSHIPS}</button>' +
'</div>' +
'			<table cellpadding="0" cellspacing="0" border="0" width="100%" >' +
'				<tr>' +
'					<td NOWRAP valign="top" width="1%" class="displayEmailLabel">' +
'						{app_strings.LBL_EMAIL_FROM}:' +
'					</td>' +
'					<td width="99%" class="displayEmailValue">' +
'						{email.from_addr}' +
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
'				<tr>{meta.cc}</tr>' +
'				<tr>{email.attachments}</tr>' +
'			</table>' +
'			<div id="displayEmailFrameDiv{idx}" name="displayEmailFrameDiv{idx}"><iframe id="displayEmailFrame{idx}" src="modules/Emails/templates/_blank.html" width="100%" height="100%" frameborder="0"></iframe></div>' +
//'                           {email.description}' +
'</div>'
;