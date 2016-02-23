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
        alert('Cannot Delete My Sugar');
    }
}

function addDashboardForm(page_id){

    $.ajax({

        url : "index.php?entryPoint=add_dash_page",
        dataType: 'HTML',
        type: 'POST',

        success : function(data) {
            var titleval = SUGAR.language.get('app_strings', 'LBL_ADD_DASHBOARD_PAGE');
            var myButtons = [{ text: SUGAR.language.get('app_strings', 'LBL_SAVE_BUTTON_LABEL'), handler: handleSubmit, isDefault: true },
                { text: SUGAR.language.get('app_strings', 'LBL_CANCEL_BUTTON_TITLE'), handler:handleCancel }];
            get_form(data,titleval,myButtons)

        },
        error : function(request,error)
        {

        }
    })
}


function get_form(data,titleval,myButtons) {

    var form = data;
    dialog = new YAHOO.widget.Dialog('dialog1', {
        width: '400px',

        fixedcenter: "contained",
        visible: false,
        draggable: true,
        effect: [
            {effect: YAHOO.widget.ContainerEffect.SLIDE, duration: 0.2},
            {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.2}
        ],
        modal: true
    });

    dialog.setHeader(titleval);
    dialog.setBody(form);
    dialog.callback.success = function() {
        refreshPage();
    }
    dialog.callback.failure = function() {
	dialog.setBody(SUGAR.language.get('app_strings', 'ERR_AJAX_LOAD_FAILURE'));
    }
    dialog.cfg.queueProperty("buttons", myButtons);
    dialog.render(document.body);
    dialog.show();

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
            get_form(data,titleval,myButtons)

        },
        error : function(request,error)
        {

        }
    })
}

function renameTabSubmit(){
    var dashName = $("#dashName").val();
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
    })
}
