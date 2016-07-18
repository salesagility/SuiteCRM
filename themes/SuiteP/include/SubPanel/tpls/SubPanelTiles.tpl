<br>
{foreach from=$subpanel_tabs key=i item=subpanel_tab}

    <div class="panel panel-default sub-panel">
        <div class="panel-heading panel-heading-collapse">
            <a class="collapsed" role="button" data-toggle="collapse" href="#subpanel_{$subpanel_tab}" aria-expanded="false">
                <div class="col-xs-10 col-sm-11 col-md-11">
                    <div>
                        <span class="glyphicon"> <img src="{sugar_getimagepath file_name=$subpanel_tabs_properties.$i.module_name file_extension='png'}"> </span>
                        {$subpanel_tabs_properties.$i.title}
                    </div>
                </div>
            </a>

        </div>
        <div class="panel-body panel-collapse collapse" id="subpanel_{$subpanel_tab}">
            <div class="tab-content">
                {$subpanel_tabs_properties.$i.subpanel_body}
            </div>
        </div>
    </div>

{/foreach}

{*{/if}*}