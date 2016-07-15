SubPanelTiles.tpl:<br>
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
            {foreach from=$sub_panel_tabs item=subpanel_tab}
                <li class="noBullet" id="whole_subpanel_{$subpanel_tab}">
                    <div cookie_name="{$subpanel_tab.cookie_name}" id="subpanel_{$subpanel_tab}" style="display:{$subpanel_tab.div_display}">
                        <script>document.getElementById("subpanel_{$subpanel_tab}" ).cookie_name="{$subpanel_tab.cookie_name}";</script>

                    {if empty($show_tabs)}
                        <a name="{$subpanel_tab}"> </a>
                        <span id="show_link_{$subpanel_tab}" style="display: {$subpanel_tab.opp_display}">
                            <a href='#' class='utilsLink' onclick="current_child_field = '{$subpanel_tab}'; showSubPanel('{$subpanel_tab}',null,null,'{$layout_def_key}');document.getElementById('show_link_{$subpanel_tab}').style.display='none';document.getElementById('hide_link_".$tab."').style.display='';return false;">
                                {$subpanel_tab.show_icon_html}
                            </a>
                        </span>

                        <span id="hide_link_{$subpanel_tab}" style="display: {$subpanel_tab.div_display}">
                            <a href='#' class='utilsLink' onclick="hideSubPanel('{$subpanel_tab}');document.getElementById('hide_link_{$subpanel_tab}').style.display='none';document.getElementById('show_link_{$subpanel_tab}').style.display='';return false;">
                                {$subpanel_tab.hide_icon_html}
                            </a>
                        </span>
                        <div id="subpanel_title_{$subpanel_tab}" {if empty($sugar_config.lock_subpanels) || $sugar_config.lock_subpanels == false} onmouseover="this.style.cursor = 'move';" {/if}>
                                {$subpanel_tab.get_form_header}
                        </div>
                    {/if}

                        <script>SUGAR.util.doWhen("typeof(markSubPanelLoaded) != 'undefined'\", function() {literal}{markSubPanelLoaded('{/literal}{$subpanel_tab}{literal}');}{/literal});</script>
                        <div id="list_subpanel_{$subpanel_tab}">{$subpanel_tab.display_spd}</div>
                    </div>
                </li>
            {/foreach}
        </ul>
    {*{/if}*}

/SubPanelTiles.tpl: