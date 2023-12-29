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

{$CSS}

{$INSTRUCTION}


<form enctype="multipart/form-data" real_id="importstep3" id="importstep3" name="importstep3" method="POST" action="index.php">
<input type="hidden" name="module" value="stic_Import_Validation">
<input type="hidden" name="previous_action" value="Confirm">
<input type="hidden" name="custom_delimiter" value="{$CUSTOM_DELIMITER}">
<input type="hidden" name="custom_enclosure" value="{$CUSTOM_ENCLOSURE}">
<input type="hidden" name="import_type" value="{$TYPE}">
<input type="hidden" name="source" value="{$smarty.request.source}">
<input type="hidden" name="source_id" value="{$smarty.request.source_id}">
<!-- STIC-Code MHP - If it is a multimodule validation, delete the instructions 
<input type="hidden" name="action" value="Step3"> -->
<input type="hidden" name="action" value="dupcheck">
<input type="hidden" name="import_module" value="{$IMPORT_MODULE}">
<input type="hidden" name="has_header" value="{$HAS_HEADER}">
<input type="hidden" name="tmp_file" value="{$TMP_FILE}">
<input type="hidden" name="tmp_file_base" value="{$TMP_FILE}">
<input type="hidden" name="firstrow" value="{$FIRSTROW}">
<input type="hidden" name="columncount" value ="{$COLUMNCOUNT}">
<input type="hidden" name="current_step" value="{$CURRENT_STEP}">
<input type="hidden" name="importlocale_charset" value="{$smarty.request.importlocale_charset}">
<input type="hidden" name="importlocale_dateformat" value="{$smarty.request.importlocale_dateformat}">
<input type="hidden" name="importlocale_timeformat" value="{$smarty.request.importlocale_timeformat}">
<input type="hidden" name="importlocale_timezone" value="{$smarty.request.importlocale_timezone}">
<input type="hidden" name="importlocale_currency" value="{$smarty.request.importlocale_currency}">
<input type="hidden" name="importlocale_default_currency_significant_digits" value="{$smarty.request.importlocale_default_currency_significant_digits}">
<input type="hidden" name="importlocale_num_grp_sep" value="{$smarty.request.importlocale_num_grp_sep}">
<input type="hidden" name="importlocale_dec_sep" value="{$smarty.request.importlocale_dec_sep}">
<input type="hidden" name="importlocale_default_locale_name_format" value="{$smarty.request.importlocale_default_locale_name_format}">
<input type="hidden" name="from_admin_wizard" value="{$smarty.request.from_admin_wizard}">
    
<br>
{if $NOTETEXT != ''}
    <p>
        <input title="{$MOD.LBL_SHOW_ADVANCED_OPTIONS}"  id="toggleNotes" class="button" type="button"
                       name="button" value="  {$MOD.LBL_SHOW_NOTES}  ">
        <div id="importNotes" style="display: none;">
            <ul>
                {$NOTETEXT}
            </ul>
        </div>
    </p>
{/if}

<div class="hr"></div>


<table border="0" cellspacing="0" cellpadding="0" width="100%" id="importTable" class="detail view">
{foreach from=$rows key=key item=item name=rows}
{if $smarty.foreach.rows.first}
<tr>
    {if $HAS_HEADER == 'on'}
    <th style="text-align: left;" scope="col">
        <b>{$MOD.LBL_HEADER_ROW}</b>&nbsp;
        {sugar_help text=$MOD.LBL_HEADER_ROW_HELP}
    </th>
    {/if}
    <th style="text-align: left;" scope="col">
        <b>{$MOD.LBL_DATABASE_FIELD}</b>&nbsp;
        {sugar_help text=$MOD.LBL_DATABASE_FIELD_HELP}
    </th>
    <th style="text-align: left;" scope="col">
        <b>{$MOD.LBL_ROW} 1</b>&nbsp;
        {sugar_help text=$MOD.LBL_ROW_HELP}
    </th>
    {if $HAS_HEADER != 'on'}
    <th style="text-align: left;" scope="col"><b>{$MOD.LBL_ROW} 2</b></td>
    {/if}
    <th scope='col' style="text-align: left;" scope="rcol" id="default_column_header" width="10%">
        <span id="hide_default_link" class="expand">&nbsp;<b id="">{$MOD.LBL_DEFAULT_VALUE}</b>&nbsp;
        {sugar_help text=$MOD.LBL_DEFAULT_VALUE_HELP}</span>
        <span id="default_column_header_span">&nbsp;</span>
    </th>
