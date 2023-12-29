{* 
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 *}
<div id='grid_Div'>
    <table width="100%">
        <tr>
            <td>
                <h2>{$MOD.LBL_SYNCOPTIONS_TITLE}</h2>
            </td>
        </tr>
	</table>
	
    <form id="syncoptions" name="syncoptions" action="index.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="module" id="module" value="{$MAP.MODULE}">
        <input type="hidden" name="action" id="action" value="{$MAP.ACTION}">
        <input type="hidden" name="return_module" id="return_module" value="{$MAP.RETURN_MODULE}">
        <input type="hidden" name="return_id" id="return_id" value="{$MAP.RETURN_ID}">
        <input type="hidden" name="return_action" id="return_action" value="{$MAP.RETURN_ACTION}">
        <input type="hidden" name="INCORPORA_TEST_CONNECTION_PARAMS" id="INCORPORA_TEST_CONNECTION_PARAMS"
            value="{$MAP.INCORPORA_TEST_CONNECTION_PARAMS}">
        {foreach from=$MAP.INCORPORA_TEST_CONNECTION_PARAMS key=KEY item=ITEM}
            <input type="hidden" name="{$KEY}_test" id="{$KEY}_test" size=500 value="{$ITEM.label}">
            <input type="hidden" name="{$KEY}_test_code" id="{$KEY}_test_code" size=500 value="{$ITEM.code}">
        {/foreach}
        {foreach from=$MAP.IDS key=KEY item=ID}
            <input type="hidden" name="ids[]" id="{$KEY}" size=500 value="{$ID}">
        {/foreach}
        {foreach from=$MAP.INC_IDS key=KEY item=INC_ID}
            <input type="hidden" name="inc_ids[{$KEY}]" id="{$KEY}" size=500 value="{$INC_ID}">
        {/foreach}
        <h3>{$MOD.LBL_SUMMARY_TITLE}:</h3>
        <table class="edit view">
            <tr>
                <td width="30%"></td>
            </tr>
            {foreach from=$MAP.SUMMARY key=KEY item=INFO}
                <input type="hidden" name="summary[{$KEY}]" id="summary" size=50 value="{$INFO}">
                <tr>
                    {assign var="lbl_summary_field" value="LBL_SUMMARY_"|cat:$KEY|upper}
                    <td style="text-align: left; border-bottom: 0.5px inset silver; line-height: 1.7;">
                        {$MOD[$lbl_summary_field]}:
                    </td>
                    <td>
                        {$INFO}
                    </td>
                </tr>
            {/foreach}
            <tr>
        </table>
        <h3>
            {$MOD.LBL_SYNCOPTIONS_INCORPORA_CONNECTION_PARAMS}:
            <img border="0"
                onclick="return SUGAR.util.showHelpTips(this,SUGAR.language.translate('stic_Incorpora','LBL_SYNCOPTIONS_INCORPORA_CONNECTION_PARAMS_HELP'),'','' );"
                src="themes/default/images/helpInline.gif?v=qpjLeQy5v2GkTP23EP91ag" alt="Información"
                class="inlineHelpTip">
        </h3>
		<table class="edit view">
			<tr><td></td></tr>
            {if $MAP.IS_STIC_ADMIN}
                <tr>
                    <td width="30%">
                        <label id="label_test" for="label_test">{$MOD.LBL_SYNCOPTIONS_INCORPORA_OPTION_TEST}</label>
                    </td>
                    <td>
                        <input type="checkbox" id="test" name="test" value=0>
                    </td>
                </tr>
            {/if}
            {foreach from=$MAP.INCORPORA_CONNECTION_PARAMS key=KEY item=PARAM}
                <input type="hidden" name="{$KEY}_pro" id="{$KEY}_pro" size=250 value="{$PARAM.label}">
                <input type="hidden" name="{$KEY}_pro_code" id="{$KEY}_pro_code" size=500 value="{$PARAM.code}">
                <tr style="line-height: 2.5;">
                    {assign var="lbl_connection_field" value="LBL_SYNCOPTIONS_INCORPORA_"|cat:$KEY|upper}
                    <td id="{$lbl_connection_field}" style="text-align: left; border-bottom: 0.5px inset silver; line-height: 2.5;">
                        {$MOD[$lbl_connection_field]}:
                    </td>
                    <td style="font-weight: bold;" id="{$KEY}_label">
                        {$PARAM.label}
                        <input type="hidden" id="{$KEY}" name="{$KEY}" type="text" value="{$PARAM.label}">
                    </td>
                </tr>
            {/foreach}
            <tr style="line-height: 2.5;">
                <td>
                    <label id="label_password" for="password">{$MOD.LBL_SYNCOPTIONS_INCORPORA_PASSWORD}</label>:&nbsp;
                </td>
                <td>
                    <input id="password" type="password" name="password" value="">
                </td>
            </tr>
        </table>
        <h3 id="LBL_SYNCOPTIONS_SELECT">{$MOD.LBL_SYNCOPTIONS_SELECT}:</h3>
        <table class="edit view" id='options'>
            <tr><td></td></tr>
            <tr style="line-height: 2.5;">
                <td>
                    {* Using SUGAR.language.translate because the symbols "'" can't be scaped. *}
                    <input style="margin-right: 5px;" type="radio" id="crm_inc" name="sync_option" value="crm_inc">
                    {$MOD.LBL_SYNCOPTIONS_CRM_INC}
                    <img border="0"
                        onclick="return SUGAR.util.showHelpTips(this,SUGAR.language.translate('stic_Incorpora','LBL_SYNCOPTIONS_CRM_INC_HELP'),'','' );"
                        src="themes/default/images/helpInline.gif?v=qpjLeQy5v2GkTP23EP91ag" alt="Información"
                        class="inlineHelpTip">
                </td>
            </tr>
            <tr style="line-height: 2.5;">
                <td>
                    <input style="margin-right: 5px;" type="radio" id="crm_edit_inc" name="sync_option"
                        value="crm_edit_inc">{$MOD.LBL_SYNCOPTIONS_CRM_EDIT_INC}
                </td>
            </tr>
            <tr style="line-height: 2.5;">
                <td>
                    <input style="margin-right: 5px;" type="radio" id="inc_crm" name="sync_option"
                        value="inc_crm">{$MOD.LBL_SYNCOPTIONS_INC_CRM}
                    <div id="div_override" style="display: none">
                        <label id="label_override" name="override"
                            visibility="hidden">{$MOD.LBL_SYNCOPTIONS_SELECT_OVERRIDE_OPTION}</label><br>
                        <input style="margin-right: 5px;" type="radio" name="override"
                            value=1>{$MOD.LBL_SYNCOPTIONS_INC_CRM_OVERRIDE}<br>
                        <input style="margin-right: 5px;" type="radio" class="desc" name="override"
                            value=0>{$MOD.LBL_SYNCOPTIONS_INC_CRM_NOT_OVERRIDE}
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <input type="submit" id="cancel_button" title="{$MOD.LBL_EXECUTE_BUTTON}" class="button"
                        name="cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}"
                        onclick="this.form.action.value='{$MAP.RETURN_ACTION}'; this.form.module.value='{$MAP.RETURN_MODULE}'; this.form.record.value='{$MAP.RETURN_ID}';">
                    <input type="submit" id="next_button" title="{$APP.LBL_NEXT_BUTTON_LABEL}" class="button"
                        name="next_button" value="{$APP.LBL_NEXT_BUTTON_LABEL}">
                </td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
    {literal}
        // init options
        window.onload = function() {
            $('#test').prop( "checked", false );
            $("input[name='sync_option']").each(function(){
                $(this).prop('checked', false);
            }); 
            $("input[name='override']").each(function(){
                $(this).prop('checked', false);
            }); 
        }; 
        
        // The overrite options are only displayed if the option is inc_crm
        $("input[name=sync_option]").on("change", function() {
            if ($('#inc_crm').is(':checked')) {
                $('#div_override').show();
            } else if ($('#crm_inc').is(':checked')) {
                $('#div_override').hide();
                $("input[name=override]").prop('checked', false);
            } else {
                $('#div_override').hide();
                $("input[name=override]").prop('checked', false);
            }
        });
        // If the TEST option is checked, we fill the TEST user params values
        $("#test").on("change", function() {
            if ($('#test').is(':checked')) {
                $('#url').val('https://pre.intranet.incorpora.org:445/Incorpora/services/');
                $('#user_label').text($('#user_test').val());
                $('#user').val($('#user_test').val());
                $('#password').val($('#password_test_code').val());
                $('#reference_group_label').text($('#reference_group_test').val());
                $('#reference_group').val($('#reference_group_test').val());

                $('#reference_entity_label').text($('#reference_entity_test').val());
                $('#reference_entity').val($('#reference_entity_test').val());

                $('#reference_officer_label').text($('#reference_officer_test').val());
                $('#reference_officer').val($('#reference_officer_test').val());

                $('#test').val(1);
            } else {
                $('#url').val('https://intranet.incorpora.org/Incorpora/services/');
                $('#user_label').text($('#user_pro').val());
                $('#user').val($('#user_pro').val());

                $('#password').val('');
                $('#reference_group_label').text($('#reference_group_pro').val());
                $('#reference_group').val($('#reference_group_pro').val() ? $('#reference_group_pro').val() : '');

                $('#reference_entity_label').text($('#reference_entity_pro').val());
                $('#reference_entity').val($('#reference_entity_pro').val());

                $('#reference_officer_label').text($('#reference_officer_pro').val());
                $('#reference_officer').val($('#reference_officer_pro').val());

                $('#test').val(0);
            }
        });

        // Field validation before submitting
        $('#next_button').on('click', function() {
            var err = false;
            if (!$("input[name=sync_option]").is(':checked')) {
                $('#LBL_SYNCOPTIONS_SELECT').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
                err = true;
            }
            else {
                $('#LBL_SYNCOPTIONS_SELECT').css('color', 'black');
            }
            if ($('#inc_crm').is(':checked') && !$("input[name=override]").is(':checked')) {
                $('#label_override').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
                err = true;
            }
            else {
                $('#label_override').css('color', 'black');
            }
            if (!$('#password').val()) {
                $('#label_password').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
                err = true;
            }
            else {
                $('#label_password').css('color', 'black');
            }
            if ($('#user').val() == '') {
                $('#LBL_SYNCOPTIONS_INCORPORA_USER').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
                err = true;
            }
            else {
                $('#LBL_SYNCOPTIONS_INCORPORA_USER').css('color', 'black');
            }
            if ($('#reference_group').val() == '') {
                $('#LBL_SYNCOPTIONS_INCORPORA_REFERENCE_GROUP').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300)
                    .fadeIn(300);
                err = true;
            } 
            else {
                $('#LBL_SYNCOPTIONS_INCORPORA_REFERENCE_GROUP').css('color', 'black');
            }
            if ($('#reference_entity').val() == '') {
                $('#LBL_SYNCOPTIONS_INCORPORA_REFERENCE_ENTITY').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300)
                    .fadeIn(300);
                err = true;
            }
            else {
                $('#LBL_SYNCOPTIONS_INCORPORA_REFERENCE_ENTITY').css('color', 'black');
            }
            if ($('#reference_officer').val() == '') {
                $('#LBL_SYNCOPTIONS_INCORPORA_REFERENCE_OFFICER').css('color', 'red').fadeOut(300).fadeIn(300).fadeOut(300)
                    .fadeIn(300);
                err = true;
            }
            else {
                $('#LBL_SYNCOPTIONS_INCORPORA_REFERENCE_OFFICER').css('color', 'black');
            }
            if (err) {
                return false;
            } 
        });

    {/literal}
</script>