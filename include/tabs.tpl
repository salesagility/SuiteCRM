<br>
<script>
    {literal}
        var keys = [
    {/literal}
            {foreach from=$subpanel_tabs key=subpanel_tab_count item=subpanel_tab}
                {$subpanel_tab},
            {/foreach}
    {literal}
        ];
    {/literal}

    tabPreviousKey = '';
    {literal}
    function selectTabCSS(key)
    {
        for( var i=0; i<keys.length;i++)
        {
            var liclass = '';
            var linkclass = '';

            if ( key == keys[i])
            {
                var liclass = 'active';
                var linkclass = 'current';
            }
            document.getElementById('tab_li_'+keys[i]).className = liclass;
            document.getElementById('tab_link_'+keys[i]).className = linkclass;
        }
        {/literal}

        {$jscallback}(key, tabPreviousKey);

        {literal}
        tabPreviousKey = key;
    }
    {/literal}
</script>


<ul id="searchTabs" class="tablist">
    {foreach from=$subpanel_tabs key=subpanel_tab_count item=subpanel_tab}

        {assign var="subpanel_title" value=$subpanel_tab.title}
        {assign var="li_id" value=""}
        {assign var="a_id" value=""}

        {if !empty($subpanel_tab.hidden) &&  $subpanel_tab.hidden == true}
            {assign var="li_id" value="style=\"display: none\";"}
            {assign var="a_id" value="style=\"display: none\";"}
        {elseif $subpanel_current_key == $subpanel_tab.key }
            {assign var="li_id" value="class=\"active\";"}
            {assign var="a_id" value="class=\"current: none\";"}
        {/if}
        {*<li>{$subpanel_title}</li>*}
        <li {$li_id} id="tab_li_{$subpanel_tab.link}"><a {$a_id} id="tab_link_{$subpanel_tab.link}" href="javascript:selectTabCSS('{$subpanel_tab.link}_sp_tab');">{$subpanel_title}</a></li>

    {/foreach}
</ul>