/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
/* HEADER */
// Set module name
var module = "stic_Bookings";
var resourceLineCount = 0;
var resourceMaxCount = 0;

/* INCLUDES */
// Load moment.js to use in validations
loadScript("include/javascript/moment.min.js");

/* VALIDATION DEPENDENCIES */
var validationDependencies = {
    end_date: "start_date",
    start_date: "end_date"
};

/* VALIDATION CALLBACKS */
addToValidateCallback(getFormName(), "end_date", "date", false, SUGAR.language.get(module, "LBL_RESOURCES_END_DATE_ERROR"), function() {
    return JSON.parse(checkStartAndEndDatesCoherence("start_date", "end_date", false));
});
addToValidateCallback(getFormName(), "start_date", "date", false, SUGAR.language.get(module, "LBL_RESOURCES_START_DATE_ERROR"), function() {
    return JSON.parse(checkStartAndEndDatesCoherence("start_date", "end_date", false));
});

addToValidateCallback(getFormName(), "status", "enum", true, SUGAR.language.get(module, "LBL_RESOURCES_STATUS_ERROR"), function() {
    return JSON.parse(isResourceAvailable());
});
addToValidateCallback(
    getFormName(),
    "resource_name0",
    "text",
    false,
    SUGAR.language.get(module, "LBL_RESOURCES_EMPTY_RESOURCES_ERROR"),
    function() {
        return resourceLineWithData(resourceMaxCount) ? true : confirm(SUGAR.language.get(module, "LBL_RESOURCES_EMPTY_RESOURCES_ERROR_DIALOG"));
    }
);

/* VIEWS CUSTOM CODE */
switch (viewType()) {
    case "edit":
    case "quickcreate":
        // Include the resources that are in the booking (will do nothing on quickcreate)
        insertResourceLine();
        resources.map(resource => {
            insertResourceLine();
            populateResourceLine(resource, resourceMaxCount -1);
        });
        // Set event to add more lines in the resources area when needed
        $("#addResourceLine").click(function() {
            insertResourceLine();
        });

        previousStartDateHours = "10";
        previousStartDateMinutes = "00";
        previousEndDateHours = "10";
        previousEndDateMinutes = "30";

        // With all_day checked the DateTime fields shouldn't display the time section 
        // and the end_date should display one day less
        if ($("#all_day", "form").is(":checked")) {
            $("#start_date_hours").val("00");
            $("#start_date_minutes").val("00");
            $("#end_date_hours").val("00");
            $("#end_date_minutes").val("00");
            $("#start_date_hours").change();
            $("#start_date_minutes").change();
            $("#end_date_hours").change();
            $("#end_date_minutes").change();
            $("#start_date_time_section").parent().hide();
            $("#end_date_time_section").parent().hide();
            if ($("#end_date_date").val()) {
                var formatString = cal_date_format
                    .replace(/%/g, "")
                    .toLowerCase()
                    .replace(/y/g, "yy")
                    .replace(/m/g, "mm")
                    .replace(/d/g, "dd");
                endDate = $.datepicker.parseDate(formatString, $("#end_date_date").val());
                endDate.setDate(endDate.getDate() - 1);
                endDateValue = $.datepicker.formatDate(formatString, endDate);
                $("#end_date_date").val(endDateValue);
                $("#end_date_date").change();
            }
        }
        $("#all_day", "form").on("change", function() {
            if ($("#all_day", "form").is(":checked")) {
                previousStartDateHours = $("#start_date_hours").val();
                previousStartDateMinutes = $("#start_date_minutes").val();
                previousEndDateHours = $("#end_date_hours").val();
                previousEndDateMinutes = $("#end_date_minutes").val();
                $("#start_date_hours").val("00");
                $("#start_date_minutes").val("00");
                $("#end_date_hours").val("00");
                $("#end_date_minutes").val("00");
                $("#start_date_hours").change();
                $("#start_date_minutes").change();
                $("#end_date_hours").change();
                $("#end_date_minutes").change();
                $("#start_date_time_section").parent().hide();
                $("#end_date_time_section").parent().hide();
            } else {
                $("#start_date_hours").val(previousStartDateHours);
                $("#start_date_minutes").val(previousStartDateMinutes);
                $("#end_date_hours").val(previousEndDateHours);
                $("#end_date_minutes").val(previousEndDateMinutes);
                $("#start_date_hours").change();
                $("#start_date_minutes").change();
                $("#end_date_hours").change();
                $("#end_date_minutes").change();
                $("#start_date_time_section").parent().show();
                $("#end_date_time_section").parent().show();
            }
        });

        // Set autofill mark beside field label
        setAutofill(["name"]);

        break;

    case "list":
    case "detail":
        break;
    default:
        break;
}

