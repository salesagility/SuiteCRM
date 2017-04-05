{*
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

*}
<div id="contactsDialogue"></div>
<div id="contactsDialogueHTML" class="yui-hidden">
	<div id="contactsDialogueBody">
		<div id='addressBookTabsDiv'></div>
		<div id='contactsSearchTabs'>
		  {include file="modules/Emails/templates/addressSearch.tpl"}
		</div>
		
        <table >
        <tr>
            <td width="60%">
                <div id="addrSearchGrid" ></div>
	           <div id='dt-pag-nav-addressbook'></div>
	        </td>
	        <td width="3%">
	           <span style="position:relative; top:1px;">&nbsp;
	               <div style="overflow: visible; height: 0; position: absolute; width: 0; right:-2em; top:-166px;">
	                   <h3 style="">{sugar_translate label="LBL_SELECTED_ADDR" module="Emails"}:</h3>
	               </div>
	           </span>
	        </td>
	        <td width="37%"valign="top">
	           <div id="addrSearchResultGrid"></div>
	           <div class="yui-pg-container">&nbsp;</div>
	         </td>
        </tr>
        </table>
	    
    </div>
</div>