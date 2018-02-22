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
<div>
    <form action='index.php' name='EditView' id='configure_{$id}' method='post' onSubmit='return SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage);'>
        <input type='hidden' name='id' value='{$id}'>
        <input type='hidden' name='module' value='Home'>
        <input type='hidden' name='action' value='ConfigureDashlet'>
        <input type='hidden' name='configure' value='true'>
        <input type='hidden' name='to_pdf' value='true'>

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="edit view">
            <tr>
                <td scope='row'>
                    {$MOD.LBL_DASHLET_TITLE}
                </td>
                <td>
                    <input type='text' name='dashletTitle' value='{$dashletTitle}'>
                </td>
            </tr>
            <tr>
                <td scope='row'>
                    {$MOD.LBL_DASHLET_REPORT}
                </td>
                <td>
                    <input type="text" name="aor_report_name" class="sqsEnabled" tabindex="0" id="aor_report_name" size="" value="{$aor_report_name}" title='' autocomplete="off">
                    <input type="hidden" name="aor_report_id" id="aor_report_id" value="{$aor_report_id}">
                    <span class="id-ff multiple">
                        <button type="button" name="btn_aor_report_name" id="btn_aor_report_name" tabindex="0" title="{$MOD.LBL_DASHLET_SELECT_REPORT}" class="button firstChild" value="{$MOD.LBL_DASHLET_SELECT_REPORT}"
                                {literal}
                                    onclick='open_popup(
                                            "AOR_Reports",
                                            600,
                                            400,
                                            "",
                                            true,
                                            false,
                                            {"call_back_function":"aor_report_set_return","form_name":"EditView","field_to_name_array":{"id":"aor_report_id","name":"aor_report_name"}},
                                            "single",
                                            true
                                    );' >
                                {/literal}
                            <span class="suitepicon suitepicon-action-select"></span>
                        </button>
                        <button type="button" name="btn_clr_aor_report_name" id="btn_clr_aor_report_name" tabindex="0" title="{$MOD.LBL_DASHLET_CLEAR_REPORT}"  class="button lastChild"
                            onclick="SUGAR.clearRelateField(this.form, 'aor_report_name', 'aor_report_id');"  value="{$MOD.LBL_DASHLET_CLEAR_REPORT}" >
                            <span class="suitepicon suitepicon-action-clear"></span>
                        </button>
                    </span>
                    <script type="text/javascript">
                        {literal}
                        if(typeof sqs_objects == 'undefined'){
                            var sqs_objects = new Array;
                        }
                        sqs_objects['EditView']={
                            "form":"EditView",
                            "method":"query",
                            "modules": ["AOR_Reports"],
                            "field_list":["name","id"],
                            "populate_list":["aor_report_name","aor_report_id"],
                            "required_list":["aor_report_id"],
                            "conditions": [{
                                "name": "name",
                                "op": "like_custom",
                                "end": "%",
                                "value": ""
                            }],
                            "limit":"30",
                            "no_match_text":"No Match"};
                        SUGAR.util.doWhen(
                                "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['EditView_aor_report_name']) != 'undefined'",
                                enableQS
                        );
                        {/literal}
                    </script>
                </td>
            </tr>
            <tr>
                <td scope='row'>
                    <label for="onlyCharts{$id}">
                        {$MOD.LBL_DASHLET_ONLY_CHARTS}
                    </label>
                </td>
                <td>
                    <input type='checkbox' id='onlyCharts{$id}' name='onlyCharts' {if $onlyCharts}checked='checked'{/if}>
                </td>
            </tr>
            <tr>
                <td scope='row'>
                    {$MOD.LBL_DASHLET_CHARTS}
                </td>
                <td>
                    <select multiple="multiple" name="charts[]" id="charts{$id}">
                        {$chartOptions}
                    </select>
                    <script type="text/javascript">

                        var chartId = '{$id}';
                        var chartUnnamedDefaultTitle = '{$MOD.LBL_CHAR_UNNAMED_DEFAULT_TITLE}';

                        {literal}

                        $(function() {
                            $('#charts' + chartId + ' option').each(function(i,e) {
                                if(!$(this).html()) {
                                    $(this).html(chartUnnamedDefaultTitle + ' #' + (i+1));
                                }
                            });
                        });

                        {/literal}

                    </script>
                </td>
            </tr>
            {foreach from=$parameters item=condition}
            <tr>
                <td scope='row'>
                    {$MOD.LBL_PARAMETERS}
                </td>
                <td>
                    <div id="parameterOptions{$id}">

                            <input type='hidden' name='parameter_id[]' value='{$condition.id}'>
                            <input type='hidden' name='parameter_operator[]' value='{$condition.operator}'>
                            <input type='hidden' name='parameter_type[]' value='{$condition.value_type}'>

                        {if $condition.value_type == "Period"}
                            {$condition.module_display} - <em>{$condition.field_display}</em> - {$condition.operator_display}
                            <select name='parameter_value[]'>
                                {html_options options=$date_time_period_list selected=$condition.value}
                            </select>
                        {elseif $condition.value_type == "Relate"}

                        {else}
                            {$condition.module_display} - <em>{$condition.field_display}</em> - {$condition.operator_display}  {$condition.field}
                        {/if}

                    </div>
                </td>
            </tr>
            {/foreach}
            <script>
                {literal}
                // Make sure to change dates back to the user format
                $(document).ready(function() {
                    $('.date_input').each(function(index, elem) {
                        var value = $(this).val();
                        var formatString = cal_date_format.replace(/%/g, '').toLowerCase().replace(/y/g, 'yy').replace(/m/g, 'mm').replace(/d/g, 'dd');

                        // From DB format
                        var date_reg_format = '([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})';
                        myregexp = new RegExp(date_reg_format);
                        if(myregexp.test(value)) {
                            // Split timestamp into [ Y, M, D ]
                            var t = value.split(/[- :]/);
                            // Apply each element to the Date function
                            var dateObject = new Date(Date.UTC(t[0], t[1]-1, t[2]));
                            value = $.datepicker.formatDate(formatString, dateObject);
                            // From user format
                        } else {
                            if (isDate(value)) {
                                var dateObject = getDateObject(value);
                            }
                            value = $.datepicker.formatDate(formatString, dateObject);
                        }

                        $(this).val(value);
                    });
                });
                {/literal}
            </script>
            <tr>
                <td scope='row'>

                </td>
                <td align='right'>
                    <input type='submit' class='button' value='{$MOD.LBL_DASHLET_SAVE}'>
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
    {literal}
    function loadCharts(reportId){
        $.getJSON('index.php',
                {module : 'AOR_Reports',
                    record : reportId,
                    to_pdf : 1,
                    action : 'getChartsForReport'}).done(
                function(data){
                    var chartSelect = $('#charts{/literal}{$id}{literal}');
                    chartSelect.empty();
                    $.each(data, function(key,val){
                        chartSelect.append($('<option></option').val(key).text(val));
                    });
                }
        );
    }
    function loadParameters(reportId){
        $.getJSON('index.php',
                {module : 'AOR_Reports',
                    record : reportId,
                    to_pdf : 1,
                    action : 'getParametersForReport'}).done(
                function(data){
                    var paramContainer = $('#parameterOptions{/literal}{$id}{literal}');
                    var html = '';
                    for(var x = 0; x < data.length; x++) {
                        var cond = data[x];
                        html += "<input type='hidden' name='parameter_id[]' value='"+cond.id+"'>";
                        html += "<input type='hidden' name='parameter_operator[]' value='"+cond.operator+"'>";
                        html += "<input type='hidden' name='parameter_type[]' value='"+cond.value_type+"'>";
                        html += cond.module_display+" "+cond.field_display+" "+cond.operator_display+" "+cond.field;
                    }
                    paramContainer.html(html);
                }
        );
    }
    function aor_report_set_return(ret){
        loadCharts(ret.name_to_value_array.aor_report_id);
        loadParameters(ret.name_to_value_array.aor_report_id);
        set_return(ret);
    }
    {/literal}
</script>