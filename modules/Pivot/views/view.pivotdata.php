<?php
/**
 *
 *
 * @package
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');
require_once('include/MVC/View/views/view.list.php');

class PivotViewPivotData extends SugarView {

    public function __construct() {
        parent::SugarView();
    }
    /**
     * display the form
     */
    public function display(){
        global $mod_strings,$hook_array;

        //parent::display();
        $buttonSave = $mod_strings['LBL_AN_BTN_SAVE_PIVOT'];
        $buttonLoad = $mod_strings['LBL_AN_BTN_LOAD'];
        $buttonDelete = $mod_strings['LBL_AN_BTN_DELETE'];
        $pivotDeleteError = $mod_strings['LBL_AN_PIVOT_DELETE_ERROR'];
        $deletedSuccessfully = $mod_strings['LBL_AN_DELETED_SUCCESSFULLY'];
        $pleaseSave = $mod_strings['LBL_AN_PLEASE_SAVE'];
        $loadError = $mod_strings['LBL_AN_PIVOT_LOAD_ERROR'];
        $loadedSuccessfully = $mod_strings['LBL_AN_LOADED_SUCCESSFULLY'];
        $noSavedPivots = $mod_strings['LBL_AN_NO_SAVED_PIVOTS'];
        $minPivotName = $mod_strings['LBL_AN_MIN_PIVOT_NANE'];
        $pivotCharacters = $mod_strings['LBL_AN_CHARACTERS'];
        $pivotSavedAs = $mod_strings['LBL_AN_PIVOT_SAVED_AS'];
        $areaForAnalysis = $mod_strings['LBL_AN_AREA_FOR_ANALYSIS'];
        $sales = $mod_strings['LBL_AN_SALES'];
        $accounts = $mod_strings['LBL_AN_ACCOUNTS'];
        $leads = $mod_strings['LBL_AN_LEADS'];
        $service = $mod_strings['LBL_AN_SERVICE'];
        $genericSave = $mod_strings['LBL_AN_BTN_SAVE'];
        $genericLoad = $mod_strings['LBL_AN_BTN_LOAD'];
        $genericDelete = $mod_strings['LBL_AN_BTN_DELETE'];
        $dialogSaveLabel = $mod_strings['LBL_AN_SAVE_PIVOT'];
        $dialogLoadLabel = $mod_strings['LBL_AN_LOAD_PIVOT'];
        $dialogDeleteLabel = $mod_strings['LBL_AN_DELETE_PIVOT'];

        $analytics = <<<EOT
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
            "$buttonSave": savePivot,
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
            "$buttonLoad": getPivotFromObjectToLoad,
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
                "$buttonDelete": markPivotAsDeleted,
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
                toastr.error("$pivotDeleteError");
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
                        toastr.info("$deletedSuccessfully"+" "+name);
                        $( "#dialogDelete" ).dialog("close");
                    });
            }

        }

        function getPivotFromObjectToLoad()
        {

            if($("#pivotLoadList").val() === "noEntries")
            {
                toastr.info("$pleaseSave");
            }
            else
            {
                var item = $.grep(savedPivotList, function (item) {
                    return item.id == $("#pivotLoadList").val();
                });

                if(item === undefined || item[0] === undefined || item[0].type === undefined || item[0].config === undefined)
                {
                    toastr.error("$loadError");
                }
                else
                {
                    //console.log(item[0]);
                    $('#analysisType').val(item[0].type);
                    loadPivot(item[0].type,item[0].config);
                    toastr.success(item[0].name + " "+ "$loadedSuccessfully");
                    //console.log(item[0].config);
                }
            }



        }

        function populateLoadPivotList()
        {
            var list = "";
            if(savedPivotList === undefined || savedPivotList.length === 0)
            {
                list = "<option value='noEntries'>$noSavedPivots</option>";
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
                list = "<option value='noEntries'>$noSavedPivots</option>";
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
                var message ="$minPivotName"+" "+minNameLength+" "+"$pivotCharacters";
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
                        'module': 'Pivot',
                        'action': 'savePivot',
                        'to_pdf':1,
                        'name':name,
                        'type':area,
                        'config':config
                    }

                    })
                    .done(function( msg ) {
                        toastr.success("$pivotSavedAs"+" "+name);
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
                        //console.log(combined);

                        $("#output").pivotUI(mps,combined,true);
                    });
            }

        }

        getDataForPivot();

    });
</script>
<!--<hr>-->
<label for="analysisType">$areaForAnalysis</label>
<select id="analysisType">
    <option value="getSalesPivotData">$sales</option>
    <option value="getAccountsPivotData">$accounts</option>
    <option value="getLeadsPivotData">$leads</option>
    <option value="getServicePivotData">$service</option>
</select>
<div id="output" style="margin: 30px;"></div>
<div id="config"></div>

<button type="button" id="btnSavePivot"><i class="fa fa-floppy-o"></i>$genericSave</button>
<button type="button" id="btnLoadPivot"><i class="fa fa-search"></i>$genericLoad</button>
<button type="button" id="btnDeletePivot"><i class="fa fa-trash"></i>$genericDelete</button>

<input type="hidden" id="txtChosenSave">
<input type="hidden" id="txtConfigSave">
<div id="dialogSave" title="$dialogSaveLabel">
    <p class="validateTips"></p>
    <form>
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="pivotName" class="text ui-widget-content ui-corner-all">
        </fieldset>
    </form>
</div>
<div id="dialogLoad" title="$dialogLoadLabel">
<select id="pivotLoadList"></select>
</div>
<div id="dialogDelete" title="$dialogDeleteLabel">
    <select id="pivotDeleteList"></select>
</div>
EOT;

        echo $analytics;
    }
}