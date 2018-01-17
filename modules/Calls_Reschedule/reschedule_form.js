/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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

function get_form() {


  var id = document.getElementsByName('record')[0];
  var form = '';
  var titleval = SUGAR.language.get('app_strings', 'LBL_RESCHEDULE_LABEL');

  var callback = {

    success: function (result) {

      form = result.responseText;

      var dialog = new YAHOO.widget.Dialog('dialog1', {
        width: '400px',
        fixedcenter: "contained",
        visible: false,
        draggable: true,
        modal: true
      });

      dialog.setHeader(titleval);
      dialog.setBody(form);

      var handleCancel = function () {
        this.cancel();

      };
      var handleSubmit = function () {

        var date_box = dialog.getData().date;
        var reason_box = dialog.getData().reason;
        var hours = dialog.getData().date_start_hours;
        var mins = dialog.getData().date_start_minutes;
        var format = dialog.getData().format;
        var dateformat = dialog.getData().dateformat;
        var ampm = dialog.getData().date_start_meridiem;
        var username = dialog.getData().user;

        //basic validation
        if ((date_box == '' && reason_box == '') || (reason_box == '' && !isDate(date_box))) {

          document.getElementById('error1').style.display = "";
          document.getElementById('error2').style.display = "";

        } else if (date_box == '' || !isDate(date_box)) {

          document.getElementById('error1').style.display = "";
          document.getElementById('error2').style.display = "none";

        }
        else if (reason_box == '') {

          document.getElementById('error1').style.display = "none";
          document.getElementById('error2').style.display = "";

        }
        else {

          this.submit();
          update(date_box, reason_box, hours, mins, format, dateformat, ampm, username);
        }

      };

      var save = SUGAR.language.get('Calls', 'LBL_SAVE');
      var cancel = SUGAR.language.get('Calls', 'LBL_CANCEL');
      var myButtons = [{text: save, handler: handleSubmit, isDefault: true},
        {text: cancel, handler: handleCancel}];

      dialog.cfg.queueProperty("buttons", myButtons);
      dialog.render(document.body);
      dialog.show();

      document.getElementById('call_id').value = id.value;

      var manageCalendar = function () {
          if(YAHOO.widget.Calendar) {
              Calendar.setup ({
                  inputField : 'date',
                  ifFormat : cal_date_format,
                  daFormat : '%m/%d/%Y %I:%M%P',
                  button : 'date_start_trigger',
                  singleClick : true,
                  step : 1,
                  weekNumbers: false,
                  startWeekday: 0
              });
          }
      };

      document.getElementById('date_start_trigger').addEventListener('click', manageCalendar);
      SUGAR.util.evalScript(document.getElementById('script').innerHTML);
    }

  };

  YAHOO.util.Connect.asyncRequest("GET", "index.php?entryPoint=Reschedule&call_id=" + id.value, callback);

//Updates date/time field on page
  function update(date_box, reason_box, hours, mins, format, dateFormat, ampm, username) {

//used to update the history list
    var currentDate = new Date();
    var Year = currentDate.getFullYear();
    var Month = currentDate.getMonth() + 1;
    var Day = currentDate.getDate();
    var Hours = currentDate.getHours();
    var Minutes = currentDate.getMinutes();
    var date;
    var time;
    var time2;

    Month = Month < 10 ? "0" + Month : Month; // get 2 digit months
    Day = Day < 10 ? "0" + Day : Day; // get 2 digit days
    Hours = Hours < 10 ? "0" + Hours : Hours; // get 2 digit hours
    Minutes = Minutes < 10 ? "0" + Minutes : Minutes; // get 2 digit Minutes

//convert to 12 hour format (am/pm)
    var h = Hours;
//determine if 12 hour format should user Capitals for am/pm or not
    if (format == '11:00pm' || format == '11:00 pm' || format == '11.00pm' || format == '11.00 pm') {
      var d = 'am';

      if (h >= 12) {
        h = Hours - 12;
        d = 'pm';

      }

      if (h == 0) {
        h = 12;
      }

    }
    else {//set am/pm to uppercase
      var d = 'AM';

      if (h >= 12) {
        h = Hours - 12;
        d = 'PM';

      }

      if (h == 0) {
        h = 12;
      }

    }

    h = h < 10 ? "0" + h : h; // get 2 digit hours

//set dateFormat
    if (dateFormat == 'Y-m-d') {

      date = Year + '-' + Month + '-' + Day;
    }
    else if (dateFormat == 'm-d-Y') {

      date = Month + '-' + Day + '-' + Year;
    }
    else if (dateFormat == 'd-m-Y') {

      date = Day + '-' + Month + '-' + Year;
    }
    else if (dateFormat == 'Y/m/d') {

      date = Year + '/' + Month + '/' + Day;
    }
    else if (dateFormat == 'm/d/Y') {

      date = Month + '/' + Day + '/' + Year;
    }
    else if (dateFormat == 'd/m/Y') {

      date = Day + '/' + Month + '/' + Year;
    }
    else if (dateFormat == 'Y.m.d') {

      date = Year + '.' + Month + '.' + Day;
    }
    else if (dateFormat == 'm.d.Y') {

      date = Month + '.' + Day + '.' + Year;
    }
    else if (dateFormat == 'd.m.Y') {

      date = Day + '.' + Month + '.' + Year;
    }

//set time format
    if (format == '23.00') {

      time = hours + '.' + mins;//the time for updating the scheduled call start time
      time2 = Hours + '.' + Minutes; //the time for updating the history list

    }
    else if (format == '23:00') {

      time = hours + ':' + mins;
      time2 = Hours + ':' + Minutes;

    }
    else if (format == '11:00pm' || format == '11:00PM') {

      time = hours + ':' + mins + ampm;
      time2 = h + ':' + Minutes + d;

    }
    else if (format == '11:00 pm' || format == '11:00 PM') {

      time = hours + ':' + mins + ' ' + ampm;
      time2 = h + ':' + Minutes + ' ' + d;

    }
    else if (format == '11.00pm' || format == '11.00PM') {

      time = hours + '.' + mins + ampm;
      time2 = h + '.' + Minutes + d;
    }
    else if (format == '11.00 pm' || format == '11.00 PM') {

      time = hours + '.' + mins + ' ' + ampm;
      time2 = h + '.' + Minutes + ' ' + d;
    }


//update call start time
    document.getElementById('date_start').innerHTML = date_box + ' ' + time;

//update call attempt history
    var list = document.getElementById('history_list');
    var new_element = document.createElement('li');
    var call_reschedule_dom = SUGAR.language.languages.app_list_strings['call_reschedule_dom'];
    new_element.innerHTML = call_reschedule_dom[reason_box] + ' - ' + date + ' ' + time2 + ' by: ' + username;
    list.insertBefore(new_element, list.firstChild);
  }

}
