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
                  appendHiddenFields(_form, ln, id);
                  updateTimeDateFields(fieldInput, ln);
                  // Fix for issue #1272 - AOR_Report module cannot update Date type parameter.
                  updateHiddenReportFields(ln, _form);
                });
                _form.submit();
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
