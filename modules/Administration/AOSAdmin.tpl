

<form id="ConfigureSettings" name="ConfigureSettings" enctype='multipart/form-data' method="POST"
      action="index.php?module=Administration&action=AOSAdmin&do=save">

    <span class='error'>{$error.main}</span>

    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="actionsContainer">
        <tr>
            <td>
                {$BUTTONS}
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_AOS_ADMIN_CONTRACT_SETTINGS}</h4></th>
        <tr>
            <td  scope="row" width="200">{$MOD.LBL_AOS_ADMIN_CONTRACT_RENEWAL_REMINDER}: </td>
            <td  >
                <input type='number' size='10' name='aos_contracts_renewalReminderPeriod' value='{$config.aos.contracts.renewalReminderPeriod}' > <span>{$MOD.LBL_AOS_DAYS}</span>
            </td>
        </tr>
    </table>


    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_AOS_ADMIN_INVOICE_SETTINGS}</h4></th>
        </tr>
        <tr>
            <td  scope="row" width="200">{$MOD.LBL_AOS_ADMIN_INITIAL_INVOICE_NUMBER}: </td>
            <td  >
                <input type='number' size='10' name='aos_invoices_initialNumber' value='{$config.aos.invoices.initialNumber}' >
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_AOS_ADMIN_QUOTE_SETTINGS}</h4></th>
        </tr>
        <tr>
            <td  scope="row" width="200">{$MOD.LBL_AOS_ADMIN_INITIAL_QUOTE_NUMBER}: </td>
            <td  >
                <input type='number' size='10' name='aos_quotes_initialNumber' value='{$config.aos.quotes.initialNumber}' >
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_AOS_ADMIN_LINE_ITEM_SETTINGS}</h4></th>
        </tr>
        <tr>
            <td  scope="row" width="200">{$MOD.LBL_AOS_ADMIN_ENABLE_LINE_ITEM_GROUPS}: </td>
            {if isset($config.aos.lineItems.enableGroups) && $config.aos.lineItems.enableGroups != "true" }
                {assign var='lineItems_enableGroups' value=''}
            {else}
                {assign var='lineItems_enableGroups' value='CHECKED'}
            {/if}
            <td>
                <input type='hidden' name='aos_lineItems_enableGroups' value='false'>
                <input name='aos_lineItems_enableGroups'  type="checkbox" value="true" {$lineItems_enableGroups}>
            </td>

            <td  scope="row" width="200">{$MOD.LBL_AOS_ADMIN_ENABLE_LINE_ITEM_TOTAL_TAX}: </td>
            {if isset($config.aos.lineItems.totalTax) && $config.aos.lineItems.totalTax != "true" }
                {assign var='lineItems_totalTax' value=''}
            {else}
                {assign var='lineItems_totalTax' value='CHECKED'}
            {/if}
            <td>
                <input type='hidden' name='aos.lineItems.totalTax' value='false'>
                <input name='aos.lineItems.totalTax'  type="checkbox" value="true" {$lineItems_totalTax}>
            </td>
        </tr>
    </table>

    <div style="padding-top: 2px;">
        {$BUTTONS}
    </div>
    {$JAVASCRIPT}
</form>
