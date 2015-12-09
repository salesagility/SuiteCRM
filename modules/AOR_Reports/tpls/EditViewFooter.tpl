<div id="report-editview-footer">


{literal}
    <script src="modules/AOR_Reports/js/jqtree/tree.jquery.js"></script>
    <script src="modules/AOR_Fields/fieldLines.js"></script>
    <script src="modules/AOR_Conditions/conditionLines.js"></script>
    <script src="modules/AOR_Charts/chartLines.js"></script>

    <link rel="stylesheet" href="include/javascript/jquery/themes/base/jquery-ui.min.css">
    <script src="include/javascript/jquery/jquery-ui-min.js"></script>

<script>
    $(document).ready(function(){
        SUGAR.util.doWhen("typeof $('#fieldTree').tree != 'undefined'", function(){
            var $moduleTree = $('#fieldTree').tree({
                data: {},
                dragAndDrop: false,
                //selectable: true,
                onDragStop: function(node, e,thing){
//                    var target = $(document.elementFromPoint(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset));
//                    if(node.type != 'field'){
//                        return;
//                    }
//                    if(target.closest('#fieldLines').length > 0){
//                        addNodeToFields(node);
//                        updateChartDimensionSelects();
//                    }else if(target.closest('#conditionLines').length > 0){
//                        addNodeToConditions(node);
//                    }

                },
                onCanMoveTo: function(){
                    return false;
                }
            });

        function loadTreeData(module, node){
            $.getJSON('index.php',
                    {
                        'module' : 'AOR_Reports',
                        'action' : 'getModuleTreeData',
                        'aor_module' : module,
                        'view' : 'JSON'
                    },
                    function(relData){
                        processTreeData(relData, node);
                    }
            );
        }

            var treeDataLeafs = [];

            var dropFieldLine = function(node) {
                addNodeToFields(node);
                updateChartDimensionSelects();
            };

            var dropConditionLine = function(node) {
                addNodeToConditions(node);
                LogicalOperatorHandler.hideUnnecessaryLogicSelects();
                ConditionOrderHandler.setConditionOrders();
                ParenthesisHandler.addParenthesisLineIdent();
            };

            var showTreeDataLeafs = function(treeDataLeafs, module) {
                $('#module-name').html('(' + module + ')');
                $('#fieldTreeLeafs').remove();
                $('#detailpanel_fields_select').append('<div id="fieldTreeLeafs" class="dragbox"></div>');
                $('#fieldTreeLeafs').tree({
                    data: treeDataLeafs,
                    dragAndDrop: true,
                    selectable: true,
                    onDragStop: function(node, e,thing){
                        var target = $(document.elementFromPoint(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset));
                        if(node.type != 'field'){
                            return;
                        }
                        if(target.closest('#fieldLines').length > 0){
                            dropFieldLine(node);
                        }else if(target.closest('#conditionLines').length > 0){
                            dropConditionLine(node);
                        }
                        else if(target.closest('.tab-toggler').length > 0) {
                            target.closest('.tab-toggler').click();
                            if(target.closest('.tab-toggler').hasClass('toggle-detailpanel_fields')) {
                                dropFieldLine(node);
                            }
                            else if (target.closest('.tab-toggler').hasClass('toggle-detailpanel_conditions')) {
                                dropConditionLine(node);
                            }
                        }

                    },
                    onCanMoveTo: function(){
                        return false;
                    }
                });
            };

        function loadTreeLeafData(node){
            var module = node.module;
            if(!treeDataLeafs[module]) {
                $.getJSON('index.php',
                        {
                            'module': 'AOR_Reports',
                            'action': 'getModuleFields',
                            'aor_module': node.module,
                            'view': 'JSON'
                        },
                        function (fieldData) {
                            var treeData = [];

                            for (var field in fieldData) {
                                if (field) {
                                    treeData.push(
                                            {
                                                id: field,
                                                label: fieldData[field],
                                                'load_on_demand': false,
                                                type: 'field',
                                                module: node.module,
                                                module_path: node.module_path,
                                                module_path_display: node.module_path_display
                                            });
                                }
                            }
                            //$('#fieldTree').tree('loadData',treeData,node);
                            //node.loaded = true;
                            //$('#fieldTree').tree('openNode', node);
                            treeDataLeafs[module] = treeData;
                            showTreeDataLeafs(treeDataLeafs[module], module);
                        }
                );
            }
            else {
                showTreeDataLeafs(treeDataLeafs[module], module);
            }
        }

        function processTreeData(relData, node){
            var treeData = [];

            for(var field in relData){
                if(field) {
                    var modulePath = '';
                    var modulePathDisplay = '';
                    if(relData[field]['type'] == 'relationship') {
                        modulePath = field;
                        if (node) {
                            modulePath = node.module_path + ":" + field;
                            modulePathDisplay = node.module_path_display + " : "+relData[field]['module_label'];
                        }else{
                            modulePathDisplay = $('#report_module option:selected').text() + ' : ' + relData[field]['module_label'];
                        }
                    }else{
                        if (node) {
                            modulePath = node.module_path;
                            modulePathDisplay = node.module_path_display;
                        }else{
                            modulePathDisplay = relData[field]['module_label'];
                        }
                    }
                    var newNode = {
                        id: field,
                        label: relData[field]['label'],
                        load_on_demand : true,
                        type: relData[field]['type'],
                        module: relData[field]['module'],
                        module_path: modulePath,
                        module_path_display: modulePathDisplay};
                    treeData.push(newNode);
                }
            }
            $('#fieldTree').tree('loadData',treeData, node);
            if(node){
                node.loaded = true;
                $('#fieldTree').tree('openNode', node);
            }

        }

        $('#fieldTree').on(
                'click',
                '.jqtree-toggler',
                function() {
                    var node = $(this).closest('li.jqtree_common').data('node');
                    if(node.loaded) {

                    }else if(node.type == 'relationship'){
                        loadTreeData(node.module, node);
                    }else{
                        loadTreeLeafData(node);
                        $('#fieldTree').tree('openNode', node);
                    }
                    return true;
                }
        );




        $('#report_module').change(function(){
            report_module = $(this).val();
            loadTreeData($(this).val());
            clearFieldLines();
            clearConditionLines();
            clearChartLines();
        });


        $('#addChartButton').click(function(){
            loadChartLine({});
            updateChartDimensionSelects();

        });

        report_module = $('#report_module').val();
        loadTreeData($('#report_module').val());

        $.each(fieldLines,function(key,val){
            loadFieldLine(val);
        });
        $.each(conditionLines,function(key,val){
            loadConditionLine(val);
        });
        $.each(chartLines,function(key,val){
            loadChartLine(val);
        });
        updateChartDimensionSelects();
        });
    });
