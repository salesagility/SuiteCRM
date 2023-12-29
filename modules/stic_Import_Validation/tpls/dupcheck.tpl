{*
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
 *}
{literal}
<style>
<!--

#DupeCheck{
    border: none;
    box-shadow:none;
}

#selected_indices
{
    padding-left:30px;
    padding-right:30px;
}


-->
</style>
{/literal}

{$INSTRUCTION}
<br /><br />
<form enctype="multipart/form-data" real_id="importstepdup" id="importstepdup" name="importstepdup" method="POST" action="index.php">

{foreach from=$smarty.request key=k item=v}
    {if $k neq 'current_step'}
        {if is_array($v)}
            {foreach from=$v key=k1 item=v1}
                <input type="hidden" name="{$k}[]" value="{$v1}">
            {/foreach}
        {else}
            <input type="hidden" name="{$k}" value="{$v}">
        {/if}
    {/if}
{/foreach}

<input type="hidden" name="module" value="stic_Import_Validation">
<input type="hidden" name="import_type" value="{$smarty.request.import_type}">
<input type="hidden" name="type" value="{$smarty.request.type}">
<input type="hidden" name="file_name" value="{$smarty.request.tmp_file}">
<input type="hidden" name="source_id" value="{$SOURCE_ID}">
<input type="hidden" name="to_pdf" value="1">
<input type="hidden" name="display_tabs_def">
<input type="hidden" id="enabled_dupes" name="enabled_dupes" value="">
<input type="hidden" id="disabled_dupes" name="disabled_dupes" value="">
<input type="hidden" id="current_step" name="current_step" value="{$CURRENT_STEP}">

<div class="hr"></div>
<div>
<table border="0" cellpadding="30" id="importTable" style="width:60% !important;">
<tr>
    <td  width="40%" colspan="2">
        <table id="DupeCheck" class="themeSettings edit view noBorder" style='margin-bottom:0px;' border="0" cellspacing="10" cellpadding="0"  width = '100%'>
            <tr>
                <td align="right">
                    <div id="enabled_div" class="enabled_tab_workarea">
                    </div>
                </td>
                <td align="left">
                    <div id="disabled_div" class="disabled_tab_workarea">
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
    <div class="hr"></div>
<br />     
    <span><strong><label for="save_map_as">{$MOD.LBL_SAVE_MAPPING_AS}</label></strong> {sugar_help text=$MOD.LBL_SAVE_MAPPING_HELP}</span>
            <span >
                <input type="text" name="save_map_as" id="save_map_as" value="" style="width: 20em" maxlength="254">
            </span>
    </div>
<br /><br />

<table width="100%" cellpadding="2" cellspacing="0" border="0">
    <tr>
        <td align="left">

            <input title="{$MOD.LBL_STIC_IMPORT_VALIDATION_NOW}"  id="importnow" class="button" type="button" name="button" value="  {$MOD.LBL_STIC_IMPORT_VALIDATION_NOW}  ">
        </td>
    </tr>
</table>
</form>


