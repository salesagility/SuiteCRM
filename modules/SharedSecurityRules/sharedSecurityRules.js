/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

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
            $('#detailpanel_fields_select').append('<div id="fieldTreeLeafs" class="dragbox aor_dragbox"></div>');


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
                        module_path_display: modulePathDisplay
                    };
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
    
    setInterval(function(){
        $('.jqtree-title.jqtree_common').each(function(){
            if (!$(this).hasClass('treebkcolorselection')) {
                $(this).addClass('treebkcolorselection');
                $(this).click(function(){
                    $('.jqtree-title.jqtree_common').each(function(){
                        $(this).parent().removeClass('treeselected');
                    });
                    $(this).parent().addClass('treeselected');
                    lastSelected = $(this).innerHTML;
                });
            }
        });
        $('.jqtree_common.jqtree-toggler').each(function(){
            if (!$(this).hasClass('jqtree-closed')) {
                $(this).parent().addClass('treeselected');
            } else {
                $(this).parent().removeClass('treeselected');
            }
        });
    }, 300);
    
    $('body').append('<style>.treeselected {background-color: #97BDD6; background: -webkit-gradient(linear, left top, left bottom, from(#BEE0F5), to(#89AFCA));}</style>');
    
});