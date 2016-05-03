/**
 * Date: 11/06/13
 * Written by: Andrew Mclaughlan
 * Company: SalesAgility
 */

$(function () {

       //remove sugar onclick from select
      // $("#Delegates_select_button").attr('onclick', 'open_popup("ProspectLists",600,400,"",true,true,{"call_back_function":"set_return_and_save_background2","form_name":"DetailView","field_to_name_array":{"id":"subpanel_id"},"passthru_data":{"child_field":"delegates","return_url":"index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26record%3Deccf1f61-d38a-d1f7-c21b-519c9353b00f%26sugar_body_only%3D1","link_field_name":null,"module_name":"delegates","refresh_page":0}},"MultiSelect",true);');
     
        //set variable to global window scope to compensate for lost vaule during subpanel pagination
    if(window.select_entire_list == 1){
        $('#select_entire_list').val(1); 
        var table = $('#list_subpanel_delegates .list');
        
        table.find('input:checkbox').prop({
            checked: true,
            disabled: true
        });
    }

    //checks all and unchecks all checkboxes based on checkbox in first row of the subpanel table.
    $('th input:checkbox').click(function(e) {
        var table = $(e.target).parents('table:first');
        $('td input:checkbox', table).attr('checked', e.target.checked);

    });
    //Shows and hides the custom mass update button in subpanel
    $('.cust_select').unbind("click").click(function() { //unbined is used to prevent the click event from firing twice 

        if($(this).siblings('.cust_list').is(':hidden')) {
               
            $(this).siblings('.cust_list').show();   
        }
        else {   
            $(this).siblings('.cust_list').hide(); 
        }
    });

    //select this page only button
    $('.button_select_this_page_top').click(function(e) {
        
       var table = $(this).parents('div:eq(0)').children(".list");
        
        table.find('input:checkbox').prop('checked', true);
        
        $(this).parents('.cust_list').hide();

        Populate();

        return false; //Prevent page from jumping back to the top on click
    });

    //select all (selects all related contacts)
    $('.button_select_all_top').click(function(e){

        var table = $(this).parents('div:eq(0)').children(".list");
        
        table.find('input:checkbox').prop({
            checked: true,
            disabled: true
        });

        $('#select_entire_list').val(1); 
        window.select_entire_list = 1;  

        $(this).parents('.cust_list').hide();

        Populate();

        return false;

     });

    //unselects all 
    $('.button_deselect_top').click(function(e){
        
        var table = $(this).parents('div:eq(0)').children(".list");
 
        table.find('input:checkbox').prop({
                checked: false,
                disabled: false
            });
        
        $('#select_entire_list').val(0);        
        window.select_entire_list = 0; 
        
        $(this).parents('.cust_list').hide();
        
        //clear id's on deselect
        var vals = '';

        $('#custom_hidden_1').val(vals);


        return false;
        
    });
  
    function Populate(){
        vals = $('input[type="checkbox"]:checked').map(function() {

            if(this.value != 'on'){

                return this.value;
            }
        }).get().join(',');

        $('#custom_hidden_1').val(vals);
    }

    $('input[type="checkbox"]').on('change', function() {
        Populate()
    }).change();   
});