</script>

<style type="text/css">
    #detailpanel_fields_select {float: left; width: 20%; height: 640px; overflow-y: auto; margin-right: 20px;}
    .dragbox {height: 250px; overflow: scroll;}
    .tab-togglers {width: 80%;}
    .tab-toggler {display: block; float: left;}
    .tab-toggler.active .button {background-color: #286090;}
    .tab-panels .edit.view {/*width: 80%; float: right;*/}
    .parentheses-btn {display: block; width: 100%; min-height: 30px; border: 1px solid lightgray;}
    .condition-sortable-handle {cursor: move;}
    .parenthesis-line strong {font-size: 18px}
    .condition-ident {width: 25px; display: block; float: left;}
</style>

{/literal}


<div class="tab-togglers">
    <div class="tab-toggler toggle-detailpanel_fields ">
        <h4 class="button">{$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE}</h4>
    </div>
    <div class="tab-toggler toggle-detailpanel_conditions active">
        <h4 class="button">{$MOD.LBL_AOR_CONDITIONS_SUBPANEL_TITLE}</h4>
    </div>
    <div class="tab-toggler toggle-detailpanel_charts">
        <h4 class="button">{$MOD.LBL_AOR_CHARTS_SUBPANEL_TITLE}</h4>
    </div>
</div>

<div class="tab-panels">

    <div class="edit view edit508 hidden" id="detailpanel_fields">
        <h4><!-- {$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE} -->&nbsp;</h4>
                <div id="fieldLines" style="min-height: 50px;">
                </div>
    </div>
    <div class="edit view edit508 " id="detailpanel_conditions">
        <h4><!-- {$MOD.LBL_AOR_CONDITIONS_SUBPANEL_TITLE} -->&nbsp;</h4>
        <div id="conditionLines"  style="min-height: 50px;">
        </div>
        <hr>
        <table>
            <tbody id="aor_condition_parenthesis_btn" class="connectedSortableConditions">
                <tr class="parentheses-btn"><td class="condition-sortable-handle">{$MOD.LBL_ADD_PARENTHESIS}</td></tr>
            </tbody>
        </table>
    </div>
    <div class="edit view edit508 hidden" id="detailpanel_charts">
        <h4><!-- {$MOD.LBL_AOR_CHARTS_SUBPANEL_TITLE} -->&nbsp;</h4>
        <div id="chartLines">
            <table>
                <thead id="chartHead" style="display: none;">
                    <tr>
                        <td></td>
                        <td>{$MOD.LBL_CHART_TITLE}</td>
                        <td>{$MOD.LBL_CHART_TYPE}</td>
                        <td>{$MOD.LBL_CHART_X_FIELD}</td>
                        <td>{$MOD.LBL_CHART_Y_FIELD}</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <button id="addChartButton" type="button">{$MOD.LBL_ADD_CHART}</button>
    </div>
</div>
{literal}
<script type="text/javascript">

    setModuleFieldsPendingFinishedCallback(function(){
        var parenthesisBtnHtml;
        $( "#aor_conditions_body, #aor_condition_parenthesis_btn" ).sortable({
            handle: '.condition-sortable-handle',
            placeholder: "ui-state-highlight",
            cancel: ".parenthesis-line",
            connectWith: ".connectedSortableConditions",
            start: function(event, ui) {
                parenthesisBtnHtml = $('#aor_condition_parenthesis_btn').html();
            },
            stop: function(event, ui) {
                if(event.target.id == 'aor_condition_parenthesis_btn') {
                    $('#aor_condition_parenthesis_btn').html('<tr class="parentheses-btn">' + ui.item.html() + '</tr>');
                    ParenthesisHandler.replaceParenthesisBtns();
                }
                else {
                    if($(this).attr('id') == 'aor_conditions_body' && parenthesisBtnHtml != $('#aor_condition_parenthesis_btn').html()) {
                        $(this).sortable("cancel");
                    }
                }
                LogicalOperatorHandler.hideUnnecessaryLogicSelects();
                ConditionOrderHandler.setConditionOrders();
                ParenthesisHandler.addParenthesisLineIdent();
            }
        });//.disableSelection();
        LogicalOperatorHandler.hideUnnecessaryLogicSelects();
        ConditionOrderHandler.setConditionOrders();
        ParenthesisHandler.addParenthesisLineIdent();
    });

    $(function(){

        var reportToggler = function(elem) {
            var marker = 'toggle-';
            var classes = $(elem).attr('class').split(' ');
            $('.tab-togglers .tab-toggler').removeClass('active');
            $(elem).addClass('active');
            $('.tab-panels .edit.view').addClass('hidden');
            $.each(classes, function(i, cls){
                if(cls.substring(0, marker.length) == marker) {
                    var panelId = cls.substring(marker.length);
                    $('#'+panelId).removeClass('hidden');
                }
            });
        };

        $('.tab-toggler').click(function(){
            reportToggler(this);
        });


    });
</script>
{/literal}

</div>

<div style="clear: both;"></div>
<div style="display: block; float: none;">
    {{include file="include/EditView/footer.tpl"}}
</div>