{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
*}
{literal}
<style type="text/css">
    #EditView_tabs {float: left;}
</style>
{/literal}
<div id="report-editview-footer">

{literal}
    <script src="modules/AOR_Reports/js/jqtree/tree.jquery.js"></script>
    <script src="modules/AOR_Fields/fieldLines.js"></script>
    <script src="modules/AOR_Conditions/conditionLines.js"></script>
    <script src="modules/AOR_Charts/chartLines.js"></script>

    <link rel="stylesheet" href="include/javascript/jquery/themes/base/jquery-ui.min.css">
    <script src="include/javascript/jquery/jquery-ui-min.js"></script>
    <script src="modules/AOR_Reports/AOR_Report_Before.js"></script>
{/literal}

<ul class="nav nav-tabs tab-togglers">
    <li class="tab-toggler toggle-detailpanel_fields active">
        <a>{$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE}</a>
    </li>
    <li class="tab-toggler toggle-detailpanel_conditions ">
        <a>{$MOD.LBL_AOR_CONDITIONS_SUBPANEL_TITLE}</a>
    </li>
    <li class="tab-toggler toggle-detailpanel_charts ">
        <a>{$MOD.LBL_AOR_CHARTS_SUBPANEL_TITLE}</a>
    </li>
</ul>
<div class="clearfix"></div>
<div class="aor-tab-content panel panel-default">
    <div class="edit view edit508" id="detailpanel_fields_select">
        <h4>{$MOD.LBL_AOR_MODULETREE_SUBPANEL_TITLE}</h4>
        <div id="fieldTree" class="dragbox aor_dragbox"></div>

        <br>

        <h4>{$MOD.LBL_AOR_FIELDS_SUBPANEL_TITLE} <span id="module-name"></span></h4>
        <div id="fieldTreeLeafs" class="dragbox aor_dragbox"></div>

    </div>
    <div class="tab-panels" id="detailpanel_fields_display">
        <div class="toggle-panel" id="detailpanel_fields">
            <table id="group_display_table" style="display: none;">
                <tbody>
                <tr>
                    <td>{$MOD.LBL_MAIN_GROUPS}</td>
                    <td>
                        <select id="group_display" name="aor_fields_group_display[0]"></select>
                        <select id="group_display_1" name="aor_fields_group_display[1]" style="display: none;"></select>
                        {literal}
                            <script type="text/javascript">
                              $(function(){
                                setInterval(function(){
                                  if($('#group_display').val() == -1) {
                                    $('#group_display_1').val(-1);
                                    $('#group_display_1').css('display', 'none');
                                  }
                                  else {
                                    if($('#group_display_1').val() == $('#group_display').val()) {
                                      $('#group_display_1').val(-1);
                                    }
                                    $('#group_display_1 option').show();
                                    $('#group_display_1 option[value="' + $('#group_display').val() + '"]').hide();

                                    $('#group_display_1').css('display', 'none');
                                    $('#group_display_1').val(-1);

                                    //$('#group_display_1').css('display', 'block');
                                  }

                                }, 100);
                              });
                            </script>
                        {/literal}
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="drop-area" id="fieldLines" style="min-height: 450px;">
            </div>
        </div>
        <div class="toggle-panel hidden" id="detailpanel_conditions">
            <table id="aor_condition_parenthesis_table">
                <tbody id="aor_condition_parenthesis_btn" class="connectedSortableConditions">
                <tr class="parentheses-btn"><td class="condition-sortable-handle">
                    <span title="{$MOD.LBL_ADD_PARENTHESIS}">( ... ) {$MOD.LBL_ADD_PARENTHESIS}</span>
                    </td></tr>
                </tbody>
            </table>
            <div class="drop-area" id="aor_conditionLines"  style="min-height: 450px;">
            </div>


        </div>
        <div class="toggle-panel hidden" id="detailpanel_charts">
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
            <button id="addChartButton" type="button" class="button">{$MOD.LBL_ADD_CHART}</button>
        </div>
    </div>
</div>

{literal}
<script type="text/javascript" src="modules/AOR_Reports/AOR_Report_After.js"></script>
{/literal}
</div>

<div style="clear: both;"></div>
<div style="display: block; float: none;">
    {{include file="include/EditView/footer.tpl"}}
</div>
