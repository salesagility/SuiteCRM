<div class="email-indicator">
    {if $bean}
        {if $bean.status == 'unread'}
            <div class="email-new">{$MOD.LBL_NEW}</div>
        {/if}
        {if $bean.flagged == 1}
            <span class="email-flagged">!</span>
        {/if}
    {/if}
</div>