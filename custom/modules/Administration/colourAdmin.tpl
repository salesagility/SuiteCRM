<form id="ConfigureSettings" name="ConfigureSettings" enctype='multipart/form-data' method="POST"
      action="index.php?module=Administration&action=colourAdmin&do=save">

    <span class='error'>{$error.main}</span>

    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="actionsContainer">
        <tr>
            <td>
                {$BUTTONS}
            </td>
        </tr>

    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_COLOUR_ADMIN_MENU}</h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_menu" name="colourselector_menu" class="colour" value="{$config.colourselector.menu}" />
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_COLOUR_ADMIN_MENUFONT}</h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_menufont" name="colourselector_menufont" class="colour" value="{$config.colourselector.menufont}" />
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_COLOUR_ADMIN_MENUBRD}</h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_menubrd" name="colourselector_menubrd" class="colour" value="{$config.colourselector.menubrd}" />
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_COLOUR_ADMIN_PAGEHEADER}</h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_pageheader" name="colourselector_pageheader" class="colour" value="{$config.colourselector.pageheader}" />
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_COLOUR_ADMIN_PAGELINK}</h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_pagelink" name="colourselector_pagelink" class="colour" value="{$config.colourselector.pagelink}" />
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_COLOUR_ADMIN_DASHLET}</h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_dashlet" name="colourselector_dashlet" class="colour" value="{$config.colourselector.dashlet}" />
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_COLOUR_ADMIN_BUTTON}</h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_button" name="colourselector_button" class="colour" value="{$config.colourselector.button}" />
            </td>
        </tr>
    </table>

    <div style="padding-top: 2px;">
        {$BUTTONS}
    </div>
    {$JAVASCRIPT}
</form>
