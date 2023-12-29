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

.link {
    text-decoration:underline
}
</style>
{/literal}
<!-- STIC-Code MHP - If it is a multimodule validation, delete the instructions -->
{if !$smarty.session.stic_ImporValidation.multimodule}
    <span style="font-weight:bold;">{$MOD.LBL_FILE_HEADER}</span>
    <br /><br />
    {$MOD.LBL_HEADER_REQUIRED}
    <br /><br />

    {$INSTRUCTION}
    {$SAMPLE_URL} &nbsp;{sugar_help text=$MOD.LBL_SAMPLE_URL_HELP}
    <br /><br /><br />
    
{/if}
<!-- END STIC-Code MHP -->
<form enctype="multipart/form-data" name="importstep2" method="POST" action="index.php" id="importstep2">
<input type="hidden" name="module" value="stic_Import_Validation">
<input type="hidden" name="custom_delimiter" value="{$CUSTOM_DELIMITER}">
<input type="hidden" name="custom_enclosure" value="{$CUSTOM_ENCLOSURE}">
<input type="hidden" name="source" value="{$SOURCE}">
<input type="hidden" name="source_id" value="{$SOURCE_ID}">
<input type="hidden" name="action" value="Confirm">
<input type="hidden" name="current_step" value="{$CURRENT_STEP}">
<input type="hidden" name="import_module" value="{$IMPORT_MODULE}">
<input type="hidden" name="from_admin_wizard" value="{$smarty.request.from_admin_wizard}">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>

<!-- If we are in multimodule import, do not show the file selection -->
{if !$smarty.session.stic_ImporValidation.multimodule}
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td scope="row" colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td align="left" scope="row" colspan="3"><div><label for="userfile">{$MOD.LBL_SELECT_FILE}</label></div> <div><input type="hidden" /><input size="20" id="userfile" name="userfile" type="file"/>{sugar_help text=$MOD.LBL_FILE_UPLOAD_WIDGET_HELP}</div> <div><span class="small">{$APP.LBL_LOGGER_VALID_FILENAME_CHARACTERS}</span></div></td>
        </tr>
        <input id="import_create" type="hidden" name="type" value="import"/>
	</table>
    <br /><br />
{/if}
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
          {foreach from=$custom_mappings item=item name=custommappings}
          {capture assign=mapping_label}{$MOD.LBL_CUSTOM_MAPPING_}{$item|upper}{/capture}
          <tr>
            <td colspan="3" scope="row"><input class="radio" type="radio" id="source" name="source" value="{$item}" />
              &nbsp;<label for="source">{$mapping_label}</label></td>
          </tr>
          {/foreach}

          {if !empty($custom_imports) || !empty($published_imports)}
          <tr>
            <td scope="row" colspan="3">
                <h3>{$MOD.LBL_PUBLISHED_SOURCES}&nbsp;{sugar_help text=$savedMappingHelpText}</h3></td>
          </tr>
          
          <tr id="custom_import_{$smarty.foreach.saved.index}">
            <td scope="row" colspan="4">
                <input class="radio" type="radio" name="source" value=""/>
                &nbsp;{$MOD.LBL_NONE}
            </td>

          </tr>
          {else}
          {$MOD.LBL_EMPTY_PUBLISH}
          {/if}
          {foreach from=$custom_imports key=key item=item name=saved}
          <tr id="custom_import_{$smarty.foreach.saved.index}">
            <td scope="row" colspan="2" style="padding-right: 10px;">
                <input class="radio" type="radio" name="source" value="custom:{$item.IMPORT_ID}"/>
                &nbsp;{$item.IMPORT_NAME}
                {if $is_admin}
                <input type="button" name="publish" value="{$MOD.LBL_PUBLISH}" class="button" publish="yes"
                    onclick="publishMapping(this, 'yes','{$item.IMPORT_ID}', '{$IMPORT_MODULE}');">
                {/if}
                <input type="button" name="delete" value="{$MOD.LBL_DELETE}" class="button"
					onclick="if(confirm('{$MOD.LBL_DELETE_MAP_CONFIRMATION}')){literal}{{/literal} deleteMapping('custom_import_{$smarty.foreach.saved.index}', '{$item.IMPORT_ID}', '{$IMPORT_MODULE}' );{literal}}{/literal}">
            </td>
          </tr>
          {/foreach}

          {foreach from=$published_imports key=key item=item name=published}
          <tr id="published_import_{$smarty.foreach.published.index}">
            <td scope="row" colspan="2">
                <input class="radio" type="radio" name="source" value="custom:{$item.IMPORT_ID}"/>
                &nbsp;{$item.IMPORT_NAME}
            </td>
            <td scope="row">
                {if $is_admin}
                <input type="button" name="publish" value="{$MOD.LBL_UNPUBLISH}" class="button" publish="no"
                    onclick="publishMapping(this, 'no','{$item.IMPORT_ID}', '{$IMPORT_MODULE}');">
                <input type="button" name="delete" value="{$MOD.LBL_DELETE}" class="button"
                    onclick="if(confirm('{$MOD.LBL_DELETE_MAP_CONFIRMATION}')){literal}{{/literal}deleteMapping('published_import_{$smarty.foreach.published.index}','{$item.IMPORT_ID}' );{literal}}{/literal}">
                {/if}
            </td>
          </tr>
          {/foreach}
    </table>
</td>
</tr>
</table>

<br>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
  <td align="left">
      <input title="{$MOD.LBL_NEXT}"  class="button" type="submit" name="button" value="  {$MOD.LBL_NEXT}  " id="gonext">
    </td>
</tr>
</table>
<script>
{$JAVASCRIPT}
</script>
</form>