</tr>
{/if}
<tr>
    {if $HAS_HEADER == 'on'}
    <td id="row_{$smarty.foreach.rows.index}_header">{$item.cell1}</td>
    {/if}
    <td valign="top" align="left" id="row_{$smarty.foreach.rows.index}_col_0">
        <select class='fixedwidth' name="colnum_{$smarty.foreach.rows.index}">
            <option value="-1">{$MOD.LBL_DONT_MAP}</option>
            {$item.field_choices}
        </select>
    </td>
    {if $item.show_remove}
    <td colspan="2">
        <input title="{$MOD.LBL_REMOVE_ROW}" 
            id="deleterow_{$smarty.foreach.rows.index}" class="button" type="button"
            value="  {$MOD.LBL_REMOVE_ROW}  ">
    </td>
    {else}
    {if $HAS_HEADER != 'on'}
    <td id="row_{$smarty.foreach.rows.index}_col_1" scope="row">{$item.cell1}</td>
    {/if}
    <td id="row_{$smarty.foreach.rows.index}_col_2" scope="row" colspan="2">{$item.cell2}</td>
    {/if}
    <td id="defaultvaluepicker_{$smarty.foreach.rows.index}" nowrap="nowrap">
        {$item.default_field}
    </td>
</tr>
{/foreach}
<tr>
    <td align="left" colspan="4">
        <input title="{$MOD.LBL_ADD_ROW}"  id="addrow" class="button" type="button"
            name="button" value="  {$MOD.LBL_ADD_ROW}  "> {sugar_help text=$MOD.LBL_ADD_FIELD_HELP}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
</tr>
</table>

<!-- STIC-Code MHP - Add multimodule inputs options -->
<br /><br />

<h4>{$MOD.LBL_MULTIMODULE}</h4>
<br />

{$MOD.LBL_GENERATE_ID_HELP}<br /><br />
{$MOD.LBL_GENERATE_ID_HELP_2}<br /><br />
{$MOD.LBL_GENERATE_ID_HELP_3}<br /><br />
{$MOD.LBL_GENERATE_ID_HELP_4}
<br /><br />

<table class="detail view">
<tr>
    <th style="text-align: left; width: 25%;"">
    {$MOD.LBL_GENERATE_ID}
    </th>
    <td>
        <input class="radio" type="radio" name="generateID" value=1 id='yes' checked='checked'/>&nbsp;Sí
        <input class="radio" type="radio" name="generateID" value=0 id='no'/>&nbsp;No
    </td>
    <td></td>
</tr>
<tr>
    <th style="text-align: left; width: 25%;">
    {$MOD.LBL_COLUMN_FOR_ID}
    </th>
    <td style="text-align: left; width: 10%;">
        <select id="positionForIdColumn" name="positionForIdColumn">
            {html_options options=$COLUMNSNAME }
        </select>
    </td>
    <td style="text-align: left; width: 65%; color: red;">{$MOD.LBL_REQUIRED_COLUMN}</td>

</tr>
</table>
<!-- END STIC-Code -->
<br />

<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
    <td align="left">
        <input title="{$MOD.LBL_NEXT}"  id="gonext" class="button" type="submit" name="button" value="  {$MOD.LBL_NEXT}  ">
    </td>
</tr>
</table>

{$QS_JS}