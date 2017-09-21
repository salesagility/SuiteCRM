{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
<br>
    <script type="text/javascript" src="{sugar_getjspath file='include/SubPanel/SubPanelTiles.js'}"></script>
    <script>
        {literal}
    if(document.DetailView != null &&
        document.DetailView.elements != null &&
        document.DetailView.elements.layout_def_key != null &&
        typeof document.DetailView.elements['layout_def_key'] != 'undefined'){
            document.DetailView.elements['layout_def_key'].value = '{/literal}{$layout_def_key}{literal}';
    }
        {/literal}
    </script>
    {*{if $show_subpanel_tabs}*}
        <ul id="subpanel_list" class="noBullet subpanel_list">
            {foreach from=$subpanel_tabs key=i item=subpanel_tab}
                <li class="noBullet" id="whole_subpanel_{$subpanel_tab}">
                    <!--subpanel-title -->
                    <div id="subpanel_title_{$subpanel_tab}" {if empty($sugar_config.lock_subpanels) || $sugar_config.lock_subpanels == false} onmouseover="this.style.cursor = 'move';" {/if}>
                        {$subpanel_tabs_properties.$i.get_form_header}
                    </div>

                    <!--subpanel-body -->
                    <div cookie_name="{$subpanel_tabs_properties.$i.cookie_name}" id="subpanel_{$subpanel_tab}" style="display:{$subpanel_tabs_properties.$i.div_display}">

                        <script>document.getElementById("subpanel_{$subpanel_tab}" ).cookie_name="{$subpanel_tabs_properties.$i.cookie_name}";</script>

                        {if $tabs_properties.$i.div_display != 'none'}
                            <script>SUGAR.util.doWhen("typeof(markSubPanelLoaded) != 'undefined'", function() {literal}{ markSubPanelLoaded('{/literal}{$subpanel_tab}{literal}');}{/literal});</script>
                            {*{$subpanel_tabs_properties.$i.buttons}*}
                        {/if}

                        <div id="list_subpanel_{$subpanel_tab}">{$subpanel_tabs_properties.$i.subpanel_body}</div>
                    </div>
                </li>
            {/foreach}
        </ul>

{if $show_container}
    </ul>
    {if !empty($selected_group)}
        {*closing table from tpls/singletabmenu.tpl*}
        </td></tr></table>
    {/if}
{/if}

{if empty($sugar_config.lock_subpanels) || $sugar_config.lock_subpanels == false}
    {*drag and drop code*}
    <script>
        {literal}
        var SubpanelInit = function() {
            SubpanelInitTabNames({/literal}{$tab_names}{literal});
        }
        var SubpanelInitTabNames = function(tabNames) {
            subpanel_dd = new Array();
            j = 0;
            for(i in tabNames) {
                subpanel_dd[j] = new ygDDList('whole_subpanel_' + tabNames[i]);
                subpanel_dd[j].setHandleElId('subpanel_title_' + tabNames[i]);
                subpanel_dd[j].onMouseDown = SUGAR.subpanelUtils.onDrag;
                subpanel_dd[j].afterEndDrag = SUGAR.subpanelUtils.onDrop;
                j++;
            }
            YAHOO.util.DDM.mode = 1;
        }
        currentModule = '{/literal}{$module}{literal}';
        SUGAR.util.doWhen(
                "typeof(SUGAR.subpanelUtils) == 'object' && typeof(SUGAR.subpanelUtils.onDrag) == 'function'" +
                " && document.getElementById('subpanel_list')",
                SubpanelInit
        );
        {/literal}
    </script>
{/if}
<script>
    var ModuleSubPanels = {$module_sub_panels};
    {literal}

    var updateSubpanelGroup = function() {
        // Filter subpanels to show the current tab
        if (typeof SUGAR.subpanelUtils.currentSubpanelGroup !== "undefined") {
            SUGAR.subpanelUtils.loadSubpanelGroup(SUGAR.subpanelUtils.currentSubpanelGroup);
            clearCheckSubpanelGroup();
        }
    };

    var checkSubpanelGroup =  setInterval(updateSubpanelGroup, 100);

    var clearCheckSubpanelGroup = function() {
        clearInterval(checkSubpanelGroup);
    };
    {/literal}
</script>

    {*{/if}*}