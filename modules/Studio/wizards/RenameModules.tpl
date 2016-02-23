{*

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 ********************************************************************************/




*}


{literal}
<style type='text/css'>
    .slot
    {
        border-width:1px;border-color:#999999;border-style:solid;padding:0px 1px 0px 1px;margin:2px;cursor:move;
    }

    .slotB
    {
        border-width:0;cursor:move;
    }
    div.moduleTitle
    {
        margin-bottom: 5px;
    }
</style>
{/literal}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
           {$title}
<table cellspacing="2">
    <tr>
        <td colspan="3">{$MOD.LBL_RENAME_MOD_SAVE_HELP}</td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td colspan="3">
            <input type="button" class="button primary" value="{$MOD.LBL_BTN_SAVE}" id="renameSaveBttn" onclick='validateForm();'name="{$MOD.LBL_BTN_SAVE}" />
            <input type="button" class="button" value="{$MOD.LBL_BTN_CANCEL}"  id="renameCancelBttn" name="{$MOD.LBL_BTN_CANCEL}" onclick="document.editdropdown.action.value='index'; document.editdropdown.module.value='Administration';document.editdropdown.submit()" />
        </td>
    </tr>
</table>
<div style="height:10px">&nbsp;</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class='edit view' >
<tr>
    <td>
        <span class='error'>{$error}</span>
        <table>
            <tr>
                <td colspan='2'>
                    <form method='post' action='index.php' name='dropdownsform'>
                        <input type='hidden' name='action' value='wizard'>
                        <input type='hidden' name='wizard' value='RenameModules'>
                        <input type='hidden' name='option' value='EditDropdown'>
                        <input type='hidden' name='module' value='Studio'>
                        <input type='hidden' name='dropdown_name' value='{$dropdown_name}'>
                        {$MOD.LBL_TABGROUP_LANGUAGE} &nbsp;
                        {html_options name='dropdown_lang' options=$dropdown_languages selected=$dropdown_lang onchange="document.dropdownsform.submit();"}
                        {sugar_help text=$MOD.LBL_LANGUAGE_TOOLTIP}
                    </form>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
<form method='post' action='index.php' name='editdropdown'>
<input type='hidden' name='action' value='wizard'>
<input type='hidden' name='wizard' value='RenameModules'>
<input type='hidden' name='option' value='SaveDropDown'>
<input type='hidden' name='module' value='Studio'>
<input type='hidden' name='dropdown_lang' value='{$dropdown_lang}'>
<input type='hidden' name='dropdown_name' value='moduleList'>

<table name='tabDropdown' id='tabDropdown'>

{counter start=0 name="rowCounter" print=false assign="rowCounter"}
{foreach from=$dropdown item="value" key="key"}
<tr>
    <td>
        <span id='slot{$rowCounter}b' >
            <span onclick='prepChangeDropDownValue({$rowCounter}, document.getElementById("slot{$rowCounter}_value"));'>{$editImage}</span>
            &nbsp;
            <span id ='slot{$rowCounter}_value' onclick='prepChangeDropDownValue({$rowCounter}, this);'>{$value.lang}</span>
            <span id='slot{$rowCounter}_textspan' style='display:none;'>{$value.user_lang}
                <table style="margin-left:15px;">
                    <tr>
                        <td align="right">{$MOD.LBL_SINGULAR}</td>
                        <td align="left"><input id='slot{$rowCounter}_stext' value='{$value.singular}' onchange='setSingularDropDownValue({$rowCounter});' type='text'></td>
                    </tr>
                    <tr>
                        <td align="right">{$MOD.LBL_PLURAL}</td>
                        <td align="left"><input id='slot{$rowCounter}_text' value='{$value.lang}' type='text'  onchange='setDropDownValue({$rowCounter}, this.value, true)' ></td>
                    </tr>
                </table>
                <input name='slot_{$rowCounter}' id='slot_{$rowCounter}' value='{$rowCounter}' type = 'hidden'>
                <input type='hidden' name='key_{$rowCounter}' id='key_{$rowCounter}' value='{$key|default:"BLANK"}'>
                <input type='hidden' id='delete_{$rowCounter}' name='delete_{$rowCounter}' value='0'>
                <input type='hidden' id='slot{$rowCounter}_key' name='slot{$rowCounter}_key' value='{$key}'>
                <input name='value_{$rowCounter}' id='value_{$rowCounter}' value='{$value.lang}' type = 'hidden'>
                <input name='svalue_{$rowCounter}' id='svalue_{$rowCounter}' value='{$value.singular}' type = 'hidden'>
            </span>
        </span>
    </td>
