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

<!-- STIC-Code MHP - Compare this file with the import module file as it has quite a few changes -->

{literal}
<style type="text/css">
    .tableResults {
        margin-left: 2em;
    }

    td,th {
        height: 2.5em;
    }

    .lista {
        list-style-type: circle; 
        margin: 1em 2em;
    }

</style>
{/literal}


<h4>{$MOD.LBL_MODULES_RESULTS}</h4>
<br />
<table class='tableResults' width="50%" cellpadding="0" cellspacing="0">
    <tr>
        <th>{$MOD.LBL_MODULE}</th>
        <th style="color:green;">{$MOD.LBL_SUCCESSFULLY_IMPORTED}</th>
        <th style="color:red;">{$MOD.LBL_RECORDS_SKIPPED_DUE_TO_ERROR}</th>
    </tr>
    {foreach from=$smarty.session.stic_ImporValidation.modules item=moduleStatus}
        <tr>
            <td>{$moduleStatus.translatedName}</td>
            <td style="color:green;">{$moduleStatus.createdCount}</td>
            <td style="color:red;">{$moduleStatus.errorCount}</td>
        </tr>
    {/foreach}
</table>

<br /><br />

{if !empty($DUPLICATESINFILE)}
    <h4>{$MOD.LBL_DUPLICATES_VALUES_IN_FILE}</h4>
    <br />
    <p style="margin-left: 0.5em;">{$MOD.LBL_DUPLICATES_VALUES_IN_FILE_HELP}</p>
    <ul>
        <li class="lista">{$MOD.LBL_DUPLICATES_VALUES_IN_FILE_HELP_MULTIMODULE}</li>
        <li class="lista">{$MOD.LBL_DUPLICATES_VALUES_IN_FILE_HELP_ERROR}</li>
    </ul>
    <br />
    <table class='tableResults' width="46%" cellpadding="0" cellspacing="0">
        {foreach from=$DUPLICATESINFILE key=filter item=values}
            <th COLSPAN=2>{$filter}</td>
            <th>{$MOD.LBL_FREQUENCY}</td>
            {foreach from=$values key=value item=frecuency}
                <tr>
                    <td COLSPAN=2>{$value}</td>
                    <td style="color:red;">{$frecuency}</td>
                </tr>
            {/foreach}
            <tr><td></td></tr>
        {/foreach}
    </table>
{/if}

