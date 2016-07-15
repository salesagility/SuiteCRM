<br>
    <script type="text/javascript" src="{sugar_getjspath file='include/SubPanel/SubPanelTiles.js'}"></script>
    <script>
        {literal}
    if(document.DetailView != null &&
        document.DetailView.elements != null &&
        document.DetailView.elements.layout_def_key != null &&
        typeof document.DetailView.elements['layout_def_key'] != 'undefined'){
            document.DetailView.elements['layout_def_key'].value = '{/literal}{$layout_def_key}{literal}';
    }
        {/literal}
    </script>
    {*{if $show_subpanel_tabs}*}
        <ul class="noBullet" id="subpanel_list">
            {foreach from=$subpanel_tabs key=i item=subpanel_tab}
                <li class="noBullet" id="whole_subpanel_{$subpanel_tab}">
                    <!--subpanel-title -->
                    <div id="subpanel_title_{$subpanel_tab}" {if empty($sugar_config.lock_subpanels) || $sugar_config.lock_subpanels == false} onmouseover="this.style.cursor = 'move';" {/if}>
                        {$subpanel_tabs_properties.$i.get_form_header}
                    </div>

                    <!--subpanel-body -->
                    <div cookie_name="{$subpanel_tabs_properties.$i.cookie_name}" id="subpanel_{$subpanel_tab}" style="display:{$subpanel_tabs_properties.$i.div_display}">
                        <script>document.getElementById("subpanel_{$subpanel_tab}" ).cookie_name="{$subpanel_tab.cookie_name}";</script>
                        <div id="list_subpanel_{$subpanel_tab}">{$subpanel_tabs_properties.$i.display_spd}</div>
                    </div>
                </li>
            {/foreach}
        </ul>
    {*{/if}*}