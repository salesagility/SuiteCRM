/**
 * Created by lewis on 18/02/14.
 */



function retrievePage(page_id){
     retrieveData(page_id);
}

function retrieveData(page_id){
    $.ajax({

        url : "index.php?entryPoint=retrieve_dash_page",
        dataType: 'html',
        type: 'POST',
        data : {
            'page_id' : page_id
        },

        success : function(data) {
            var pageContent = data;

            outputPage(page_id,pageContent)
        },
        error : function(request,error)
        {

        }
    })
}

function outputPage(page_id,pageContent) {
    $('#tab_content_'+page_id).html(pageContent);
}

$(document).ready(function () {
    console.log('retrievePage')
    retrievePage(0);
    // events

    $('.modal-add-dashlet').on('show.bs.modal', function (e) {
        console.log('add dashlet')
        SUGAR.mySugar.showDashletsDialog();
    })

    $('.modal-add-dashboard').on('show.bs.modal', function (e) {
        console.log('add dashboard')
        addDashboardForm($('ul.nav-dashboard > li').length -1);
        $('.btn-add-dashboard').click(function() {
            //validate
            if($('#dashName').val() == '') {
                return;
            }

            $.post($('#addpageform').attr('action'), { dashName: $('#dashName').val(), numColumns: $('[name=numColumns] option:selected').val() } );
            location.reload();

        })
    })

    $('.modal-edit-dashboard').on('show.bs.modal', function (e) {
        console.log('edit dashboard')
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
                var removeButton = $('<button class="btn btn-xs btn-danger"><img src="themes/SuiteP/images/id-ff-remove-nobg.svg"></button>');
                removeButton.click(function(a) {
                    var id = $(this).parents('.panel').index();
                    console.log(id)

                    $.ajax({

                        url: "index.php?entryPoint=remove_dash_page",
                        dataType: 'HTML',
                        type: 'POST',
                        data: {
                            'page_id': id
                        },

                        success: function (data) {
                            console.log(data)
                            $.ajax({

                                url: "index.php?module=Home&action=RemoveDashboardPages",
                                dataType: 'HTML',
                                type: 'POST',
                                data: {
                                    'page_id': id,
                                    'status': 'yes'
                                },

                                success: function (data) {
                                    console.log(data)


                                },
                                error: function (request, error) {

                                }
                            })

                        },
                        error: function (request, error) {

                        }
                    })


                    $($('ul.nav-dashboard > li')[$(this).parents('.panel').index()]).remove();
                    $(this).parents('.panel').remove()
                });
                removeButton.appendTo(panelTemplate.find('.panel-title'));
            }

            panelTemplate.removeClass('panel-template');
            panelTemplate.appendTo(render);
        }

        $('.modal-edit-dashboard .modal-body').html(render);
    })
});



