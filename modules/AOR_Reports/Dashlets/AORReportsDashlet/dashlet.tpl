{if !$onlyCharts}
    {literal}
        <script>
            if (typeof changeReportPage !== "function") {
                function changeReportPage(record, offset, group_value, table_id){
                    $.get('index.php',
                            {module : 'AOR_Reports',
                                record : record,
                                offset : offset,
                                table_id : table_id,
                                action : 'changeReportPage'}).done(
                            function(data){
                                $('#dashlet_'+table_id+' .aor_report_contents').html(data);
                            }
                    );
                }
            }
            $(document).ready(function(){
                changeReportPage('{/literal}{$report_id}{literal}',0,'','{/literal}{$dashlet_id}{literal}');
            });

        </script>
    {/literal}
    <div class="aor_report_contents">
        {$MOD.LBL_DASHLET_CHOOSE_REPORT}

    </div>
{/if}
<div style="padding: 10px">
    {$chartHTML}
</div>