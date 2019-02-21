<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


// SugarCRM free/busy server
// put and get free/busy information for sugarcrm users in vCalendar format.
// Uses WebDAV for HTTP PUT and GET methods of access
// REQUIRED PHP packages:
// 1. PEAR
//
// Saves PUTs as Freebusy SugarBeans
//
// documentation on Free/Busy from Microsoft:
// http://support.microsoft.com/kb/196484
//
// other docs:
// http://www.windowsitpro.com/MicrosoftExchangeOutlook/Article/ArticleID/7697/7697.html
//
// excerpt:
// You must install the Microsoft Internet Explorer (IE) Web Publishing Wizard to get
// the functionality you need to publish Internet free/busy data to a server or the Web.
// You can install this wizard from Control Panel, Add/Remove Programs, Microsoft Internet
// Explorer, Web Publishing Wizard. For every user, you must configure the path and filename
// where you want Outlook to store free/busy information. You configure this location on the
// Free/Busy Options dialog box you see in Screen 2. You must initiate publishing manually by
// using Tools, Send/Receive, Free/Busy Information in Outlook.
//
// To access a non-Exchange Server user's free/busy information, you must configure the
// appropriate path on each contact's Details tab. For example, you enter
// "http://servername/sugarcrm/index.php?entryPoint=vcal_server/type=vfb&source=outlook&email=myemail@servername.com".
// If you don't configure this information correctly, the client software looks up the entry
// in the Search at this URL window on the Free/Busy Options dialog box.
//
// Setup for: Microsoft Outlook XP
// In Tools > Options > Calendar Options > Free/Busy
//
// Global search path:
// %USERNAME% and %SERVER% are Outlook replacement variables to construct the email address:
// http://servername/sugarcrm/index.php?entryPoint=vcal_server/type=vfb&source=outlook&email=%NAME%@%SERVER%
// or contact by contact by editing the details and entering its Free/Busy URL:
// http://servername/sugarcrm/index.php?entryPoint=vcal_server/type=vfb&source=outlook&email=user@email.com
// or
// http://servername/sugarcrm/index.php?entryPoint=vcal_server/type=vfb&source=outlook&user_name=user_name
// or:
// http://servername/sugarcrm/index.php?entryPoint=vcal_server/type=vfb&source=outlook&user_id=user_id
    require_once "modules/vCals/HTTP_WebDAV_Server_vCal.php";
    $server = new HTTP_WebDAV_Server_vCal();
    $server->ServeRequest();
    sugar_cleanup();
