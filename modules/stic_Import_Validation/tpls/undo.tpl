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
<br>
{if $UNDO_SUCCESS}
<h3>{$MOD.LBL_LAST_IMPORT_UNDONE}</h3>
{else}
<h3>{$MOD.LBL_NO_IMPORT_TO_UNDO}</h3>
{/if}
<br />
<form enctype="multipart/form-data" name="importundo" method="POST" action="index.php" id="importundo">
<input type="hidden" name="module" value="stic_Import_Validation">
<input type="hidden" name="action" value="Step1">
<input type="hidden" name="import_module" value="{$IMPORT_MODULE}">
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
    <td align="left">
       <input title="{$MOD.LBL_MODULE_NAME}&nbsp;{$MODULENAME}"  class="button" type="submit" name="button"
            value="{$MOD.LBL_MODULE_NAME}&nbsp;{$MODULENAME}">

        <input title="{$MOD.LBL_FINISHED}{$MODULENAME}"  class="button" type="submit"
            name="finished" id="finished" value="{$MOD.LBL_STIC_IMPORT_VALIDATION_COMPLETE}">
    </td>
</tr>
</table>
<br />
</form>

