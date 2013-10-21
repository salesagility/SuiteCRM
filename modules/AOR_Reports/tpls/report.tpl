<div id='detailpanel_report' class='detail view  detail508 expanded'>
    {counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
    <h4>
        <a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel('report');">
            <img border="0" id="detailpanel_report_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
        <a href="javascript:void(0)" class="expandLink" onclick="expandPanel('report');">
            <img border="0" id="detailpanel_report_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
        {sugar_translate label='REPORT' module='AOR_Reports'}
        <script>
            document.getElementById('detailpanel_report').className += ' expanded';
        </script>
    </h4>
    <table id='FIELDS' class="panelContainer" cellspacing='{$gridline}'>
        {counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
        {counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
        {capture name="tr" assign="tableRow"}
            <tr>
                {counter name="fieldsUsed"}
                <td width='37.5%' colspan='4' >
                    {if !$fields.field_lines.hidden}
                        {counter name="panelFieldCount"}
                        <span id='field_lines_span'>
{$fields.field_lines.value}
</span>
                    {/if}
                </td>
            </tr>
        {/capture}
        {if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
            {$tableRow}
        {/if}
    </table>
    <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel('report', 'expanded'); {rdelim}); </script>
</div>