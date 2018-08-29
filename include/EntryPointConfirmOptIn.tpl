{if $FOCUS}
    <div class="email-address-confirmed">
        You have confirmed that your email address "{$FOCUS->email_address}" has been opted in
    </div>
{else}
    <div class="error">
        Unable to confirm email address
    </div>
{/if}