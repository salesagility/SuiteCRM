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


<div>&nbsp;</div>
{{assign var="selectRelation" value=$selectFields[$module]}}
<span class="color">{$ERROR}</span>
{{foreach name=section from=$sectionPanels key=label item=panel}}
{{counter name="panelCount" print=false}}
<div class="edit-view-row-item">
                <input type="hidden" name="convert_create_{{$module}}" id="convert_create_{{$module}}"
                        {if ($def.required && empty($def.select)) || (!empty($def.default_action) && $def.default_action == "create")} value="true" {/if}/>

                {{if isset($def.templateMeta.form.hidden)}}
                {{foreach from=$def.templateMeta.form.hidden item=field}}
                {{$field}}
                {{/foreach}}
                {{/if}}
                {if $def.required }
                    <script type="text/javascript">
                        mod_array.push('{{$module}}');//Bug#50590 add all required modules to mod_array
                    </script>
                {/if}
                {if !$def.required || !empty($def.select)}
                <input class="checkbox" type="checkbox" name="new{{$module}}" id="new{{$module}}"
                       onclick="toggleDisplay('create{{$module}}');if (typeof(addRemoveDropdownElement) == 'function') addRemoveDropdownElement('{{$module}}');{if !empty($def.select)}toggle{{$module}}Select();{/if}">
                <script type="text/javascript">
                    {{if !empty($selectRelation)}}
                    {if !empty($def.select)}
                    toggle{{$module}}Select = function () {ldelim}
                        var inputs = document.getElementById('select{{$module}}').getElementsByTagName('input');
                        for (var i in inputs) {
                            ldelim}inputs[i].disabled = !inputs[i].disabled;{rdelim}
                    var buttons = document.getElementById('select{{$module}}').getElementsByTagName('button');
                    for (var i in buttons) {
                        ldelim}buttons[i].disabled = !buttons[i].disabled;{rdelim}
                    {rdelim}
                    {/if}
                    {{/if}}
                    {if !empty($def.default_action) && $def.default_action == "create"}
                    {if $lead_conv_activity_opt == 'move' || $lead_conv_activity_opt == 'copy' || $lead_conv_activity_opt == ''}
                    YAHOO.util.Event.onContentReady('lead_conv_ac_op_sel', function () {ldelim}
                        {else}
                        YAHOO.util.Event.onContentReady('create{{$module}}', function () {ldelim}
                            {/if}
                            toggleDisplay('create{{$module}}');
                            document.getElementById('new{{$module}}').checked = true;
                            if (typeof(addRemoveDropdownElement) == 'function')
                                addRemoveDropdownElement('{{$module}}');
                            {{if !empty($selectRelation)}}
                            {if !empty($def.select)}
                            toggle{{$module}}Select();
                            {/if}
                            {{/if}}
                            {rdelim});
                    {/if}
                    {/if}
                </script>

                {sugar_translate label='{{$label}}' module='Leads'}

                {{if !empty($selectRelation)}}
                {if !empty($def.select)}
                {sugar_translate label='LNK_SELECT_{{$module|strtoupper}}' module='Leads'}
                {if $def.required }
                    <span class="required">{{$APP.LBL_REQUIRED_SYMBOL}}</span>
                {/if}

            <span id="select{{$module}}">
                {{sugar_field parentFieldArray='contact_def' vardef=$contact_def[$selectRelation] displayType='EditView' displayParams=$displayParams formName=$form_name call_back_function='set_return_lead_conv'}}
                <script>
                    if (typeof(sqs_objects) == "undefined") sqs_objects = [];
                    sqs_objects['{{$form_name}}_{$selectFields.{{$module}}}'] = {ldelim}
                        form: '{{$form_name}}',
                        method: 'query',
                        modules: ['{{$module}}'],
                        group: 'or',
                        field_list: ['name', 'id'],
                        populate_list: ['{$selectFields.{{$module}}}', '{$contact_def[$selectFields.{{$module}}].id_name}'],
                        conditions: [{ldelim}'name': 'name', 'op': 'like', 'end': '%', 'value': ''{rdelim}],
                        required_list: ['{$contact_def[$selectFields.{{$module}}].id_name}'],
                        order: 'name',
                        limit: '10'
                        {rdelim}
                </script>
                {/if}
                {{/if}}
            </span>
</div>
<div class=""
      id="create{{$module}}"
       {if !$def.required || !empty($def.select)}style="display:none"{/if}>
    {{assign var='rowCount' value=0}}
    {{foreach name=rowIteration from=$panel key=row item=rowData}}
    {{assign var='columnsInRow' value=$rowData|@count}}
    {{assign var='columnsUsed' value=0}}



        {{* Loop through each column and display *}}
        {{counter name="colCount" start=0 print=false assign="colCount"}}
    {*column*}
    {{if $smarty.foreach.colCount.total > 1}}
        <div class="col-xs-12 col-sm-6 edit-view-row-item">
      {{else}}
        <div class="col-xs-12 col-sm-12 edit-view-row-item">
    {{/if}}


        {{foreach name=colIteration from=$rowData key=col item=colData}}

        {{if $smarty.foreach.colCount.total > 1}}
        <div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
        {{else}}
        <div class="edit-view-field col-xs-12 col-sm-12 col-md-6 col-lg-6">
        {{/if}}

            {{counter name="colCount" print=false}}
            {{if count($rowData) == $colCount}}
            {{assign var="colCount" value=0}}
            {{/if}}
            {{if empty($def.templateMeta.labelsOnTop) && empty($colData.field.hideLabel)}}
            <div valign="top" id='{{$colData.field.name}}_label'
                scope="row" class="col-xs-12 col-sm-12 label" >
                {{if isset($colData.field.customLabel)}}
                {{$colData.field.customLabel}}
                {{elseif isset($colData.field.label)}}
                {capture name="label" assign="label"}
                    {sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}
                {/capture}
                {$label|strip_semicolon}:
                {{elseif isset($fields[$colData.field.name])}}
                {capture name="label" assign="label"}
                    {sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}
                {/capture}
                {$label|strip_semicolon}:
                {{/if}}
                {{* Show the required symbol if field is required, but override not set.  Or show if override is set *}}
                {{if ($fields[$colData.field.name].required && !isset($colData.field.displayParams.required)) ||
                (isset($colData.field.displayParams.required) && $colData.field.displayParams.required)}}
                <span class="required">{{$APP.LBL_REQUIRED_SYMBOL}}</span>
                {{/if}}
            </div>
            {{/if}}
            <div valign="top"
                {{if $colData.colspan}}colspan='{{$colData.colspan}}'{{/if}} class=" col-xs-12 col-sm-8 edit-view-field pad-bottom">
                {{if $fields[$colData.field.name] && !empty($colData.field.fields) }}
                {{foreach from=$colData.field.fields item=subField}}
                {{if $fields[$subField.name]}}
                {counter name="panelFieldCount" print=false}
                {{sugar_field parentFieldArray='fields' tabindex=$colData.field.tabindex vardef=$fields[$subField.name] displayType='EditView' displayParams=$subField.displayParams formName=$form_name}}
                &nbsp;
                {{/if}}
                {{/foreach}}
                {{elseif !empty($colData.field.customCode)}}
                {counter name="panelFieldCount" print=false}
                {{php}}$this->_tpl_vars['colData']['field']['displayParams']['idName'] = $this->_tpl_vars['module'] .
                $this->_tpl_vars['colData']['field']['name'];{{/php}}
                {{sugar_evalcolumn var=$colData.field.customCode colData=$colData tabindex=$colData.field.tabindex}}
                {{elseif $fields[$colData.field.name]}}
                {counter name="panelFieldCount" print=false}
                {{$colData.displayParams}}
                {{php}}$this->_tpl_vars['colData']['field']['displayParams']['idName'] = $this->_tpl_vars['module'] .
                $this->_tpl_vars['colData']['field']['name'];{{/php}}
                {{sugar_field parentFieldArray='fields' tabindex=$colData.field.tabindex vardef=$fields[$colData.field.name] displayType='EditView' displayParams=$colData.field.displayParams typeOverride=$colData.field.type formName=$form_name}}
                {{/if}}
            </div>
        </div>
        {{/foreach}}
    </div>

    {{/foreach}}
</div>
{{/foreach}}