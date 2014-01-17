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
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_MENU}</strong></h4></th>
        <tr>
            <td>Base menu colour: </td><td><input type="text" id="colourselector_menu" name="colourselector_menu" class="color" value="{$config.colourselector.menu}" /></td>
            <td>Top gradient colour: </td><td><input type="text" id="colourselector_menuto" name="colourselector_menuto" class="color" value="{$config.colourselector.menuto}" /></td>
            <td>Bottom gradient colour: </td><td><input type="text" id="colourselector_menufrom" name="colourselector_menufrom" class="color" value="{$config.colourselector.menufrom}" /></td>
        </tr>
        <tr>
            <td>{$MOD.LBL_COLOUR_ADMIN_MENUFONT}: </td><td><input type="text" id="colourselector_menufont" name="colourselector_menufont" class="color" value="{$config.colourselector.menufont}" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_MENUBRD}: </td><td><input type="text" id="colourselector_menubrd" name="colourselector_menubrd" class="color" value="{$config.colourselector.menubrd}" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_BUTTON}</strong></h4></th>
        <tr>
            <td>Button colour top: </td><td><input type="text" id="colourselector_button" name="colourselector_button1" class="color" value="{$config.colourselector.button1}" /></td>
            <td>Button colour mid-top: </td><td><input type="text" id="colourselector_button" name="colourselector_button2" class="color" value="{$config.colourselector.button2}" /></td>
            <td>Button colour mid-bottom: </td><td><input type="text" id="colourselector_button" name="colourselector_button3" class="color" value="{$config.colourselector.button3}" /></td>
        <tr>

            <td>Button colour bottom: </td><td><input type="text" id="colourselector_button" name="colourselector_button4" class="color" value="{$config.colourselector.button4}" /></td>
            <td>Button hover colour: </td><td><input type="text" id="colourselector_buttonhover" name="colourselector_buttonhover" class="color" value="{$config.colourselector.buttonhover}" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_PAGE}</strong></h4></th>
        <tr>
            <td>{$MOD.LBL_COLOUR_ADMIN_PAGEHEADER}: </td><td><input type="text" id="colourselector_pageheader" name="colourselector_pageheader" class="color" value="{$config.colourselector.pageheader}" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_PAGELINK}: </td><td><input type="text" id="colourselector_pagelink" name="colourselector_pagelink" class="color" value="{$config.colourselector.pagelink}" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_DASHLET}</strong></h4></th>
        <tr>
            <td>
                <input type="text" id="colourselector_dashlet" name="colourselector_dashlet" class="color" value="{$config.colourselector.dashlet}" />
            </td>
        </tr>
    </table>

    <div style="padding-top: 2px;">
        {$BUTTONS}
    </div>
    {$JAVASCRIPT}
</form>
