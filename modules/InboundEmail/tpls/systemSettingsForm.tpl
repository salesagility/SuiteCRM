<form action="index.php" method="post" name="Macro" id="form" class="inboundmacroform">
    <input type="hidden" name="module" value="InboundEmail">
    <input type="hidden" name="action" value="ListView">
    <input type="hidden" name="save" value="true">    

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail view inboundmacro">
        <tr>
            <td valign="top" width='10%' NOWRAP scope="row">
                <span>
                    <b>{$MOD.LBL_CASE_MACRO}:</b>
                </span>
            </td>
            <td valign="top" width='20%'>
                <span>
                    <input name="inbound_email_case_macro" type="text" value="{$MACRO}">
                </span>
            </td>
            <td valign="top" width='60%'>
                <span>
                    {$MOD.LBL_CASE_MACRO_DESC}
                    <br />
                    {$MOD.LBL_CASE_MACRO_DESC2}
                </span>
            </td>
            <td width='10%'>
                <input title="{$APP.LBL_SAVE_BUTTON_TITLE}"
                          accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
                          class="button"
                          onclick="this.form.return_module.value='InboundEmail'; this.form.return_action.value='ListView';"
                          type="submit" name="Edit" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
            </td>
        </tr>
    </table>
</form>