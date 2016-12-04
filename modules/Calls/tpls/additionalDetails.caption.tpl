<div id="qtip-6-title" class="qtip-title" aria-atomic="true">
    <div class="qtip-title-text">
       {$FIELD.NAME}
    </div>
    {if $PARAM.show_buttons != "false"}
    <div class="qtip-title-buttons">
        {if $ACL_EDIT_VIEW == true}<a href="index.php?action=DetailView&module={$MODULE_NAME}&record={$FIELD.ID}" class="btn btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>{/if}
        {if $ACL_DETAIL_VIEW == true}<a href="index.php?action=EditView&module={$MODULE_NAME}&record={$FIELD.ID}" class="btn btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>{/if}
    </div>
    {/if}
</div>