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
<form id="searchForm" method="get" action="#">
    <table id="searchTable" border="0" cellpadding="0" cellspacing="0" width="670">
		<tr id="peopleTableSearchRow">
			<td scope="row" nowrap="NOWRAP">
			     <div id="rollover">
			     {$mod_strings.LBL_SEARCH_FOR}:
			         <a href="#" class="rollover"><img border="0" alt=$mod_strings.LBL_HELP src="index.php?entryPoint=getImage&amp;imageName=helpInline.png">
	                        <div><span class="rollover">{$mod_strings.LBL_ADDRESS_BOOK_SEARCH_HELP}</span></div>
	                 </a>

		      	<input id="input_searchField" name="input_searchField" type="text" value="">
		      	</div>
			    &nbsp;&nbsp; {$mod_strings.LBL_LIST_RELATED_TO}: &nbsp;
			    <select name="person" id="input_searchPerson">
			         {$listOfPersons}
			    </select>
			    &nbsp;
			    <a href="javascript:void(0);">
                    {sugar_getimage name="select" ext=".gif" alt=$mod_strings.LBL_EMAIL_SELECTOR_SELECT other_attributes='align="absmiddle" border="0" onclick="SUGAR.email2.addressBook.searchContacts();" '}
                </a>
                <a href="javascript:void(0);">
                    {sugar_getimage name="clear" ext=".gif" alt=$mod_strings.LBL_EMAIL_SELECTOR_CLEAR other_attributes='align="absmiddle" border="0" onclick="SUGAR.email2.addressBook.clearAddressBookSearch();" '}
                </a>
			</td>
        </tr>
        <tr id="peopleTableSearchRow">
            <td scope="row" nowrap="NOWRAP" colspan="2" id="relatedBeanColumn">
		      {$mod_strings.LBL_FILTER_BY_RELATED_BEAN}<span id="relatedBeanInfo"></span>
		   	  <input name="hasRelatedBean" id="hasRelatedBean" type="checkbox"/>
            </td>

        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr id="peopleTableSearchRow">
            <td id="searchSubmit" scope="row" nowrap="NOWRAP">
                <button onclick="SUGAR.email2.addressBook.insertContactToResultTable(null,'{sugar_translate label='LBL_EMAIL_ADDRESS_BOOK_ADD_TO'}')">
                    {sugar_translate label="LBL_ADD_TO_ADDR" module="Emails"} <b>{sugar_translate label="LBL_EMAIL_ADDRESS_BOOK_ADD_TO"}</b>
                </button>
                <button onclick="SUGAR.email2.addressBook.insertContactToResultTable(null,'{sugar_translate label='LBL_EMAIL_ADDRESS_BOOK_ADD_CC'}')">
                    {sugar_translate label="LBL_ADD_TO_ADDR" module="Emails"} <b>{sugar_translate label="LBL_EMAIL_ADDRESS_BOOK_ADD_CC"}</b>
                </button>
                <button onclick="SUGAR.email2.addressBook.insertContactToResultTable(null,'{sugar_translate label='LBL_EMAIL_ADDRESS_BOOK_ADD_BCC'}')">
                    {sugar_translate label="LBL_ADD_TO_ADDR" module="Emails"} <b>{sugar_translate label="LBL_EMAIL_ADDRESS_BOOK_ADD_BCC"}</b>
                </button>
            </td>
        </tr>

    </table>
</form>