{literal}
<style type="text/css">
    #EditView_tabs {float: left;}
</style>
{/literal}

<div id="report-editview-footer" style="width:100%">


{literal}
    <script src="modules/AOR_Reports/js/jqtree/tree.jquery.js"></script>
    <script src="modules/SharedSecurityRulesConditions/conditionLines.js"></script>
    <script src="modules/AOR_Charts/chartLines.js"></script>

    <link rel="stylesheet" href="include/javascript/jquery/themes/base/jquery-ui.min.css">
    <script src="include/javascript/jquery/jquery-ui-min.js"></script>
    <script src="modules/SharedSecurityRules/sharedSecurityRules.js"></script>


{/literal}


<div class="clear"></div>

    <div class="tab-panels" style="width:100%">
       <!-- <div class="edit view edit508" id="detailpanel_conditions">
            <div class="drop-area" id="conditionLines"  style="min-height: 450px;">
            </div> -->
            <hr>
            <table>
                <tbody id="aor_condition_parenthesis_btn" class="connectedSortableConditions">
             <!--   <tr class="parentheses-btn"><td class="condition-sortable-handle">{$MOD.LBL_ADD_PARENTHESIS}</td></tr> -->
                </tbody>
            </table>
        </div>
    </div>

{literal}
    <script src="modules/SharedSecurityRules/setModuleFields.js"></script>
{/literal}

</div>

<div style="clear: both;"></div>

<div style="display: block; float: none;">
    {{include file="include/EditView/footer.tpl"}}
</div>
{literal}
<style>
    #conditionLines td{
        width:13%!important
    }
</style>
{/literal}