</tr>
{counter name="rowCounter"}
{/foreach}

</table>
</table>

{sugar_getscript file="include/javascript/yui/build/dragdrop/dragdrop-min.js"}
{literal}
<script>

    var lastField = '';
    var lastRowCount = -1;
    var inputsWithErrors = [];
    function prepChangeDropDownValue(rowCount, field)
    {
        var tempLastField = lastField;
        if(lastRowCount != -1)
        {
            //Check for validation errors first
            if(checkForErrors(lastRowCount))
                return true;

            collapseRow(lastRowCount);
        }
        if(tempLastField == field)
            return;
        lastField = field;
        lastRowCount = rowCount;

        field.style.display="none";

        var textspan =  document.getElementById('slot' + rowCount + '_textspan');
        var text = document.getElementById("slot" + rowCount + "_text");
        textspan.style.display='inline'
        text.focus();
    }

    function checkForErrors(rowCount)
    {
        var foundErrors = false;
        var el1 = document.getElementById("slot" + rowCount + "_text");
        var el2 = document.getElementById("slot" + rowCount + "_stext");

        if( YAHOO.lang.trim(el1.value) == "")
        {
            add_error_style('editdropdown', el1, SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS'),true);
            foundErrors = true;
        }
        if( YAHOO.lang.trim(el2.value) == "")
        {
            add_error_style('editdropdown', el2, SUGAR.language.get('app_strings', 'ERR_MISSING_REQUIRED_FIELDS'),true);
            foundErrors = true;
        }

        return foundErrors;
    }

    /*
        scrub input for bug 50607: able to enter HTML/JS and execute through module renaming.
     */
    function cleanModuleName(val)
    {
        return YAHOO.lang.escapeHTML(val);
    }

    /*
        pulled out routine to keep scrubbing from being called multiple times
     */
    function collapseRow(rowCount)
    {
        var text =  document.getElementById('slot' + rowCount + '_text');
        var textspan =  document.getElementById('slot' + rowCount + '_textspan');
        var span = document.getElementById('slot' + rowCount + '_value');
        textspan.style.display = 'none';
        span.style.display = 'inline';
        lastField = '';
        lastRowCount = -1;
    }

    function setSingularDropDownValue(rowCount)
    {
        document.getElementById('svalue_'+ rowCount).value = document.getElementById('slot' + rowCount + '_stext').value;
    }

    function setDropDownValue(rowCount, val, collapse)
    {
        //Check for validation errors first
        if(checkForErrors(rowCount))
            return true;

        document.getElementById('value_' + rowCount).value = val;

        var span = document.getElementById('slot' + rowCount + '_value');
        if(collapse)
        {
            span.innerHTML  = cleanModuleName(val);
            collapseRow(rowCount);
        }

        setSingularDropDownValue(rowCount);
    }

    var slotCount = {/literal}{$rowCounter}{literal};
    var yahooSlots = [];

    function validateForm()
    {
        for(i=0;i<slotCount;i++)
        {
            if( checkForErrors(i) )
            {
                //Highlight dropdown value if we find an error.
                prepChangeDropDownValue(i,  document.getElementById("slot"+i+"_value"));
                return;
            }
        }

        if(check_form("editdropdown"))
        {
            document.editdropdown.submit();
        }

    }
</script>
{/literal}


<div id='logDiv' style='display:none'>
</div>

<input type='hidden' name='use_push' value='1'>
</form>
</td></tr>
</table>