function setModuleFieldsPendingFinishedCallback() {
  var parenthesisBtnHtml;

  $( "#aor_conditions_body, #aor_condition_parenthesis_btn" ).sortable({
    handle: '.condition-sortable-handle',
    placeholder: "ui-state-highlight",
    cancel: ".parenthesis-line",
    connectWith: ".connectedSortableConditions",
    start: function(event, ui) {
      parenthesisBtnHtml = $('#aor_condition_parenthesis_btn').html();
    },
    stop: function(event, ui) {
      if(event.target.id == 'aor_condition_parenthesis_btn') {
        $('#aor_condition_parenthesis_btn').html('<tr class="parentheses-btn">' + ui.item.html() + '</tr>');
        ParenthesisHandler.replaceParenthesisBtns();
      }
      else {
        if($(this).attr('id') == 'aor_conditions_body' && parenthesisBtnHtml != $('#aor_condition_parenthesis_btn').html()) {
          $(this).sortable("cancel");
        }
      }
      LogicalOperatorHandler.hideUnnecessaryLogicSelects();
      ConditionOrderHandler.setConditionOrders();
      ParenthesisHandler.addParenthesisLineIdent();
    }
  });//.disableSelection();
  LogicalOperatorHandler.hideUnnecessaryLogicSelects();
  ConditionOrderHandler.setConditionOrders();
  ParenthesisHandler.addParenthesisLineIdent();
  FieldLineHandler.makeGroupDisplaySelectOptions();
}

$(function(){

  $('#EditView_tabs .clear').remove();

  $( '#aor_condition_parenthesis_btn' ).bind( "sortstart", function (event, ui) {
    ui.helper.css('margin-top', 0 );
  });
  $( '#aor_condition_parenthesis_btn' ).bind( "sortbeforestop", function (event, ui) {
    ui.helper.css('margin-top', 0 );
  });

  $(window).resize()
  {
    $('div.panel-heading a div').css({
      width: $('div.panel-heading a').width() - 14
    });
  }

  var reportToggler = function(elem) {
    var marker = 'toggle-';
    var classes = $(elem).attr('class').split(' ');
    $('.tab-togglers .tab-toggler').removeClass('active');
    $(elem).addClass('active');
    $('.tab-panels .toggle-panel').addClass('hidden');
    $.each(classes, function(i, cls){
      if(cls.substring(0, marker.length) == marker) {
        var panelId = cls.substring(marker.length);
        $('#'+panelId).removeClass('hidden');
      }
    });
  };

  $('.tab-toggler').click(function(){
    reportToggler(this);
  });


});