{*

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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
 ********************************************************************************/




*}

{literal}
    <style>
        .menu {
            z-index: 100;
        }

        .subDmenu {
            z-index: 100;
        }

        div.moduleTitle {
            height: 10px;
        }
    </style>
{/literal}

{sugar_getscript file="cache/include/javascript/sugar_grp_yui_widgets.js"}
{sugar_getscript file='include/javascript/dashlets.js'}

<div class="clear"></div>

<!-- Construct Dashlets -->
<div id="pageContainer" class="yui-skin-sam">
    <div class="row" id="pageNum_{$activePage}_div">
        <table width="100%">
            <tr>
                {counter assign=hiddenCounter start=0 print=false}
                {foreach from=$columns key=colNum item=data}
                    <td class="dashletcontainer" valign='top'>
                        <ul class='noBullet' id='col_{$activePage}_{$colNum}'>
                            <li id='page_{$activePage}_hidden{$hiddenCounter}b'
                                style='height: 5px; margin-top:12px;' class='noBullet'>
                                &nbsp;&nbsp;&nbsp;
                            </li>
                            {foreach from=$data.dashlets key=id item=dashlet}
                                <li class='noBullet' id='dashlet_{$id}'>
                                    <div id='dashlet_entire_{$id}' class='dashletPanel'>
                                        {$dashlet.script}
                                        {$dashlet.displayHeader}
                                        {$dashlet.display}
                                        {$dashlet.displayFooter}
                                    </div>
                                </li>
                            {/foreach}
                            <li id='page_{$activePage}_hidden{$hiddenCounter}' style='height: 5px'
                                class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
                        </ul>
                    </td>
                    {counter}
                {/foreach}
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
    var activePage = {$activePage};
    var colNum = {$colNum};
    var theme = '{$theme}';
    current_user_id = '{$current_user}';
    jsChartsArray = new Array();
    var moduleName = '{$module}';
    document.body.setAttribute("class", "yui-skin-sam");
    {literal}

    $(function(){
        var percent = Math.round(100/(colNum+1));
        $('#pageContainer #pageNum_'+activePage+'_div .dashletcontainer').addClass('col-'+percent);
    });

    var mySugarLoader = new YAHOO.util.YUILoader({
        require : ["my_sugar", "sugar_charts"],
        // Bug #48940 Skin always must be blank
        skin: {
            base: 'blank',
            defaultSkin: ''
        },
        onSuccess: function(){
            initMySugar();
            initmySugarCharts();
            SUGAR.mySugar.maxCount = 	{/literal}{$maxCount}{literal};
            SUGAR.mySugar.homepage_dd = new Array();
            var j = 0;

            {/literal}
            var dashletIds = {$dashletIds};

            {if !$lock_homepage}
            for(i in dashletIds) {ldelim}
                SUGAR.mySugar.homepage_dd[j] = new ygDDList('dashlet_' + dashletIds[i]);
                SUGAR.mySugar.homepage_dd[j].setHandleElId('dashlet_header_' + dashletIds[i]);
                // Bug #47097 : Dashlets not displayed after moving them
                // add new property to save real id of dashlet, it needs to have ability reload dashlet by id
                SUGAR.mySugar.homepage_dd[j].dashletID = dashletIds[i];
                SUGAR.mySugar.homepage_dd[j].onMouseDown = SUGAR.mySugar.onDrag;
                SUGAR.mySugar.homepage_dd[j].afterEndDrag = SUGAR.mySugar.onDrop;
                j++;
                {rdelim}
            {if $hiddenCounter > 0}
            for(var wp = 0; wp <= {$hiddenCounter}; wp++) {ldelim}
                SUGAR.mySugar.homepage_dd[j++] = new ygDDListBoundary('page_'+activePage+'_hidden' + wp);
                {rdelim}
            {/if}
            YAHOO.util.DDM.mode = 1;
            {/if}
            {literal}
            SUGAR.mySugar.renderDashletsDialog();
            SUGAR.mySugar.sugarCharts.loadSugarCharts(activePage);
            {/literal}
            {literal}
        }
    });
    mySugarLoader.addModule({
        name :"my_sugar",
        type : "js",
        fullpath: {/literal}"{sugar_getjspath file='include/MySugar/javascript/MySugar.js'}"{literal},
        varName: "initMySugar",
        requires: []
    });
    mySugarLoader.addModule({
        name :"sugar_charts",
        type : "js",
        fullpath: {/literal}"{sugar_getjspath file="include/SugarCharts/Jit/js/mySugarCharts.js"}"{literal},
        varName: "initmySugarCharts",
        requires: []
    });
    mySugarLoader.insert();
    {/literal}
</script>
