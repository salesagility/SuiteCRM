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
<!--end body panes-->
        </td></tr></table>
    </div>
    <div class="clear"></div>

</div>

<div id="bottomLinks">
{if $AUTHENTICATED}
{*{$BOTTOMLINKS}*}
    {/if}
</div>

<div id="footer">
    {if $AUTHENTICATED}
    <div id="links">
        <button id="backtotop">Back To Top</button>
    </div>
    {/if}
	<div id="responseTime">
    	{$STATISTICS}
    </div>
    <div id="copyright_data">
    <div id="dialog2" title="SuiteCRM - SugarCRM Supercharged!">
        <p>SuiteCRM has been written and assembled by SalesAgility, one of the world's most knowledgeable SugarCRM consultancies.</p>
        <br>
        <p>SuiteCRM is intended to deliver on the promise of SugarCRM - a freely available open source CRM project that combines great functionality, with community and commitment.</p>
        <br>
        <p>There will be no licenced software as part of the project managed by SalesAgility. All the code is free. All the code is available for free download. There is no hidden agenda to charge for access to the code. It is and always will be free and open source. There will be no paid-for versions.</p>
    </div>
    <div id="dialog" title="&copy; Powered by SugarCRM">
        <p>{$COPYRIGHT}</p>
    </div>

    <button id="admin_options">Supercharged by SuiteCRM</button>
    <button id="powered_by">&copy; Powered by SugarCRM</button>
    </div>

</div>
<script>
{literal}

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
    <script>
        $( "button" ).click(function() {
            $( "#sugarcopy" ).toggle();

        });

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

        $("#read").click(function(){

        });

        // Back to top animation
        $('#backtotop').click(function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop:0}, 500); // Scroll speed to the top
        });
    </script>
{/literal}
{$SUGAR_JS}
{literal}
<script type="text/javascript">
    <!--
    SUGAR.themes.theme_name      = '{/literal}{$THEME}{literal}';
    SUGAR.themes.theme_ie6compat = {/literal}{$THEME_IE6COMPAT}{literal};
    SUGAR.themes.hide_image      = '{/literal}{sugar_getimagepath file="hide.gif"}{literal}';
    SUGAR.themes.show_image      = '{/literal}{sugar_getimagepath file="show.gif"}{literal}';
    SUGAR.themes.loading_image      = '{/literal}{sugar_getimagepath file="img_loading.gif"}{literal}';
    SUGAR.themes.allThemes       = eval({/literal}{$allThemes}{literal});
    if ( YAHOO.env.ua )
        UA = YAHOO.env.ua;
    -->
</script>
{/literal}
<script type="text/javascript" src='{sugar_getjspath file="cache/include/javascript/sugar_field_grp.js"}'></script>

</body>
</html>
