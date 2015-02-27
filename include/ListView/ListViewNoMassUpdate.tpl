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


<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list View'>
{assign var="link_select_id" value="selectLinkTop"}
{assign var="link_action_id" value="actionLinkTop"}
{include file='include/ListView/ListViewPagination.tpl'}
    <thead>
	<tr height='20'>
	    {if !empty($quickViewLinks)}
		<th scope='col' width='1%'>&nbsp;</th>
		{/if}
		{counter start=0 name="colCounter" print=false assign="colCounter"}
		{foreach from=$displayColumns key=colHeader item=params}
            {if $colCounter == '1'}<th scope='col' width='{$params.width}%' data-toggle="true">
            {else}<th scope='col' width='{$params.width}%' data-hide="phone,tablet">{/if}
				<span sugar="sugar{$colCounter}"><div style='white-space: nowrap;'width='100%' align='{$params.align|default:'left'}'>
                {if $params.sortable|default:true}
	                <a href='{$pageData.urls.orderBy}{$params.orderBy|default:$colHeader|lower}' class='listViewThLinkS1' title="{$arrowAlt}">{sugar_translate label=$params.label module=$pageData.bean.moduleDir}&nbsp;&nbsp;
					{if $params.orderBy|default:$colHeader|lower == $pageData.ordering.orderBy}
						{if $pageData.ordering.sortOrder == 'ASC'}
							{capture assign="imageName"}arrow_down.$arrowExt{/capture}
                            {capture assign="alt_sort"}{sugar_translate label='LBL_ALT_SORT_DESC'}{/capture}
							{sugar_getimage name=$imageName width=$arrowWidth height=$arrowHeight attr='align="absmiddle" border="0" ' alt="$alt_sort"}
						{else}
							{capture assign="imageName"}arrow_up.$arrowExt{/capture}
                            {capture assign="alt_sort"}{sugar_translate label='LBL_ALT_SORT_ASC'}{/capture}
							{sugar_getimage name=$imageName width=$arrowWidth height=$arrowHeight attr='align="absmiddle" border="0" ' alt="$alt_sort"}
						{/if}
					{else}
						{capture assign="imageName"}arrow.$arrowExt{/capture}
                        {capture assign="alt_sort"}{sugar_translate label='LBL_ALT_SORT'}{/capture}
						{sugar_getimage name=$imageName width=$arrowWidth height=$arrowHeight attr='align="absmiddle" border="0" ' alt="$alt_sort"}
					{/if}
                    </a>
				{else}
					{sugar_translate label=$params.label module=$pageData.bean.moduleDir}
				{/if}
				</div></span sugar='sugar{$colCounter}'>
			</th>
			{counter name="colCounter"}
		{/foreach}
	</tr>
</thead>
	{foreach name=rowIteration from=$data key=id item=rowData}
		{if $smarty.foreach.rowIteration.iteration is odd}
			{assign var='_rowColor' value=$rowColor[0]}
		{else}
			{assign var='_rowColor' value=$rowColor[1]}
		{/if}
		<tr height='20' class='{$_rowColor}S1'>
			{if !empty($quickViewLinks)}
			<td width='1%' nowrap>
				{if $pageData.access.edit && $pageData.bean.moduleDir != "Employees"}
					<a title='{$editLinkString}' id="edit-{$rowData.ID}" href='index.php?action=EditView&module={$params.module|default:$pageData.bean.moduleDir}&record={$rowData[$params.id]|default:$rowData.ID}&offset={$pageData.offsets.current+$smarty.foreach.rowIteration.iteration}&stamp={$pageData.stamp}&return_module={$params.module|default:$pageData.bean.moduleDir}' title="{sugar_translate label="LBL_EDIT_INLINE"}">{sugar_getimage name="edit_inline.gif" attr='border="0" '}</a>
				{/if}
			</td>
			{/if}
			{counter start=0 name="colCounter" print=false assign="colCounter"}
			{foreach from=$displayColumns key=col item=params}
				<td scope='row' align='{$params.align|default:'left'}' {if $params.nowrap}nowrap='nowrap' {/if}valign='top'><span sugar="sugar{$colCounter}b">
					{if $col == 'NAME' || $params.bold}<b>{/if}
				    {if $params.link && !$params.customCode}
						<{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN} href="#" onMouseOver="javascript:lvg_nav('{if $params.dynamic_module}{$rowData[$params.dynamic_module]}{else}{$params.module|default:$pageData.bean.moduleDir}{/if}', '{$rowData[$params.id]|default:$rowData.ID}', 'd', {$smarty.foreach.rowIteration.iteration}, this);"  onFocus="javascript:lvg_nav('{if $params.dynamic_module}{$rowData[$params.dynamic_module]}{else}{$params.module|default:$pageData.bean.moduleDir}{/if}', '{$rowData[$params.id]|default:$rowData.ID}', 'd', {$smarty.foreach.rowIteration.iteration}, this);">
						{/if}
					{if $params.customCode}
						{sugar_evalcolumn_old var=$params.customCode rowData=$rowData}
					{else}
                       {sugar_field parentFieldArray=$rowData vardef=$params displayType=ListView field=$col}
					{/if}
					{if empty($rowData.$col)}&nbsp;{/if}
					{if $params.link && !$params.customCode}
						</{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN}>
                    {/if}
                    {if $col == 'NAME' || $params.bold}</b>{/if}
				</span sugar='sugar{$colCounter}b'></td>
				{counter name="colCounter"}
			{/foreach}
	    	</tr>
	{foreachelse}
	<tr height='20' class='{$rowColor[0]}S1'>
	    <td colspan="{$colCount}">
	        <em>{$APP.LBL_NO_DATA}</em>
	    </td>
	</tr>
	{/foreach}
{assign var="link_select_id" value="selectLinkBottom"}
{assign var="link_action_id" value="actionLinkBottom"}
{include file='include/ListView/ListViewPagination.tpl'}
</table>
<script type='text/javascript'>
{literal}function lvg_nav(m,id,act,offset,t){if(t.href.search(/#/) < 0){return;}else{if(act=='pte'){act='ProjectTemplatesEditView';}else if(act=='d'){ act='DetailView';}else if( act =='ReportsWizard'){act = 'ReportsWizard';}else{ act='EditView';}{/literal}url = 'index.php?module='+m+'&offset=' + offset + '&stamp={$pageData.stamp}&return_module='+m+'&action='+act+'&record='+id;t.href=url;{literal}}}{/literal}
{literal}function lvg_dtails(id){{/literal}return SUGAR.util.getAdditionalDetails( '{$pageData.bean.moduleDir}',id, 'adspan_'+id);{literal}}{/literal}
{if $contextMenus}
	{$contextMenuScript}
{/if}
</script>
