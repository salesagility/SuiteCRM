{*

/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */



*}

<form name="exportcustom" id="exportcustom">
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='ExportCustom'>
<div align="left">
<input type="submit" class="button" name="exportCustomBtn" value="{$mod_strings.LBL_EC_EXPORTBTN}" onclick="return check_form('exportcustom');">
</div>
<br>
    <table class="mbTable">
    <tbody>
    <tr>
    	<td class="mbLBL">
    		<b><font color="#ff0000">*</font> {$mod_strings.LBL_EC_NAME} </b>
    	</td>
    	<td>
    		<input type="text" value="" size="50" name="name"/>
    	</td>
    </tr>
    <tr>
    	<td class="mbLBL">
    		<b>{$mod_strings.LBL_EC_AUTHOR} </b>
    	</td>
    	<td>
    		<input type="text" value="" size="50" name="author"/>
    	</td>
    </tr>
    <tr>
    	<td class="mbLBL">
    		<b>{$mod_strings.LBL_EC_DESCRIPTION} </b>
    	</td>
    	<td>
    		<textarea rows="3" cols="60" name="description"></textarea>
    	</td>
    </tr>
    <tr>
    	<td height="100%"/>
    	<td/>
    </tr>
    </tbody>
	</table>
	
    <table border="0" CELLSPACING="15" WIDTH="100%">
        <TR><input type="hidden" name="hiddenCount"></TR>
        {foreach from=$modules key=k item=i}
        
        <TR>
            <TD><h3 style='margin-bottom:20px;'>{if $i != ""}<INPUT onchange="updateCount(this);" type="checkbox" name="modules[]" value={$k}>{/if}{$moduleList[$k]}</h3></TD>
            <TD VALIGN="top">
            {foreach from=$i item=j}
            {$j}<br>
            {/foreach}
            </TD>
        </TR>
        
        {/foreach} 
    </table>
    <br> 
</form>

{literal}
<script type="text/javascript">
var boxChecked = 0;

function updateCount(box) {
   boxChecked = box.checked == true ? ++boxChecked : --boxChecked;
   document.exportcustom.hiddenCount.value = (boxChecked == 0 ? "" : "CHECKED");
}
{/literal}
ModuleBuilder.helpRegister('exportcustom');
ModuleBuilder.helpSetup('exportcustom','exportHelp');
addToValidate('exportcustom', 'hiddenCount', 'varchar', true, '{$mod_strings.LBL_EC_CHECKERROR}');
addToValidate('exportcustom', 'name', 'varchar', true, '{$mod_strings.LBL_PACKAGE_NAME}'{literal});
</script>
{/literal}
{include file='modules/ModuleBuilder/tpls/assistantJavascript.tpl'}