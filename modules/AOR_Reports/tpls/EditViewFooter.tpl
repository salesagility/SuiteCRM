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
        });
        report_module = $('#report_module').val();
        loadTreeData($('#report_module').val());

        $.each(fieldLines,function(key,val){
            loadFieldLine(val);
        });
    });
</script>
{/literal}
<table>
    <tr>
        <td rowspan="2">
            <div class="edit view edit508  expanded" id="detailpanel_fields_select">
                <h4>{$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE}</h4>
                <div id="fieldTree"></div>
            </div>
        </td>
        <td>
<div class="edit view edit508  expanded" id="detailpanel_fields" style="height: 50%;">
    <h4>&nbsp;&nbsp;
        <a onclick="collapsePanel('fields');" class="collapseLink" href="javascript:void(0)">
            <img border="0" src="{sugar_getimagepath file="basic_search.gif"}"
                 id="detailpanel_fields_img_hide"></a>
        <a onclick="expandPanel('fields');" class="expandLink" href="javascript:void(0)">
            <img border="0" src="{sugar_getimagepath file="advanced_search.gif"}"
                 id="detailpanel_fields_img_show"></a>
        {$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE}
        <script>
            document.getElementById('detailpanel_fields').className += ' expanded';
        </script>
    </h4>
    <table width="100%" cellspacing="1" cellpadding="0" border="0" class="yui3-skin-sam edit view panelContainer"
           id="FIELDS">
        <tbody>
        <tr>
            <div id="fieldLines">



            </div>
        </tr>
        </tbody>
    </table>
    {literal}
    <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function () {
            initPanel('fields', 'expanded');
        }); </script>
    {/literal}
</div> <div class="edit view edit508  expanded" id="detailpanel_conditions" style="height: 50%;">
                <h4>&nbsp;&nbsp;
                    <a onclick="collapsePanel('conditions');" class="collapseLink" href="javascript:void(0)">
                        <img border="0" src="{sugar_getimagepath file="basic_search.gif"}"
                             id="detailpanel_conditions_img_hide"></a>
                    <a onclick="expandPanel('conditions');" class="expandLink" href="javascript:void(0)">
                        <img border="0" src="{sugar_getimagepath file="advanced_search.gif"}"
                             id="detailpanel_conditions_img_show"></a>
                    {$MOD.LBL_AOR_CONDITIONS_SUBPANEL_TITLE}
                    <script>
                        document.getElementById('detailpanel_conditions').className += ' expanded';
                    </script>
                </h4>
                <table width="100%" cellspacing="1" cellpadding="0" border="0" class="yui3-skin-sam edit view panelContainer"
                       id="CONDITIONS">
                    <tbody>
                    <tr>
                        <div id="conditionLines">

                        </div>
                    </tr>
                    </tbody>
                </table>
                {literal}
                    <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function () {
                            initPanel('conditions', 'expanded');
                        }); </script>
                {/literal}
            </div></td>
    </tr>
    <tr><td>
           </td></tr>
</table>