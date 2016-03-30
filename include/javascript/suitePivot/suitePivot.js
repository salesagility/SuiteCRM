var minNameLength = 5;
var savedPivotList;

$(function() {

    //Chrome drag and drop fix
    //The category drag and drop is thrown out and scrolls down quickly (and is not usable) hence this fix
    //This is taken from the style.js for responding to smaller screens
    //$('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 sidebar main');
    //$('.sidebar,#buttontoggle').hide();
    $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10');
    //End of Chrome drag and drop fix

    var buttonLoad = SUGAR.language.get('Pivot','LBL_AN_BTN_LOAD');
    var buttonCancel = SUGAR.language.get('Pivot','LBL_AN_BTN_CANCEL');
    var buttonSave = SUGAR.language.get('Pivot','LBL_AN_BTN_SAVE');
    var buttonDelete = SUGAR.language.get('Pivot','LBL_AN_BTN_DELETE');
    var pivotDeleteError = SUGAR.language.get('Pivot','LBL_AN_PIVOT_DELETE_ERROR');
    var deletedSuccessfully = SUGAR.language.get('Pivot','LBL_AN_DELETED_SUCCESSFULLY');
    var pleaseSave = SUGAR.language.get('Pivot','LBL_AN_PLEASE_SAVE');
    var loadError = SUGAR.language.get('Pivot','LBL_AN_PIVOT_LOAD_ERROR');
    var noSavedPivots = SUGAR.language.get('Pivot','LBL_AN_NO_SAVED_PIVOTS');
    var loadedSuccessfully = SUGAR.language.get('Pivot','LBL_AN_LOADED_SUCCESSFULLY');
    var minPivotName = SUGAR.language.get('Pivot','LBL_AN_MIN_PIVOT_NAME');
    var pivotCharacters = SUGAR.language.get('Pivot','LBL_AN_CHARACTERS');
    var pivotSavedAs = SUGAR.language.get('Pivot','LBL_AN_PIVOT_SAVED_AS');

    var tips = $( ".validateTips" );

    var saveDialogButtons = {};
    saveDialogButtons[buttonSave] = savePivot;
    saveDialogButtons[buttonCancel] = function() {dialogSave.dialog( "close" );};
    var dialogSave = $( "#dialogSave" ).dialog({
        autoOpen: false,
        height: 200,
        width: 350,
        modal: true,
        buttons: saveDialogButtons,
        close: function() {
            $("#pivotName").val("").removeClass( "ui-state-error" );
            tips.text("");
        }
    });


    var loadDialogButtons = {};
    loadDialogButtons[buttonLoad] = getPivotFromObjectToLoad;
    loadDialogButtons[buttonCancel] = function() {dialogLoad.dialog( "close" );};
    var dialogLoad = $( "#dialogLoad" ).dialog({
        autoOpen: false,
        height: 200,
        width: 350,
        modal: true,
        buttons: loadDialogButtons,
        open:function(){
            populateLoadPivotList();
        }
    });

    var deleteDialogButtons = {};
    deleteDialogButtons[buttonDelete] = markPivotAsDeleted;
    deleteDialogButtons[buttonCancel] = function() {dialogDelete.dialog( "close" );};
    var dialogDelete = $( "#dialogDelete" ).dialog({
        autoOpen: false,
        height: 200,
        width: 350,
        modal: true,
        buttons: deleteDialogButtons,
        open:function(){
            populateDeletePivotList();
        }
    });

    function markPivotAsDeleted()
    {
        var id = $("#pivotDeleteList").val();
        if(id === undefined || id === "noEntries")
        {
            alert(pivotDeleteError);
        }
        else
        {
            $.ajax({
                    method: "POST",
                    url: "index.php",
                    data:{
                        'module': 'Pivot',
                        'action': 'deletePivot',
                        'to_pdf':1,
                        'id':id
                    }

                })
                .done(function( msg ) {
                    alert(deletedSuccessfully+" "+name);
                    $( "#dialogDelete" ).dialog("close");
                });
        }

    }

    function getPivotFromObjectToLoad()
    {

        if($("#pivotLoadList").val() === "noEntries")
        {
            alert(pleaseSave);
        }
        else
        {
            var item = $.grep(savedPivotList, function (item) {
                return item.id == $("#pivotLoadList").val();
            });

            if(item === undefined || item[0] === undefined || item[0].type === undefined || item[0].config === undefined)
            {
                alert(loadError);
            }
            else
            {
                $('#analysisType').val(item[0].type);
                loadPivot(item[0].type,item[0].config);
                //alert(item[0].name + " "+loadedSuccessfully);
            }
        }



    }

    function populateLoadPivotList()
    {
        var list = "";
        if(savedPivotList === undefined || savedPivotList.length === 0)
        {
            list = "<option value='noEntries'>noSavedPivots</option>";
        }
        else
        {
            $.each(savedPivotList,function(i,v){
                list+= "<option value='"+ v.id +"'>"+ v.name+"</option>";
            });
        }

        $("#pivotLoadList").empty().append(list);
    }

    function populateDeletePivotList()
    {
        var list = "";
        if(savedPivotList === undefined || savedPivotList.length === 0)
        {
            list = "<option value='noEntries'>noSavedPivots</option>";
        }
        else
        {
            $.each(savedPivotList,function(i,v){
                list+= "<option value='"+ v.id +"'>"+ v.name+"</option>";
            });
        }

        $("#pivotDeleteList").empty().append(list);
    }


    function savePivot()
    {
        var name = $("#pivotName").val();
        if(name === undefined || name.length < minNameLength)
        {
            var message =minPivotName+" "+minNameLength+" "+pivotCharacters;
            tips.text(message);
            $("#pivotName").addClass('ui-state-error')
            alert(message);
        }
        else
        {

            //catch if there is an error with the saved pivot details
            var area = $('#txtChosenSave').val();
            var config = $('#txtConfigSave').val();


            $.ajax({
                    method: "POST",
                    url: "index.php",
                    data:{
                        'module': 'Pivot',
                        'action': 'savePivot',
                        'to_pdf':1,
                        'name':name,
                        'type':area,
                        'config':config
                    }

                })
                .done(function( msg ) {
                    alert(pivotSavedAs+" "+name);
                    $( "#dialogSave" ).dialog("close");
                });
        }

    }

    var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers);


    var template = {
        renderers: renderers,
        onRefresh:function(config)
        {
            var config_copy = JSON.parse(JSON.stringify(config));
            delete config_copy["aggregators"];
            delete config_copy["renderers"];
            delete config_copy["rendererOptions"];
            delete config_copy["localeStrings"];
            $("#txtChosenSave").val($("#analysisType").val());
            $("#txtConfigSave").val(JSON.stringify(config_copy, undefined, 2));
        }
    }

    $("#btnLoadPivot").on("click",function(){
        $.getJSON("index.php",
            {
                'module': 'Pivot',
                'action': 'getSavedPivotList',
                'to_pdf':1
            },
            function (mps) {
                savedPivotList = mps;
                $( "#dialogLoad" ).dialog("open");

            });
    });

    $("#btnDeletePivot").on("click",function(){
        $.getJSON("index.php",
            {
                'module': 'Pivot',
                'action': 'getSavedPivotList',
                'to_pdf':1
            },
            function (mps) {
                savedPivotList = mps;
                $( "#dialogDelete" ).dialog("open");

            });
    });

    $("#btnSavePivot").on("click",function(){
        $( "#dialogSave" ).dialog("open");
    });

    $('#analysisType').change(function(){
        $("#txtChosenSave").val($("#analysisType").val());
        getDataForPivot();
    });

    function getDataForPivot()
    {
        var type = $('#analysisType').val();
        if(type !== undefined)
        {
            $.getJSON("index.php",
                {
                    'module': 'Pivot',
                    'action': type,
                    'to_pdf':1
                },
                function (mps) {
                    $("#output").pivotUI(mps, template,true);
                });
        }

    }

    function loadPivot(type,config)
    {
        if(type !== undefined)
        {
            $("#analysisType").val(type);
            $.getJSON("index.php",
                {
                    'module': 'Pivot',
                    'action': type,
                    'to_pdf':1
                },
                function (mps) {
                    $("#txtChosenSave").val($("#analysisType").val());
                    $("#txtConfigSave").val(config);
                    var configParsed =JSON.parse(config);
                    var combined = $.extend(configParsed,template);
                    //Remove the two keys that can cause issue if passed as array rather than object
                    if("derivedAttributes" in combined)
                        delete configParsed["derivedAttributes"];

                    console.log(combined);
                    $("#output").pivotUI(mps,combined,true);
                });
        }

    }

    getDataForPivot();

});
