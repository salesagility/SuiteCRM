{*
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

*}

{if $controls}

<div class="clear"></div>

<div style='float:left; width: 70%;'>
{foreach name=tabs from=$tabs key=k item=tab}
	<input type="button" class="button" {if $view == $k} selected {/if} id="{$tabs_params[$k].id}" title="{$tabs_params[$k].title}" value="{$tabs_params[$k].title}" onclick="{$tabs_params[$k].link}">
{/foreach}
</div>

<div style="float:left; text-align: right; width: 30%; font-size: 12px;">
{* STIC-custom 20210927 AAM - Adding Shared Day option *}
{* STIC#422 *}
{if $view == "sharedDay" || $view == "sharedWeek" || $view == "sharedMonth"}
{* END STIC *}
<input id="userListButtonId" type="button" class="button" value="{$MOD.LBL_EDIT_USERLIST}" onclick="javascript: CAL.toggle_shared_edit('shared_cal_edit');">
	{/if}
	{if $view != 'year' && !$print}
		{* STIC-custom 20210927 AAM - The core HTML element aren't parsed properly when overriding the tpl in custom. Therefore the Calendar.setup can't render them.
		We modify the elements so they appear properly. *}
		{* STIC#422 *}
		{* <span class="dateTime">
		<img border="0" src="{$cal_img}" alt="{$APP.LBL_ENTER_DATE}" id="goto_date_trigger" align="absmiddle"> *}
		<button id="goto_date_trigger" class="btn btn-danger">
			<span class="dateTime module-calendar">
				<span class="suitepicon suitepicon-module-calendar" alt="{$APP.LBL_ENTER_DATE}"></span>
				<input type="hidden" id="goto_date" name="goto_date" value="{$current_date}">
			</span>
		</button>
		{* END STIC *}
		<script type="text/javascript">
		Calendar.setup ({literal}{{/literal}
			inputField : "goto_date",
			ifFormat : "%m/%d/%Y",
			daFormat : "%m/%d/%Y",
			button : "goto_date_trigger",
			singleClick : true,
			dateStr : "{$current_date}",
			step : 1,
			onUpdate: goto_date_call,
			startWeekday: {$start_weekday},
			weekNumbers:false
		{literal}}{/literal});
		{literal}
		YAHOO.util.Event.onDOMReady(function(){
			YAHOO.util.Event.addListener("goto_date","change",goto_date_call);
		});
		function goto_date_call(){
			CAL.goto_date_call();
		}
		{/literal}
		</script>
	{* </span> *}
	{/if}
	<input type="button" id="cal_settings" class="btn btn-info" onclick="CAL.toggle_settings()" value="{$MOD.LBL_SETTINGS}">
	{* STIC-Custom 20211015 - It adds the Filters button, the Cross button that removes the filters, and the necessary CSS styles *}
	{* STIC#438 *}
	<div class="filter-group">
		<span type="button" id="cal_filters" class="btn-filter btn btn-info glyphicon glyphicon-filter parent-dropdown-handler" onclick="toggle_filters()"></span>
		<a title='{$MOD.LBL_FILTERS_CROSS_REMOVE_FILTERS_TOOLTIP}' id='cross_filters' href="javascript:void(0)" class="cross glyphicon glyphicon-remove" onClick=handleCrossRemoveFilters()></a>
	</div>
{literal}
	<style>
		.filter-group {
			display: inline-block;
		}
		.btn-filter {
			font-size: 14px;
			font-weight: 500;
			height: 32px;
			padding-left: 12px;
			padding-right: 12px;
			top: auto;
		}
		.cross {
			left: -14px;
			top: -10px;
			background-color: #b5bc31;
			color: white;
			font-size: 10px;
			padding: 4px;
		}
	</style>
{/literal}
{* END STIC *}

</div>

<div style='clear: both;'></div>

{/if}

{* STIC-custom 20240222 ART - Make the arrows of the calendar dashlet visible *}
{* https://github.com/SinergiaTIC/SinergiaCRM/pull/136 *}
{literal}
	<style>
		.dashletPanel #rect3120, .dashletPanel #rect3124{
			fill: #474f50 !important;
		}
	</style>
{/literal}
{* END STIC *}

<div class="{if $controls}monthHeader{/if}">
	<div style='float: left; width: 20%;'>{$previous}</div>
	<div style='float: left; width: 60%; text-align: center;'><h3>{$date_info}</h3></div>
	<div style='float: right;'>{$next}</div>
	<br style='clear:both;'>
</div>
