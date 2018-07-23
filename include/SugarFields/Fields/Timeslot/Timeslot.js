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
function Timeslot(timeval, field, timeformat, tabindex, helphour, helpminute) {
  this.timeval = timeval;
  if (typeof this.timeval == "undefined") {
    this.timeval = "";
  }
  this.fieldname = field;
  this.helph = helphour;
  this.helpm = helpminute;
  if (this.timeval == "") {
    this.mins = 61;
    this.hrs = 24;
  } else {
    v = parseInt(timeval, 10);
    if (v == 86400) {
      this.hrs = 23;
      this.mins = 59;
    } else {
      this.mins = v % 3600;
      this.hrs = (v - this.mins) / 3600;
      this.mins = Math.floor(this.mins / 60);
    }
  }
  this.timeformat = timeformat;
  this.tabindex = tabindex == null || isNaN(tabindex) ? 1 : tabindex;
  this.timeseparator = ":";
}
Timeslot.prototype.html = function (callback) {
  var text = '<select title="' + this.helph + '" class="datetimecombo_time" size="1" id="' + this.fieldname + '_hours" tabindex="' + this.tabindex + '" onchange="combo_' + this.fieldname + '.update(); ' + callback + '">';
  text += '<option></option>';
  for (i = 0; i <= 23; i++) {
    val = i < 10 ? "0" + i : i;
    text += '<option value="' + val + '" ' + (i == this.hrs ? "SELECTED" : "") + '>' + val + '</option>';
  }
  text += '\n</select>&nbsp;';
  text += this.timeseparator;
  text += '\n&nbsp;<select title="' + this.helpm + '" class="datetimecombo_time" size="1" id="' + this.fieldname + '_minutes" tabindex="' + this.tabindex + '" onchange="combo_' + this.fieldname + '.update(); ' + callback + '">';
  text += '\n<option></option>';
  for (i = 0; i <= 59; i++) {
    val = i < 10 ? "0" + i : i;
    text += '<option value="' + val + '" ' + (i == this.mins ? "SELECTED" : "") + '>' + val + '</option>';
  }
  text += '\n</select>';
  return text;
};
Timeslot.prototype.update = function () {
  id = this.fieldname + '_hours';
  h = window.document.getElementById(id).value;
  id = this.fieldname + '_minutes';
  m = window.document.getElementById(id).value;
  if( h == "" && m == "" ){
    document.getElementById('val_'+this.fieldname).value="ok";
  } else {
    document.getElementById('val_'+this.fieldname).value="";
  }
  if (h == "" || m == "") {
    document.getElementById(this.fieldname).value = "";
    return;
  }
  if (h == "23" && m == "59") {
    s = 60;
  } else {
    s = 0;
  }
  newdate = (((parseInt(h, 10) * 60) + parseInt(m, 10)) * 60) + s;
  document.getElementById(this.fieldname).value = newdate;
  document.getElementById('val_'+this.fieldname).value="ok";
};
