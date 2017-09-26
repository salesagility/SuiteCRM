<div>
    <label>{$MOD.LBL_OPT_IN_CHECKBOX_ON_PERSON_FORM_ENABLED}</label>
    <input type="hidden" name="opt_in_checkbox_on_person_form_enabled" value="0">
    <input type="checkbox" id="opt_in_checkbox_on_person_form_enabled" name="opt_in_checkbox_on_person_form_enabled" {if $opt_in_checkbox_on_person_form_enabled}checked="checked"{/if} value="1">
</div>

<div>
    <label>{$MOD.LBL_OPT_IN_CONFIRMATION_EMAIL_ENABLED}</label>
    <input type="hidden" name="opt_in_confirmation_email_enabled" value="0">
    <input type="checkbox" id="opt_in_confirmation_email_enabled" name="opt_in_confirmation_email_enabled" {if $opt_in_confirmation_email_enabled}checked="checked"{/if} value="1">
</div>

<div>
<label>{$MOD.LBL_OPT_IN_CONFIRMATION_EMAIL_TEMPLATE}</label>
    <select id='opt_in_confirmation_email_template_id_select' name='opt_in_confirmation_email_template_id' onchange='show_edit_template_link(this);'>{$OPT_IN_CONFIRMATION_EMAIL_TEMPLATES}</select>

    <a href='javascript:open_email_template_form("opt_in_confirmation_email_template_id")' >{$MOD.LBL_CREATE_EMAIL_TEMPLATE}</a>
    <span name='edit_template' id='opt_in_confirmation_email_template_id_edit_template_link' style='visibility: hidden;'>
                    <a href='javascript:edit_email_template_form("opt_in_confirmation_email_template_id")' >{$MOD.LBL_EDIT_EMAIL_TEMPLATE}</a></span>
</div>
<script>
{literal}

var currentEmailSelect;

function open_email_template_form(id) {
  currentEmailSelect = id + "_select";
  URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
  URL += "&show_js=1";

  windowName = 'email_template';
  windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';

  win = window.open(URL, windowName, windowFeatures);
  if (window.focus) {
    // put the focus on the popup if the browser supports the focus() method
    win.focus();
  }
}

function edit_email_template_form(id) {
  currentEmailSelect = id + "_select";
  var field = document.getElementById(id + "_select");
  URL = "index.php?module=EmailTemplates&action=EditView&inboundEmail=1&return_module=AOW_WorkFlow&base_module=AOW_WorkFlow";
  if (field.options[field.selectedIndex].value != 'undefined') {
    URL += "&record=" + field.options[field.selectedIndex].value;
  }
  URL += "&show_js=1";

  windowName = 'email_template';
  windowFeatures = 'width=800' + ',height=600' + ',resizable=1,scrollbars=1';

  win = window.open(URL, windowName, windowFeatures);
  if (window.focus) {
    // put the focus on the popup if the browser supports the focus() method
    win.focus();
  }
}

function refresh_email_template_list(template_id, template_name) {
  refresh_template_list(template_id, template_name, currentEmailSelect);
}

var templateFields = ['opt_in_confirmation_email_template_id_select'];

function refreshEditVisibility() {
  for (var x = 0; x < templateFields.length; x++) {
    var fieldId = templateFields[x];
    var field = document.getElementById(fieldId);
    field.onchange();
  }
}

function refresh_template_list(template_id, template_name, select) {
  var bfound = 0;
  for (var x = 0; x < templateFields.length; x++) {
    var fieldId = templateFields[x];
    var field = document.getElementById(fieldId);
    for (var i = 0; i < field.options.length; i++) {
      if (field.options[i].value == template_id) {
        if (field.options[i].selected == false && fieldId == select) {
          field.options[i].selected = true;
        }
        field.options[i].text = template_name;
        bfound = 1;
      }
    }
    //add item to selection list.
    if (bfound == 0) {
      var newElement = document.createElement('option');
      newElement.text = template_name;
      newElement.value = template_id;
      field.options.add(newElement);
      if (fieldId == select) {
        newElement.selected = true;
      }
    }
  }
  refreshEditVisibility();
}
function show_edit_template_link(field) {
  var field1 = document.getElementById(field.name + "_edit_template_link");
  if (field.selectedIndex == 0) {
    field1.style.visibility = "hidden";
  } else {
    field1.style.visibility = "visible";
  }
}
{/literal}
</script>