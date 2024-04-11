{*
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

*}
<div class="moduleTitle">
	<h2>{$title}</h2>
</div>

<div class='customViewsModules' width='100%'>
	<table align="center" cellspacing="7" width="90%">
		<tr>
			{counter start=0 name="buttonCounter" print=false assign="buttonCounter"}
			{foreach from=$buttons item='button' key='buttonName'}
				{if $buttonCounter > 5}
				</tr>
				<tr>
					{counter start=0 name="buttonCounter" print=false assign="buttonCounter"}
				{/if}
				<td {if isset($button.help)}id="{$button.help}" {/if} width="16%" name=helpable" style="padding: 5px;"
				valign="top" align="center">
				<table class='CustomViewButton'>
					<tr>
						<td align="center">
							<a class='studiolink'
								href="./index.php?module=stic_Custom_Views&action=selectView&view_module={$button.module}">
								<span class="suitepicon suitepicon-module-{$button.icon}"></span>
							</a>
						</td>
					</tr>
					<tr>
						<td align="center">
							<a class='studiolink' id='{$button.linkId}'
								href="./index.php?module=stic_Custom_Views&action=selectView&view_module={$button.module}">
								{$buttonName}
							</a>
						</td>
					</tr>
				</table>
			</td>
			{counter name="buttonCounter"}
			{/foreach}
		</tr>
	</table>
	<!-- Hidden div for hidden content so IE doesn't ignore it -->
	<div style="float:left; left:-100px; display: hidden;">&nbsp;
			{literal}
				<style type='text/css'>
					.customViewsModules {
						padding: 5px;
						text-align: center;
						font-weight: bold
					}
				</style>
			{/literal}
	</div>