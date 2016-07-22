<ul class="dropdown-menu tab-actions">
    {if !$lock_homepage}
        <li>
            <a class="button addDashlets"  data-toggle="modal" data-target=".modal-add-dashlet">{$lblAddDashlets}</a>
        </li>
        <li>
            <a class="button addDashboard"  data-toggle="modal" data-target=".modal-add-dashboard">
                <span>{$lblAddTab}</span>
            </a>
        </li>
        <li>
            <a class="button addDashboard"  data-toggle="modal" data-target=".modal-edit-dashboard">
                <span>{$app.LBL_EDIT_TAB}</span>
            </a>
        </li>
    {/if}
</ul>
