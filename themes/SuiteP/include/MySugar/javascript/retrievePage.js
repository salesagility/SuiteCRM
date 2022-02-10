/**
 * Created by lewis on 18/02/14.
 */



function retrievePage(page_id, callback){
    setTimeout(function(){
        retrieveData(page_id, callback);
    }, 300);
}

function retrieveData(page_id, callback){
    var _cb = typeof callback != 'undefined' ? callback : false;
    $("#pageContainer").html('<img src="themes/SuiteP/images/loading.gif" width="48" height="48" align="baseline" border="0" alt="">');
    $.ajax({

        url : "index.php?entryPoint=retrieve_dash_page",
        dataType: 'html',
        type: 'POST',
        data : {
            'page_id' : page_id
        },

        success : function(data) {
            var pageContent = data;

            outputPage(page_id,pageContent);
            if(_cb) _cb();
        },
        error : function(request,error)
        {
            if(_cb) _cb();
        }
    })
}

function outputPage(page_id,pageContent) {
    $('#tab_content_'+page_id).html(pageContent);
}

var dashletsPageInit = function() {
    // events

    $('.modal-add-dashlet').on('show.bs.modal', function (e) {
        SUGAR.mySugar.showDashletsDialog();
    })

  $('.modal-add-dashboard').on('show.bs.modal', function (e) {

    addDashboardForm($('ul.nav-dashboard > li').length -1);

    $('.btn-add-dashboard').unbind('click');
    $('.btn-add-dashboard').click(function() {
      if($('#dashName').val() == '') {
        return;
      }

      $.post($('#addpageform').attr('action'), {
        dashName: $('#dashName').val(),
        numColumns: $('[name=numColumns] option:selected').val()
      }).then(function() {
        location.reload();
      });
    })
  })

    $('.modal-edit-dashboard').on('show.bs.modal', function (e) {
        var tabs = $('ul.nav-dashboard > li');
        var totalTabs = tabs.length -1;

        var render = $('<div></div>');

        for(var tab = 0; tab < totalTabs; tab++) {
            // clone the template from the dom
            var  panelTemplate = $('.modal-edit-dashboard .panel-template').clone();
            // set the title
            panelTemplate.find('.panel-title').html($($('ul.nav-dashboard > li')[tab]).find('[data-toggle="tab"]').html())

            if(tab != 0) {
                // add buttons
                var removeButton = $('<button class="btn btn-xs btn-danger"><span class="suitepicon suitepicon-action-minus"></span></button>');
                removeButton.click(function(a) {
                    const _this = $(this);
                    var id = $(this).parents('.panel').index();

                    $.ajax({

                        url: "index.php?entryPoint=remove_dash_page",
                        dataType: 'HTML',
                        type: 'POST',
                        data: {
                            'page_id': id
                        },

                        success: function (data) {
                            $.ajax({

                                url: "index.php?module=Home&action=RemoveDashboardPages",
                                dataType: 'HTML',
                                type: 'POST',
                                data: {
                                    'page_id': id,
                                    'status': 'yes'
                                },

                                success: function (data) {
                                    var modelTabItem = $(_this).closest('.panel');
                                    var tabItem = tabs.eq(modelTabItem.index());

                                    if (tabItem.hasClass('active')) {
                                        $('> a', tabs.eq(0)).trigger('click');
                                    }

                                    modelTabItem.remove();
                                    tabItem.remove();
                                },
                                error: function (request, error) {

                                }
                            })

                        },
                        error: function (request, error) {

                        }
                    })

                });
                removeButton.appendTo(panelTemplate.find('.panel-title'));
            }

            panelTemplate.removeClass('panel-template');
            panelTemplate.appendTo(render);
        }

        $('.modal-edit-dashboard .modal-body').html(render);
    });
};

$(document).ready(function () {
    retrievePage(0, function(){
        dashletsPageInit();
    });

});