function set_return_and_save_background2(popup_reply_data)
{
    var form_name = popup_reply_data.form_name;
    var name_to_value_array = popup_reply_data.name_to_value_array;
    var passthru_data = popup_reply_data.passthru_data;
    var select_entire_list = typeof( popup_reply_data.select_entire_list ) == 'undefined' ? 0 : popup_reply_data.select_entire_list;
    var current_query_by_page = popup_reply_data.current_query_by_page;

    // construct the POST request
    var query_array =  new Array();
    if (name_to_value_array != 'undefined') {
        for (var the_key in name_to_value_array)
        {
            if(the_key == 'toJSON')
            {
                /* just ignore */
            }
            else
            {
                query_array.push(the_key+"="+name_to_value_array[the_key]);
            }
        }
    }
    //construct the muulti select list
    var selection_list = popup_reply_data.selection_list;
    if (selection_list != 'undefined') {
        for (var the_key in selection_list)
        {
            query_array.push('subpanel_id[]='+selection_list[the_key])
        }
    }
    var module = get_module_name();
    var id = get_record_id();


    query_array.push('value=DetailView');
    query_array.push('module='+module);
    query_array.push('http_method=get');
    query_array.push('return_module='+module);
    query_array.push('return_id='+id);
    query_array.push('record='+id);
    query_array.push('isDuplicate=false');
    query_array.push('action=add_to_list');
    query_array.push('inline=1');
    query_array.push('select_entire_list='+select_entire_list);
    if(select_entire_list == 1){
        query_array.push('current_query_by_page='+current_query_by_page);
    }
    //var refresh_page = escape(passthru_data['refresh_page']);
    var refresh_page = 1;
    for (prop in passthru_data) {
        if (prop=='link_field_name') {
            query_array.push('subpanel_field_name='+escape(passthru_data[prop]));
        } else {
            if (prop=='module_name') {
                query_array.push('subpanel_module_name='+escape(passthru_data[prop]));
            } else if(prop == 'prospect_ids'){
                for(var i=0;i<passthru_data[prop].length;i++){
                    query_array.push(prop + '[]=' + escape(passthru_data[prop][i]));
                }
            } else {
                query_array.push(prop+'='+escape(passthru_data[prop]));
            }
        }
    }

    var query_string = query_array.join('&');
    request_map[request_id] = passthru_data['child_field'];
   // alert(query_string);
    var returnstuff = http_fetch_sync('index.php',query_string);
    request_id++;

    // Bug 52843
    // If returnstuff.responseText is empty, don't process, because it will blank the innerHTML
    if (typeof returnstuff != 'undefined' && typeof returnstuff.responseText != 'undefined' && returnstuff.responseText.length != 0) {
        got_data(returnstuff, true);
    }
    
    if(refresh_page == 1){
        document.location.reload(true);
    }
}


//Using Sugar native YUI Library dialog pop-up for button link groupings
function select_targets(){

    titleVal = SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_TITLE');

    htmltext = "<table style='width: 100%;text-align:left;'>";

    htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><b><a href='#' onclick='handle_targetlists();return false;'>"+SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_TARGET_LIST')+"</a></b><td></tr>";
    htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><strong><a href='#' onclick='handle_targets();return false;'>"+SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_TARGETS')+"</a></strong><td></tr>";
    htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><strong><a href='#' onclick='handle_contacts();return false;'>"+SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_CONTACTS')+"</a></strong><td></tr>";
    htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><strong><a href='#' onclick='handle_leads();return false;'>"+SUGAR.language.get('FP_events', 'LBL_SELECT_DELEGATES_LEADS')+"</a></strong><td></tr>";

    htmltext += "</table>";
    //initialise dialog       
    dialog = new YAHOO.widget.Dialog('details_popup_div', {
                width: '200px',
                fixedcenter : "contained",    
                visible : false, 
                draggable: true,
                effect:[//{effect:YAHOO.widget.ContainerEffect.SLIDE, duration:0.2},        
                {effect:YAHOO.widget.ContainerEffect.FADE,duration:0.1}],
                    modal:true
                });
    
    dialog.setHeader(titleVal);
    dialog.setBody(htmltext);
    dialog.setFooter('');

    var handleCancel = function() {
        this.cancel();
    };
    /*var handleSubmit = function() {
      this.cancel();
    };*/
    //set dialog box buttons
    var myButtons = [{ text: "Cancel", handler: handleCancel, isDefault: true }];
    dialog.cfg.queueProperty("buttons", myButtons);
    //render dialog box
    dialog.render(document.body);
    dialog.show();
    //dialog.configFixedCenter(null,false)          
}

