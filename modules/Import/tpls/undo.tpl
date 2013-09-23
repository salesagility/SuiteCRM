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
<br>
{if $UNDO_SUCCESS}
<h3>{$MOD.LBL_LAST_IMPORT_UNDONE}</h3>
{else}
<h3>{$MOD.LBL_NO_IMPORT_TO_UNDO}</h3>
{/if}
<br />
<form enctype="multipart/form-data" name="importundo" method="POST" action="index.php" id="importundo">
<input type="hidden" name="module" value="Import">
<input type="hidden" name="action" value="Step1">
<input type="hidden" name="import_module" value="{$IMPORT_MODULE}">
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
    <td align="left">
       <input title="{$MOD.LBL_MODULE_NAME}&nbsp;{$MODULENAME}"  class="button" type="submit" name="button"
            value="{$MOD.LBL_MODULE_NAME}&nbsp;{$MODULENAME}">

        <input title="{$MOD.LBL_FINISHED}{$MODULENAME}"  class="button" type="submit"
            name="finished" id="finished" value="{$MOD.LBL_IMPORT_COMPLETE}">
    </td>
</tr>
</table>
<br />
</form>

