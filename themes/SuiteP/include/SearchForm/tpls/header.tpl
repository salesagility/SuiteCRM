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
<div class="clear"></div>
<div class='listViewBody'>
    <script type="text/javascript" src="{sugar_getjspath file='include/javascript/popup_parent_helper.js'}"></script>
    {$TABS}
    {{if $displayView == 'saved_views'}}
    {literal}
        <script>SUGAR.savedViews.handleForm();</script>
    {/literal}
    {{/if}}
    {literal}
        <script>


            function addXMLRequestCallback(callback) {
                var oldSend, i;
                if (XMLHttpRequest.callbacks) {
                    // we've already overridden send() so just add the callback
                    XMLHttpRequest.callbacks.push(callback);
                } else {
                    // create a callback queue
                    XMLHttpRequest.callbacks = [callback];
                    // store the native send()
                    oldSend = XMLHttpRequest.prototype.send;
                    // override the native send()
                    XMLHttpRequest.prototype.send = function () {
                        // process the callback queue
                        for (i = XMLHttpRequest.callbacks.length - 1; i >= 0; i--) {
                            XMLHttpRequest.callbacks[i](this);
                        }
                        // call the native send()
                        oldSend.apply(this, arguments);
                    }
                }
            }

            function refreshSearchForm() {
                $('.search_form textarea').each(function (i, e) {
                    $(e).css('max-width', $(e).parent().width());
                });
                if (!$('#search_form .tabFormAdvLink').prev().hasClass('clear')) {
                    $('#search_form .tabFormAdvLink').before('<div class="clear"></div>');
                }
                $('#search_form .dateTimeRangeChoice').css({
                    'white-space': 'initial',
                    'display': 'block'
                });
            }

            $(function () {
                var refreshSearchFormIntervals = [];
                var refreshSearchFormIntervalsCountDown = 100;
                addXMLRequestCallback(function (xhr) {
                    refreshSearchFormIntervalsCountDown = 100;
                    refreshSearchFormIntervals.push(setInterval(function () {
                        refreshSearchForm();
                        refreshSearchFormIntervalsCountDown -= 1 / refreshSearchFormIntervals.length;
                        if (refreshSearchFormIntervalsCountDown <= 0) {
                            $.each(refreshSearchFormIntervals, function (i, e) {
                                clearInterval(e);
                            });
                            refreshSearchFormIntervals = [];
                        }
                    }, 100));
                });
            });

            function submitOnEnter(e) {
                var characterCode = (e && e.which) ? e.which : event.keyCode;
                if (characterCode == 13 && event.target.type !== "textarea") {
                    document.getElementById('search_form').submit();
                    return false;
                } else {
                    return true;
                }
            }
        </script>
    {/literal}

    {if $searchFormInPopup}
        {include file='include/SearchForm/tpls/headerPopup.tpl'}
    {/if}

    <form name='search_form' id='search_form' class='search_form {if !$searchFormInPopup} non-popup{/if}' method='post'
          action='index.php?module={$module}&action={$action}' onkeydown='submitOnEnter(event);'>
        <input type='hidden' name='searchFormTab' value='{$displayView}'/>
        <input type='hidden' name='module' value='{$module}'/>
        <input type='hidden' name='action' value='{$action}'/>
        <input type='hidden' name='query' value='true'/>
        {foreach name=tabIteration from=$TAB_ARRAY key=tabkey item=tabData}
            <div id='{$module}{$tabData.name}_searchSearchForm' style='{$tabData.displayDiv}'
                 class="edit view search {$tabData.name}">{if $tabData.displayDiv}{else}{$return_txt}{/if}</div>
        {/foreach}
        <div id='{$module}saved_viewsSearchForm'
             {{if $displayView != 'saved_views'}}style='display: none;'{{/if}}>{$saved_views_txt}</div>
