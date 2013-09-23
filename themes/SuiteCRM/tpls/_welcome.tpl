{if $AUTHENTICATED}
<div id="welcome" style="float:right;">
    <strong><a id="welcome_link" href='index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}'>{$CURRENT_USER}</a></strong>
</div>
{/if}