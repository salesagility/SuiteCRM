{*

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




*}


<script type="text/javascript">
SUGAR.util.doWhen("typeof get_module_name != 'undefined'", function()
{ldelim}
	SUGAR.subpanelUtils.currentSubpanelGroup = '{$startSubPanel}';

	SUGAR.subpanelUtils.subpanelMoreTab = '{$moreTab}';

	SUGAR.subpanelUtils.subpanelMaxSubtabs = '{$maxSubtabs}';

	SUGAR.subpanelUtils.subpanelHtml = new Array();

	SUGAR.subpanelUtils.loadedGroups = Array();
	SUGAR.subpanelUtils.loadedGroups.push('{$startSubPanel}');

	SUGAR.subpanelUtils.subpanelSubTabs = new Array();
	SUGAR.subpanelUtils.subpanelGroups = new Array();
{foreach from=$othertabs item=tab}
{assign var='notFirst' value='0'}
	SUGAR.subpanelUtils.subpanelGroups['{$tab.key}'] = [{foreach from=$tab.tabs item=subtab}{if $notFirst != 0}, {else}{assign var='notFirst' value='1'}{/if}'{$subtab.key}'{/foreach}{foreach from=$otherMoreSubMenu[$tab.key].tabs item=subtab}, '{$subtab.key}'{/foreach}];
{/foreach}

{assign var='notFirst' value='0'}
	SUGAR.subpanelUtils.subpanelTitles = {$subpanelTitlesJSON};

	SUGAR.subpanelUtils.tabCookieName = get_module_name() + '_sp_tab';

	SUGAR.subpanelUtils.showLinks = {$showLinks};

	SUGAR.subpanelUtils.requestUrl = 'index.php?to_pdf=1&module=MySettings&action=LoadTabSubpanels&loadModule={$smarty.request.module}&record={$smarty.request.record}&subpanels=';
{rdelim});
</script>


{if !empty($sugartabs)}
<ul id="groupTabs" class="nav nav-tabs">
{foreach from=$sugartabs key=i item=tab}
	<li id="{$tab.label}_sp_tab" class="{if $tab.type == 'current'}active{/if}">
		<a class="{$tab.type}" href="javascript:SUGAR.subpanelUtils.loadSubpanelGroup('{$tab.label}');">{$tab.label}</a>
	</li>
{/foreach}
{if !empty($moreMenu)}
	<li>
		<div id='MorePanelHandle' onmouseover='SUGAR.subpanelUtils.menu.tbspButtonMouseOver(this.id,"","",0);'>
			{sugar_getimage name="blank" ext=".gif" width="16" height="16" alt=$app_strings.LBL_MORE other_attributes='border="0" '}
		</div>
	</li>
{/if}
</ul>
{* Table closed in SubPanelTiles.php, line 295 *}
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="subpanelTabForm">
	<tr>
		<td>
{/if}

{if $showLinks == 'true'}
<table cellpadding="0" cellspacing="0" width='100%'>
	<tr height="20">
		<td class="subpanelSubTabBar" colspan="100" id="subpanelSubTabs">
			<table border="0" cellpadding="0" cellspacing="0" height="20" width="100%" class="subTabs">
				<tbody>
				<tr>
{foreach from=$subtabs item=tab}
{if !empty($notFirst) && ($notFirst != 0) && ($notFirst != 1)}
					<td width='1'> | </td>
{else}
{assign var='notFirst' value='2'}
{/if}
					<td nowrap="nowrap">
						<a href='#{$tab.key}' class='subTabLink'>{$tab.label}</a>
					</td>
{/foreach}
{if !empty($otherMoreSubMenu[$moreSubMenuName].tabs)}
					<td nowrap="nowrap"> | &nbsp;<span class="subTabMore" id="MoreSub{$moreSubMenuName}PanelHandle" style="margin-left:2px; cursor: pointer; cursor: hand;" align="absmiddle" onmouseover="SUGAR.subpanelUtils.menu.tbspButtonMouseOver(this.id,'','',0);">&gt;&gt;</span></td>
{/if}
					<td width='100%'>&nbsp;</td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>
{/if}

{if !empty($moreMenu)}
<div id="MorePanelMenu" class="menu">
{foreach from=$moreMenu item=tab}
	<a href="javascript:SUGAR.subpanelUtils.loadSubpanelGroupFromMore('{$tab.label}');" class="menuItem" id="{$tab.label}_sp_mm" parentid="MorePanelMenu" onmouseover="hiliteItem(this,'yes'); closeSubMenus(this);" onmouseout="unhiliteItem(this);">{$tab.label}</a>
{/foreach}
</div>
{/if}

{foreach from=$otherMoreSubMenu item=group}
{if !empty($group.tabs)}
<div id="MoreSub{$group.key}PanelMenu" class="menu">
{foreach from=$group.tabs item=subtab}
	<a href="#{$subtab.key}" class="menuItem" parentid="MoreSub{$group.key}PanelMenu" onmouseover="hiliteItem(this,'yes'); closeSubMenus(this);" onmouseout="unhiliteItem(this);">{$subtab.label}</a>
{/foreach}
</div>
{/if}
{/foreach}


