<div id='detailpanel_report' class='detail view  detail508 expanded' style="overflow:auto">
    {counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
    <h4>
        <a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel('report');">
            <img border="0" id="detailpanel_report_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
        <a href="javascript:void(0)" class="expandLink" onclick="expandPanel('report');">
            <img border="0" id="detailpanel_report_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
        {sugar_translate label='LBL_REPORT' module='AOR_MatrixReporting'}
        <script>
          document.getElementById('detailpanel_report').className += ' expanded';
        </script>
    </h4>

    <table id='FIELDS' class="panelContainer table table-bordered" border="1" cellspacing='{$gridline}'>
        <tbody>
        <tr>
            {foreach from=$header key=name item=title}
                {if $title|is_array}
                    <td colspan="{$level1Break}">
                        {$name}
                    </td>
                {else}
                    <td>
                        {$title}
                    </td>
                {/if}
            {/foreach}
        </tr>
        {if $level2 == "true"}
            <tr>
                {foreach from=$header key=name item=title}
                    {if $title|is_array}
                        {foreach from=$title key=subname item=subtitle}
                            {if $subtitle|is_array}
                                <td colspan="{$subtitle|@count}">{$subname}</td>
                            {else}
                                <td>{$subtitle}</td>
                            {/if}
                        {/foreach}
                    {else}
                        <td></td>
                    {/if}
                {/foreach}
            </tr>
        {/if}
        {if $level3 == "true"}
            <tr>
                {foreach from=$header key=name item=title}
                    {if $title|is_array}
                        {foreach from=$title key=name item=subtitle}
                            {if $subtitle|is_array}
                                {foreach from=$subtitle key=name item=subsubtitle}
                                    <td colspan="">{$subsubtitle}</td>
                                {/foreach}
                            {else}
                                <td></td>
                            {/if}
                        {/foreach}
                    {else}
                        <td></td>
                    {/if}
                {/foreach}
            </tr>
        {/if}
        </tbody>

        {foreach from=$data key=name item=group}
            <tbody>
            <tr>
                {foreach from=$group key=field item=value}
                    <td>
                        {$value}
                    </td>
                {/foreach}
            </tr>

            </tbody>
        {/foreach}
        <tbody>
        <tr>
            {foreach from=$counts key=totalkey item=totalvalue}
                <td><b>{$totalvalue}</b></td>
            {/foreach}
        </tr>
        </tbody>
    </table>
    <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel('report', 'expanded'); {rdelim}); </script>
</div>

