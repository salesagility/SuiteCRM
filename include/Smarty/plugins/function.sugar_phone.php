<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50752 - 2009-09-10 15:18:28 -0700 (Thu, 10 Sep 2009) - dwong - Merged branches/tokyo from revision 50372 to 50729 to branches/kobe2
Discard lzhang r50568 changes in Email.php and corresponding en_us.lang.php

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r36563 - 2008-06-11 10:36:05 -0700 (Wed, 11 Jun 2008) - jmertic - Bug 22877: Make a new wireless detail view and have the smarty sugar_phone plugin check for being in a mobile session; if true then format the phone number as a link in the form of "tel:1234567890" per RFC 3966.
Added:
- include/SugarFields/Fields/Phone/WirelessDetailView.tpl
Touched:
- include/Smarty/plugins/function.sugar_phone.php
- include/SugarWireless/css/wireless.css

r29406 - 2007-11-08 16:36:28 -0800 (Thu, 08 Nov 2007) - bsoufflet - Bug 17690 : [RC] No license and/or entry point check in the files

r28844 - 2007-10-24 22:52:24 -0700 (Wed, 24 Oct 2007) - clee - Fix for 16807
It appears that the formats may be giving some trouble.  It is best to consolidate the formatting to a known skype format.  Adding function in include/utils.php to format the phone number to a known skype format that will work for sure.
Modified:
include/utils.php
include/Smarty/plugins/function.sugar_phone.php
Code review by Ajay

r28841 - 2007-10-24 20:11:24 -0700 (Wed, 24 Oct 2007) - ajay - 16807: added support for skypeout in detail view..


*/


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

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_translate} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_translate<br>
 * Purpose:  translates a label into the users current language
 * 
 * @author Majed Itani {majed at sugarcrm.com
 * @param array
 * @param Smarty
 */
function smarty_function_sugar_phone($params, &$smarty)
{
	if (!isset($params['value'])){
		$smarty->trigger_error("sugar_phone: missing 'value' parameter");
		return '';
	}
	
	global $system_config;
    if(isset($system_config->settings['system_skypeout_on']) && $system_config->settings['system_skypeout_on'] == 1
    	&& isset($params['value']) && skype_formatted($params['value'])  ) {
    		$GLOBALS['log']->debug($params['value']);
			return '<a href="callto:'.format_skype($params['value']).'">'.$params['value'].'</a>';
    } else {
    	return $params['value'];
    }
}
?>
