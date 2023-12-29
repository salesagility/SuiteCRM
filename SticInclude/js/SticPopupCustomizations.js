$(document).ready(function () {

  $queryForm = $("#popup_query_form");
  $addForm = $("#addform");
  $('#addformlink input, table.formHeader.h3Row, #popup_query_form').hide()
  $('#popupButtonBar').remove()

  $buttonBar = $('<p>', {
    id: 'popupButtonBar',
  }).prependTo($('body.popupBody'))

  $searchButton = $('<button>', {
    id: 'searchButton',
    type: 'button',
    class: 'button suitepicon suitepicon-module-filter inactive',
    text: $queryForm.closest("table").prev("table").find("h3").text(),
    style: 'margin-right:.5em'
  }).appendTo($buttonBar)

  if ($('#addformlink input').val() != undefined) {
    $newRecordButton = $('<button>', {
      id: 'newRecordButton',
      type: 'button',
      class: 'button suitepicon suitepicon-action-plus inactive',
      text: $('#addformlink input').val()
    }).appendTo($buttonBar);

    $newRecordButton.on("click", function (a) {
      //toggleDisplay('addform');
      $addForm.slideToggle(500);
      if ($addForm.is(':visible')) {
        $queryForm.hide();
      }
      buttonVisibility()
    })
  }

  $searchButton.on("click", function () {
    $queryForm.slideToggle(500);
    if ($queryForm.is(':visible')) {
      $addForm.hide();

    }
    buttonVisibility()
  })


});

function buttonVisibility() {
  $('#popupButtonBar .button').addClass('inactive')
  setTimeout(function () {
    if ($queryForm.is(':visible')) {
      $('#searchButton').removeClass('inactive');
    }
    if ($addForm.is(':visible')) {
      $('#newRecordButton').removeClass('inactive');
    }
  }, 500)
}