/* AUX FUNCTIONS */

// This function adds rows to the resources table at the bottom of the Editview
function insertResourceLine() {
    ln = 0;
    // If there is any empty line, it won't add more lines
    for (var i = 0; i <= resourceMaxCount; i++) {
        if ($("#resource_id" + i).length && !$("#resource_id" + i).val()) {
            return ln;
        } else if(!$("#resource_id" + i).length) {
            ln = i;
            break;
        }
    }
    
    var x = document.getElementById("resourceLine").insertRow(-1);
    var y = x.insertCell(0);
    var v = x.insertCell(1);
    var z = x.insertCell(2);
    var a = x.insertCell(3);
    var h = x.insertCell(4);
    var b = x.insertCell(5);
    var p = x.insertCell(6);
    var c = x.insertCell(7);

    x.id = "resourceLine" + ln;
    y.className = "dataField ";
    v.className = "dataField resource_code";
    z.className = "dataField resource_status";
    a.className = "dataField resource_type";
    h.className = "dataField resource_color";
    b.className = "dataField resource_hourly_rate hidden-xs hidden-sm";
    p.className = "dataField resource_daily_rate hidden-xs hidden-sm";

    y.innerHTML =
        "<div class='resouce_data_group'> <input type='text' class='sqsEnabled yui-ac-input resouce_data_name' name='resource_name" +
        ln +
        "' id='resource_name" +
        ln +
        "' autocomplete='new-password' value='' title='' tabindex='3' >" +
        "<input type='hidden' name='resource_id[]' id='resource_id" +
        ln +
        "' value=''>" +
        "<span class='id-ff multiple'>" +
        "<button title='" +
        SUGAR.language.get("app_strings", "LBL_SELECT_BUTTON_TITLE") +
        "' type='button' class='button' name='btn_1' onclick='openResourceSelectPopup(" +
        ln +
        ")'>" +
        "<span class='suitepicon suitepicon-action-select'/></span></button>" +
        "<button type='button' name='btn_1' class='button lastChild' onclick='clearRow(this.form," +
        ln +
        ");'>" +
        "<span class='suitepicon suitepicon-action-clear'></span>" +
        "</span></div>";
    v.innerHTML =
        "<div><input class='resource_data resource_code' type='text' name='resource_code" +
        ln +
        "' id='resource_code" +
        ln +
        "' value=''  title='' tabindex='3' readonly='readonly'></div>";
    z.innerHTML =
        "<input class='resource_data resource_status' type='text' name='resource_status" +
        ln +
        "' id='resource_status" +
        ln +
        "' value=''  title='' tabindex='3' readonly='readonly'>";
    a.innerHTML =
        "<input class='resource_data resource_type' type='text' name='resource_type" +
        ln +
        "' id='resource_type" +
        ln +
        "' value=''  title='' tabindex='3' readonly='readonly'>";
    h.innerHTML =
        "<input class='resource_data resource_color' type='text' name='resource_color" +
        ln +
        "' id='resource_color" +
        ln +
        "' tabindex='3' disabled='disabled' readonly='readonly' >";
    b.innerHTML =
        "<input class='resource_data resource_hourly_rate' type='text' name='resource_hourly_rate" +
        ln +
        "' id='resource_hourly_rate" +
        ln +
        "' value=''  title='' tabindex='3' readonly='readonly'>";
    p.innerHTML =
        "<input class='resource_data resource_daily_rate' type='text' name='resource_daily_rate" +
        ln +
        "' id='resource_daily_rate" +
        ln +
        "' value=''  title='' tabindex='3' readonly='readonly'>";
    c.innerHTML =
        "<input type='button' class='button' value='" +
        SUGAR.language.get("app_strings", "LBL_REMOVE") +
        "' tabindex='3' onclick='markResourceLineDeleted(" +
        ln +
        ")'>";

    // This is used to add the autofill functionality in the field. It searches records while writing the record name
    sqs_objects[getFormName() + "_resource_name" + ln] = {
        id: ln,
        form: getFormName(),
        method: "query",
        modules: ["stic_Resources"],
        group: "or",
        field_list: ["name", "id", "code", "color", "status", "type", "hourly_rate", "daily_rate"],
        populate_list: [
            "resource_name" + ln,
            "resource_id" + ln,
            "resource_code" + ln,
            "resource_color" + ln,
            "resource_status" + ln,
            "resource_type" + ln,
            "resource_hourly_rate" + ln,
            "resource_daily_rate" + ln
        ],
        conditions: [
            {
                name: "name",
                op: "like_custom",
                begin: "%",
                end: "%",
                value: ""
            }
        ],
        order: "name",
        limit: "30",
        post_onblur_function: "callbackResourceSelectQS(" + ln + ")",
        no_match_text: "No Match"
    };
    QSProcessedFieldsArray[getFormName() + "_resource_name" + ln] = false;
    enableQS(false);
    addToValidateCallback(getFormName(), "resource_name" + ln, "text", false, SUGAR.language.get(module, "LBL_RESOURCES_ERROR"), function(
        formName,
        resourceElement
    ) {
        return isResourceAvailable(resourceElement.replace("name", "id"));
    });
    resourceMaxCount++;
}

