<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
global $sugar_config, $mod_strings;
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<link rel="stylesheet" type="text/css" href="include/javascript/pivottable/pivot.css">
<!--<script type="text/javascript" src="include/javascript/jquery/jquery-min.js"></script>-->
<!--<script type="text/javascript" src="include/javascript/jquery/jquery-ui-min.js"></script>-->
<script type="text/javascript" src="include/javascript/pivottable/pivot.js"></script>
<script type="text/javascript" src="include/javascript/pivottable/c3_renderers.js"></script>

<style>
    i.fa {
        margin-right: 10px;
    }
</style>
<!--<script type="text/javascript" src="include/javascript/cookie.js"></script>-->

<script type="text/javascript">

//    var containerId = new Date().getTime();

    var minNameLength = 5;
    var savedPivotList;

    $(function () {


        toastr.options = {
            "positionClass": "toast-bottom-right"
        }
        tips = $(".validateTips");

        var dialog = $(".dialogSave").dialog({
            autoOpen: false,
            height: 200,
            width: 350,
            modal: true,
            buttons: {
                "Save pivot": savePivot,
                Cancel: function () {
                    dialog.dialog("close");
                }
            },
            close: function () {
                $(".pivotName").val("").removeClass("ui-state-error");
                tips.text("");
            }
        });

        var dialogLoad = $(".dialogLoad").dialog({
            autoOpen: false,
            height: 200,
            width: 350,
            modal: true,
            buttons: {
                "Load": getPivotFromObjectToLoad,
                Cancel: function () {
                    dialogLoad.dialog("close");
                }
            },
            open: function () {
                console.log($(this).data("containingDiv"));
                populateLoadPivotList();
            }
        });

        function getPivotFromObjectToLoad() {

            if ($(".pivotLoadList").val() === "noEntries") {
                toastr.info("Please save a pivot to load");
            }
            else {
                var item = $.grep(savedPivotList, function (item) {
                    return item.id == $(".pivotLoadList").val();
                });

                if (item === undefined || item[0] === undefined || item[0].type === undefined || item[0].config === undefined) {
                    toastr.error("Sorry, this pivot cannot be loaded");
                }
                else {
                    //console.log(item[0]);
                    $('.analysisType').val(item[0].type);
                    loadPivot(item[0].type, item[0].config);
                    toastr.success(item[0].name + " loaded successfully")
                    //console.log(item[0].config);
                }
            }


        }

        function populateLoadPivotList() {
            var list = "";
            if (savedPivotList === undefined || savedPivotList.length === 0) {
                list = "<option value='noEntries'>No saved pivots</option>";
            }
            else {
                $.each(savedPivotList, function (i, v) {
                    list += "<option value='" + v.id + "'>" + v.name + "</option>";
                });
            }

            $(".pivotLoadList").empty().append(list);
        }

        function savePivot() {
            var name = $(".pivotName").val();
            if (name === undefined || name.length < minNameLength) {
                var message = "Pivot name must be at lest " + minNameLength + " characters";
                tips.text(message);
                $(".pivotName").addClass('ui-state-error')
                toastr.error(message);
            }
            else {

                //catch if there is an error with the saved pivot details
                var area = $('.txtChosenSave').val();
                var config = $('.txtConfigSave').val();


                $.ajax({
                        method: "POST",
                        url: "index.php",
                        data: {
                            'module': 'Home',
                            'action': 'savePivot',
                            'to_pdf': 1,
                            'name': name,
                            'type': area,
                            'config': config
                        }

                    })
                    .done(function (msg) {
                        toastr.success("Pivot saved as " + name);
                        $(".dialogSave").dialog("close");
                    });
            }

        }


        var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers);
        var template = {
            renderers: renderers,
            onRefresh: function (config) {
                var config_copy = JSON.parse(JSON.stringify(config));
                delete config_copy["aggregators"];
                delete config_copy["renderers"];
                delete config_copy["rendererOptions"];
                delete config_copy["localeStrings"];
                $(".txtChosenSave").val($(".analysisType").val());
                $(".txtConfigSave").val(JSON.stringify(config_copy, undefined, 2));
            }
        }

        $(".btnToggleUI").on("click",function(){
            containingDiv =  $(".analysisContainer").has($(this));
            console.log(containingDiv);
            $(containingDiv).find("table.pvtUi tbody tr:lt(2), table.pvtUi tbody tr:nth-child(3) td:nth-child(1), select.analysisType, label.analysisTypeLabel").toggle();;
        });

        $(".btnLoadPivot").on("click", function () {
            containingDiv =  $(".analysisContainer").has($(this));
            console.log(containingDiv);
            console.log($(containingDiv).find(".dialogLoad"));
            $.getJSON("index.php",
                {
                    'module': 'Home',
                    'action': 'getSavedPivotList',
                    'to_pdf': 1
                },
                function (mps) {
                    savedPivotList = mps;
                  //  $(containingDiv).find(".dialogLoad").dialog("open");
                    $(".dialogLoad").dialog("open");

                });
        });

        $(".btnSavePivot").on("click", function () {
            /*
             var config = $(".txtConfig").val();
             var type = "getLeadsPivotData";
             loadPivot(type,config);
             */
            containingDiv =  $(".analysisContainer").has($(this));
            $(containingDiv).find(".dialogSave").dialog("open");
        });

        $('.analysisType').change(function () {
            containingDiv =  $(".analysisContainer").has($(this));
            //console.log(containingDiv);
            //console.log($(containingDiv).find(".txtChosenSave").val());
            //console.log($(containingDiv).find(".analysisType").val());

            $(containingDiv).find(".txtChosenSave").val($(containingDiv).find(".analysisType").val());
            //$(".txtChosenSave").val($(".analysisType").val());
            // $(".txtConfigSave").val("");
            //PG refresh the config save

            //console.log($(this));
            getDataForPivot(containingDiv);
        });

        function getDataForPivot(containingDiv) {
            var type = $(containingDiv).find('.analysisType').val()// $('.analysisType').val();
            if (type !== undefined) {
                $.getJSON("index.php",
                    {
                        'module': 'Home',
                        'action': type,
                        'to_pdf': 1
                    },
                    function (mps) {
                        //$(".output").pivotUI(mps, template, true);
                        $(containingDiv).find(".output").pivotUI(mps, template, true);
                    });
            }

        }

        function loadPivot(type, config) {
            if (type !== undefined) {
                $(".analysisType").val(type);
                $.getJSON("index.php",
                    {
                        'module': 'Home',
                        'action': type,
                        'to_pdf': 1
                    },
                    function (mps) {
                        $(".txtChosenSave").val($(".analysisType").val());
                        $(".txtConfigSave").val(config);

                        var configParsed = JSON.parse(config);
                        var combined = $.extend(configParsed, template);
                        //console.log(combined);

                        $(".output").pivotUI(mps, combined, true);
                    });
            }

        }

        var containingDivs = $(".analysisContainer");
        $.each(containingDivs,function(i,v){
            getDataForPivot(v);
        });


    });
