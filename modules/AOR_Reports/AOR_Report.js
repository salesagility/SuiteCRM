/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

$(document).ready(function () {
  $("#download_pdf_button_old").click(function () {
    var _form = addParametersToForm("DownloadPDF");

    var rGraphs = document.getElementsByClassName("resizableCanvas");
    for (var i = 0; i < rGraphs.length; i++) {
      _form.append(
        '<input type="hidden" id="graphsForPDF" name="graphsForPDF[]" value=' +
          rGraphs[i].toDataURL() +
          ">"
      );
    }

    _form.submit();

    $("#formDetailView #graphsForPDF").remove();
  });

  $("#download_csv_button_old").click(function () {
    var _form = addParametersToForm("Export");

    _form.submit();
  });

  $("#updateParametersButton").click(function () {
    var _form = addParametersToForm("DetailView");

    _form.submit();
  });
});

function updateTimeDateFields(fieldInput, ln) {
  // Fix 22_07_12 datetime combo fields
  if (
    $("[name='aor_conditions_value\\[" + ln + "\\]").hasClass("DateTimeCombo")
  ) {
    //Get the dateFormat now embedded in the DOM
    var dateFormat = $("#user_dateFormat").val();
    //Get the separator
    var dateSeparator = dateFormat.match(/[^a-zA-Z\d\s:]/)[0];

    //Get the entered date from the hidden field (time removed)
    var dateTime = fieldInput.substr(0, 10);
    var dateParts = dateTime.split(dateSeparator);

    //Use the dateFormat to create the date
    var dateFormatParts = dateFormat.split(dateSeparator);
    var newDate = new Date();
    for (let i = 0; i < dateFormatParts.length; i++) {
      if (dateFormatParts[i] == "dd") {
        newDate.setDate(dateParts[i]);
      }
      if (dateFormatParts[i] == "mm") {
        newDate.setMonth(dateParts[i] - 1);
      }
      if (dateFormatParts[i] == "yy" || dateFormatParts[i] == "yyyy") {
        newDate.setYear(dateParts[i]);
      }
    }
    var fieldInput = $.datepicker.formatDate("yy-mm-dd", newDate);
  }
  return fieldInput;
}

function appendHiddenFields(_form, ln, id) {
  _form.append(
    '<input type="hidden" name="parameter_id[' + ln + ']" value="' + id + '">'
  );
  var operator = $("#aor_conditions_operator\\[" + ln + "\\]").val();
  _form.append(
    '<input type="hidden" name="parameter_operator[' +
      ln +
      ']" value="' +
      operator +
      '">'
  );
  var fieldType = $("#aor_conditions_value_type\\[" + ln + "\\]").val();
  _form.append(
    '<input type="hidden" name="parameter_type[' +
      ln +
      ']" value="' +
      fieldType +
      '">'
  );

  // Fix 22_07_12 - Updates hidden date fields with date and time
  if (
    $("[name='aor_conditions_value\\[" + ln + "\\]").hasClass("DateTimeCombo")
  ) {
    //Appends hidden date and time
    var fieldInput = $("#aor_conditions_value" + ln).val();
    var fieldInputTime = fieldInput.substr(11, 16);
    debugger;
    fieldInput = updateTimeDateFields(fieldInput, ln);
    _form.append(
      '<input type="hidden" name="parameter_value[' +
        ln +
        ']" value="' +
        fieldInput +
        '">'
    );

    fieldInput = updateTimeDateFields(fieldInput, ln);
    _form.append(
      '<input type="hidden" name="parameter_date_time[' +
        ln +
        ']" value="' +
        fieldInputTime +
        ":00" +
        '">'
    );
  }
}

function addParametersToForm(action) {
  var _form = $("#formDetailView");
  _form.find("input[name=action]").val(action);

  $(".aor_conditions_id").each(function (index, elem) {
    $elem = $(elem);
    var ln = $elem.attr("id").substr(17);
    var id = $elem.val();
    appendHiddenFields(_form, ln, id);
  });
  return _form;
}

function openProspectPopup() {
  var popupRequestData = {
    call_back_function: "setProspectReturn",
    form_name: "EditView",
    field_to_name_array: {
      id: "prospect_id",
    },
  };

  open_popup("ProspectLists", "600", "400", "", true, false, popupRequestData);
}

function setProspectReturn(popup_reply_data) {
  var callback = {
    success: function (result) {
      //report_rel_modules = result.responseText;
      //alert('pass '+result.responseText);
    },
    failure: function (result) {
      //alert('fail '+result.responseText);
    },
  };

  var prospect_id = popup_reply_data.name_to_value_array.prospect_id;
  var record = document.getElementsByName("record")[0].value;

  var form = addParametersToForm("addToProspectList");
  var query = form.serialize();
  YAHOO.util.Connect.asyncRequest(
    "GET",
    "index.php?" + query + "&prospect_id=" + prospect_id,
    callback
  );
}

function changeReportPage(record, offset, group_value, table_id) {
  var paginationButtonCaller = $(this);
  var query =
    "?module=AOR_Reports&action=changeReportPage&record=" +
    record +
    "&offset=" +
    offset +
    "&group=" +
    group_value;
  $(".aor_conditions_id").each(function (index, elem) {
    $elem = $(elem);
    var ln = $elem.attr("id").substr(17);
    var id = $elem.val();
    query += "&parameter_id[]=" + id;
    var operator = $("#aor_conditions_operator\\[" + ln + "\\]").val();
    query += "&parameter_operator[]=" + operator;
    var fieldType = $("#aor_conditions_value_type\\[" + ln + "\\]").val();
    query += "&parameter_type[]=" + fieldType;
    var fieldInput = "";

    // FIX 22_07_12 - checks for DateTimeCombo condition
    if (
      $("[name='aor_conditions_value\\[" + ln + "\\]").hasClass("DateTimeCombo")
    ) {
      // Condition is a date
      var hiddenDateTime = $("#aor_conditions_value" + ln).val();

      // fieldValueTime parameter addded to the query. Referenced in aor_utils.php to add time to date
      var fieldValueTime = hiddenDateTime.substr(11, 5) + ":00";
      query += "&parameter_date_time[]=" + fieldValueTime;

      fieldInput = $("#aor_conditions_value" + ln).val();
      fieldInput = updateTimeDateFields(fieldInput, ln);
    } else {
      fieldInput = $("#aor_conditions_value\\[" + ln + "\\]").val();
    }
    query += "&parameter_value[]=" + fieldInput;
  });

  $.get(query).done(function (data) {
    $("#report_table_" + table_id + group_value).replaceWith(data);
  });
}
