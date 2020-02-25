function handleSubmit(){
    $(this).submit();
}

function handleCancel(){
    this.cancel();
}

function refreshPage() {
    window.location.replace("index.php");
}

function removeDashboardForm(page_id) {
    if (page_id > 0) {
        $.ajax({

            url: "index.php?entryPoint=remove_dash_page",
            dataType: 'HTML',
            type: 'POST',
            data: {
                'page_id': page_id
            },

            success: function (data) {
                console.log(data)
                var titleval = SUGAR.language.get('app_strings', 'LBL_DELETE_DASHBOARD_PAGE');
                var myButtons = [
                    { text: SUGAR.language.get('app_strings', 'LBL_SEARCH_DROPDOWN_YES'), handler: handleSubmit, isDefault: true },
                    { text: SUGAR.language.get('app_strings', 'LBL_SEARCH_DROPDOWN_NO'), handler: handleCancel }
                ];
                get_form(data,titleval,myButtons)

            },
            error: function (request, error) {

            }
        })
    }else{
        alert('Cannot Delete first tab');
    }
}

function get_form(data,titleval,myButtons){}

function addDashboardForm(page_id){

    $.ajax({

        url : "index.php?entryPoint=add_dash_page",
        dataType: 'HTML',
        type: 'POST',

        success : function(data) {
            var titleval = SUGAR.language.get('app_strings', 'LBL_ADD_DASHBOARD_PAGE');
            $("#dashName").attr('type', 'text');
            $('.modal-add-dashboard > .modal-dialog > .modal-content > .modal-header .modal-title').html(titleval);
            $('.modal-add-dashboard > .modal-dialog > .modal-content > .modal-body').html(data);

        },
        error : function(request,error)
        {

        }
    })
}


function renameTab(page_id){
    $.ajax({

        url : "index.php?entryPoint=rename_dash_page",
        dataType: 'HTML',
        type: 'POST',
        data: {
            'page_id': page_id
        },

        success : function(data) {
            var titleval = SUGAR.language.get('app_strings', 'LBL_RENAME_DASHBOARD_PAGE');
            var myButtons = [{ text: SUGAR.language.get('app_strings', 'LBL_SAVE_BUTTON_LABEL'), handler: renameTabSubmit, isDefault: true },
                { text: SUGAR.language.get('app_strings', 'LBL_CANCEL_BUTTON_LABEL'), handler:handleCancel }];
            $("#dashName").attr('type', 'text');
            $('.modal-add-dashboard > .modal-dialog > .modal-content > .modal-header .modal-title').html(titleval);
            $('.modal-add-dashboard > .modal-dialog > .modal-content > .modal-body').html(data);

        },
        error : function(request,error)
        {

        }
    })
}

function renameTabSubmit() {
    var dashName = $("#dashName").val();
    $("#dashName").attr('type', 'text');
    var page_id = $("#page_id").val();
    $.ajax({
        url : "index.php?entryPoint=rename_dash_page",
        dataType: 'HTML',
        type: 'POST',
        data: {
            'page_id': page_id,
            'dashName': dashName
        },


        success : function(data) {
            data = JSON.parse(data);

            $("#name_" + data.page_id).text(data.dashName);

            dialog.hide();

        },
        error : function(request,error)
        {

        }
    });
}