</script>
<hr>
<div class="analysisContainer">
    <label class="analysisTypeLabel" for="analysisType">Area for Analysis:</label>
    <select class="analysisType">
        <option value="getSalesPivotData">Sales</option>
        <option value="getAccountsPivotData">Accounts</option>
        <option value="getLeadsPivotData">Leads</option>
    </select>
    <div class="output" style="margin: 30px;"></div>
    <div class="config"></div>
    <!--<textarea id="txtConfig"></textarea>-->
    <button type="button" class="btnSavePivot"><i class="fa fa-floppy-o"></i>Save</button>
    <button type="button" class="btnLoadPivot"><i class="fa fa-search"></i>Load</button>
    <button type="button" class="btnToggleUI"><i class="fa fa-toggle-on"></i>Toggle UI</button>

    <input type="hidden" class="txtChosenSave">
    <input type="hidden" class="txtConfigSave">
    <div class="dialogSave" title="Save pivot">
        <p class="validateTips"></p>
        <form>
            <fieldset>
                <label for="name">Name</label>
                <input type="text" name="name" class="pivotName" class="text ui-widget-content ui-corner-all">
            </fieldset>
        </form>
    </div>
    <div class="dialogLoad" title="Load pivot">
        <select class="pivotLoadList"></select>
    </div>
</div>

<!--<div class="analysisContainer">
    <label for="analysisType">Area for Analysis:</label>
    <select class="analysisType">
        <option value="getSalesPivotData">Sales</option>
        <option value="getAccountsPivotData">Accounts</option>
        <option value="getLeadsPivotData">Leads</option>
    </select>
    <div class="output" style="margin: 30px;"></div>
    <div class="config"></div>
    <button type="button" class="btnSavePivot"><i class="fa fa-floppy-o"></i>Save</button>
    <button type="button" class="btnLoadPivot"><i class="fa fa-search"></i>Load</button>
    <button type="button" class="btnToggleUI"><i class="fa fa-toggle-on"></i>Toggle UI</button>

    <input type="hidden" class="txtChosenSave">
    <input type="hidden" class="txtConfigSave">
    <div class="dialogSave" title="Save pivot">
        <p class="validateTips"></p>
        <form>
            <fieldset>
                <label for="name">Name</label>
                <input type="text" name="name" class="pivotName" class="text ui-widget-content ui-corner-all">
            </fieldset>
        </form>
    </div>
    <div class="dialogLoad" title="Load pivot">
        <select class="pivotLoadList"></select>
    </div>
</div>-->