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

<input type="hidden" name="module" value="Import">
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
    <span><strong><label for="save_map_as">{$MOD.LBL_SAVE_MAPPING_AS}</label></strong> {sugar_help text=$MOD.LBL_SAVE_MAPPING_HELP}</span>
            <span >
                <input type="text" name="save_map_as" id="save_map_as" value="" style="width: 20em" maxlength="254">
            </span>
    </div>
<br />

<table width="100%" cellpadding="2" cellspacing="0" border="0">
    <tr>
        <td align="left">
            <input title="{$MOD.LBL_BACK}"  id="goback" class="button" type="submit" name="button" value="  {$MOD.LBL_BACK}  ">&nbsp;
            <input title="{$MOD.LBL_IMPORT_NOW}"  id="importnow" class="button" type="button" name="button" value="  {$MOD.LBL_IMPORT_NOW}  ">
        </td>
    </tr>
</table>
</form>


