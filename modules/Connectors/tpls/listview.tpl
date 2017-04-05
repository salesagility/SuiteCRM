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
<script type='text/javascript' src='{sugar_getjspath file='include/javascript/sugar_3.js'}'></script>

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
<tr>
<th width="5%">{$APP.LBL_SELECT_BUTTON_LABEL}</td>
{foreach from=$displayColumns key=colHeader item=params}
{if $colHeader != 'id'}
	<th width="{$params.width}%" nowrap>
          	{sugar_translate label=$params.label module=$module}
	</th>
{/if}	
{/foreach}
<th width="1%"></td>
</tr>


{foreach name=rowIteration from=$DATA key=id item=bean}
    {counter name="offset" print=false}
	{if $smarty.foreach.rowIteration.iteration is odd}
		{assign var='_bgColor' value=$bgColor[0]}
		{assign var='_rowColor' value=$rowColor[0]}
		{assign var='_class' value='oddListRowS1'}
	{else}
		{assign var='_bgColor' value=$bgColor[1]}
		{assign var='_rowColor' value=$rowColor[1]}
		{assign var='_class' value='evenListRowS1'}
	{/if}
    
    <tr height='20' onmouseover="setPointer(this, '{$rowData.id}', 'over', '{$_bgColor}', '{$bgHilite}', '');" onmouseout="setPointer(this, '{$rowData.ID}', 'out', '{$_bgColor}', '{$bgHilite}', '');" onmousedown="setPointer(this, '{$rowData.id}', 'click', '{$_bgColor}', '{$bgHilite}', '');" class="{$_class}">
		<td valign="top" scope="row" NOWRAP>
		<input vertical-align="middle" type="radio" name="{$source_id}_id" value="{$bean->data_source_id}">

		</td>
		{foreach from=$displayColumns key=colHeader item=params}
		{if $colHeader != 'id'}
		<td valign="top" scope="row">{sugar_connector_display bean=$bean field=$colHeader source=$source_id}</td>               
        {/if}
        {/foreach}
		<td scope="row"><span id='adspan_{$bean->id}' onmouseout="return clear_source_details()" onmouseover="get_source_details('{$source_id}', '{$bean->id}', 'adspan_{$bean->id}')" onmouseout="return nd(1000);" vertical-align="middle">{sugar_getimage name="info_inline" alt=$mod_strings.LBL_INFO_INLINE ext=".png" other_attributes=''}</span></td>
    </tr>

    
{/foreach}
</table>
