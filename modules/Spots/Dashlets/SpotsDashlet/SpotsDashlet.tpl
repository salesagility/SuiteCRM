{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
*}
<link rel="stylesheet" type="text/css" href="include/javascript/c3/c3.min.css">
<script type="text/javascript" src="include/javascript/touchPunch/jquery.ui.touch-punch.min.js"></script>
<link rel="stylesheet" type="text/css" href="include/javascript/pivottable/pivot.css">
<script type="text/javascript" src="include/javascript/suitespots/suitespots.js"></script>


<script type="text/javascript">
    {literal}
    $(function () {
        $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10');
        var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers);

        var template = {
            renderers: renderers
        }
        function getDataForPivot(element, config, type, showUI)
        {
                $.getJSON("index.php",
                        {
                            'module': 'Spots',
                            {/literal}
                            'action': type,
                            {literal}
                            'to_pdf':1
                        },
                        function (data) {
                            {/literal}
                            if("derivedAttributes" in config)
                                delete config["derivedAttributes"];
                            $(element)
                                    .pivotUI(data,$.extend(config,template),true);

                            if(showUI !== "1")
                                hideUI(element);

                            {literal}

                        });
        }
        function hideUI(element)
        {
            //This is to ascertain if the pivot ui is laying out the column options horizontally or vertically
            //It is vertically for larger data sets.  This allows us to hide the pivot ui appropriately
            var columnLayout = $(element+" table.pvtUi tr td:nth-child(3)").length;

            if(columnLayout > 0)
                $(element+" table.pvtUi tbody tr:lt(1),"+element+" table.pvtUi tbody tr:eq(1) td:lt(2)").hide();
            else
                $(element+" table.pvtUi tbody tr:lt(2),"+element+" table.pvtUi tbody tr:nth-child(3) td:nth-child(1)").hide();

        }
        {/literal}
        getDataForPivot(".output-{$id}",JSON.parse($(".config-{$id}").val()),$(".type-{$id}").val(), $(".showUI-{$id}").val());

        {literal}

    });

</script>
{/literal}

<input type="hidden" class="config-{$id}" value="{$config}">
<input type="hidden" class="type-{$id}" value="{$type}">
<input type="hidden" class="showUI-{$id}" value="{$showUI}">
<div class="output-{$id}"></div>


