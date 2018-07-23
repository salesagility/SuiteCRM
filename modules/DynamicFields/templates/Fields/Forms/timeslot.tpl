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
{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}
{literal}
<script language="Javascript">
  function timeValueUpdate(){
    var fieldname = 'defaultTime';
    var timeseparator = ':';
    var newtime = '';

    id = fieldname + '_hours';
    h = window.document.getElementById(id).value;
    id = fieldname + '_minutes';
    m = window.document.getElementById(id).value;
    if( h == "" && m == "" ){
      document.getElementById('val'+fieldname).value="ok";
    } else {
      document.getElementById('val'+fieldname).value="";
    }
    if( h == "" || m == "" ){
      document.getElementById(fieldname).value="";
      return;
    }
    if( h == "23" && m == "59" ){
      s=60;
    } else {
      s=0;
    }
    newtime = (((parseInt(h,10)*60)+parseInt(m,10))*60)+s;
    document.getElementById(fieldname).value = newtime;
    document.getElementById('val'+fieldname).value="ok";
}
</script>
{/literal}
<tr>
  <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MINUTE_HELP_TEXT"}:</td>
  <td>{if $hideLevel < 5 }<input type="text" name="ext4" value="{$help_minute}">{else}<input type="hidden" name="ext4" value="{$help_minute}">{$help_minute}{/if}
  </td>
</tr>
<tr>
  <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td>
  <td>
    {if $hideLevel < 5}
      <div style='padding:0px'>{html_options name='defaultHours' size='1' id='defaultTime_hours' options=$default_hours_values onchange="timeValueUpdate();"  selected=$default_hours} : 
        {html_options  name='defaultMinutes' size='1'  id='defaultTime_minutes' options=$default_minutes_values onchange="timeValueUpdate();"  selected=$default_minutes}
      </div>
      <input type='hidden' name='defaultTime' id='defaultTime' value="{$defaultTime}">
      <input type='hidden' name='valdefaultTime' id='valdefaultTime' value="{$valdefaultTime}">
    {else}
      <input type='hidden' name='defaultTime' id='defaultTime' value='{$defaultTime}'>{$defaultTime}
    {/if}
  </td>
</tr>
<tr>
  <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_MASS_UPDATE"}:</td>
  <td>
    {if $hideLevel < 5}
       <input type="checkbox" id="massupdate" name="massupdate" value="1" {if !empty($vardef.massupdate)}checked{/if}/>
    {else}
       <input type="checkbox" id="massupdate" name="massupdate" value="1" disabled {if !empty($vardef.massupdate)}checked{/if}/>
    {/if}
  </td>
</tr>
{if $hideLevel < 5}
  <script>
    addToValidateComposeField('popup_form', "valdefaultTime", "timeslot", false, "Timeslot");
    addRequireFieldToComposeField('popup_form', "valdefaultTime", "defaultTime_hours", "timeslot", "{$APP.LBL_HOURS}");
    addRequireFieldToComposeField('popup_form', "valdefaultTime", "defaultTime_minutes", "timeslot", "{$APP.LBL_MINUTES}");
  </script>
{/if}
{include file="modules/DynamicFields/templates/Fields/Forms/coreBottom.tpl"}
