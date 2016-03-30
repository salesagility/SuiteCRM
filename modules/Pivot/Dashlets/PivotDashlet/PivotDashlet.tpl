{literal}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
<script type="text/javascript" src="include/javascript/d3/d3.min.js"></script>
<script type="text/javascript" src="include/javascript/c3/c3.min.js"></script>
<script type="text/javascript" src="include/javascript/touchPunch/jquery.ui.touch-punch.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="include/javascript/pivottable/pivot.css">
<script type="text/javascript" src="include/javascript/pivottable/pivot.js"></script>
<script type="text/javascript" src="include/javascript/pivottable/c3_renderers.js"></script>
<script type="text/javascript" src="include/javascript/suitePivot/suitePivot.js"></script>

<style>
    i.fa {
        margin-right: 10px;
    }
</style>

<script type="text/javascript">
    var refreshRate = 60000;
    var minNameLength = 5;
    $(function () {
        tips = $(".validateTips");

        {/literal}
        $(".analysisContainer-{$id} .dialogLoad-{$id}").dialog(
        {literal}
        {
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
                        getPivotFromObjectToLoad(savedList);
                    }
                },

                Cancel: {
                    text:"Cancel",
                    {/literal}
                    'class':'dialogBtnCancel-{$id}',
                    {literal}
                    click:function () {
                        {/literal}
                        $(".dialogLoad-{$id}").dialog("close");
                        {literal}
                    }
                }
            },
            open: function () {
                var savedList = $(this).data("savedList");
                populateLoadPivotList(savedList);
                var automated = $(this).data("automated");
                if(automated === true)
                {
                    {/literal}
                    $(".pivotLoadList-{$id}").val('{$pivotToLoad}');
                    $(".dialogBtnLoad-{$id}").click();
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
                {/literal}
                {literal}
            }
            else {
                var item = $.grep(savedPivotList, function (item) {
                    {/literal}
                    return item.id == $(".pivotLoadList-{$id}").val();
                    {literal}
                });
                if (item === undefined || item[0] === undefined || item[0].type === undefined || item[0].config === undefined) {
                    {/literal}
                    {literal}
                }
                else {
                    {/literal}
                    $(".type-{$id}").val(item[0].type);
                    //console.log(item[0].type);
                    //console.log(item[0].config);
                    loadPivot(item[0].type, item[0].config);
                    {literal}
                }
            }
        }

        function populateLoadPivotList(savedList) {

            var list = "";
            {/literal}
            if (savedList === undefined || savedList.length === 0)
            {literal}
            {
                {/literal}
                list = "<option value='noEntries'>"+"{$lblNoSavedPivots}"+"</option>";
                {literal}
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
                {literal}
            }
        }

        {/literal}
        $(".btnToggleUI-{$id}").on("click",function()
        {literal}
        {
            //This is to ascertain if the pivot ui is laying out the column options horizontally or vertically
            //It is vertically for larger data sets.  This allows us to hide the pivot ui appropriately
            var columnLayout = $("table.pvtUi tr td:nth-child(3)").length;

            {/literal}
            if(columnLayout > 0)
                $(".analysisContainer-{ $id} table.pvtUi tbody tr:lt(1),.analysisContainer-{ $id} table.pvtUi tbody tr:eq(1) td:lt(2)").toggle();
            else
                $(".analysisContainer-{$id} table.pvtUi tbody tr:lt(2),.analysisContainer-{$id} table.pvtUi tbody tr:nth-child(3) td:nth-child(1)").toggle();
            {literal}
        });

        {/literal}
        $(".analysisContainer-{$id} .btnLoadPivot-{$id}").on("click",function()
        {literal}
        {
            var automated = $(this).data("automated");
            {/literal}
            var containingDiv =  $(".analysisContainer-{$id}").has($(this));
            {literal}
            $.getJSON("index.php",
                    {
                        'module': 'Pivot',
                        'action': 'getSavedPivotList',
                        'to_pdf': 1
                    },
                    function (mps) {
                        {/literal}
                        $(".dialogLoad-{$id}").data("automated",automated).data("savedList",mps).dialog("open");
                        {literal}
                    });
        });

        {/literal}
        $('.analysisContainer-{$id} .analysisType-{$id}').change(function ()
        {literal}
        {
            {/literal}
            $(".txtChosenSave-{$id}").val($(".analysisType-{$id}").val());
            {literal}
        });

        function getDataForPivot(containingDiv) {
            {/literal}
            var type = $(containingDiv).find('.analysisType-{$id}').val()// $('.analysisType').val();
            {literal}
            if (type !== undefined) {
                {/literal}
                {literal}
                $.getJSON("index.php",
                        {
                            'module': 'Pivot',
                            'action': type,
                            'to_pdf': 1
                        },
                        function (mps) {
                            {/literal}
                            $(".output-{$id}").pivotUI(mps, template, true);
                            {literal}
                        });
            }

        }

        function loadPivot(type, config) {
            if (type !== undefined) {
                {/literal}
                $(".analysisType-{$id}").val(type);
                {literal}
                $.getJSON("index.php",
                        {
                            'module': 'Pivot',
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
                            //Remove the two items that can cause issue by being array rather than objects
                            if("derivedAttributes" in combined)
                                delete configParsed["derivedAttributes"];

                            {/literal}
                            $(".output-{$id}").pivotUI(mps, combined, true);
                            if(!{$showUI})$(".btnToggleUI-{$id}").click();
                            {literal}

                        });
            }

        }

        function refreshPivot(item) {
            {/literal}
            var type = $(item).val();
            {literal}
            if (type !== undefined) {
                $.getJSON("index.php",
                        {
                            'module': 'Pivot',
                            'action': type,
                            'to_pdf': 1
                        },
                        function (mps) {
                            {/literal}
                            $(".output-{$id}").pivotUI(mps, [], false);
                            if(!{$showUI})$(".btnToggleUI-{$id}").click();
                            {literal}

                        });
            }

        }

        {/literal}

        $(".btnLoadPivot-{$id}").data("automated",true).click();
        {literal}

        setInterval(function(){
            {/literal}
            refreshPivot("input.type-{$id}");
            {literal}
        },refreshRate);


    });
    {/literal}
</script>
<hr>

<div class="analysisContainer-{$id}">
    <input type="hidden" class="type-{$id}">
    <div class="output-{$id}" style="margin: 30px;"></div>
    <div class="config-{$id}"></div>
    <button type="button" class="btnLoadPivot-{$id}" style="display:none;"><i class="fa fa-search"></i>{$lblBtnLoad}</button>
    <button type="button" class="btnToggleUI-{$id}" style="display:none;"><i class="fa fa-toggle-on"></i>{$lblToggleUI}</button>
    <input type="hidden" class="txtChosenSave-{$id}">
    <input type="hidden" class="txtConfigSave-{$id}">
    <div class="dialogLoad-{$id}" title="Load pivot">
        <select class="pivotLoadList-{$id}"></select>
    </div>
</div>
