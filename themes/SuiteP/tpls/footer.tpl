{*
 /**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2020 SalesAgility Ltd.
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
</div>
</div>
<!-- END of container-fluid, pageContainer divs -->
<!-- Start Footer Section -->
{if $AUTHENTICATED}
    <!-- Start generic footer -->
    <footer>
        <div id="copyright_data" class="footer_left">
            <div id="dialog2" title="{$APP.LBL_SUITE_SUPERCHARGED}" style="display: none">
                <p>{$APP.LBL_SUITE_DESC1}</p>
                <br>
                <p>{$APP.LBL_SUITE_DESC2}</p>
                <br>
                <p>{$APP.LBL_SUITE_DESC3}</p>
                <br>
            </div>
            <div id="dialog" title="&copy; {$APP.LBL_SUITE_POWERED_BY}" style="display: none">
                <p>{$COPYRIGHT}</p>
            </div>
            <div id="copyrightbuttons">
                <a id="admin_options">&copy; {$APP.LBL_SUITE_SUPERCHARGED}</a>
                <a id="powered_by">&copy; {$APP.LBL_SUITE_POWERED_BY}</a>
            </div>
        </div>
        {if $STATISTICS}
        <div class="serverstats">
            <span class="glyphicon glyphicon-globe"></span> {$STATISTICS}
        </div>
        {/if}
    	<div class="footer_right">
    		
    		<a onclick="SUGAR.util.top();" href="javascript:void(0)">{$APP.LBL_SUITE_TOP}<span class="suitepicon suitepicon-action-above"></span> </a>
    	</div>
    </footer>
    <!-- END Generic Footer -->
{/if}
<!-- END Footer Section -->
{literal}
    <script>
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
