/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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

$(function () {
  //set variable to global window scope to compensate for lost value during subpanel pagination
  if (window.select_entire_list == 1) {
    $('#select_entire_list').val(1);
    var table = $('#list_subpanel_delegates .list');

    table.find('input:checkbox').prop({
      checked: true,
      disabled: true
    });
  }

  //checks all and unchecks all checkboxes based on checkbox in first row of the subpanel table.
  $('th input:checkbox').click(function (e) {
    var table = $(e.target).parents('table:first');
    $('td input:checkbox', table).attr('checked', e.target.checked);

  });
  //Shows and hides the custom mass update button in subpanel
  $('.cust_select').unbind("click").click(function () { //unbined is used to prevent the click event from firing twice

    if ($(this).siblings('.cust_list').is(':hidden')) {

      $(this).siblings('.cust_list').show();
    }
    else {
      $(this).siblings('.cust_list').hide();
    }
  });

  //select this page only button
  $('.button_select_this_page_top').click(function (e) {

    var table = $(this).parents('div:eq(0)').children(".list");

    table.find('input:checkbox').prop('checked', true);

    $(this).parents('.cust_list').hide();

    Populate();

    return false; //Prevent page from jumping back to the top on click
  });

  //select all (selects all related contacts)
  $('.button_select_all_top').click(function (e) {

    var table = $(this).parents('div:eq(0)').children(".list");

    table.find('input:checkbox').prop({
      checked: true,
      disabled: true
    });

    $('#select_entire_list').val(1);
    window.select_entire_list = 1;

    $(this).parents('.cust_list').hide();

    Populate();

    return false;

  });

  //unselects all
  $('.button_deselect_top').click(function (e) {

    var table = $(this).parents('div:eq(0)').children(".list");

    table.find('input:checkbox').prop({
      checked: false,
      disabled: false
    });

    $('#select_entire_list').val(0);
    window.select_entire_list = 0;

    $(this).parents('.cust_list').hide();

    //clear id's on deselect
    var vals = '';

    $('#custom_hidden_1').val(vals);


    return false;

  });

  function Populate() {
    vals = $('input[type="checkbox"]:checked').map(function () {

      if (this.value != 'on') {

        return this.value;
      }
    }).get().join(',');

    $('#custom_hidden_1').val(vals);
  }

  $('input[type="checkbox"]').on('change', function () {
    Populate()
  }).change();
});

function set_return_and_save_background2(popup_reply_data) {
  var form_name = popup_reply_data.form_name;
  var name_to_value_array = popup_reply_data.name_to_value_array;
  var passthru_data = popup_reply_data.passthru_data;
  var select_entire_list = typeof( popup_reply_data.select_entire_list ) == 'undefined' ? 0 : popup_reply_data.select_entire_list;
  var current_query_by_page = popup_reply_data.current_query_by_page;

  // construct the POST request
  var query_array = new Array();
  if (name_to_value_array != 'undefined') {
    for (var the_key in name_to_value_array) {
      if (the_key == 'toJSON') {
        /* just ignore */
      }
      else {
        query_array.push(the_key + "=" + name_to_value_array[the_key]);
      }
    }
  }
  //construct the muulti select list
  var selection_list = popup_reply_data.selection_list;
  if (selection_list != 'undefined') {
    for (var the_key in selection_list) {
      query_array.push('subpanel_id[]=' + selection_list[the_key])
    }
  }
  var module = get_module_name();
  var id = get_record_id();


  query_array.push('value=DetailView');
  query_array.push('module=' + module);
  query_array.push('http_method=get');
  query_array.push('return_module=' + module);
  query_array.push('return_id=' + id);
  query_array.push('record=' + id);
  query_array.push('isDuplicate=false');
  query_array.push('action=add_to_list');
  query_array.push('inline=1');
  query_array.push('select_entire_list=' + select_entire_list);
  if (select_entire_list == 1) {
    query_array.push('current_query_by_page=' + current_query_by_page);
  }

  var refresh_page = 1;
  for (prop in passthru_data) {
    if (prop == 'link_field_name') {
      query_array.push('subpanel_field_name=' + escape(passthru_data[prop]));
    } else {
      if (prop == 'module_name') {
        query_array.push('subpanel_module_name=' + escape(passthru_data[prop]));
      } else if (prop == 'prospect_ids') {
        for (var i = 0; i < passthru_data[prop].length; i++) {
          query_array.push(prop + '[]=' + escape(passthru_data[prop][i]));
        }
      } else {
        query_array.push(prop + '=' + escape(passthru_data[prop]));
      }
    }
  }

  var query_string = query_array.join('&');
  request_map[request_id] = passthru_data['child_field'];

  var returnstuff = http_fetch_sync('index.php', query_string);
  request_id++;

  // Bug 52843
  // If returnstuff.responseText is empty, don't process, because it will blank the innerHTML
  if (typeof returnstuff != 'undefined' && typeof returnstuff.responseText != 'undefined' && returnstuff.responseText.length != 0) {
    got_data(returnstuff, true);
  }

  if (refresh_page == 1) {
    document.location.reload(true);
  }
}


