{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

*}
</div>
</div>
<!-- END of container-fluid, pageContainer divs -->
<!-- Start Footer Section -->
{if $AUTHENTICATED}
<!-- Start of mobile/tablet footer -->
<div id="mobilefooter">
    <div id="footernav" class="btn-toolbar" role="toolbar" aria-label="...">
        <div class="btn-group dropup" role="group" aria-label="...">
            <a href="index.php" class="btn btn-success"></span><span class="glyphicon glyphicon-home" aria-hidden="true"></a>
            <a href="javascript:void(0)" class="btn btn-success" onclick="refresh();"><span class=" glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
            <div class="btn-group" role="group">
                <button type="button" class="btn dropdown-toggle btn-success quickcreate" data-toggle="dropdown" aria-expanded="false">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li role="presentation"><a href="index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=DetailView">{$MOD.LBL_QUICK_ACCOUNT}</a></li>
                    <li role="presentation"><a href="index.php?module=Contacts&action=EditView&return_module=Contacts&return_action=DetailView">{$MOD.LBL_QUICK_CONTACT}</a></li>
                    <li role="presentation"><a href="index.php?module=Opportunities&action=EditView&return_module=Opportunities&return_action=DetailView">{$MOD.LBL_QUICK_OPPORTUNITY}</a></li>
                    <li role="presentation"><a href="index.php?module=Leads&action=EditView&return_module=Leads&return_action=DetailView">{$MOD.LBL_QUICK_LEAD}</a></li>
                    <li role="presentation"><a href="index.php?module=Documents&action=EditView&return_module=Documents&return_action=DetailView">{$MOD.LBL_QUICK_DOCUMENT}</a></li>
                    <li role="presentation"><a href="index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView">{$MOD.LBL_QUICK_CALL}</a></li>
                    <li role="presentation"><a href="index.php?module=Tasks&action=EditView&return_module=Tasks&return_action=DetailView">{$MOD.LBL_QUICK_TASK}</a></li>
                </ul>
            </div>
            <a role="menuitem" href='index.php?module=Administration&action=index' class="btn btn-success"><span class=" glyphicon glyphicon-cog" aria-hidden="true"></span></a>
            <a role="menuitem" href='index.php?module=Users&action=Logout' class="btn btn-success"><span class=" glyphicon glyphicon-log-out" aria-hidden="true"></span></a>
        </div>
    </div>
</div>
<!-- END of mobile/tablet footer -->
<!-- Start generic footer -->
    <footer>
        <div class="serverstats">
            <span class="glyphicon glyphicon-globe"></span> {$STATISTICS}
        </div>
        <div id="links">
            <button id="print_page" class="button primary" onclick="printpage()">{$MOD.LBL_SUITE_PRINT}</button>
            <button id="backtotop" class="button primary">{$MOD.LBL_SUITE_TOP}</button>
        </div>
        <div id="copyright_data">
            <div id="dialog2" title="{$MOD.LBL_SUITE_SUPERCHARGED}">
                <p>{$MOD.LBL_SUITE_DESC1}</p>
                <br>
                <p>{$MOD.LBL_SUITE_DESC2}</p>
                <br>
                <p>{$MOD.LBL_SUITE_DESC3}</p>
                <br>
            </div>
            <div id="dialog" title="&copy; {$MOD.LBL_SUITE_POWERED_BY}">
                <p>{$COPYRIGHT}</p>
            </div>
            <div id="copyrightbuttons">
            <button id="admin_options" class="button primary">&copy; {$MOD.LBL_SUITE_SUPERCHARGED}</button>
            <button id="powered_by" class="button primary">&copy; {$MOD.LBL_SUITE_POWERED_BY}</button>
            </div>
        </div>
    </footer>
<!-- END Generic Footer -->
{/if}
<!-- END Footer Section -->
<script>
{literal}
function printpage()
{
    window.print();
}
if(SUGAR.util.isTouchScreen()) {
        setTimeout(resizeHeader,10000);
}

//qe_init function sets listeners to click event on elements of 'quickEdit' class
 if(typeof(DCMenu) !='undefined'){
    DCMenu.qe_refresh = false;
    DCMenu.qe_handle;
 }
