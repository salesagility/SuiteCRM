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
</div>
</div>
<!-- END of container-fluid, pageContainer divs -->
<!-- Start Footer Section -->
{if $AUTHENTICATED}
    <!-- Start generic footer -->
    <footer>
        <div id="copyright_data">
            <div id="dialog2" title="{$APP.LBL_SUITE_SUPERCHARGED}">
                <p>{$APP.LBL_SUITE_DESC1}</p>
                <br>
                <p>{$APP.LBL_SUITE_DESC2}</p>
                <br>
                <p>{$APP.LBL_SUITE_DESC3}</p>
                <br>
            </div>
            <div id="dialog" title="&copy; {$APP.LBL_SUITE_POWERED_BY}">
                <p>{$COPYRIGHT}</p>
            </div>
            <div id="copyrightbuttons" class="footer_left">
                <a id="admin_options">&copy; {$APP.LBL_SUITE_SUPERCHARGED}</a>
                <a id="powered_by">&copy; {$APP.LBL_SUITE_POWERED_BY}</a>
            </div>
        </div>
    	<div class="footer_right">
    		
    		<a onclick="SUGAR.util.top();" href="javascript:void(0)">{$APP.LBL_SUITE_TOP}<span class="suitepicon suitepicon-action-above"></span> </a>
    	</div>
    </footer>
    <!-- END Generic Footer -->
{/if}
<!-- END Footer Section -->
{literal}
    <script>

        //qe_init function sets listeners to click event on elements of 'quickEdit' class
        if (typeof(DCMenu) != 'undefined') {
            DCMenu.qe_refresh = false;
            DCMenu.qe_handle;
        }
        function qe_init() {

            //do not process if YUI is undefined
            if (typeof(YUI) == 'undefined' || typeof(DCMenu) == 'undefined') {
                return;
            }


            //remove all existing listeners.  This will prevent adding multiple listeners per element and firing multiple events per click
            if (typeof(DCMenu.qe_handle) != 'undefined') {
                DCMenu.qe_handle.detach();
            }

            //set listeners on click event, and define function to call
            YUI().use('node', function (Y) {
                var qe = Y.all('.quickEdit');
                var refreshDashletID;
                var refreshListID;

                //store event listener handle for future use, and define function to call on click event
                DCMenu.qe_handle = qe.on('click', function (e) {
                    //function will flash message, and retrieve data from element to pass on to DC.miniEditView function
                    ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'), 800);
                    e.preventDefault();
                    if (typeof(e.currentTarget.getAttribute('data-dashlet-id')) != 'undefined') {
                        refreshDashletID = e.currentTarget.getAttribute('data-dashlet-id');
                    }
                    if (typeof(e.currentTarget.getAttribute('data-list')) != 'undefined') {
                        refreshListID = e.currentTarget.getAttribute('data-list');
                    }
                    DCMenu.miniEditView(e.currentTarget.getAttribute('data-module'), e.currentTarget.getAttribute('data-record'), refreshListID, refreshDashletID);
                });

            });
        }

        qe_init();

        SUGAR_callsInProgress++;
        SUGAR._ajax_hist_loaded = true;
        if (SUGAR.ajaxUI)
            YAHOO.util.Event.onContentReady('ajaxUI-history-field', SUGAR.ajaxUI.firstLoad);




        $(function(){

            // fix for campaign wizard
            if($('#wizard').length) {

                // footer fix
                var bodyHeight = $('body').height();
                var contentHeight = $('#pagecontent').height() + $('#wizard').height();
                var fieldsetHeight = $('#pagecontent').height() + $('#wizard fieldset').height();
                var height = bodyHeight < contentHeight ? contentHeight : bodyHeight;
                if(fieldsetHeight > height) {
                    height = fieldsetHeight;
                }
                height += 50;
                $('#content').css({
                    'min-height': height + 'px'
                });

                // uploader fix
                $('#step1_uploader').css({
                    position: 'relative',
                    top: ($('#wizard').height() - 90) + 'px'
                });
            }
        });

    </script>
{/literal}
</div>
<div class="modal fade modal-generic" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="title-generic">{$APP.LBL_GENERATE_PASSWORD_BUTTON_TITLE}</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">{$APP.LBL_CANCEL}</button>
                <button id="btn-generic" class="btn btn-danger" type="button">{$APP.LBL_OK}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</body>
</html>
