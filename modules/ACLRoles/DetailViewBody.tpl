{*

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




*}

{strip}
<TABLE width='100%' class='detail view' border='0' cellpadding=0 cellspacing = 1  >
<TR>
<td style="background: transparent;"></td>
{foreach from=$ACTION_NAMES item="ACTION_NAME" }
	<td style="text-align: center;" scope="row"><b>{$ACTION_NAME}</b></td>
{foreachelse}

          <td colspan="2">&nbsp;</td>

{/foreach}
</TR>
{foreach from=$CATEGORIES item="TYPES" key="CATEGORY_NAME"}


    {if $APP_LIST.moduleList[$CATEGORY_NAME]!='Users'}


	<TR>
	{if $APP_LIST.moduleList[$CATEGORY_NAME]=='Users'}
	<td nowrap width='1%' scope="row"><b>{$MOD.LBL_USER_NAME_FOR_ROLE}</b></td>
	{else}
	<td nowrap width='1%' scope="row"><b>{$APP_LIST.moduleList[$CATEGORY_NAME]}</b></td>
	{/if}
	{foreach from=$ACTION_NAMES item="ACTION_LABEL" key="ACTION_NAME"}
		{assign var='ACTION_FIND' value='false'}
		{foreach from=$TYPES item="ACTIONS" key="TYPE_NAME"}
			{foreach from=$ACTIONS item="ACTION" key="ACTION_NAME_ACTIVE"}
				{if $ACTION_NAME==$ACTION_NAME_ACTIVE}
					{assign var='ACTION_FIND' value='true'}
					<td  width='{$TDWIDTH}%' align='center'><div align='center' class="acl{$ACTION.accessLabel|capitalize}"><b>{$ACTION.accessName}</b></div></td>
				{/if}
			{/foreach}
		{/foreach}
		{if $ACTION_FIND=='false'}
			<td nowrap width='{$TDWIDTH}%' style="text-align: center;">
			<div><font color='red'>N/A</font></div>
			</td>
		{/if}
	{/foreach}
	</TR>


    {/if}


{foreachelse}
	<tr> <td colspan="2">No Actions</td></tr>
{/foreach}
</TABLE>
{/strip}