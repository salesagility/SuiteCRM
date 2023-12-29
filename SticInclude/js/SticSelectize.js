/**
 * This function applies the selectize transformations on the select type controls in the different search panels
 */
function applySelectizeInSearchForms() {


  $emptyString = "[" + SUGAR.language.get("app_strings", "LBL_STIC_EMPTY") + "]";

  // We mark the controls that we do not want to process, to avoid incompatibilities
  var unSelectize = [];
  unSelectize.push("table.dateTime select"); // Time controls
  unSelectize.push("select.datetimecombo_time"); // Time controls
  unSelectize.push("#inlineSavedSearch select"); // Column sorting and selection
  unSelectize.push("select[id$=_range_choice]"); // Range selectors
  unSelectize.push("select#orderBySelect"); // Range selectors
  unSelectize.push("#dlg.SuiteP-configureDashlet form[action='index.php'] table  tr:nth-child(-n+6) select"); // Dashlet config Gerneral area
  unSelectize.forEach(element => {
    $(element).addClass("no-selectize");
  });

  // Here we define the "$elements" in which the selectize must be executed
  $Forms = $("#search_form, #popup_query_form, #dlg.SuiteP-configureDashlet");

  $("select", $Forms).each(function () {
    if ($(this).closest("#inlineSavedSearch").length == 0 && !$(this).is(".no-selectize")) {

      if ($(this).is("[multiple]")) {
        // Set text in empty strings
        $('option[value=""]', $(this)).text($emptyString);
        var selectizeOptions = {
          plugins: ["remove_button"],
          allowEmptyOption: true
        }
      }


      $(this).selectize(selectizeOptions || {});
    }
  });

  $(".search td[nowrap],.popupBody .edit.view td[nowrap]").removeAttr("nowrap");

  // Include behavior to clear selectize fields
  $("input#search_form_clear.button,input#search_form_clear_advanced.button").on("click", function (event) {
    event.preventDefault();
    var $panel = $(this).closest(".search");
    $("select", $panel).each(function () {
      $select = $(this);
      if ($select.is(".selectized") && $select.attr("id") != "saved_search_select") {
        $select[0].selectize.clear();
      }

      // Force the equal value = in the date selection fields after cleaning, so that searches do not fail
      if ($select.is(".selectized") && ($select.attr("id") || " ").indexOf("_range_choice") >= 0) {
        $select[0].selectize.setValue("=");
      }
    });
  });
}