//Using Sugar native YUI Library dialog pop-up for button link groupings
function select_targets() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var selectDelegatesPopup = '';

  selectDelegatesPopup += '<div id="details_popup_div" class="modal fade" style="display: none;">';
  selectDelegatesPopup += '<div class="modal-dialog modal-sm">';//
  selectDelegatesPopup += '<div class="modal-content">';
  selectDelegatesPopup += '<div class="modal-header">';
  selectDelegatesPopup += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
  selectDelegatesPopup += '<h4 class="modal-title">' + SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES') + '</h4>';
  selectDelegatesPopup += '</div>';
  selectDelegatesPopup += '<div class="modal-body">';
  selectDelegatesPopup += '<div style="padding: 5px 5px; overflow: auto; height: auto;">';
  selectDelegatesPopup += '<table width="100%" class="list view table-responsive" cellspacing="0" cellpadding="0" border="0">';
  selectDelegatesPopup += '<tbody>';
  selectDelegatesPopup += "<tr class='oddListRowS1'><td style='padding: 2px;text-align:left;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;text-align:left;'><b><a href='#' onclick='handle_targetlists();return false;'>" + SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_TARGET_LIST') + "</a></b></td></tr>";
  selectDelegatesPopup += "<tr class='evenListRowS1'><td style='padding: 2px;text-align:left;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;text-align:left;'><strong><a href='#' onclick='handle_targets();return false;'>" + SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_TARGETS') + "</a></strong></td></tr>";
  selectDelegatesPopup += "<tr class='oddListRowS1'><td style='padding: 2px;text-align:left;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;text-align:left;'><strong><a href='#' onclick='handle_contacts();return false;'>" + SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_CONTACTS') + "</a></strong></td></tr>";
  selectDelegatesPopup += "<tr class='evenListRowS1'><td style='padding: 2px;text-align:left;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;text-align:left;'><strong><a href='#' onclick='handle_leads();return false;'>" + SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_LEADS') + "</a></strong></td></tr>";
  selectDelegatesPopup += '</tbody></table>';
  selectDelegatesPopup += '</div>';
  selectDelegatesPopup += '</div>';
  selectDelegatesPopup += '<div class="modal-footer">&nbsp;<button type="button" class="btn btn-primary" data-dismiss="modal">' + SUGAR.language.get('app_strings', 'LBL_CANCEL_BUTTON_LABEL') + '</button></div>';
  selectDelegatesPopup += '</div>';
  selectDelegatesPopup += '</div>';
  selectDelegatesPopup += '</div>';
  $("body").append(selectDelegatesPopup);
  $('#details_popup_div').modal('show', {backdrop: 'static'});
}

