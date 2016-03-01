{literal}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

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

    var minNameLength = 5;
    $(function () {



        toastr.options = {
            "positionClass": "toast-bottom-right"
        }
        tips = $(".validateTips");

        {/literal}
        $(".dialogSave-{$id}").dialog(
        {literal}
                {
            autoOpen: false,
            height: 200,
            width: 350,
            modal: true,
            buttons: {
                "Save pivot": savePivot,
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            close: function () {
                {/literal}
                $(".pivotName-{$id}").val("").removeClass("ui-state-error");
                {literal}
                tips.text("");
            }
        });



        {/literal}
        $(".analysisContainer-{$id} .dialogLoad-{$id}").dialog(
        {literal}
        {
        //$(".dialogLoad").dialog({
            autoOpen: false,
            height: 200,
            width: 350,
            modal: true,
            buttons: {
                "Load":{
                    text:"Load",
                    {/literal}
                    'class':'dialogBtnLoad-{$id}',
                    {literal}
                    click: function() {
                        var savedList = $(this).data("savedList");
                        ////console.log("PG "+savedList);
                        getPivotFromObjectToLoad(savedList);
                    }
                },

                Cancel: {
                    text:"Cancel",
                    {/literal}
                    'class':'dialogBtnCancel-{$id}',
                    {literal}
                    click:function () {
                        ////console.log("CLICKED ON CANCEL");
                        //$(this).dialog("close");
                        {/literal}
                        $(".dialogLoad-{$id}").dialog("close");
                        ////console.log("CLICKED ON CANCEL");
                        {literal}
                    }
                }
            },
            open: function () {
                ////console.log($(this).data("containingDiv"));

                var savedList = $(this).data("savedList");
                //console.log(savedList);
                populateLoadPivotList(savedList);
                var automated = $(this).data("automated");
                if(automated === true)
                {
                    {/literal}
                    //console.log($(".pivotLoadList-{$id} option[id='{$pivotToLoad}']"));
                    console.log("'{$id}'");
                    console.log("'{$pivotToLoad}'");
                    //$(".pivotLoadList-{$id} option[id='{$pivotToLoad}']").prop("selected","selected");
                    $(".pivotLoadList-{$id}").val('{$pivotToLoad}');

                    //$(".dialogBtnCancel-{$id}").click();
                    $(".dialogBtnLoad-{$id}").click();

                    //$(".dialogLoad-{$id} button[title='Close']").click();
                    //$(".dialogLoad-{$id}").parent().find("button[title='Close']").click()
                    //closeDialog(".dialogBtnLoad-{$id}");

                    $(".dialogLoad-{$id}").dialog("close");


                    {literal}
                }

            }
        });

        function closeDialog(item)
        {
            $(item).click();
        }

        function getPivotFromObjectToLoad(savedPivotList) {

            {/literal}
            if ($(".pivotLoadList-{$id}").val() === "noEntries")
            {literal}
            {
                toastr.info("Please save a pivot to load");
            }
            else {
                var item = $.grep(savedPivotList, function (item) {
                    {/literal}
                    return item.id == $(".pivotLoadList-{$id}").val();
                    {literal}
                });
                //console.log(item);
                if (item === undefined || item[0] === undefined || item[0].type === undefined || item[0].config === undefined) {
                    toastr.error("Sorry, this pivot cannot be loaded");
                }
                else {
                    ////console.log(item[0]);
                   // $('.analysisType').val(item[0].type);
                    loadPivot(item[0].type, item[0].config);
                    toastr.success(item[0].name + " loaded successfully")
                    ////console.log(item[0].config);
                }
            }


        }

        function populateLoadPivotList(savedList) {

            var list = "";
            {/literal}
            if (savedList === undefined || savedList.length === 0)
            {literal}
            {
                list = "<option value='noEntries'>No saved pivots</option>";
            }
            else {
                {/literal}
                $.each(savedList, function (i, v)
                {literal}
                {
                    list += "<option value='" + v.id + "'>" + v.name + "</option>";
                });
            }
            {/literal}
            $(".pivotLoadList-{$id}").empty().append(list);
            {literal}

        }

        function savePivot() {
            {/literal}
            var name = $(".pivotName-{$id}").val();
            {literal}
            if (name === undefined || name.length < minNameLength) {
                var message = "Pivot name must be at lest " + minNameLength + " characters";
                tips.text(message);
                $(".pivotName").addClass('ui-state-error')
                toastr.error(message);
            }
            else {

                //catch if there is an error with the saved pivot details
                {/literal}
                var area = $('.txtChosenSave-{$id}').val();
                var config = $('.txtConfigSave-{$id}').val();
                {literal}

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
                            {/literal}
                            $(".dialogSave-{$id}").dialog("close");
                            {literal}
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
                {/literal}
                $(".txtChosenSave-{$id}").val($(".analysisType-{$id}").val());
                $(".txtConfigSave-{$id}").val(JSON.stringify(config_copy, undefined, 2));

                //$(".btnLoadPivot-{$id}").data("automated",true).click();
                ////console.log($("select.pivotLoadList-{$id} option:contains('pgTest')"));//.prop("selected", "selected");
                ////console.log($("select.pivotLoadList-{$id}"));

                //$(".dialogBtnLoad-{$id}").click();
                //console.log("ALL LOADED");
                {literal}
            }
        }

        {/literal}
        $(".btnToggleUI-{$id}").on("click",function()
        {literal}
        {
            //console.log("TOGGLE CLICKED");
            //containingDiv =  $(".analysisContainer").has($(this));
            ////console.log(containingDiv);
            {/literal}
            //$(containingDiv).find("table.pvtUi tbody tr:lt(2), table.pvtUi tbody tr:nth-child(3) td:nth-child(1), select.analysisType, label.analysisTypeLabel").toggle();;
            $(".analysisContainer-{$id} table.pvtUi tbody tr:lt(2),.analysisContainer-{$id} table.pvtUi tbody tr:nth-child(3) td:nth-child(1), select.analysisType-{$id},.analysisContainer-{$id} label.analysisTypeLabel-{$id}").toggle();;
            {literal}
        });



        //$(".btnLoadPivot").on("click", function () {
        {/literal}
        $(".analysisContainer-{$id} .btnLoadPivot-{$id}").on("click",function()
        {literal}
        {

            //{literal}
            ////console.log(containingDiv);
            var automated = $(this).data("automated");
            //console.log(automated);

            {/literal}
            var containingDiv =  $(".analysisContainer-{$id}").has($(this));
            {literal}
            //console.log(containingDiv);
            ////console.log($(containingDiv).find(".dialogLoad"));
            $.getJSON("index.php",
                    {
                        'module': 'Home',
                        'action': 'getSavedPivotList',
                        'to_pdf': 1
                    },
                    function (mps) {
                        //savedPivotList = mps;
                        //  $(containingDiv).find(".dialogLoad").dialog("open");
                        //$(containingDiv).find(".dialogLoad").dialog("open");

                        {/literal}
                        $(".dialogLoad-{$id}").data("automated",automated).data("savedList",mps).dialog("open");
                        {literal}

                    });

            //Only run the automated sequence for the first pass
            $(this).data("automated",false);
        });

        {/literal}
        $(".btnSavePivot-{$id}").on("click", function ()
        {literal}
        {
            /*
             var config = $(".txtConfig").val();
             var type = "getLeadsPivotData";
             loadPivot(type,config);
             */
            //containingDiv =  $(".analysisContainer").has($(this));

            //console.log("OPEN DIALOG");
            //$(containingDiv).find(".dialogSave").dialog("open");
            {/literal}
            $(".dialogSave-{$id}").dialog("open");
            {literal}
        });

        {/literal}
        $('.analysisContainer-{$id} .analysisType-{$id}').change(function ()
        {literal}
        {
            {/literal}
            //containingDiv =  $(".analysisContainer").has($(this));

            ////console.log(containingDiv);
            ////console.log($(containingDiv).find(".txtChosenSave").val());
            ////console.log($(containingDiv).find(".analysisType").val());

            $(".txtChosenSave-{$id}").val($(".analysisType-{$id}").val());

            //$(".txtChosenSave").val($(".analysisType").val());
            // $(".txtConfigSave").val("");
            //PG refresh the config save

            ////console.log($(this));
            getDataForPivot($('.analysisContainer-{$id}'));
            //$("btnToggleUI-{$id}").click();
            //$(".analysisContainer-{ $id} table.pvtUi tbody tr:lt(2),.analysisContainer-{ $id} table.pvtUi tbody tr:nth-child(3) td:nth-child(1), select.analysisType-{ $id},.analysisContainer-{ $id} label.analysisTypeLabel").toggle();;
            {literal}
        });

        function getDataForPivot(containingDiv) {
            {/literal}
            var type = $(containingDiv).find('.analysisType-{$id}').val()// $('.analysisType').val();
            {literal}
            if (type !== undefined) {
                {/literal}
                //console.log($(".output-{$id}"));
                {literal}
                $.getJSON("index.php",
                        {
                            'module': 'Home',
                            'action': type,
                            'to_pdf': 1
                        },
                        function (mps) {
                            //$(".output").pivotUI(mps, template, true);
                            {/literal}
                            //console.log("HERE");
                            $(".output-{$id}").pivotUI(mps, template, true);
                            ////console.log("T "+{$showUI});

                            {literal}

                            //if(true)
                            //{

                            //}

                            //{literal}
                        });
            }

        }

        function loadPivot(type, config) {

            //console.log("PG TYPE "+type);
            //console.log("PG CONFIG "+config);

            if (type !== undefined) {
                {/literal}
                $(".analysisType-{$id}").val(type);
                {literal}
                $.getJSON("index.php",
                        {
                            'module': 'Home',
                            'action': type,
                            'to_pdf': 1
                        },
                        function (mps) {
                            {/literal}
                            $(".txtChosenSave-{$id}").val($(".analysisType").val());
                            $(".txtConfigSave-{$id}").val(config);
                            {literal}
                            var configParsed = JSON.parse(config);
                            var combined = $.extend(configParsed, template);
                            ////console.log(combined);

                            {/literal}
                            $(".output-{$id}").pivotUI(mps, combined, true);
                            if(!{$showUI})$(".btnToggleUI-{$id}").click();
                            {literal}

                        });
            }

        }

        //var containingDivs = $(".analysisContainer");
        //$.each(containingDivs,function(i,v){
        //    getDataForPivot(v);
        //});

        {/literal}

        getDataForPivot($(".analysisContainer-{$id}"));
        $(".btnLoadPivot-{$id}").data("automated",true).click();


        {literal}





    });
    {/literal}
</script>
<hr>

<div class="analysisContainer-{$id}">
    <!--<label class="analysisTypeLabel-{$id}" for="analysisType-{$id}">Area for Analysis:</label>
    <select class="analysisType-{$id}">
        <option value="getSalesPivotData">Sales</option>
        <option value="getAccountsPivotData">Accounts</option>
        <option value="getLeadsPivotData">Leads</option>
    </select>-->
    <div class="output-{$id}" style="margin: 30px;"></div>
    <div class="config-{$id}"></div>
    <!--<textarea id="txtConfig"></textarea>-->
    <button type="button" class="btnSavePivot-{$id}" style="display:none;"><i class="fa fa-floppy-o"></i>Save</button>
    <button type="button" class="btnLoadPivot-{$id}" style="display:none;"><i class="fa fa-search"></i>Load</button>
    <button type="button" class="btnToggleUI-{$id}" style="display:none;"><i class="fa fa-toggle-on"></i>Toggle UI</button>

    <input type="hidden" class="txtChosenSave-{$id}">
    <input type="hidden" class="txtConfigSave-{$id}">
    <div class="dialogSave-{$id}" title="Save pivot">
        <p class="validateTips-{$id}"></p>
        <form>
            <fieldset>
                <label for="name-{$id}">Name</label>
                <input type="text" name="name-{$id}" class="pivotName-{$id}" class="text ui-widget-content ui-corner-all">
            </fieldset>
        </form>
    </div>
    <div class="dialogLoad-{$id}" title="Load pivot">
        <select class="pivotLoadList-{$id}"></select>
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
