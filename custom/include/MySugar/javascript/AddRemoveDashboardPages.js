function handleSubmit(){
    $(this).submit();

}

function handleCancel(){
    $(this).cancel();
}




function removeForm(page_id) {
    console.log(page_id);
    if (page_id > 0) {
        $.ajax({

            url: "index.php?entryPoint=remove_dash_page",
            dataType: 'HTML',
            type: 'POST',
            data: {
                'page_id': page_id
            },

            success: function (data) {

                var titleval = 'Remove Current Dashboard Page';
                var myButtons = [
                    { text: "Yes", handler: handleSubmit, isDefault: true },
                    { text: "No", handler: handleCancel }
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

function addForm(page_id){

    $.ajax({

        url : "index.php?entryPoint=add_dash_page",
        dataType: 'HTML',
        type: 'POST',

        success : function(data) {
            var titleval = 'Add a Dashboard Page';
            var myButtons = [{ text: "Save", handler: handleSubmit, isDefault: true },
                { text: "Cancel", handler:handleCancel }];
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


    dialog.cfg.queueProperty("buttons", myButtons);
    dialog.render(document.body);
    dialog.show();

}


