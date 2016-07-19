<ul class="dropdown-menu">
    {if !$lock_homepage}
        <li class="addButton">
            <a onclick="return SUGAR.mySugar.showDashletsDialog();">{$lblAddDashlets}</a>
        </li>
        <li class="addButton">
            <a onclick="addDashboardForm({$tabNum});">
                <span>{$lblAddTab}</span>
            </a>
        </li>
    {/if}
</ul>
