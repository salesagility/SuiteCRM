<p>{$MOD.LBL_COLOUR_ADMIN_INTRO}</p>
<form id="ConfigureSettings" name="ConfigureSettings" enctype='multipart/form-data' method="POST"
      action="index.php?module=Administration&action=colourAdmin&do=save">

    <span class='error'>{$error.main}</span>

    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="actionsContainer">
        <tr style="float:left;">
            <td>
                {$BUTTONS}
            </td>
        </tr>

    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_MENU}</strong></h4></th></tr>
        <tr style="float:left;">
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_BASE}</td><td><input type="text" id="colourselector_navbar" name="colourselector_navbar" class="color" value="{$config.colourselector.navbar}" size="15" /></td>
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_MENUHOVER}</td><td><input type="text" id="colourselector_navbarlihover" name="colourselector_navbarlihover" class="color" value="{$config.colourselector.navbarlihover}" size="15" /></td>
        </tr>
        <tr style="float:left;">
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_DDLINK}</td><td><input type="text" id="colourselector_dropdownmenulink" name="colourselector_dropdownmenulink" class="color" value="{$config.colourselector.dropdownmenulink}" size="15" /></td>
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_DDMENU}</td><td><input type="text" id="colourselector_dropdownmenu" name="colourselector_dropdownmenu" class="color" value="{$config.colourselector.dropdownmenu}" size="15" /></td>
        </tr>
        <tr style="float:left;">
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_MENUFONT}</td><td><input type="text" id="colourselector_navbarfont" name="colourselector_navbarfont" class="color" value="{$config.colourselector.navbarfont}" size="15" /></td>
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_MENULNKHVR}</td><td><input type="text" id="colourselector_navbarlinkhover" name="colourselector_navbarlinkhover" class="color" value="{$config.colourselector.navbarlinkhover}" size="15" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_BUTTON}</strong></h4></th></tr>
        <tr style="float:left;">
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_BTNTOP}</td><td><input type="text" id="colourselector_button1" name="colourselector_button1" class="color" value="{$config.colourselector.button1}" size="15" /></td>
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_BTNHOVER}</td><td><input type="text" id="colourselector_buttonhover" name="colourselector_buttonhover" class="color" value="{$config.colourselector.buttonhover}" size="15" /></td>
        <tr style="float:left;">
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_BTNLNK}</td><td><input type="text" id="colourselector_buttoncolour" name="colourselector_buttoncolour" class="color" value="{$config.colourselector.buttoncolour}" size="15" /></td>
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_BTNLNKHOVER}</td><td><input type="text" id="colourselector_buttoncolourhover" name="colourselector_buttoncolourhover" class="color" value="{$config.colourselector.buttoncolourhover}" size="15" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_PAGE}</strong></h4></th></tr>
        <tr style="float:left;">
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_PAGEHEADER}: </td><td><input type="text" id="colourselector_pageheader" name="colourselector_pageheader" class="color" value="{$config.colourselector.pageheader}" size="15" /></td>
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_PAGELINK}: </td><td><input type="text" id="colourselector_pagelink" name="colourselector_pagelink" class="color" value="{$config.colourselector.pagelink}" size="15" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_DASHLET}</strong></h4></th></tr>
        <tr style="float:left;">
            <td width="150">{$MOD.LBL_COLOUR_ADMIN_DASHHEAD}</td><td><input type="text" id="colourselector_dashlet" name="colourselector_dashlet" class="color" value="{$config.colourselector.dashlet}" size="15" /></td>
        </tr>
    </table>

    <div style="padding-top: 2px;">
        {$BUTTONS}
    </div>
    {$JAVASCRIPT}
</form>