function qe_init(){

    //do not process if YUI is undefined
    if(typeof(YUI)=='undefined' || typeof(DCMenu) == 'undefined'){
        return;
    }


    //remove all existing listeners.  This will prevent adding multiple listeners per element and firing multiple events per click
    if(typeof(DCMenu.qe_handle) !='undefined'){
        DCMenu.qe_handle.detach();
    }

    //set listeners on click event, and define function to call
    YUI().use('node', function(Y) {
        var qe = Y.all('.quickEdit');
        var refreshDashletID;
        var refreshListID;

        //store event listener handle for future use, and define function to call on click event
        DCMenu.qe_handle = qe.on('click', function(e) {
            //function will flash message, and retrieve data from element to pass on to DC.miniEditView function
            ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'),800);
            e.preventDefault();
            if(typeof(e.currentTarget.getAttribute('data-dashlet-id'))!='undefined'){
                refreshDashletID = e.currentTarget.getAttribute('data-dashlet-id');
            }
            if(typeof(e.currentTarget.getAttribute('data-list'))!='undefined'){
                refreshListID = e.currentTarget.getAttribute('data-list');
            }
            DCMenu.miniEditView(e.currentTarget.getAttribute('data-module'), e.currentTarget.getAttribute('data-record'),refreshListID,refreshDashletID);
        });

    });
}

    qe_init();

	SUGAR_callsInProgress++;
	SUGAR._ajax_hist_loaded = true;
    if(SUGAR.ajaxUI)
    	YAHOO.util.Event.onContentReady('ajaxUI-history-field', SUGAR.ajaxUI.firstLoad);
</script>
    <script src="themes/suiteresponsive/js/jquery.cookie.js"></script>
    <script>
        $( "button" ).click(function() {
            $( "#sugarcopy" ).toggle();

        });
        /* Custom JavaScript for copyright pop-ups */
        $(function() {
            $( "#dialog, #dialog2" ).dialog({
                autoOpen: false,
                show: {
                    effect: "blind",
                    duration: 100
                },
                hide: {
                    effect: "fade",
                    duration: 1000
                }
            });
            $( "#powered_by" ).click(function() {
                $( "#dialog" ).dialog( "open" );
                $("#overlay").show().css({"opacity": "0.5"});
            });
            $( "#admin_options" ).click(function() {
                $( "#dialog2" ).dialog( "open" );
            });
        });
        // Back to top animation
        $('#backtotop').click(function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop:0}, 500); // Scroll speed to the top
        });
        // Refresh function for refresh button on sidebar
        function refresh(reload)
        {
            window.location.reload(true);
        }
        // Tabs jQuery for Admin panel
        $(function() {
            var tabs = $( "#tabs" ).tabs();
            tabs.find( ".ui-tabs-nav" ).sortable({
                axis: "x",
                stop: function() {
                    tabs.tabs( "refresh" );
                }
            });
        });
        /* Function to call footable for responsive table functionality */
        $(function () {
            $('.footable').footable();
        });
        /* JavaScript fix to remove unrequired classes on smaller screens where sidebar is obsolete */
        $(window).on('resize', function () {
            $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main', $(window).width() < 768);
        if ($(window).width() > 979) {
            $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main');
        }
        });
        $('.showsearch').click(function() {
            $('.search_form').toggle();
        });
        $('#buttontoggle').click(function(){
            $('.sidebar').toggle();
            if ($('.sidebar').is(':visible')){
                $.cookie('sidebartoggle', 'expanded');
                $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');

            }

            if ($('.sidebar').is(':hidden')){
                $.cookie('sidebartoggle', 'collapsed');
                $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');

            }
            console.log($.cookie('sidebartoggle'));
        });
        var sidebartoggle = $.cookie('sidebartoggle');
        if (sidebartoggle == 'collapsed'){
            $('.sidebar').hide();
            $('#bootstrap-container').removeClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 col-sm-3 col-md-2 sidebar');
        }
        if (sidebartoggle == 'expanded'){
            $('#bootstrap-container').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');
        }
    </script>
    <!-- Include all boostrap dependencies -->

    <script src="themes/suiteresponsive/js/bootstrap.min.js"></script>
    <script src="themes/suiteresponsive/js/html5shiv.min.js"></script>
    <script src="themes/suiteresponsive/js/respond.min.js"></script>
    <script src="themes/suiteresponsive/js/footable.js" type="text/javascript"></script>
{/literal}
</div>
</body>
</html>