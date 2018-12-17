<ul class="dropdown-menu tab-actions">
    {if !$lock_homepage}

        <li>
            <input class="button addDashlets" type="button" name="Edit"  data-toggle="modal" data-target=".modal-add-dashlet" value="{$lblAddDashlets}">
        </li>
        <li>
            <input class="button addDashboard" type="button" name="Edit"  data-toggle="modal" data-target=".modal-add-dashboard" value="{$lblAddTab}">
        </li>
        <li>
            <input class="button addDashboard" type="button" name="Edit"  data-toggle="modal" data-target=".modal-edit-dashboard" value="{$app.LBL_EDIT_TAB}">
        </li>
    {/if}
</ul>
