$(document).ready(function(){
    SUGAR.util.doWhen("typeof $('#fieldTree').tree != 'undefined'", function(){
        var $moduleTree = $('#fieldTree').tree({
            data: {},
            dragAndDrop: false,
            selectable: false,
            onDragStop: function(node, e,thing){
            },
            onCanMoveTo: function(){
                return false;
            }
        });

        function loadTreeData(module, node){
            var _node = node;
            $.getJSON('index.php',
                {
                    'module' : 'AOR_Reports',
                    'action' : 'getModuleTreeData',
                    'aor_module' : module,
                    'view' : 'JSON'
                },
                function(relData){
                    processTreeData(relData, _node);
                }
            );
        }

        var treeDataLeafs = [];

        var dropFieldLine = function(node) {
            addNodeToFields(node);
            updateChartDimensionSelects();
        };

        var dropConditionLine = function(node) {
            var newConditionLine = addNodeToConditions(node);
            LogicalOperatorHandler.hideUnnecessaryLogicSelects();
            ConditionOrderHandler.setConditionOrders();
            ParenthesisHandler.addParenthesisLineIdent();
            return newConditionLine;
        };

        var showTreeDataLeafs = function(treeDataLeafs, module, module_name, module_path_display) {
            if (typeof module_name == 'undefined' || !module_name) {
                module_name = module;
            }
            if (typeof module_path_display == 'undefined' || !module_path_display) {
                module_path_display = module_name;
            }
            $('#module-name').html('(<span title="' + module_path_display + '">' + module_name + '</span>)');
            $('#fieldTreeLeafs').remove();
            $('#detailpanel_fields_select').append('<div id="fieldTreeLeafs" class="dragbox aor_dragbox" title="{/literal}{$MOD.LBL_TOOLTIP_DRAG_DROP_ELEMS}{literal}"></div>');


            $('#fieldTreeLeafs').tree({
                data: treeDataLeafs,
                dragAndDrop: true,
                selectable: true,
                onCanSelectNode: function(node) {
                    if($('#report-editview-footer .toggle-detailpanel_conditions')) {
                        dropConditionLine(node);
                    }
                },
                onDragMove: function() {
                    $('.drop-area').addClass('highlighted');
                },
                onDragStop: function(node, e,thing){
                    $('.drop-area').removeClass('highlighted');
                    var target = $(document.elementFromPoint(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset));
                    if(node.type != 'field'){
                        return;
                    }
                    if(target.closest('#fieldLines').length > 0){
                        dropFieldLine(node);
                    }else if(target.closest('#conditionLines').length > 0){
                        var conditionLineTarget = ConditionOrderHandler.getConditionLineByPageEvent(e);
                        var conditionLineNew = dropConditionLine(node);
                        if(conditionLineTarget) {
                            ConditionOrderHandler.putPositionedConditionLines(conditionLineTarget, conditionLineNew);
                            ConditionOrderHandler.setConditionOrders();
                        }
                        ParenthesisHandler.addParenthesisLineIdent();
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
            var module_name = node.name;
            var module_path_display = node.module_path_display;

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

                                if (field != 'created_by_name' && field != 'modified_by_name'){ //&& field != 'assigned_user_name') {

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
                        }
                        //$('#fieldTree').tree('loadData',treeData,node);
                        //node.loaded = true;
                        //$('#fieldTree').tree('openNode', node);
                        treeDataLeafs[module] = treeData;
                        showTreeDataLeafs(treeDataLeafs[module], module, module_name, module_path_display);
                    }
                );
            }
            else {
                showTreeDataLeafs(treeDataLeafs[module], module, module_name, module_path_display);
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
                            modulePathDisplay = $('#flow_module option:selected').text() + ' : ' + relData[field]['module_label'];
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
            else
            {
                if($('#fieldTree a:first').length)
                    $('#fieldTree a:first').click();
            }

        }

        $('#fieldTree').on(
            'click',
            '.jqtree-toggler, .jqtree-title', //
            function(event) {
                if($(this).hasClass('jqtree-title')) {
                    $(this).prev().click();
                    return;
                }
                //console.log(event);
                var node = $(this).closest('li.jqtree_common').data('node');
                if(node.loaded) {

                }else if(node.type == 'relationship'){
                    loadTreeData(node.module, node);
                }else{
                    loadTreeLeafData(node);
                    $('#fieldTree').tree('openNode', node);
                }

                $('.jqtree-selected').removeClass('jqtree-selected');
                $(this).closest('li').addClass('jqtree-selected');

                return true;
            }
        );


        var clearTreeDataFields = function() {
            $('#module-name').html('');
            $('#fieldTreeLeafs').html('');
        }


        $('#flow_module').change(function(){
            report_module = $(this).val();
            loadTreeData($(this).val());
            clearTreeDataFields();
            //clearFieldLines();
            clearConditionLines();
            clearChartLines();
        });


        $('#addChartButton').click(function(){
            loadChartLine({});
            updateChartDimensionSelects();

        });

        report_module = $('#flow_module').val();
        loadTreeData($('#flow_module').val());

        $.each(conditionLines,function(key,val){
            loadConditionLine(val);
        });
    });
});