//open target list pop-up window
function handle_targetlists() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  open_popup("ProspectLists", 600, 400, "", true, true, {
    "call_back_function": "set_return_and_save_background2",
    "form_name": "DetailView",
    "field_to_name_array": {"id": "subpanel_id"},
    "passthru_data": {
      "child_field": "delegates",
      "return_url": "index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1",
      "link_field_name": null,
      "module_name": "delegates",
      "refresh_page": 0,
      "pop_up_type": "target_list"
    }
  }, "MultiSelect", true);
}
//open targets pop-up window
function handle_targets() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  open_popup("Prospects", 600, 400, "", true, true, {
    "call_back_function": "set_return_and_save_background2",
    "form_name": "DetailView",
    "field_to_name_array": {"id": "subpanel_id"},
    "passthru_data": {
      "child_field": "delegates",
      "return_url": "index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1",
      "link_field_name": null,
      "module_name": "delegates",
      "refresh_page": 0,
      "pop_up_type": "targets"
    }
  }, "MultiSelect", true);
}
//open contacts pop-up window
function handle_contacts() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  open_popup("Contacts", 600, 400, "", true, true, {
    "call_back_function": "set_return_and_save_background2",
    "form_name": "DetailView",
    "field_to_name_array": {"id": "subpanel_id"},
    "passthru_data": {
      "child_field": "delegates",
      "return_url": "index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1",
      "link_field_name": null,
      "module_name": "delegates",
      "refresh_page": 0,
      "pop_up_type": "contacts"
    }
  }, "MultiSelect", true);
}
//open leads pop-up window
function handle_leads() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  open_popup("Leads", 600, 400, "", true, true, {
    "call_back_function": "set_return_and_save_background2",
    "form_name": "DetailView",
    "field_to_name_array": {"id": "subpanel_id"},
    "passthru_data": {
      "child_field": "delegates",
      "return_url": "index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1",
      "link_field_name": null,
      "module_name": "delegates",
      "refresh_page": 0,
      "pop_up_type": "leads"
    }
  }, "MultiSelect", true);
}


function manage_delegates() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();
  var manageDelegatesPopup = '';
  var manageDelegatesPopupBody = '';

  manageDelegatesPopup += '<div id="details_popup_div" class="modal fade" style="display: none;">';
  manageDelegatesPopup += '<div class="modal-dialog modal-sm">';//
  manageDelegatesPopup += '<div class="modal-content">';
  manageDelegatesPopup += '<div class="modal-header">';
  manageDelegatesPopup += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
  manageDelegatesPopup += '<h4 class="modal-title">' + SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES') + '</h4>';
  manageDelegatesPopup += '</div>';
  manageDelegatesPopup += '<div class="modal-body">';

  if (ids != '') {
    manageDelegatesPopupBody += '<div style="padding: 5px 5px; overflow: auto; height: auto;">';
    manageDelegatesPopupBody += '<table width="100%" class="list view table-responsive" cellspacing="0" cellpadding="0" border="0">';
    manageDelegatesPopupBody += '<tbody>';
    manageDelegatesPopupBody += "<tr class='oddListRowS1'><td style='padding: 2px;text-align:right;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;'><b><a href='#' onclick='handle_invited();return false;'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_INVITED') + "</a></b></td></tr>";
    manageDelegatesPopupBody += "<tr class='evenListRowS1'><td style='padding: 2px;text-align:right;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;'><strong><a href='#' onclick='handle_not_invited();return false;'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_NOT_INVITED') + "</a></strong></td></tr>";
    manageDelegatesPopupBody += "<tr class='oddListRowS1'><td style='padding: 2px;text-align:right;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;'><strong><a href='#' onclick='handle_attended();return false;'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_ATTENDED') + "</a></strong></td></tr>";
    manageDelegatesPopupBody += "<tr class='evenListRowS1'><td style='padding: 2px;text-align:right;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;'><strong><a href='#' onclick='handle_not_attended();return false;'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_NOT_ATTENDED') + "</a></strong></td></tr>";
    manageDelegatesPopupBody += '</tbody></table>';
    manageDelegatesPopupBody += '</div>';
  } else { //if no delegates are checked show error message
    manageDelegatesPopupBody += '<div style="padding: 5px 5px; overflow: auto; height: auto;">';
    manageDelegatesPopupBody += '<table width="100%" class="list view table default" cellspacing="0" cellpadding="0" border="0">';
    manageDelegatesPopupBody += '<tbody>';
    manageDelegatesPopupBody += "<tr><td style='padding: 2px;text-align:center;color:#FF0000;' width='17'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_POPUP_ERROR') + "</td></tr>";
    manageDelegatesPopupBody += '</tbody></table>';
    manageDelegatesPopupBody += '</div>';
  }
  manageDelegatesPopup += '</div>';
  manageDelegatesPopup += '<div class="modal-footer">&nbsp;<button type="button" class="btn btn-primary" data-dismiss="modal">' + SUGAR.language.get('app_strings', 'LBL_CANCEL_BUTTON_LABEL') + '</button></div>';
  manageDelegatesPopup += '</div>';
  manageDelegatesPopup += '</div>';
  manageDelegatesPopup += '</div>';
  $("body").append(manageDelegatesPopup);
  $('#details_popup_div .modal-body').html(manageDelegatesPopupBody);
  $('#details_popup_div').modal('show', {backdrop: 'static'});
}

