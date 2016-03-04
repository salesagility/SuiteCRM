<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
global $mod_strings;
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="include/javascript/pivottable/pivot.css">
<script type="text/javascript" src="include/javascript/pivottable/pivot.js"></script>
<script type="text/javascript" src="include/javascript/pivottable/c3_renderers.js"></script>

<style>
    i.fa{
        margin-right:10px;
    }
</style>

<script type="text/javascript">
    var minNameLength = 5;
    var savedPivotList;

    $(function() {
        toastr.options={
            "positionClass": "toast-bottom-right"
        }
        tips = $( ".validateTips" );

        var dialog = $( "#dialogSave" ).dialog({
            autoOpen: false,
            height: 200,
            width: 350,
            modal: true,
            buttons: {
            "<?php echo $mod_strings['LBL_AN_BTN_SAVE_PIVOT']; ?>": savePivot,
                Cancel: function() {
                    dialog.dialog( "close" );
                }
            },
            close: function() {
                $("#pivotName").val("").removeClass( "ui-state-error" );
                tips.text("");
            }
        });

        var dialogLoad = $( "#dialogLoad" ).dialog({
            autoOpen: false,
            height: 200,
            width: 350,
            modal: true,
            buttons: {
            "<?php echo $mod_strings['LBL_AN_BTN_LOAD']; ?>": getPivotFromObjectToLoad,
                Cancel: function() {
                    dialogLoad.dialog( "close" );
                }
            },
            open:function(){
                populateLoadPivotList();
            }
        });

        var dialogDelete = $( "#dialogDelete" ).dialog({
            autoOpen: false,
            height: 200,
            width: 350,
            modal: true,
            buttons: {
                "<?php echo $mod_strings['LBL_AN_BTN_DELETE']; ?>": markPivotAsDeleted,
                Cancel: function() {
                    dialogDelete.dialog( "close" );
                }
            },
            open:function(){
                populateDeletePivotList();
            }
        });

        function markPivotAsDeleted()
        {
            //Send a request to delete the item
            //close the dialog
            //report success with toastr.info

            var id = $("#pivotDeleteList").val();
            if(id === undefined)
            {
                toastr.error("<?php echo $mod_strings['LBL_AN_PIVOT_DELETE_ERROR']; ?>");
            }
            else
            {
                $.ajax({
                        method: "POST",
                        url: "index.php",
                        data:{
                            'module': 'Home',
                            'action': 'deletePivot',
                            'to_pdf':1,
                            'id':id
                        }

                    })
                    .done(function( msg ) {
                        toastr.info("<?php echo $mod_strings['LBL_AN_DELETED_SUCCESSFULLY']; ?>"+" "+name);
                        $( "#dialogDelete" ).dialog("close");
                    });
            }

        }

        function getPivotFromObjectToLoad()
        {

            if($("#pivotLoadList").val() === "noEntries")
            {
                toastr.info("<?php echo $mod_strings['LBL_AN_PLEASE_SAVE']; ?>");
            }
            else
            {
                var item = $.grep(savedPivotList, function (item) {
                    return item.id == $("#pivotLoadList").val();
                });

                if(item === undefined || item[0] === undefined || item[0].type === undefined || item[0].config === undefined)
                {
                    toastr.error("<?php echo $mod_strings['LBL_AN_PIVOT_LOAD_ERROR']; ?>");
                }
                else
                {
                    //console.log(item[0]);
                    $('#analysisType').val(item[0].type);
                    loadPivot(item[0].type,item[0].config);
                    toastr.success(item[0].name + " "+ "<?php echo $mod_strings['LBL_AN_LOADED_SUCCESSFULLY']; ?>");
                    //console.log(item[0].config);
                }
            }



        }

        function populateLoadPivotList()
        {
            var list = "";
            if(savedPivotList === undefined || savedPivotList.length === 0)
            {
                list = "<option value='noEntries'><?php echo $mod_strings['LBL_AN_NO_SAVED_PIVOTS']; ?></option>";
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
                list = "<option value='noEntries'><?php echo $mod_strings['LBL_AN_NO_SAVED_PIVOTS']; ?></option>";
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
                var message ="<?php echo $mod_strings['LBL_AN_MIN_PIVOT_NANE']; ?>"+" "+minNameLength+" "+"<?php echo $mod_strings['LBL_AN_CHARACTERS']; ?>";
                tips.text(message);
                $("#pivotName").addClass('ui-state-error')
                toastr.error(message);
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
                        'module': 'Home',
                        'action': 'savePivot',
                        'to_pdf':1,
                        'name':name,
                        'type':area,
                        'config':config
                    }

                    })
                    .done(function( msg ) {
                        toastr.success("<?php echo $mod_strings['LBL_AN_PIVOT_SAVED_AS']; ?>"+" "+name);
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
                    'module': 'Home',
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
                    'module': 'Home',
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
                        'module': 'Home',
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
                        'module': 'Home',
                        'action': type,
                        'to_pdf':1
                    },
                    function (mps) {
                        $("#txtChosenSave").val($("#analysisType").val());
                        $("#txtConfigSave").val(config);

                        var configParsed =JSON.parse(config);
                        var combined = $.extend(configParsed,template);
                        //console.log(combined);

                        $("#output").pivotUI(mps,combined,true);
                    });
            }

        }

        getDataForPivot();

    });
</script>
<hr>
<label for="analysisType"><?php echo $mod_strings['LBL_AN_AREA_FOR_ANALYSIS']; ?></label>
<select id="analysisType">
    <option value="getSalesPivotData"><?php echo $mod_strings['LBL_AN_SALES']; ?></option>
    <option value="getAccountsPivotData"><?php echo $mod_strings['LBL_AN_ACCOUNTS']; ?></option>
    <option value="getLeadsPivotData"><?php echo $mod_strings['LBL_AN_LEADS']; ?></option>
</select>
<div id="output" style="margin: 30px;"></div>
<div id="config"></div>

<button type="button" id="btnSavePivot"><i class="fa fa-floppy-o"></i><?php echo $mod_strings['LBL_AN_BTN_SAVE']; ?></button>
<button type="button" id="btnLoadPivot"><i class="fa fa-search"></i><?php echo $mod_strings['LBL_AN_BTN_LOAD']; ?></button>
<button type="button" id="btnDeletePivot"><i class="fa fa-trash"></i><?php echo $mod_strings['LBL_AN_BTN_DELETE']; ?></button>

<input type="hidden" id="txtChosenSave">
<input type="hidden" id="txtConfigSave">
<div id="dialogSave" title="<?php echo $mod_strings['LBL_AN_SAVE_PIVOT']; ?>">
    <p class="validateTips"></p>
    <form>
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="pivotName" class="text ui-widget-content ui-corner-all">
        </fieldset>
    </form>
</div>
<div id="dialogLoad" title="<?php echo $mod_strings['LBL_AN_LOAD_PIVOT']; ?>">
<select id="pivotLoadList"></select>
</div>
<div id="dialogDelete" title="<?php echo $mod_strings['LBL_AN_DELETE_PIVOT']; ?>">
    <select id="pivotDeleteList"></select>
</div>