<form name="importlast" id="importlast" method="POST" action="index.php">
    <input type="hidden" name="module" value="{$smarty.session.stic_ImporValidation.module}">
    <input type="hidden" name="import_module" value="{$smarty.session.stic_ImporValidation.import_module}">
    <input type="hidden" name="return_module" value="{$smarty.session.stic_ImporValidation.import_module}">
    <input type="hidden" name="type" value="{$smarty.session.stic_ImporValidation.type}">
    <input type="hidden" name="source" value="{$smarty.session.stic_ImporValidation.source}">
    <input type="hidden" name="source_id" value="{$smarty.session.stic_ImporValidation.source_id}">
    <input type="hidden" name="action" value="{$smarty.session.stic_ImporValidation.action}">
    <input type="hidden" name="import_type" value="{$smarty.session.stic_ImporValidation.import_type}">
    <input type="hidden" name="file_name" value="{$smarty.session.stic_ImporValidation.file_name}">
    <input type="hidden" name="current_step" value=0>
    <input type="hidden" name="from_admin_wizard" value="{$smarty.session.stic_ImporValidation.from_admin_wizard}">
    <input type="hidden" name="importlocale_charset" value="{$smarty.session.stic_ImporValidation.importlocale_charset}">
    <input type="hidden" name="custom_delimiter" value="{$smarty.session.stic_ImporValidation.custom_delimiter}">
    <input type="hidden" name="custom_delimiter_other" value="{$smarty.session.stic_ImporValidation.custom_delimiter_other}">
    <input type="hidden" name="custom_enclosure" value="{$smarty.session.stic_ImporValidation.custom_enclosure}">
    <input type="hidden" name="custom_enclosure_other" value="{$smarty.session.stic_ImporValidation.custom_enclosure_other}">
    <input type="hidden" name="has_header" value="{$smarty.session.stic_ImporValidation.has_header}">
    <input type="hidden" name="importlocale_dateformat" value="{$smarty.session.stic_ImporValidation.importlocale_dateformat}">
    <input type="hidden" name="importlocale_timeformat" value="{$smarty.session.stic_ImporValidation.importlocale_timeformat}">
    <input type="hidden" name="importlocale_timezone" value="{$smarty.session.stic_ImporValidation.importlocale_timezone}">
    <input type="hidden" name="importlocale_currency" value="{$smarty.session.stic_ImporValidation.importlocale_currency}">
    <input type="hidden" name="importlocale_default_currency_significant_digits" value="{$smarty.session.stic_ImporValidation.importlocale_default_currency_significant_digits}">
    <input type="hidden" name="importlocale_num_grp_sep" value="{$smarty.session.stic_ImporValidation.importlocale_num_grp_sep}">
    <input type="hidden" name="importlocale_dec_sep" value="{$smarty.session.stic_ImporValidation.importlocale_dec_sep}">
    <input type="hidden" name="importlocale_default_locale_name_format" value="{$smarty.session.stic_ImporValidation.importlocale_default_locale_name_format}">
    <input type="hidden" name="button" value="{$MOD.LBL_NEXT}">
    <input type="hidden" name="multimodule" value="1">

    <br /><br />
    
    <h4>{$MOD.LBL_MULTIMODULE}</h4>
    <ul>
        <li class="lista">{$MOD.LBL_MULTIMODULE_HELP}</li>
        {if !empty($DUPLICATESINFILE)}<li class="lista">{$MOD.LBL_MULTIMODULE_HELP_2}</li>{/if}
    </ul>  
    <div style="margin:2em">
        {$MOD.LBL_SELECT_MODULE}
        <select name='import_module'>
            {html_options options=$MODULELIST selected=$IMPORT_MODULE}
        </select>    
        <input title="{$MOD.LBL_STIC_IMPORT_VALIDATION_MORE}"  class="button" type="submit" name="importmore" id="importmore" value="  {$MOD.LBL_STIC_IMPORT_VALIDATION_MORE}  ">
    </div>


    <br /><br />
    <h4>{$MOD.LBL_FILE_DOWNLOAD}</h4>
    <br />
    <div id="pageNumIW_2_div" style="margin:0.5em">
        {$MOD.LBL_INFO_HELP}
        <ul>
            <li class="lista">{$MOD.LBL_INFO_HELP_2}</li>
            <li class="lista">{$MOD.LBL_INFO_HELP_3}</li>
            <li class="lista">{$MOD.LBL_INFO_HELP_4}</li>
        </ul>
        <br />
        {if $errorCount > 0 || !empty($DUPLICATESINFILE)}
            <br />
            <p style="color:red;">{$MOD.LBL_REVALIDATION_HELP}</p>
            <ul>
                <li class="lista">{$MOD.LBL_REVALIDATION_HELP_2}</li>
                <li class="lista">{$MOD.LBL_REVALIDATION_HELP_3}</li>
                <li class="lista">{$MOD.LBL_REVALIDATION_HELP_4}</li>
                <li class="lista">{$MOD.LBL_REVALIDATION_HELP_5}</li>
            </ul>
            <br />
        {/if}
        <a href="{$errorrecordsFile}" target='_blank'>
            <button type='button' class='button'>{$MOD.LNK_RECORDS_SKIPPED_DUE_TO_ERROR}</button>
        </a>        
    </div>
    <br /><br /><br />
    <input title="{$MOD.LBL_FINISHED}{$MODULENAME}"  class="button" type="submit" name="finished" id="finished" value="{$MOD.LBL_STIC_IMPORT_VALIDATION_COMPLETE}">
</form>
