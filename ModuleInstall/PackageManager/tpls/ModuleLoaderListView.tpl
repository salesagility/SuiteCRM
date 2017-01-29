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

<table id='fileviewtable'>
	<tr height='20'>
		{counter start=0 name="colCounter" print=false assign="colCounter"}
		<th scope='col' width='5' nowrap="nowrap">view/hide</th>
		{foreach from=$displayColumns key=colHeader item=params}
			{if $params.show}
			<th scope='col' width='{$params.width}%'>
				<span sugar="sugar{$colCounter}"><div style='white-space: normal;'width='100%' align='{$params.align|default:'left'}'>
					{sugar_translate label=$params.label module='Administration'}
				</div></span sugar='sugar{$colCounter}'>
			</th>
			{/if}
				{counter name="colCounter"}
		{/foreach}
		<th scope='col' width='5' nowrap="nowrap">Select</th>
	</tr>
		{foreach name=rowIteration from=$data key=package_id item=package}
		{if $smarty.foreach.rowIteration.iteration is odd}
			{assign var='_bgColor' value=$bgColor[0]}
			{assign var='_rowColor' value=$rowColor[0]}
		{else}
			{assign var='_bgColor' value=$bgColor[1]}
			{assign var='_rowColor' value=$rowColor[1]}
		{/if}

			<tr id='package_tr_{$package_id}' height='20' class='{$_rowColor}S1'>
			<td scope='row' align='left' valign='top'><a class="listViewTdToolsS1" onclick="PackageManager.toggle_div('{$package_id}')" valign='top'><span id='span_toggle_package_{$package_id}'>{sugar_getimage name="advanced_search" ext=".gif" width="8" height="8" alt=$app_strings.LBL_ADVANCED_SEARCH other_attributes='border="0" '}&nbsp;</span></a></td>
			{counter start=0 name="colCounter" print=false assign="colCounter"}
			{foreach from=$displayColumns key=col item=params}
				<td scope='row' align='{$params.align|default:'left'}' valign='top'><span sugar="sugar{$colCounter}b">
					{if $params.show}
					{$package.$col}
					{/if}
				</span sugar='sugar{$colCounter}b'>
				</td>
				{counter name="colCounter"}
			{/foreach}
			<td scope='row' align='left' valign='top'><a class="listViewTdToolsS1" onclick="PackageManager.select_package('{$package_id}')" valign='top'>Select</a></td>
	    	</tr>
	    	<tr><td colspan="5"><table id='release_table_{$package_id}' style='display:none'>
	    	{foreach name=releaseIteration from=$package.releases key=release_id item=release}
		    	<tr id='release_tr_{$release_id}' height='20' class='{$_rowColor}S1'>
				{counter start=0 name="colCounter" print=false assign="colCounter"}
				{foreach from=$secondaryDisplayColumns key=col item=params}
					<td scope='row' align='{$params.align|default:'left'}' valign='top'><span sugar="sugar{$colCounter}b">
						{$release.$col}
					</span sugar='sugar{$colCounter}b'>
					</td>
					{counter name="colCounter"}
				{/foreach}
				<td scope='row' align='left' valign='top'><a class="listViewTdToolsS1" onclick="PackageManager.select_release('{$release_id}')" valign='top'>Select</a></td>
		    	</tr>
		    {/foreach}
		    </table></td></tr>
	 	
	{/foreach}
	
</table>