//open target list pop-up window
function handle_targetlists(){
    dialog.cancel();
    open_popup("ProspectLists",600,400,"",true,true,{"call_back_function":"set_return_and_save_background2","form_name":"DetailView","field_to_name_array":{"id":"subpanel_id"},"passthru_data":{"child_field":"delegates","return_url":"index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1","link_field_name":null,"module_name":"delegates","refresh_page":0,"pop_up_type":"target_list"}},"MultiSelect",true);
}
//open targets pop-up window
function handle_targets(){
    dialog.cancel();
    open_popup("Prospects",600,400,"",true,true,{"call_back_function":"set_return_and_save_background2","form_name":"DetailView","field_to_name_array":{"id":"subpanel_id"},"passthru_data":{"child_field":"delegates","return_url":"index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1","link_field_name":null,"module_name":"delegates","refresh_page":0,"pop_up_type":"targets"}},"MultiSelect",true);
}
//open contacts pop-up window
function handle_contacts(){
    dialog.cancel();
    open_popup("Contacts",600,400,"",true,true,{"call_back_function":"set_return_and_save_background2","form_name":"DetailView","field_to_name_array":{"id":"subpanel_id"},"passthru_data":{"child_field":"delegates","return_url":"index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1","link_field_name":null,"module_name":"delegates","refresh_page":0,"pop_up_type":"contacts"}},"MultiSelect",true);
}
//open leads pop-up window
function handle_leads(){
    dialog.cancel(); 
    open_popup("Leads",600,400,"",true,true,{"call_back_function":"set_return_and_save_background2","form_name":"DetailView","field_to_name_array":{"id":"subpanel_id"},"passthru_data":{"child_field":"delegates","return_url":"index.php%3Fmodule%3DFP_events%26action%3DSubPanelViewer%26subpanel%3Ddelegates%26sugar_body_only%3D1","link_field_name":null,"module_name":"delegates","refresh_page":0,"pop_up_type":"leads"}},"MultiSelect",true);
}


function manage_delegates(){

    var ids = $("#custom_hidden_1").val();

    if(ids != ''){

        titleVal = SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_TITLE');

        htmltext = "<div id='no_check' style='display:none;color:#FF0000;' >"+SUGAR.language.get('FP_events', 'LBL_MANAGE_POPUP_ERROR')+"</div>";

        htmltext += "<table style='width: 100%;text-align:left;'>";
        htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><b><a href='#' onclick='handle_invited();return false;'>"+SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_INVITED')+"</a></b><td></tr>";
        htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><strong><a href='#' onclick='handle_not_invited();return false;'>"+SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_NOT_INVITED')+"</a></strong><td></tr>";
        htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><strong><a href='#' onclick='handle_attended();return false;'>"+SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_ATTENDED')+"</a></strong><td></tr>";
        htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><strong><a href='#' onclick='handle_not_attended();return false;'>"+SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_NOT_ATTENDED')+"</a></strong><td></tr>";

        htmltext += "</table>";
        //initialise dialog       
        dialog = new YAHOO.widget.Dialog('details_popup_div', {
                    width: '200px',
                    fixedcenter : "contained",    
                    visible : false, 
                    draggable: true,
                    effect:[//{effect:YAHOO.widget.ContainerEffect.SLIDE, duration:0.2},        
                    {effect:YAHOO.widget.ContainerEffect.FADE,duration:0.1}],
                        modal:true
                    });
        
        dialog.setHeader(titleVal);
        dialog.setBody(htmltext);
        dialog.setFooter('');

        var handleCancel = function() {
            this.cancel();
        };
        /*var handleSubmit = function() {
          this.cancel();
        };*/
        //set dialog box buttons
        var myButtons = [{ text: "Cancel", handler: handleCancel, isDefault: true }];
        dialog.cfg.queueProperty("buttons", myButtons);
        //render dialog box
        dialog.render(document.body);
        dialog.show();
    }
    else { //if no delegates are checked show error message

            titleVal = SUGAR.language.get('FP_events', 'LBL_MANAGE_DELEGATES_TITLE');
            htmltext = "<div id='no_check' style='color:#FF0000;' >"+SUGAR.language.get('FP_events', 'LBL_MANAGE_POPUP_ERROR')+"</div>";

            //initialise dialog       
            dialog = new YAHOO.widget.Dialog('details_popup_div', {
                        width: '200px',
                        fixedcenter : "contained",    
                        visible : false, 
                        draggable: true,
                        effect:[//{effect:YAHOO.widget.ContainerEffect.SLIDE, duration:0.2},        
                        {effect:YAHOO.widget.ContainerEffect.FADE,duration:0.1}],
                            modal:true
                        });
            
            dialog.setHeader(titleVal);
            dialog.setBody(htmltext);
            dialog.setFooter('');

            var handleCancel = function() {
                this.cancel();
            };
            /*var handleSubmit = function() {
              this.cancel();
            };*/
            //set dialog box buttons
            var myButtons = [{ text: "Cancel", handler: handleCancel, isDefault: true }];
            dialog.cfg.queueProperty("buttons", myButtons);
            //render dialog box
            dialog.render(document.body);
            dialog.show();
    }
       
}

