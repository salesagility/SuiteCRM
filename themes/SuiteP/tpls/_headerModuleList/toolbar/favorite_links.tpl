{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2020 SalesAgility Ltd.
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

{* when records are found for the current module show favorites header *}
{counter start=0 name="moduleFavoriteRecordsTotal" assign="moduleFavoriteRecordsTotal"  print=false}
{foreach from=$favoriteRecords item=item name=lastViewed}
    {if $item.module_name == $module_name and $moduleFavoriteRecordsTotal == 0}
        <li class="favorite-links-title"><a><strong>{$APP.LBL_FAVORITES}</strong></a></li>
        {counter name="moduleFavoriteRecordsTotal" print=false}
    {/if}
{/foreach}
<li class="current-module-favorite-links">
    <ul>
        {* when records are found for the current module show the first 3 records *}
        {counter start=0 name="moduleFavoriteRecords" assign="moduleFavoriteRecords" print=false}
        {foreach from=$favoriteRecords item=item name=lastViewed}
            {if $item.module_name == $module_name and $moduleFavoriteRecords < 3}
                <li class="favoritelinks" role="presentation">
                    <a title="{$item.module_name}"
                       accessKey="{$smarty.foreach.lastViewed.iteration}"
                       href="{sugar_link module=$item.module_name action='DetailView' record=$item.id link_only=1}" class="favorite-links-detail">
                        <span class="suitepicon suitepicon-module-{$item.module_name|lower|replace:'_':'-'}"></span>
                        <span aria-hidden="true">{$item.item_summary_short}</span>
                    </a>
                    {capture assign='access'}{suite_check_access module=$item.module_name action='edit' record=$item.item_id }{/capture}
                    {if $access}
                        <a href="{sugar_link module=$item.module_name action='EditView' record=$item.id link_only=1}" class="favorite-links-edit"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></a>
                    {/if}
                </li>
                {counter name="moduleFavoriteRecords" print=false}
            {/if}
        {/foreach}
    </ul>
</li>