function showNoCheck() {
  $('#details_popup_div').remove();
  $("#no_check").remove();
  $('.modal-backdrop').remove();
  var manageDelegatesHandleErrorPopup = '';
  manageDelegatesHandleErrorPopup += '<div id="no_check" class="modal fade" style="display: none;">';
  manageDelegatesHandleErrorPopup += '<div class="modal-dialog modal-sm">';
  manageDelegatesHandleErrorPopup += '<div class="modal-content">';
  manageDelegatesHandleErrorPopup += '<div class="modal-header">';
  manageDelegatesHandleErrorPopup += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
  manageDelegatesHandleErrorPopup += '<h4 class="modal-title">' + SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES') + '</h4>';
  manageDelegatesHandleErrorPopup += '</div>';
  manageDelegatesHandleErrorPopup += '<div class="modal-body">';
  manageDelegatesHandleErrorPopup += '<div style="padding: 5px 5px; overflow: auto; height: auto;">';
  manageDelegatesHandleErrorPopup += '<table width="100%" class="list view table-responsive" cellspacing="0" cellpadding="0" border="0">';
  manageDelegatesHandleErrorPopup += '<tbody>';
  manageDelegatesHandleErrorPopup += "<tr><td style='padding: 2px;text-align:center;color:#FF0000;' width='17'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_POPUP_ERROR') + "</td></tr>";
  manageDelegatesHandleErrorPopup += '</tbody></table>';
  manageDelegatesHandleErrorPopup += '</div>';
  manageDelegatesHandleErrorPopup += '</div>';
  manageDelegatesHandleErrorPopup += '<div class="modal-footer">&nbsp;<button type="button" class="btn btn-primary" data-dismiss="modal">' + SUGAR.language.get('app_strings', 'LBL_CANCEL_BUTTON_LABEL') + '</button></div>';
  manageDelegatesHandleErrorPopup += '</div>';
  manageDelegatesHandleErrorPopup += '</div>';
  manageDelegatesHandleErrorPopup += '</div>';
  $("body").append(manageDelegatesHandleErrorPopup);
  $('#no_check').modal('show', {backdrop: 'static'});
}

function handle_invited() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();
  var list = $("#select_entire_list").val();
  var eventid = $("[name='record']").val();
  var data = 'id=' + ids;
  data += '&event_id=' + eventid;
  data += '&entire_list=' + list;

  if (ids != '') {

    $.ajax({
      type: "POST",
      url: "index.php?module=FP_events&action=markasinvited",
      data: data,
      success: function () {
        showSubPanel('delegates', null, true, 'FP_events');
      }
    });
  }
  else {
    showNoCheck();
  }
  $("body").removeClass('modal-open');
}

function handle_not_invited() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();
  var list = $("#select_entire_list").val();
  var eventid = $("[name='record']").val();
  var data = 'id=' + ids;
  data += '&event_id=' + eventid;
  data += '&entire_list=' + list;

  if (ids != '') {

    $.ajax({
      type: "POST",
      url: "index.php?module=FP_events&action=markasnotinvited",
      data: data,
      success: function () {
        showSubPanel('delegates', null, true, 'FP_events');
      }
    });
  }
  else {
    showNoCheck();
  }
  $("body").removeClass('modal-open');
}

function handle_attended() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();
  var list = $("#select_entire_list").val();
  var eventid = $("[name='record']").val();
  var data = 'id=' + ids;
  data += '&event_id=' + eventid;
  data += '&entire_list=' + list;

  if (ids != '') {

    $.ajax({
      type: "POST",
      url: "index.php?module=FP_events&action=markasattended",
      data: data,
      success: function () {
        showSubPanel('delegates', null, true, 'FP_events');
      }
    });
  }
  else {
    showNoCheck();
  }
  $("body").removeClass('modal-open');

}

function handle_not_attended() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();
  var list = $("#select_entire_list").val();
  var eventid = $("[name='record']").val();
  var data = 'id=' + ids;
  data += '&event_id=' + eventid;
  data += '&entire_list=' + list;

  if (ids != '') {

    $.ajax({
      type: "POST",
      url: "index.php?module=FP_events&action=markasnotattended",
      data: data,
      success: function () {
        showSubPanel('delegates', null, true, 'FP_events');
      }
    });
  }
  else {
    showNoCheck();
  }
  $("body").removeClass('modal-open');
}

