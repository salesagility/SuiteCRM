{if !$onlyCharts}
    {literal}
        <script>
                function changeReportPage(record, offset, group_value, table_id){
                 var paginationButtonCaller = $(this);
                    params = reportDashletParams[record];
                    $.get('index.php',
                            {module : 'AOR_Reports',
                                record : record,
                                offset : offset,
                                table_id : table_id,
                                'parameter_id' : params['ids'],
                                'parameter_operator' : params['operators'],
                                'parameter_type' : params['types'],
                                'parameter_value' : params['values'],
                                action : 'changeReportPage'}).done(
                            function(data){
                              $('#report_table_' + table_id).replaceWith(data);
                            }
                    );
                }
            $(document).ready(function(){
                if('{/literal}{$report_id}{literal}'){
                    if(typeof reportDashletParams === 'undefined'){
                        reportDashletParams = [];
                    }
                    reportDashletParams['{/literal}{$report_id}{literal}'] = {/literal}{$parameters}{literal}
                    changeReportPage('{/literal}{$report_id}{literal}', 0, '','{/literal}{$dashlet_id}{literal}');
                }
            });

        </script>
    {/literal}
    <div class="aor_report_contents">

        <table id="report_table_{$dashlet_id}">
            <tr>
                <td>{$MOD.LBL_DASHLET_CHOOSE_REPORT}</td>
            </tr>
        </table>

    </div>
{/if}
<div style="padding: 10px">
    {$chartHTML}
</div>

<script src="modules/AOR_Reports/Dashlets/AORReportsDashlet/AORReportsDashlet.js"></script>