function resourceLineWithData(resourcesCount) {
    for (var i = 0; i <= resourceMaxCount; i++) {
        if ($("#resource_id" + i).length && $("#resource_id" + i).val()) {
            return true;
        }
    }
    return false;
}

// Delete a resource row
function markResourceLineDeleted(ln) {
    $("#resourceLine" + ln).remove();

    if (!resourceLineWithData(resourceMaxCount)) {
        resourceLineCount = insertResourceLine();
    }
}

// Callback function used in the resources popup
function openResourceSelectPopup(ln) {
    var popupRequestData = {
        call_back_function: "callbackResourceSelectPopup",
        passthru_data: {
            ln: ln
        },
        form_name: "EditView",
        field_to_name_array: {
            id: "resource_id",
            name: "resource_name",
            code: "resource_code",
            color: "resource_color",
            status: "resource_status",
            type: "resource_type",
            hourly_rate: "resource_hourly_rate",
            daily_rate: "resource_daily_rate"
        }
    };
    open_popup("stic_Resources", 600, 400, "", true, false, popupRequestData);
}

function callbackResourceSelectQS(ln) {
    if ($("#resource_id" + ln).val()) {
        $("#resource_hourly_rate" + ln).val(myFormatNumber($("#resource_hourly_rate" + ln).val()));
        $("#resource_daily_rate" + ln).val(myFormatNumber($("#resource_daily_rate" + ln).val()));
        $("#resource_color" + ln).colorPicker({ opacity: false });
    }
}

var fromPopupReturn = false;
// callback function used after the Popup that select resources
function callbackResourceSelectPopup(popupReplyData) {
    fromPopupReturn = true;
    var nameToValueArray = popupReplyData.name_to_value_array;
    populateResourceLine(nameToValueArray, popupReplyData.passthru_data.ln);
}

// Fill a resource row with its data
function populateResourceLine(resource, ln) {
    Object.keys(resource).forEach(function(key, index) {
        $("#" + key + ln).val(resource[key]);
    }, resource);
    $("#resource_color" + ln).colorPicker();
}

// Function that asks the server if a resource is available within certain dates
function isResourceAvailable(resourceElement = null) {
    bookingId = $('[name="record"]').val()
        ? $('[name="record"]').val()
        : $(".listview-checkbox", $(".inlineEditActive").closest("tr")).val();
    if ($("#all_day", "form").is(":checked") || getFieldValue("end_date").indexOf(" ") == -1) {
        if (getFieldValue("end_date")) {
            var formatString = cal_date_format.replace(/%/g, "").toLowerCase().replace(/y/g, "yy").replace(/m/g, "mm").replace(/d/g, "dd");
            endDate = $.datepicker.parseDate(formatString, getFieldValue("end_date"));
            endDate.setDate(endDate.getDate() + 1);
            endDateValue = $.datepicker.formatDate(formatString, endDate);
        }
    } else {
        endDateValue = getFieldValue("end_date");
    }
    if (getFieldValue("start_date") && typeof endDateValue !== 'undefined' && endDateValue != '' && getFieldValue("status") != "cancelled") {
        $.ajax({
            url: "index.php?module=stic_Bookings&action=isResourceAvailable&sugar_body_only=true",
            dataType: "json",
            async: false,
            data: {
                startDate: dateToYMDHM(getDateObject(getFieldValue("start_date"))),
                endDate: dateToYMDHM(getDateObject(endDateValue)),
                resourceId: resourceElement ? $("#" + resourceElement).val() : null,
                bookingId: bookingId
            },
            success: function(res) {
                if (res.success) {
                    resourcesAllowed = res.resources_allowed;
                } else {
                    alert("Error in the controller", res);
                }
            },
            error: function() {
                alert("Error send Request");
            }
        });
        if (resourcesAllowed) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}

// Clean a resource row
function clearRow(form, ln) {
    SUGAR.clearRelateField(form, `resource_name` + ln, `resource_id` + ln);
    $(`#resource_code` + ln).val("");
    $(`#resource_color` + ln).val("");
    $(`#resource_status` + ln).val("");
    $(`#resource_type` + ln).val("");
    $(`#resource_hourly_rate` + ln).val("");
    $(`#resource_daily_rate` + ln).val("");
    $("#resource_color" + ln).css("background-color", "");
}
