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
{{capture name=idname assign=idname}}{{sugarvar key='name'}}{{/capture}}
{{if !empty($displayParams.idName)}}
  {{assign var=idname value=$displayParams.idName}}
{{/if}}
{{assign var=flag_field value=$vardef.name|cat:_flag}}
<table border="0" cellpadding="0" cellspacing="0">
  <tr valign="middle">
    <td nowrap>
      <div id="{{$idname}}_time"></div>
    </td>
  </tr>
</table>
{{if !empty($displayParams.originalFieldName)}}
  <input type="hidden" class="DateTimeCombo TimeSlot" id="{{$idname}}" name="{{$displayParams.originalFieldName}}" value="{$fields[{{sugarvar key='name' stringFormat=true}}].value}">
{{else}}
  <input type="hidden" class="DateTimeCombo TimeSlot" id="{{$idname}}" name="{{$idname}}" value="{$fields[{{sugarvar key='name' stringFormat=true}}].value}">
{{/if}}

<input type="hidden" id="val_{{$idname}}" name="val_{{$idname}}" value="ok">
<script type="text/javascript" src="include/SugarFields/Fields/Timeslot/Timeslot.js"></script>
<script type="text/javascript">
  var combo_{{$idname}} = new Timeslot("{$fields[{{sugarvar key='name' stringFormat=true}}].value}", "{{$idname}}", "{$TIME_FORMAT}", "{{$tabindex}}", "{{$vardef.help}}", "{{$vardef.help_minute}}");
  text = combo_{{$idname}}.html('{{$displayParams.updateCallback}}');
  document.getElementById('{{$idname}}_time').innerHTML = text;
  {{if !empty($displayParams.addValidate)}}
     addToValidateComposeField('{$form_name}', "val_{{$idname}}", 'timeslot', false, "{{$displayParams.label}}" );
     addRequireFieldToComposeField('{$form_name}', "val_{{$idname}}", "{{$idname}}_hours", 'timeslot',  "{$APP.LBL_HOURS}" );
     addRequireFieldToComposeField('{$form_name}', "val_{{$idname}}", "{{$idname}}_minutes", 'timeslot',  "{$APP.LBL_MINUTES}" );
  {{/if}}
</script>

<script type="text/javascript">
  function update_{{$idname}}_available() {ldelim}
    YAHOO.util.Event.onAvailable("{{$idname}}_time_hours", this.handleOnAvailable, this);
  {rdelim}

  update_{{$idname}}_available.prototype.handleOnAvailable = function(me) {ldelim}
    combo_{{$idname}}.update();
  {rdelim}

  var obj_{{$idname}} = new update_{{$idname}}_available();
</script>
