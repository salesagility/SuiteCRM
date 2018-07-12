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

setModuleFieldsPendingFinishedCallback(function(){
    var parenthesisBtnHtml;
    $( "#aor_conditions_body, #aor_condition_parenthesis_btn" ).sortable({
        handle: '.condition-sortable-handle',
        placeholder: "ui-state-highlight",
        cancel: ".parenthesis-line",
        connectWith: ".connectedSortableConditions",
        start: function(event, ui) {
            parenthesisBtnHtml = $('#aor_condition_parenthesis_btn').html();
        },
        stop: function(event, ui) {
            if(event.target.id == 'aor_condition_parenthesis_btn') {
                $('#aor_condition_parenthesis_btn').html('<tr class="parentheses-btn">' + ui.item.html() + '</tr>');
                ParenthesisHandler.replaceParenthesisBtns();
            }
            else {
                if($(this).attr('id') == 'aor_conditions_body' && parenthesisBtnHtml != $('#aor_condition_parenthesis_btn').html()) {
                    $(this).sortable("cancel");
                }
            }
            LogicalOperatorHandler.hideUnnecessaryLogicSelects();
            ConditionOrderHandler.setConditionOrders();
            ParenthesisHandler.addParenthesisLineIdent();
        }
    });
    LogicalOperatorHandler.hideUnnecessaryLogicSelects();
    ConditionOrderHandler.setConditionOrders();
    ParenthesisHandler.addParenthesisLineIdent();
});

$(function(){

    $('#EditView_tabs .clear').remove();
    $('#EditView_tabs').attr('style', 'width: 78%;');

    $( '#aor_condition_parenthesis_btn' ).bind( "sortstart", function (event, ui) {
        ui.helper.css('margin-top', $(window).scrollTop() );
    });
    $( '#aor_condition_parenthesis_btn' ).bind( "sortbeforestop", function (event, ui) {
        ui.helper.css('margin-top', 0 );
    });

    $(window).resize()
    {
        $('div.panel-heading a div').css({
            width: $('div.panel-heading a').width() - 14
        });
    }

    var reportToggler = function(elem) {
        var marker = 'toggle-';
        var classes = $(elem).attr('class').split(' ');
        $('.tab-togglers .tab-toggler').removeClass('active');
        $(elem).addClass('active');
        $('.tab-panels .edit.view').addClass('hidden');
        $.each(classes, function(i, cls){
            if(cls.substring(0, marker.length) == marker) {
                var panelId = cls.substring(marker.length);
                $('#'+panelId).removeClass('hidden');
            }
        });
    };

});