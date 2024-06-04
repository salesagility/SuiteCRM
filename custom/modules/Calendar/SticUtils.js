/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */
// It shows or hide the Cross button that remove the filters
if ($('#applied_filters').val()) {
    $('#cross_filters').show();
} else {
    $('#cross_filters').hide();
}

// Removes all filters and submit changes
function handleCrossRemoveFilters() 
{
    for (var key in relatedFilters) {
        clearRow(document.getElementById('form_filters'), relatedFilters[key].elementId);
    }
    fieldFilters.map((key) => {
        document.getElementById(key).innerHTML = "";
        document.getElementById(key).value = "";
    });
    $('#form_filters').submit();
}

// Clears a single filter, name and id fields
function clearRow(form, field) {
    SUGAR.clearRelateField(form, field + '_name', field + '_id');
}

fieldFilters = [
    'stic_sessions_color',
    'stic_sessions_activity_type',
    'stic_sessions_stic_events_type',
    'stic_followups_color',
    'stic_followups_type',
    'stic_work_calendar_type',
    'stic_work_calendar_assigned_user_department',
];

// Filters array
relatedFilters = {
    'stic_Sessions_stic_Events': {
        elementId: 'stic_sessions_stic_events',
        module: 'stic_Events',
    },
    'stic_Sessions_stic_Centers': {
        elementId: 'stic_sessions_stic_centers',
        module: 'stic_Centers',
    },
    'stic_Sessions_responsible': {
        elementId: 'stic_sessions_responsible',
        module: 'Contacts',
    },
    'stic_Sessions_Contacts': {
        elementId: 'stic_sessions_contacts',
        module: 'Contacts',
    },
    'stic_Sessions_Project': {
        elementId: 'stic_sessions_projects',
        module: 'Project',
    },
    'stic_FollowUps_Contacts': {
        elementId: 'stic_followups_contacts',
        module: 'Contacts',
    },
    'stic_FollowUps_Project': {
        elementId: 'stic_followups_projects',
        module: 'Project',
    } 
};

// The SQS functions add the autocompletion functionality for the related input records
if(typeof sqs_objects == 'undefined'){
    var sqs_objects = new Array;
}

for (var key in relatedFilters) {
    sqs_objects["form_filters_" + relatedFilters[key].elementId + "_name"] = {
        id: relatedFilters[key].elementId,
        form: "form_filters",
        method: "query",
        modules: [relatedFilters[key].module],
        group: "or",
        field_list: ["name", "id"],
        populate_list: [relatedFilters[key].elementId + "_name", relatedFilters[key].elementId + "_id"],
        conditions: [
            {
                name: "name",
                op: "like_custom",
                begin: "%",
                end: "%",
                value: "",
            },
        ],
        order: "name",
        limit: "30",
        // post_onblur_function: "callbackSticEventSelectQS()",
        no_match_text: "No Match",
    };
    QSProcessedFieldsArray["form_filters_" + relatedFilters[key].elementId + "_name"] = false;
}

SUGAR.util.doWhen(
    "typeof(sqs_objects) != 'undefined'",
    enableQS
);

// Open the modal-popup that contains the filters
function toggle_filters() {
    $(".modal-calendar-filters").modal("toggle");
};

// callback function used in the Popup that select events
function openSelectPopup(module, field) {
    var popupRequestData = {
        call_back_function: "callbackSelectPopup",
        form_name: "form_filters",
        field_to_name_array: {
            id: field + "_id",
            name: field + "_name",
        },
    };
    open_popup(module, 600, 400, "", true, false, popupRequestData);
}

var fromPopupReturn = false;
// callback function used after the Popup that select events
function callbackSelectPopup(popupReplyData) {
    fromPopupReturn = true;
    var nameToValueArray = popupReplyData.name_to_value_array;
    // It fills the data of the events
    Object.keys(nameToValueArray).forEach(function(key, index) {
        $('#'+key).val(nameToValueArray[key]);
    }, nameToValueArray);
}

// selectizing filters
emptyString = "[" + SUGAR.language.get("app_strings", "LBL_STIC_EMPTY") + "]";
$("select").each(function () {
    if (this.id != 'stic_sessions_color' && 
        this.id != 'stic_followups_color' && 
        this.name != document.getElementsByName('show_work_calendar')[0].name &&
        this.name != document.getElementsByName('show_calls')[0].name &&
        this.name != document.getElementsByName('show_tasks')[0].name &&
        this.name != document.getElementsByName('show_completed')[0].name
    ) { 
        var selectizeOptions = {
            plugins: ["remove_button"],
            allowEmptyOption: true
        }
        if ($(this).is("[multiple]")) {
            // Set text in empty strings
            $('option[value=""]', $(this)).text(emptyString);

        }
        $(this).selectize(selectizeOptions || {});
    }
});

// Adding color dots to "color" enum field
$(document).ready(function() {
    $('#stic_sessions_color').selectize({
        render: {
            option: function(item, escape) {
              return '<div class="option" style="display: flex; align-items: center; padding: 5px;">' +
                       '<div style="background-color: #' + escape(item.value) + '; width: 20px; height: 20px; border-radius: 50%; margin-right: 10px; margin-left: 10px;"></div>' +
                       escape(item.text) +
                     '</div>';
            },
            item: function(item, escape) {
              return '<div class="item" style="display: inline-flex; align-items: left; padding: 5px;" >' +
                '<div style="background-color: #' + escape(item.value) + '; width: 20px; height: 20px; border-radius: 50%; margin-right: 10px; margin-left: 5px;"></div>' +
                escape(item.text) +
              '</div>';
            }
        },
        plugins: ["remove_button"],
        allowEmptyOption: true
    });
    $('#stic_followups_color').selectize({
        render: {
            option: function(item, escape) {
              return '<div class="option" style="display: flex; align-items: center; padding: 5px;">' +
                       '<div style="background-color: #' + escape(item.value) + '; width: 20px; height: 20px; border-radius: 50%; margin-right: 10px; margin-left: 10px;"></div>' +
                       escape(item.text) +
                     '</div>';
            },
            item: function(item, escape) {
              return '<div class="item" style="display: inline-flex; align-items: left; padding: 5px;" >' +
                '<div style="background-color: #' + escape(item.value) + '; width: 20px; height: 20px; border-radius: 50%; margin-right: 10px; margin-left: 5px;"></div>' +
                escape(item.text) +
              '</div>';
            }
        },
        plugins: ["remove_button"],
        allowEmptyOption: true
    });
});