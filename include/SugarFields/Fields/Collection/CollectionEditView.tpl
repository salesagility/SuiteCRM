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
<link rel="stylesheet" type="text/css" href="include/javascript/yui-old/assets/container.css" />
<script type="text/javascript" src='{sugar_getjspath file="include/SugarFields/Fields/Collection/SugarFieldCollection.js"}'></script>
<script type="text/javascript">
    var collection = (typeof collection == 'undefined') ? new Array() : collection;
    collection['{$displayParams.formName}_{$vardef.name}'] = new SUGAR.collection('{$displayParams.formName}', '{$vardef.name}', '{$module}', '{$displayParams.popupData}');
</script>
<input type="hidden" id="update_fields_{$displayParams.formName}_{$vardef.name}_collection" name="update_fields_{$displayParams.formName}_{$vardef.name}_collection" value="">
<input type="hidden" id="{$displayParams.formName}_{$vardef.name}_new_on_update" name="{$displayParams.formName}_{$vardef.name}_new_on_update" value="{$displayParams.new_on_update}">
<input type="hidden" id="{$displayParams.formName}_{$vardef.name}_allow_update" name="{$displayParams.formName}_{$vardef.name}_allow_update" value="{$displayParams.allow_update}">
<input type="hidden" id="{$displayParams.formName}_{$vardef.name}_allow_new" name="{$displayParams.formName}_{$vardef.name}_allow_new" value="{$displayParams.allow_new}">

{if !empty($vardef.required)}
<input type="hidden" id="{$vardef.name}_field" name="{$vardef.name}_field" value="{$vardef.name}_table">
{/if}
<table name='{$displayParams.formName}_{$vardef.name}_table' id='{$displayParams.formName}_{$vardef.name}_table' style="border-spacing: 0pt;">
        {include file=$cacheRowFile}
        <td valign='top'>
        </td>
<!-- BEGIN Remove and Radio -->
        <td valign='top'>
        	{capture assign=attr}id="remove_{$vardef.name}_collection_0" name="remove_{$vardef.name}_collection_0" onclick="collection['{$displayParams.formName}_{$vardef.name}'].remove('lineFields_{$displayParams.formName}_{$vardef.name}_0');"{/capture}
        	{sugar_getimage name="delete_inline" ext=".gif" attr=$attr}
            {if !empty($displayParams.allowNewValue) }
            <input type="hidden" name="allow_new_value_{$vardef.name}_collection_0" id="allow_new_value_{$vardef.name}_collection_0" value="true">
            {/if}
        </td>
        <td valign='top' align="center">
            <input id="primary_{$vardef.name}_collection_0" type="radio" class="radio" checked="checked" value="0" name="primary_{$vardef.name}_collection" style="{if empty($values.role_field)};display:none;{/if}" onclick="collection['{$displayParams.formName}_{$vardef.name}'].changePrimary(true);" />
        </td>
<!-- END Remove and Radio -->
    </tr>


</table>
<table name='{$displayParams.formName}_{$vardef.name}_add_table' id='{$displayParams.formName}_{$vardef.name}_add_table'>
    <tr>
        <td>
            <a href="javascript:collection['{$displayParams.formName}_{$vardef.name}'].add();">
            {capture assign="attr"}class="img" id="add_{$displayParams.formName}_{$vardef.name}_image" border="0" style="margin-top: 3px;"{/capture}
            [sugar_getimage name="plus_inline" ext=".gif" attr=$attr width="10" height="10"}
            </a>
            <a href="javascript:collection['{$displayParams.formName}_{$vardef.name}'].add();"> Add </a>
        </td>
    </tr>
</table>
{if !empty($values.secondaries)}
            {foreach item=secondary_field from=$values.secondaries key=key}
                <script type="text/javascript">
                    var temp_array = new Array();
                    temp_array['name'] = '{$secondary_field.name}';
                    temp_array['id'] = '{$secondary_field.id}';
                    collection['{$displayParams.formName}_{$vardef.name}'].secondaries_values.push(temp_array);
                </script>
            {/foreach}
{/if}
<script type="text/javascript">
(function() {ldelim}
    var field_id = '{$displayParams.formName}_{$vardef.name}';
    YAHOO.util.Event.onContentReady(field_id + "_table", function(){ldelim}
        collection[field_id].add_secondaries(collection[field_id].secondaries_values});
    {rdelim});
{rdelim})();
 	document.getElementById("id_{$displayParams.formName}_{$vardef.name}_collection_0").value = "{$values.primary.id}";
    document.getElementById("{$displayParams.formName}_{$vardef.name}_collection_0").value = "{$values.primary.name}";
</script>
{/literal}
{$quickSearchCode}