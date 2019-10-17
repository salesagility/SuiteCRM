{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
 *}

{{if $fieldCount < $smarty.foreach.colIteration.total && $addressCount < 1 && !empty($colData.field.name) && empty($colData.field.hideIf)}}
    {{if !empty($colData.field.hideLabel) && $colData.field.hideLabel == true}}
    {*hide label*}
    {{else}}

    {*<!-- LABEL -->*}
    {{if $smarty.foreach.colIteration.total > 1 && $colData.colspan != 3}}
        <div class="col-xs-12 col-sm-4 label" data-label="{{$fields[$colData.field.name].vname}}">
    {{else}}
         <div class="col-xs-12 col-sm-2 label" data-label="{{$fields[$colData.field.name].vname}}">
    {{/if}}

            {{include file='themes/SuiteP/include/EditView/tab_panel_content/field/label.tpl'}}

        </div>
    {{/if}}

    {*<!-- VALUE -->*}
    {{if !empty($colData.field.hideLabel) && $colData.field.hideLabel == true && $colData.colspan != 3}}
        {{assign var="fieldClasses" value="col-xs-12 col-sm-12"}}
    {{else}}
        {{assign var="fieldClasses" value="col-xs-12 col-sm-8"}}
    {{/if}}

    <div class="{{$fieldClasses}} edit-view-field {{if $inline_edit && !empty($colData.field.name) && ($fields[$colData.field.name].inline_edit == 1 || !isset($fields[$colData.field.name].inline_edit))}}inlineEdit{{/if}}" type="{{$fields[$colData.field.name].type}}" field="{{$fields[$colData.field.name].name}}" {{if $colData.colspan}}colspan='{{$colData.colspan}}'{{/if}} {{if isset($fields[$colData.field.name].type) && $fields[$colData.field.name].type == 'phone'}}class="phone"{{/if}}>

        {{include file='themes/SuiteP/include/EditView/tab_panel_content/field/value_edit.tpl'}}

    </div>
{{else}}

{{/if}}

{{if $inline_edit && !empty($colData.field.name) && ($fields[$colData.field.name].inline_edit == 1 || !isset($fields[$colData.field.name].inline_edit))}}<div class="inlineEditIcon col-xs-1">
    {sugar_getimage name="inline_edit_icon.svg" attr='border="0" ' alt="$alt_edit"}
    </div>
{{/if}}

{*Field Exceptions*}
{{if !empty($colData.field.type)}}
    {{if $colData.field.type == 'address'}}
         {{counter name="addressCount" print=false}}
    {{/if}}
{{/if}}
