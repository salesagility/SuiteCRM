<div>
    <form action='index.php' name='ConfigureReportDashlet' id='configure_{$id}' method='post' onSubmit='return SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage);'>
        <input type='hidden' name='id' value='{$id}'>
        <input type='hidden' name='module' value='Home'>
        <input type='hidden' name='action' value='ConfigureDashlet'>
        <input type='hidden' name='configure' value='true'>
        <input type='hidden' name='to_pdf' value='true'>

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="edit view">
            <tr>
                <td scope='row'>
                    {$MOD.LBL_DASHLET_TITLE}
                </td>
                <td>
                    <input type='text' name='dashletTitle' value='{$dashletTitle}'>
                </td>
            </tr>
            <tr>
                <td scope='row'>
                    {$MOD.LBL_DASHLET_REPORT}
                </td>
                <td>




                    <input type="text" name="aor_report_name" class="sqsEnabled" tabindex="0" id="aor_report_name" size="" value="{$aor_report_name}" title='' autocomplete="off">
                    <input type="hidden" name="aor_report_id" id="aor_report_id" value="{$aor_report_id}">
                    <span class="id-ff multiple">
                        <button type="button" name="btn_aor_report_name" id="btn_aor_report_name" tabindex="0" title="{$MOD.LBL_DASHLET_SELECT_REPORT}" class="button firstChild" value="{$MOD.LBL_DASHLET_SELECT_REPORT}"
                                {literal}
                                    onclick='open_popup(
                                            "AOR_Reports",
                                            600,
                                            400,
                                            "",
                                            true,
                                            false,
                                            {"call_back_function":"set_return","form_name":"ConfigureReportDashlet","field_to_name_array":{"id":"aor_report_id","name":"aor_report_name"}},
                                            "single",
                                            true
                                    );' >
                                {/literal}
                            <img src="themes/default/images/id-ff-select.png">
                        </button>
                        <button type="button" name="btn_clr_aor_report_name" id="btn_clr_aor_report_name" tabindex="0" title="{$MOD.LBL_DASHLET_CLEAR_REPORT}"  class="button lastChild"
                            onclick="SUGAR.clearRelateField(this.form, 'aor_report_name', 'aor_report_id');"  value="{$MOD.LBL_DASHLET_CLEAR_REPORT}" >
                            <img src="themes/default/images/id-ff-clear.png">
                        </button>
                    </span>
                    <script type="text/javascript">
                        {literal}
                        if(typeof sqs_objects == 'undefined'){
                            var sqs_objects = new Array;
                        }
                        sqs_objects['ConfigureReportDashlet']={
                            "form":"ConfigureReportDashlet",
                            "method":"query",
                            "modules": ["AOR_Reports"],
                            "field_list":["name","id"],
                            "populate_list":["aor_report_name","aor_report_id"],
                            "required_list":["aor_report_id"],
                            "conditions": [{
                                "name": "name",
                                "op": "like_custom",
                                "end": "%",
                                "value": ""
                            }],
                            "limit":"30",
                            "no_match_text":"No Match"};
                        SUGAR.util.doWhen(
                                "typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['ConfigureReportDashlet_aor_report_name']) != 'undefined'",
                                enableQS
                        );
                        {/literal}
                    </script>




                </td>
            </tr>
            <tr>
                <td align='right'>
                    <input type='submit' class='button' value='{$MOD.LBL_DASHLET_SAVE}'>
                </td>
            </tr>
        </table>
    </form>
</div>