function manage_acceptances() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();

  var manageAcceptancePopup = '';
  var manageAcceptancePopupBody = '';

  manageAcceptancePopup += '<div id="details_popup_div" class="modal fade" style="display: none;">';
  manageAcceptancePopup += '<div class="modal-dialog modal-sm" style="width: 350px;">';//
  manageAcceptancePopup += '<div class="modal-content">';
  manageAcceptancePopup += '<div class="modal-header">';
  manageAcceptancePopup += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
  manageAcceptancePopup += '<h4 class="modal-title">' + SUGAR.language.get('FP_events', 'LBL_MANAGE_ACCEPTANCES') + '</h4>';
  manageAcceptancePopup += '</div>';
  manageAcceptancePopup += '<div class="modal-body">';

  if (ids != '') {
    manageAcceptancePopupBody += '<div style="padding: 5px 5px; overflow: auto; height: auto;">';
    manageAcceptancePopupBody += '<table width="100%" class="list view table-responsive" cellspacing="0" cellpadding="0" border="0">';
    manageAcceptancePopupBody += '<tbody>';
    manageAcceptancePopupBody += "<tr class='oddListRowS1'><td style='padding: 2px;text-align:right;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;'><b><a id='MarkAsAcceptedForm' onclick='handle_accepted();return false;' href='#'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_ACCEPTANCES_ACCEPTED') + "</a></b></td></tr>";
    manageAcceptancePopupBody += "<tr class='evenListRowS1'><td style='padding: 2px;text-align:right;' width='17'><img src='themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 120%;'><strong><a id='MarkAsDeclinedForm' onclick='handle_declined();return false;' href='#'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_ACCEPTANCES_DECLINED') + "</a></strong></td></tr>";
    manageAcceptancePopupBody += '</tbody></table>';
    manageAcceptancePopupBody += '</div>';
  } else { //if no delegates are check show error message
    manageAcceptancePopupBody += '<div style="padding: 5px 5px; overflow: auto; height: auto;">';
    manageAcceptancePopupBody += '<table width="100%" class="list view table default" cellspacing="0" cellpadding="0" border="0">';
    manageAcceptancePopupBody += '<tbody>';
    manageAcceptancePopupBody += "<tr><td style='padding: 2px;text-align:center;color:#FF0000;' width='17'>" + SUGAR.language.get('FP_events', 'LBL_MANAGE_POPUP_ERROR') + "</td></tr>";
    manageAcceptancePopupBody += '</tbody></table>';
    manageAcceptancePopupBody += '</div>';
  }
  manageAcceptancePopup += '</div>';
  manageAcceptancePopup += '<div class="modal-footer">&nbsp;<button type="button" class="btn btn-primary" data-dismiss="modal">' + SUGAR.language.get('app_strings', 'LBL_CANCEL_BUTTON_LABEL') + '</button></div>';
  manageAcceptancePopup += '</div>';
  manageAcceptancePopup += '</div>';
  manageAcceptancePopup += '</div>';
  $("body").append(manageAcceptancePopup);
  $('#details_popup_div .modal-body').html(manageAcceptancePopupBody);
  $('#details_popup_div').modal('show', {backdrop: 'static'});
}

function handle_accepted() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();
  var list = $("#select_entire_list").val();
  var eventid = $("[name='record']").val();
  var data = 'id=' + ids;
  data += '&event_id=' + eventid;
  data += '&entire_list=' + list;

  if (ids != '') {

    $.ajax({
      type: "POST",
      url: "index.php?module=FP_events&action=markasaccepted",
      data: data,
      success: function () {
        showSubPanel('delegates', null, true, 'FP_events');
      }
    });
  }
  else {
    showNoCheck();
  }
}

function handle_declined() {
  $('#details_popup_div').remove();
  $('.modal-backdrop').remove();
  var ids = $("#custom_hidden_1").val();
  var list = $("#select_entire_list").val();
  var eventid = $("[name='record']").val();
  var data = 'id=' + ids;
  data += '&event_id=' + eventid;
  data += '&entire_list=' + list;

  if (ids != '') {

    $.ajax({
      type: "POST",
      url: "index.php?module=FP_events&action=markasdeclined",
      data: data,
      success: function () {
        showSubPanel('delegates', null, true, 'FP_events');
      }
    });
  }
  else {
    showNoCheck();
  }
}
