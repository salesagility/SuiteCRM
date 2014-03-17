{*

/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/en/msa/master_subscription_agreement_11_April_2011.pdf
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2011 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/




*}
{literal}
    <style>
        .menu{
            z-index:100;
        }

        .subDmenu{
            z-index:100;
        }
    </style>
{/literal}

<!-- begin includes for overlib -->
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000"></div>
<script type="text/javascript" src="{sugar_getjspath file='include/javascript/sugar_grp_overlib.js'}"></script>
<!-- end includes for overlib -->

<script type="text/javascript">
    var numPages = {$numPages};
    var theme = '{$theme}';
    var loadedPages = new Array();
    var activePage = {$activePage};
    loadedPages[0] = '{$loadedPage}';
    current_user_id = '{$current_user}';
    jsChartsArray = new Array();
    var moduleName = 'Home';
</script>

<script type="text/javascript" src="{sugar_getjspath file='include/javascript/sugar_grp_yui_widgets.js'}"></script>
<script type="text/javascript" src="{sugar_getjspath file='include/javascript/dashlets.js'}"></script>
<script type="text/javascript" src='{sugar_getjspath file='include/JSON.js'}'></script>
<script type='text/javascript' src='{sugar_getjspath file='include/MySugar/javascript/MySugar.js'}'></script>
<link rel='stylesheet' href='{sugar_getjspath file='include/javascript/yui/build/assets/skins/sam/skin.css'}'>


<!-- CSS Files -->
<link type="text/css" href="{sugar_getjspath file='custom/include/SugarCharts/js/Jit/Examples/css/base.css'}" rel="stylesheet" />
<link type="text/css" href="{sugar_getjspath file='custom/include/SugarCharts/js/Jit/css/Examples/BarChart.css'}" rel="stylesheet" />
<!--[if IE]><script language="javascript" type="text/javascript" src="{sugar_getjspath file='custom/include/SugarCharts/js/Jit/Extras/excanvas.js'}"></script><![endif]-->
<!-- JIT Library File -->
<script language="javascript" type="text/javascript" src="{sugar_getjspath file='custom/include/SugarCharts/js/Jit/jit.js'}"></script>

<ul class="subpanelTablist" id="tabList">
    {foreach from=$pages key=pageNum item=pageData}
        <li id="pageNum_{$pageNum}">
            <a id="pageNum_{$pageNum}_anchor" class="{$pageData.tabClass}" href="javascript:SUGAR.mySugar.togglePages('{$pageNum}');">
        <span id="pageNum_{$pageNum}_input_span" style="display:none;">
        <input type="hidden" id="pageNum_{$pageNum}_name_hidden_input" value="{$pageData.pageTitle}"/>
        <input type="text" id="pageNum_{$pageNum}_name_input" value="{$pageData.pageTitle}" size="10" onblur="SUGAR.mySugar.savePageTitle('{$pageNum}',this.value);"/>
        </span>
        <span id="pageNum_{$pageNum}_link_span">
        <span id="pageNum_{$pageNum}_title_text" ondblclick="SUGAR.mySugar.renamePage('{$pageNum}');">{$pageData.pageTitle}</span>&nbsp;
        <span id="pageNum_{$pageNum}_more_detail" {if $pageData.tabClass != 'current'}style="display:none;"{/if}>
        <img onclick="return SUGAR.mySugar.showTabContext('{$pageNum}');" onmouseout="return nd(1000);" src="{sugar_getimagepath file='MoreDetail.png'}" width="8" height="7" border="0"/>
		</span>
        </span>
            </a>
        </li>
    {/foreach}

</ul>