function handle_invited(){
    var ids = $("#custom_hidden_1").val();
    var list = $("#select_entire_list").val();
    var eventid = $("[name='fp_events_id']").val();
    var data = 'id='+ids;
    data += '&event_id='+eventid;
    data += '&entire_list='+list;

    if(ids != ''){

        $.ajax({
            type: "POST",
            url: "index.php?module=FP_events&action=markasinvited",
            data: data,
            success: function(){
                // showSubPanel('fp_events_contacts','/fitzrovia/index.php?module=FP_events&offset=1&stamp=1364377103040618200&return_module=FP_events&action=DetailView&record=60b8111c-9fb9-da01-3632-514c89c028fe&ajax_load=1&loadLanguageJS=1&FP_events_fp_events_contacts_CELL_offset=end&FP_events_fp_events_contacts_CELL_ORDER_BY=&sort_order=asc&to_pdf=true&action=SubPanelViewer&subpanel=fp_events_contacts&layout_def_key=FP_events',true);
                showSubPanel('delegates',null,true,'FP_events');
            }
        });

            dialog.cancel();
    }
    else {

        $('#no_check').show();
    }
}

function handle_not_invited(){
        var ids = $("#custom_hidden_1").val();
        var list = $("#select_entire_list").val();
        var eventid = $("[name='fp_events_id']").val();
        var data = 'id='+ids;
        data += '&event_id='+eventid;
        data += '&entire_list='+list;

        if(ids != ''){

            $.ajax({
                type: "POST",
                url: "index.php?module=FP_events&action=markasnotinvited",
                data: data,
                success: function(){
                    showSubPanel('delegates',null,true,'FP_events');
                }
            });

            dialog.cancel();
        }
        else {

        $('#no_check').show();
    }
}

function handle_attended() {
        var ids = $("#custom_hidden_1").val();
        var list = $("#select_entire_list").val();
        var eventid = $("[name='fp_events_id']").val();
        var data = 'id='+ids;
        data += '&event_id='+eventid;
        data += '&entire_list='+list;

        if(ids != ''){

            $.ajax({
                type: "POST",
                url: "index.php?module=FP_events&action=markasattended",
                data: data,
                success: function(){
                    showSubPanel('delegates',null,true,'FP_events');
                }
            });

            dialog.cancel();
        }
         else {

        $('#no_check').show();
    }

}

function handle_not_attended(){
        var ids = $("#custom_hidden_1").val();
        var list = $("#select_entire_list").val();
        var eventid = $("[name='fp_events_id']").val();
        var data = 'id='+ids;
        data += '&event_id='+eventid;
        data += '&entire_list='+list;

        if(ids != ''){

            $.ajax({
                type: "POST",
                url: "index.php?module=FP_events&action=markasnotattended",
                data: data,
                success: function(){
                    showSubPanel('delegates',null,true,'FP_events');
                }
            });

             dialog.cancel();
        }
        else {

        $('#no_check').show();
    }
}

