<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <!-- Password Security Settings -->
    <tr>
        <th align="left" scope="row" colspan="3"><h4>{$MOD.LBL_PWDSEC_SETS}</h4></th>
    </tr>

    <!-- Expiry Period -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_EXPIRY}
            {sugar_help text=$MOD.LBL_PWDSEC_EXPIRY_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_expirydays" id="passwordsetting_expirydays" type="number" value="{$config.passwordsetting.expirydays}">
            {$MOD.LBL_PWDSEC_DAYS}
        </td>
        <td>&nbsp;</td><td>&nbsp;</td>
    </tr>

    <!-- Block After Inactivity --> <!-- TODO: Im not 100% sure, is this a password settings?
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_BLOCK_AFTER}
            {sugar_help text=$MOD.LBL_PWDSEC_BLOCK_AFTER_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_blockafterdays" id="passwordsetting_blockafterdays" type="number" value="{$config.passwordsetting.blockafterdays}">
            {$MOD.LBL_PWDSEC_DAYS}
        </td>
        <td>&nbsp;</td><td>&nbsp;</td>
    </tr>
    -->

    <!-- Password Min Length -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_MIN_LENGTH}
            {sugar_help text=$MOD.LBL_PWDSEC_MIN_LENGTH_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_minlength" id="passwordsetting_minlength" type="number" value="{$config.passwordsetting.minlength}">
            {$MOD.LBL_PWDSEC_CHARS}
        </td>
        <td>&nbsp;</td><td>&nbsp;</td>
    </tr>

    <!-- Password should contains both of uppercase and lowercase characters -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_UPPERCASE}
            {sugar_help text=$MOD.LBL_PWDSEC_UPPERCASE_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_uppercase" id="passwordsetting_uppercase" type="checkbox" {if $config.passwordsetting.uppercase}checked="checked"{/if} value="1">
        </td>
        <td>&nbsp;</td><td>&nbsp;</td>
    </tr>

    <!-- Password should contains numbers -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_NUMBERS}
            {sugar_help text=$MOD.LBL_PWDSEC_NUMBERS_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_numbers" id="passwordsetting_numbers" type="checkbox" {if $config.passwordsetting.numbers}checked="checked"{/if} value="1">
        </td>
        <td>&nbsp;</td><td>&nbsp;</td>
    </tr>

    <!-- Password should contains special characters -->
    <tr>
        <td width="25%" scope="row" valign="middle">
            {$MOD.LBL_PWDSEC_SPECCHAR}
            {sugar_help text=$MOD.LBL_PWDSEC_SPECCHAR_DESC}
        </td>
        <td valign="middle">
            <input name="passwordsetting_specchars" id="passwordsetting_specchars" type="checkbox" {if $config.passwordsetting.specchars}checked="checked"{/if} value="1">
        </td>
        <td>&nbsp;</td><td>&nbsp;</td>
    </tr>

</table>