{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
*}

<script src="modules/AOR_Conditions/conditionLines.js"></script>
<script>
  report_module = '{$report_module}';
</script>

<div>
    {$charts_content}
</div>

<div id='detailpanel_parameters' class='detail view  detail508 expanded hidden'>
    <form onsubmit="return false" id="EditView" name="EditView">
        <h4>
            <a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel('parameters');">
                <img border="0" id="detailpanel_parameters_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
            <a href="javascript:void(0)" class="expandLink" onclick="expandPanel('parameters');">
                <img border="0" id="detailpanel_parameters_img_show"
                     src="{sugar_getimagepath file="advanced_search.gif"}"></a>
            {sugar_translate label='LBL_PARAMETERS' module='AOR_Reports'}
            <script>
              document.getElementById('detailpanel_parameters').className += ' expanded';
            </script>
        </h4>
        <div id="aor_conditionLines" class="panelContainer" style="min-height: 50px;">
        </div>
        <input id='updateParametersButton' class="panelContainer" type="button"
               value="{sugar_translate label='LBL_UPDATE_PARAMETERS' module='AOR_Reports'}"/>
        <script>
            {literal}
            $.each(reportParameters, function (key, val) {
              loadConditionLine(val, 'EditView');
            });

            $(document).ready(function () {
              $('#updateParametersButton').click(function () {
                //Update the Detail view form to have the parameter info and reload the page
                var _form = $('#formDetailView');
                _form.find('input[name=action]').val('DetailView');
                //Add each parameter to the form in turn
                $('.aor_conditions_id').each(function (index, elem) {
                  $elem = $(elem);
                  var ln = $elem.attr('id').substr(17);
                  var id = $elem.val();
                  _form.append('<input type="hidden" name="parameter_id[]" value="' + id + '">');
                  var operator = $("#aor_conditions_operator\\[" + ln + "\\]").val();
                  _form.append('<input type="hidden" name="parameter_operator[]" value="' + operator + '">');
                  var fieldType = $('#aor_conditions_value_type\\[' + ln + '\\]').val();
                  _form.append('<input type="hidden" name="parameter_type[]" value="' + fieldType + '">');
                  var fieldInput = $('#aor_conditions_value\\[' + ln + '\\]').val();

                        // datetime combo fields
                        if (typeof fieldInput === 'undefined'
                          && $("[name='aor_conditions_value\\["+ln+"\\]']").val()
                          && $("[name='aor_conditions_value\\["+ln+"\\]']").hasClass('DateTimeCombo')) {
                            var datetime = $("[name='aor_conditions_value\\["+ln+"\\]']").val();
                            var date = datetime.substr(0,10);
                            var formatDate = $.datepicker.formatDate('yy-mm-dd', new Date(date));
                            fieldInput = datetime.replace(date, formatDate) + ':00';
                        }

                        // Fix for issue #1272 - AOR_Report module cannot update Date type parameter.
                        if($('#aor_conditions_value\\['+ln+'\\]\\[0\\]').length){
                            var fieldValue = $('#aor_conditions_value\\['+ln+'\\]\\[0\\]').val();
                            var fieldSign = $('#aor_conditions_value\\['+ln+'\\]\\[1\\]').val();
                            var fieldNumber = $('#aor_conditions_value\\['+ln+'\\]\\[2\\]').val();
                            var fieldTime = $('#aor_conditions_value\\['+ln+'\\]\\[3\\]').val();                            _form.append('<input type="hidden" name="parameter_value[]" value="'+fieldValue+'">');
                            _form.append('<input type="hidden" name="parameter_value[]" value="'+fieldSign+'">');
                            _form.append('<input type="hidden" name="parameter_value[]" value="'+fieldNumber+'">');
                            _form.append('<input type="hidden" name="parameter_value[]" value="'+fieldTime+'">');
                        }
                        // Fix for issue #1082 - change local date format to db date format
                        if($('#aor_conditions_value\\['+index+'\\]').hasClass('date_input')) { // only change to DB format if its a date
                            if ($('#aor_conditions_value\\[' + ln + '\\]').hasClass('date_input')) {
                                fieldInput = $.datepicker.formatDate('yy-mm-dd', new Date(fieldInput));
                            }
                        }
                        _form.append('<input type="hidden" name="parameter_value[]" value="'+fieldInput+'">');
                    });
                    _form.submit();
                });

                // Make sure to change dates back to the user format
                $('.aor_conditions_id').each(function(index, elem){
                    if($('#aor_conditions_value\\['+index+'\\]').hasClass('date_input')) {
                        var dateValue = new Date( $('#aor_conditions_value\\['+index+'\\]').val() );
                        var dateValueinUserFormat = dateValue.toLocaleFormat(cal_date_format);
                        $('#aor_conditions_value\\['+index+'\\]').val(dateValueinUserFormat)
                    }
                });
            });
            {/literal}
        </script>
        <script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function () {ldelim} initPanel('parameters', 'expanded'); {rdelim}); </script>
    </form>
</div>


<div class="panel-content">
    <div>&nbsp;</div>
    <div class="panel panel-default">
        <div class="panel-heading ">
            <a class="" role="button" data-toggle="collapse" href="#detailpanel_report" aria-expanded="false">
                <div class="col-xs-10 col-sm-11 col-md-11">
                    {sugar_translate label='LBL_REPORT' module='AOR_Reports'}
                </div>
            </a>
        </div>
        <div class="panel-body panel-collapse collapse in" id="detailpanel_report">
            <div class="tab-content">
                {$report_content}
            </div>
        </div>
    </div>


<script src="modules/AOR_Reports/Dashlets/AORReportsDashlet/AORReportsDashlet.js"></script>
