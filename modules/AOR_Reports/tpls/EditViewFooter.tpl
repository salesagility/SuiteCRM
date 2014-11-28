{literal}
    <script src="modules/AOR_Reports/js/jqtree/tree.jquery.js"></script>
    <script src="modules/AOR_Fields/fieldLines.js"></script>
    <script src="modules/AOR_Conditions/conditionLines.js"></script>

<script>
    $(document).ready(function(){


        $('#fieldTree').tree({
            data: {},
            dragAndDrop: true,
            selectable: true,
            onDragStop: function(node, e,thing){
                var target = $(document.elementFromPoint(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset));
                if(node.type != 'field'){
                    return;
                }
                if(target.closest('#fieldLines').length > 0){
                    addNodeToFields(node);
                }else if(target.closest('#conditionLines').length > 0){
                    addNodeToConditions(node);
                }

            },
            onCanMoveTo: function(){
                return false;
            }
        });

        function addNodeToFields(node){
            loadFieldLine(
                    {
                        'label' : node.name,
                        'module_path' : node.module_path,
                        'module_path_display' : node.module_path,
                        'field' : node.id,
                        'field_label' : node.name});
        }

        function addNodeToConditions(node){
            loadConditionLine(
                    {
                        'label' : node.name,
                        'module_path' : node.module,
                        'module_path_display' : node.module,
                        'field' : node.id,
                        'field_label' : node.name});
        }

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

        function loadTreeLeafData(node){
            $.getJSON('index.php',
                    {
                        'module' : 'AOR_Reports',
                        'action' : 'getModuleFields',
                        'aor_module' : node.module,
                        'view' : 'JSON'
                    },
                    function(fieldData){
                        var treeData = [];

                        for(var field in fieldData){
                            if(field) {
                                treeData.push(
                                        {
                                            id: field,
                                            label: fieldData[field],
                                            'load_on_demand' : false,
                                            type: 'field',
                                            module: node.module,
                                            module_path : node.module_path
                                        });
                            }
                        }
                        $('#fieldTree').tree('loadData',treeData,node);
                        node.loaded = true;
                        $('#fieldTree').tree('openNode', node);

                    }
            );
        }

        function processTreeData(relData, node){
            var treeData = [];

            for(var field in relData){
                if(field) {
                    var modulePath = '';
                    if(relData[field]['type'] == 'relationship') {
                        modulePath = field;
                        if (node) {
                            modulePath = node.module_path + ":" + field;
                        }
                    }else{
                        if (node) {
                            modulePath = node.module_path;
                        }
                    }
                    var newNode = {
                        id: field,
                        label: relData[field]['label'],
                        load_on_demand : true,
                        type: relData[field]['type'],
                        module: relData[field]['module'],
                        module_path: modulePath};
                    treeData.push(newNode);
                }
            }
         //   console.log("treeData is ");
         //   console.log(treeData);
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
        });


        $('#addChartButton').click(function(){
            loadChartLine({});
            updateChartDimensionSelects();

        });

        function loadChartLine(chart){
            var span = $('<tr></tr>');
            var removeButton = $('<button type="button"><img src="themes/default/images/id-ff-remove-nobg.png" alt=""></button>');
            removeButton.click(function(){
                removeButton.closest('tr').remove();
            });
            var cell = $('<td></td>');
            cell.append(removeButton);
            var id = '';
            if(chart['id']){
                id = chart['id'];
            }
            cell.append("<td><input type='hidden' name='aor_chart_id[]' value='"+id+"'></td>");
            span.append(cell);
            var title = '';
            if(chart['name']){
                title = chart['name'];
            }
            span.append("<td><input type='text' name='aor_chart_title[]' placeholder='{/literal}{$MOD.LBL_CHART_TITLE}{literal}' value='"+title+"'></td>");

            var cell = $('<td></td>');
            var select = $("<select name='aor_chart_type[]'></select>");
            $.each(SUGAR.language.languages['app_list_strings']['aor_chart_types'],function(key,value){
                var option = $('<option></option');
                option.val(key);
                option.text(value);
                if(chart['type'] === key){
                    option.attr('selected','selected');
                }

                select.append(option);
            });
            cell.append(select);
            span.append(cell);




            span.append("<td><select name='aor_chart_x_field[]' class='chartDimensionSelect' data-value='"+chart.x_field+"'></select></td>");
            span.append("<td><select name='aor_chart_y_field[]' class='chartDimensionSelect' data-value='"+chart.y_field+"'></select></td>");

            $('#chartLines tbody').append(span);
        }

        function updateChartDimensionSelects(){
            var options = {};
            for(var x = 0; x < fieldln_count; x++){
                options[x] = $('#aor_fields_module_path_display'+x).text() + " - "+$('#aor_fields_label'+x).val();
            }
            $('#chartLines .chartDimensionSelect').each(function(index){
                var select = $(this);
                $.each(options, function(key,val){
                    var selected = '';
                    if(key === select.data('value')){
                        selected = "selected='selected'";
                    }
                    select.append($('<option '+selected+' ></option').val(key).text(val));
                });

            });



        }

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
</script>
{/literal}
<div class="edit view edit508" id="detailpanel_fields_select" style="float: left; width: 15%; height: 500px; overflow-y: auto;">
    <h4>{$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE}</h4>
    <div id="fieldTree"></div>
</div>
<div class="edit view edit508" id="detailpanel_fields" style="width: 80%; float: right;">
    <h4>{$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE}</h4>
            <div id="fieldLines" style="min-height: 50px;">
            </div>
</div>
<div class="edit view edit508" id="detailpanel_conditions" style="width: 80%; float: right;">
    <h4>{$MOD.LBL_AOR_CONDITIONS_SUBPANEL_TITLE}</h4>
    <div id="conditionLines"  style="min-height: 50px;">
    </div>
</div>
<div class="edit view edit508" id="detailpanel_charts" style="width: 80%; float: right;">
    <h4>{$MOD.LBL_AOR_CHARTS_SUBPANEL_TITLE}</h4>
    <div id="chartLines"  style="min-height: 50px;">
        <table>
            <thead>
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