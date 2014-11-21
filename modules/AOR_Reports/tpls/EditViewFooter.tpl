{literal}
    <script src="modules/AOR_Reports/js/jqtree/tree.jquery.js"></script>
    <script src="modules/AOR_Fields/fieldLines.js"></script>

<script>
    $(document).ready(function(){

        var fieldData = {"":"-none-","id":"ID","date_entered":"Date Created","date_modified":"Date Modified","modified_by_name":"Modified By Name","created_by_name":"Created By","description":"Description","deleted":"Deleted","assigned_user_name":"Assigned to","salutation":"Salutation","first_name":"First Name","last_name":"Last Name","title":"Title","department":"Department","do_not_call":"Do Not Call","phone_home":"Home","phone_mobile":"Mobile","phone_work":"Office Phone","phone_other":"Other Phone","phone_fax":"Fax","primary_address_street":"Primary Address Street","primary_address_city":"Primary Address City","primary_address_state":"Primary Address State","primary_address_postalcode":"Primary Address Postal Code","primary_address_country":"Primary Address Country","alt_address_street":"Alternate Address Street","alt_address_city":"Alternate Address City","alt_address_state":"Alternate Address State","alt_address_postalcode":"Alternate Address Postal Code","alt_address_country":"Alternate Address Country","assistant":"Assistant","assistant_phone":"Assistant Phone","lead_source":"Lead Source","account_name":"Account Name","report_to_name":"Reports To","birthdate":"Birthdate","campaign_name":"Campaign","joomla_account_id":"LBL_JOOMLA_ACCOUNT_ID","portal_account_disabled":"LBL_PORTAL_ACCOUNT_DISABLED","portal_user_type":"Portal User Type","jjwg_maps_address_c":"Address","jjwg_maps_geocode_status_c":"Geocode Status","jjwg_maps_lat_c":"Latitude","jjwg_maps_lng_c":"Longitude"};

        $('#fieldTree').tree({
            data: {},
            dragAndDrop: true,
            selectable: true,
            onDragStop: function(node, e,thing){
                var target = $(document.elementFromPoint(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset));
                if(node.type != 'field'){
                    return;
                }
                if(target.closest('#fieldLines')){
                    addNodeToFields(node,target);
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
                    var modulePath = field;
                    if(node){
                        modulePath = node.module_path + ":" + modulePath;
                    }
                    var newNode = {
                        id: field,
                        label: relData[field]['label'],
                        'load_on_demand' : true,
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
            loadTreeData($(this).val());
        });
        loadTreeData($('#report_module').val());

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
<div class="edit view edit508  expanded" id="detailpanel_fields">
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
</div></td>
    </tr>
    <tr><td>
            <div class="edit view edit508  expanded" id="detailpanel_conditions">
                <h4>&nbsp;&nbsp;
                    <a onclick="collapsePanel('conditions');" class="collapseLink" href="javascript:void(0)">
                        <img border="0" src="{sugar_getimagepath file="basic_search.gif"}"
                             id="detailpanel_conditions_img_hide"></a>
                    <a onclick="expandPanel('conditions');" class="expandLink" href="javascript:void(0)">
                        <img border="0" src="{sugar_getimagepath file="advanced_search.gif"}"
                             id="detailpanel_conditions_img_show"></a>
                    {$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE}
                    <script>
                        document.getElementById('detailpanel_conditions').className += ' expanded';
                    </script>
                </h4>
                <table width="100%" cellspacing="1" cellpadding="0" border="0" class="yui3-skin-sam edit view panelContainer"
                       id="FIELDS">
                    <tbody>
                    <tr>

                    </tr>
                    </tbody>
                </table>
                {literal}
                    <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function () {
                            initPanel('conditions', 'expanded');
                        }); </script>
                {/literal}
            </div></td></tr>
</table>