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
            <td>{$MOD.LBL_COLOUR_ADMIN_BASE}</td><td><input type="text" id="colourselector_menu" name="colourselector_menu" class="color" value="{$config.colourselector.menu}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_TOPGR}</td><td><input type="text" id="colourselector_menuto" name="colourselector_menuto" class="color" value="{$config.colourselector.menuto}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_BTMGR}</td><td><input type="text" id="colourselector_menufrom" name="colourselector_menufrom" class="color" value="{$config.colourselector.menufrom}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_MENUBRD}</td><td><input type="text" id="colourselector_menubrd" name="colourselector_menubrd" class="color" value="{$config.colourselector.menubrd}" size="15" /></td>
        </tr>
        <tr style="float:left;">
            <td>{$MOD.LBL_COLOUR_ADMIN_VISITED}</td><td><input type="text" id="colourselector_modlinkvisited" name="colourselector_modlinkvisited" class="color" value="{$config.colourselector.modlinkvisited}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_MENUHOVER}</td><td><input type="text" id="colourselector_modlisthover" name="colourselector_modlisthover" class="color" value="{$config.colourselector.modlisthover}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_DDLINK}</td><td><input type="text" id="colourselector_cssmenulink" name="colourselector_cssmenulink" class="color" value="{$config.colourselector.cssmenulink}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_DDMENU}</td><td><input type="text" id="colourselector_cssmenu" name="colourselector_cssmenu" class="color" value="{$config.colourselector.cssmenu}" size="15" /></td>
        </tr>
        <tr style="float:left;">

            <td>{$MOD.LBL_COLOUR_ADMIN_MENUFONT}</td><td><input type="text" id="colourselector_menufont" name="colourselector_menufont" class="color" value="{$config.colourselector.menufont}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_MENULNKHVR}</td><td><input type="text" id="colourselector_modlinkhover" name="colourselector_modlinkhover" class="color" value="{$config.colourselector.modlinkhover}" size="15" /></td>

        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_BUTTON}</strong></h4></th></tr>
        <tr style="float:left;">
            <td>{$MOD.LBL_COLOUR_ADMIN_BTNTOP}</td><td><input type="text" id="colourselector_button" name="colourselector_button1" class="color" value="{$config.colourselector.button1}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_BTNMID1}</td><td><input type="text" id="colourselector_button" name="colourselector_button2" class="color" value="{$config.colourselector.button2}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_BTNMID2}</td><td><input type="text" id="colourselector_button" name="colourselector_button3" class="color" value="{$config.colourselector.button3}" size="15" /></td>
        <tr style="float:left;">

            <td>{$MOD.LBL_COLOUR_ADMIN_BTNBTM}</td><td><input type="text" id="colourselector_button" name="colourselector_button4" class="color" value="{$config.colourselector.button4}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_BTNHOVER}</td><td><input type="text" id="colourselector_buttonhover" name="colourselector_buttonhover" class="color" value="{$config.colourselector.buttonhover}" size="15" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_PAGE}</strong></h4></th></tr>
        <tr style="float:left;">
            <td>{$MOD.LBL_COLOUR_ADMIN_PAGEHEADER}: </td><td><input type="text" id="colourselector_pageheader" name="colourselector_pageheader" class="color" value="{$config.colourselector.pageheader}" size="15" /></td>
            <td>{$MOD.LBL_COLOUR_ADMIN_PAGELINK}: </td><td><input type="text" id="colourselector_pagelink" name="colourselector_pagelink" class="color" value="{$config.colourselector.pagelink}" size="15" /></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4><strong>{$MOD.LBL_COLOUR_ADMIN_DASHLET}</strong></h4></th></tr>
        <tr style="float:left;">
            <td>{$MOD.LBL_COLOUR_ADMIN_DASHHEAD}</td><td><input type="text" id="colourselector_dashlet" name="colourselector_dashlet" class="color" value="{$config.colourselector.dashlet}" size="15" /></td>
        </tr>
    </table>

    <div style="padding-top: 2px;">
        {$BUTTONS}
    </div>
    {$JAVASCRIPT}
</form>
