{*
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
 *}

{literal}
<style type="text/css">
    #EditView_tabs {float: left;}
</style>
{/literal}

<div id="report-editview-footer" style="width:100%">


{literal}
    <script src="modules/AOR_Reports/js/jqtree/tree.jquery.js"></script>
    <script src="modules/SharedSecurityRulesConditions/conditionLines.js"></script>
    <script src="modules/AOR_Charts/chartLines.js"></script>

    <link rel="stylesheet" href="include/javascript/jquery/themes/base/jquery-ui.min.css">
    <script src="include/javascript/jquery/jquery-ui-min.js"></script>
    <script src="modules/SharedSecurityRules/sharedSecurityRules.js"></script>


{/literal}


<div class="clear"></div>

    <div class="tab-panels" style="width:100%">
       <!-- <div class="edit view edit508" id="detailpanel_conditions">
            <div class="drop-area" id="conditionLines"  style="min-height: 450px;">
            </div> -->
            <hr>
            <table>
                <tbody id="aor_condition_parenthesis_btn" class="connectedSortableConditions">
             <!--   <tr class="parentheses-btn"><td class="condition-sortable-handle">{$MOD.LBL_ADD_PARENTHESIS}</td></tr> -->
                </tbody>
            </table>
        </div>
    </div>

{literal}
    <script src="modules/SharedSecurityRules/setModuleFields.js"></script>
{/literal}

</div>

<div style="clear: both;"></div>

<div style="display: block; float: none;">
    {{include file="include/EditView/footer.tpl"}}
</div>
{literal}
<style>
    #conditionLines td{
        width:13%!important
    }
</style>
{/literal}