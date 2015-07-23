

<form id="ConfigureSettings" name="ConfigureSettings" enctype='multipart/form-data' method="POST"
      action="index.php?module=Administration&action=AODAdmin&do=save">

    <span class='error'>{$error.main}</span>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
        <tr>
            <td>
                {$BUTTONS}
                 </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr><th align="left" scope="row" colspan="4"><h4>{$MOD.LBL_GENERAL_SETTINGS}</h4></th>
        </tr>
        <tr>
            <td  scope="row" width="200">{$MOD.LBL_AOD_ENABLE}: </td>
            <td  >
                <input type='checkbox' id='enable_aod' name='enable_aod' {if $config.enable_aod}checked='checked'{/if} >
            </td>

        </tr>
    </table>
    <div style="padding-top: 2px;">
        {$BUTTONS}
    </div>
    {$JAVASCRIPT}
</form>