function manage_acceptances(){

    var ids = $("#custom_hidden_1").val();

    if(ids != ''){

        titleVal = SUGAR.language.get('FP_events', 'LBL_MANAGE_ACCEPTANCES_TITLE');

        htmltext = "<div id='no_check' style='display:none;color:#FF0000;' >"+SUGAR.language.get('FP_events', 'LBL_MANAGE_POPUP_ERROR')+"</div>";

        htmltext += "<table style='width: 100%;text-align:left;'>";
        //ID's from removed buttons now applied to links in this pop-up example : #MarkAsAcceptedForm
        htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><b><a id='MarkAsAcceptedForm' onclick='handle_accepted();return false;' href='#'>"+SUGAR.language.get('FP_events', 'LBL_MANAGE_ACCEPTANCES_ACCEPTED')+"</a></b><td></tr>";
        htmltext += "<tr><td style='padding: 2px;text-align:right;'><img src='custom/themes/default/images/view-process-own.png'></td><td style='padding: 2px;font-size: 110%;'><strong><a id='MarkAsDeclinedForm' onclick='handle_declined();return false;' href='#'>"+SUGAR.language.get('FP_events', 'LBL_MANAGE_ACCEPTANCES_DECLINED')+"</a></strong><td></tr>";
        
        htmltext += "</table>";
        //initialise dialog       
        dialog = new YAHOO.widget.Dialog('details_popup_div', {
                    width: '200px',
                    fixedcenter : "contained",    
                    visible : false, 
                    draggable: true,
                    effect:[//{effect:YAHOO.widget.ContainerEffect.SLIDE, duration:0.2},        
                    {effect:YAHOO.widget.ContainerEffect.FADE,duration:0.1}],
                        modal:true
                    });
        
        dialog.setHeader(titleVal);
        dialog.setBody(htmltext);
        dialog.setFooter('');

        var handleCancel = function() {
            this.cancel();
        };
        /*var handleSubmit = function() {
          this.cancel();
        };*/
        //set dialog box buttons
        var myButtons = [{ text: "Cancel", handler: handleCancel, isDefault: true }];
        dialog.cfg.queueProperty("buttons", myButtons);
        //render dialog box
        dialog.render(document.body);
        dialog.show();
    }
    else { //if no delegates are check show error message

            titleVal = SUGAR.language.get('FP_events', 'LBL_MANAGE_ACCEPTANCES_TITLE');
            
            htmltext = "<div id='no_check' style='color:#FF0000;' >"+SUGAR.language.get('FP_events', 'LBL_MANAGE_POPUP_ERROR')+"</div>";


            //initialise dialog       
            dialog = new YAHOO.widget.Dialog('details_popup_div', {
                        width: '200px',
                        fixedcenter : "contained",    
                        visible : false, 
                        draggable: true,
                        effect:[//{effect:YAHOO.widget.ContainerEffect.SLIDE, duration:0.2},        
                        {effect:YAHOO.widget.ContainerEffect.FADE,duration:0.1}],
                            modal:true
                        });
            
            dialog.setHeader(titleVal);
            dialog.setBody(htmltext);
            dialog.setFooter('');

            var handleCancel = function() {
                this.cancel();
            };
            /*var handleSubmit = function() {
              this.cancel();
            };*/
            //set dialog box buttons
            var myButtons = [{ text: "Cancel", handler: handleCancel, isDefault: true }];
            dialog.cfg.queueProperty("buttons", myButtons);
            //render dialog box
            dialog.render(document.body);
            dialog.show();
    }
}

function handle_accepted(){

        var ids = $("#custom_hidden_1").val();
        var list = $("#select_entire_list").val();
        var eventid = $("[name='fp_events_id']").val();
        var data = 'id='+ids;
        data += '&event_id='+eventid;
        data += '&entire_list='+list;

        if(ids != ''){

            $.ajax({
                type: "POST",
                url: "index.php?module=FP_events&action=markasaccepted",
                data: data,
                success: function(){
                    //var record = $("[name='record']").val();
                    //var url = 'index.php?sugar_body_only=1&module=FP_events&subpanel=delegates&action=SubPanelViewer&record='+record;
                    showSubPanel('delegates',null,true,'FP_events');
                }
            });

            dialog.cancel();
        }
        else{
            $('#no_check').show();
        }
}

function handle_declined(){

        var ids = $("#custom_hidden_1").val();
        var list = $("#select_entire_list").val();
        var eventid = $("[name='fp_events_id']").val();
        var data = 'id='+ids;
        data += '&event_id='+eventid;
        data += '&entire_list='+list;

        if(ids != ''){

            $.ajax({
                type: "POST",
                url: "index.php?module=FP_events&action=markasdeclined",
                data: data,
                success: function(){
                    showSubPanel('delegates',null,true,'FP_events');
                }
            });

            dialog.cancel();
        }
        else{
            $('#no_check').show();
        }    
}