<div id="pageContainer">
    <div id="pageNum_{$activePage}_div">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="subpanelTabForm" style="border-top: 0px none; margin-bottom: 4px;">
            <tr>
                {if $numCols > 2}
                    <td>
                        &nbsp;
                    </td>

                    <td rowspan="3">
                        <img src='{sugar_getimagepath file='blank.gif'}' width='15' height='1' border='0'>
                    </td>
                {/if}
                {if $numCols > 1}
                    <td>
                        &nbsp;
                    </td>
                    <td rowspan="3">
                        <img src='{sugar_getimagepath file='blank.gif'}' width='15' height='1' border='0'>
                    </td>
                {/if}
                <td align='right'>
                    <!--
			<input id="add_dashlets" class="button" type="button" value="{$lblAddDashlets}" onclick="return SUGAR.mySugar.showDashletsTree();"/>
		-->
                    <a href='index.php?module=Administration&action=SupportPortal&view=documentation&version={$sugarVersion}&edition={$sugarFlavor}&lang={$currentLanguage}&help_module=Home&help_action=index&key={$serverUniqueKey}' class='utilsLink' target='_blank'>
                        <img src='{sugar_getimagepath file="help.gif"}' width='13' height='13' alt='{$lblLnkHelp}' border='0' align='absmiddle'>
                    </a>
                    <a href='index.php?module=Administration&action=SupportPortal&view=documentation&version={$sugarVersion}&edition={$sugarFlavor}&lang={$currentLanguage}&help_module=Home&help_action=index&key={$serverUniqueKey}' class='utilsLink' target='_blank'>
                        {$lblLnkHelp}
                    </a>
                </td>
            </tr>
            <tr>
                {counter assign=hiddenCounter start=0 print=false}
                {foreach from=$columns key=colNum item=data}
                    <td valign='top' width='{$data.width}'>
                        <ul class='noBullet' id='col_{$activePage}_{$colNum}'>
                            <li id='page_{$activePage}_hidden{$hiddenCounter}b' style='height: 5px' class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
                            {foreach from=$data.dashlets key=id item=dashlet}
                                <li class='noBullet' id='dashlet_{$id}'>
                                    <div id='dashlet_entire_{$id}'>
                                        {$dashlet.script}
                                        {$dashlet.display}
                                    </div>
                                </li>
                            {/foreach}
                            <li id='page_{$activePage}_hidden{$hiddenCounter}' style='height: 5px' class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
                        </ul>
                    </td>
                    {counter}
                {/foreach}
            </tr>
        </table>
    </div>

    {foreach from=$divPages key=divPageIndex item=divPageNum}
        <div id="pageNum_{$divPageNum}_div" style="display:none;">
        </div>
    {/foreach}

    <div id="addPageDialog" style="display:none;">
        <div class="hd">Add Page</div>
        <div class="bd">
            <form method="POST" action="index.php?module=Home&action=newTab&to_pdf=1">
                <label for="pageName">Page Name: </label><input type="textbox" name="pageName" /><br /><br />
                <label for="numColumns">Number of Columns:</label>
                <table align="center">
                    <tr>
                        <td><input type="radio" name="numColumns" value="1" />1</td>
                        <td><input type="radio" name="numColumns" value="2" checked />2</td>
                        <td><input type="radio" name="numColumns" value="3" />3</td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div id="changeLayoutDialog" style="display:none;">
        <div class="hd">Change Layout</div>
        <div class="bd">
            <form method="POST" action="index.php?module=Home&action=changeLayout&to_pdf=1">
                <label for="numColumns">Number of Columns:</label>
                <table align="center">
                    <tr>
                        <td><input type="radio" name="numColumns" value="1" />1</td>
                        <td><input type="radio" name="numColumns" value="2" checked />2</td>
                        <td><input type="radio" name="numColumns" value="3" />3</td>
                    </tr>
                </table>
                <input type="hidden" name="changeLayoutParams" value="1" />
            </form>
        </div>
    </div>

    <div id="dashletsDialog">
        <div class="hd"></div>
        <div class="bd">
            <form></form>
        </div>
    </div>


</div>

{if !$lock_homepage}
{literal}
    <script type="text/javascript">
        SUGAR.mySugar.maxCount = 	{/literal}{$maxCount}{literal};
        SUGAR.mySugar.homepage_dd = new Array();
        SUGAR.mySugar.init = function () {
            j = 0;
            {/literal}
            dashletIds = {$dashletIds};
            {literal}
            for(i in dashletIds) {
                SUGAR.mySugar.homepage_dd[j] = new ygDDList('dashlet_' + dashletIds[i]);
                SUGAR.mySugar.homepage_dd[j].setHandleElId('dashlet_header_' + dashletIds[i]);
                SUGAR.mySugar.homepage_dd[j].onMouseDown = SUGAR.mySugar.onDrag;
                SUGAR.mySugar.homepage_dd[j].afterEndDrag = SUGAR.mySugar.onDrop;
                j++;
            }
            for(var wp = 0; wp <= {/literal}{$hiddenCounter}{literal}; wp++) {
                SUGAR.mySugar.homepage_dd[j++] = new ygDDListBoundary('page_'+activePage+'_hidden' + wp);
            }

            YAHOO.util.DDM.mode = 1;

            SUGAR.mySugar.renderAddPageDialog();
            SUGAR.mySugar.renderDashletsTree();
            SUGAR.mySugar.renderChangeLayoutDialog();
        }

        YAHOO.util.Event.addListener(window, 'load', SUGAR.mySugar.init);

    </script>
{/literal}
{/if}