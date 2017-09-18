<div class="row" id="pageNum_{$tabNum}_div">
    {counter assign=hiddenCounter start=0 print=false}

    {foreach from=$columns key=colNum item=data}
        <div class="dashletcontainer col-xs-12 col-sm-12 col-md-6" valign='top' width='{$data.width}'>
            <ul class='noBullet' id='col_{$activePage}_{$colNum}'>
                <li id='page_{$activePage}_hidden{$hiddenCounter}b'
                    style='height: 5px; margin-top:12px;' class='noBullet'>
                    &nbsp;&nbsp;&nbsp;</li>
                {foreach from=$data.dashlets key=id item=dashlet}
                    <li class='noBullet' id='dashlet_{$id}'>
                        <div id='dashlet_entire_{$id}' class='dashletPanel'>
                            {$dashlet.script}
                            {$dashlet.displayHeader}
                            {$dashlet.display}
                            {$dashlet.displayFooter}
                        </div>
                    </li>
                {/foreach}
                <li id='page_{$activePage}_hidden{$hiddenCounter}' style='height: 5px'
                    class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
            </ul>
        </div>
        {counter}
    {/foreach}
    <div id="dashletsDialog" style="display:none;">
        <div class="hd" id="dashletsDialogHeader"><a href="javascript:void(0)"
                                                     onClick="javascript:SUGAR.mySugar.closeDashletsDialog();">
                <div class="container-close">&nbsp;</div>
            </a>{$lblAdd}
        </div>
        <div class="bd" id="dashletsList">
            <form></form>
        </div>

    </div>
</div>