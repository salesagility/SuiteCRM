<ul class="clickMenu selectmenu searchLink listViewLinkButton listViewLinkButton_{$action_menu_location}">
    <li class="sugar_action_button">
        <a href="javascript:void(0)" class="glyphicon glyphicon-filter parent-dropdown-handler"></a>
        <span class="searchAppliedAlert hidden">&#10004</span>
        <ul class="subnav">
            <li><a name="thispage" id="button_select_this_page_top" class="menuItem" href="#" onclick="listViewSearchIcon.toggleSearchDialog('basic');">{$APP.LBL_QUICK_SEARCH}‎</a></li>
            <li><a name="selectall" id="button_select_all_top" class="menuItem" href="#" onclick="listViewSearchIcon.toggleSearchDialog('advanced');">{$APP.LBL_ADVANCED_SEARCH}</a></li>
        </ul>
        <span onclick=""></span>
    </li>
</ul>
{literal}
<script>
    var filt
</script>
{/literal}
