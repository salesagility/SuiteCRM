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
});

