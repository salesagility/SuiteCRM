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


<div>
    <form action='index.php' id='configure_{$id}' method='post'
          onSubmit='SUGAR.mySugar.setChooser(); return SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage);'>
        <input type='hidden' name='id' value='{$id}'>
        <input type='hidden' name='module' value='Home'>
        <input type='hidden' name='action' value='ConfigureDashlet'>
        <input type='hidden' name='configure' value='true'>
        <input type='hidden' name='to_pdf' value='true'>
        <input type='hidden' id='displayColumnsDef' name='displayColumnsDef' value=''>
        <input type='hidden' id='hideTabsDef' name='hideTabsDef' value=''>
        <input type='hidden' id='dashletType' name='dashletType' value=''/>

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="edit view">
            <tr>
                <td scope='row' colspan='4' align='left'>
                    <h2>{$strings.general}</h2>
                </td>
            </tr>
            <tr>
                <td scope='row'>
                    {$strings.title}
                </td>
                <td>
                    <input type='text' name='dashletTitle' value='{$dashletTitle}'>
                </td>
            </tr>
            <tr>
                <td scope='row'>
                    {$strings.displayRows}
                </td>
                <td>
                    <select name='displayRows'>
                        {html_options values=$displayRowOptions output=$displayRowOptions selected=$displayRowSelect}
                    </select>
                </td>
            </tr>
            {if $isRefreshable}
                <tr>
                    <td scope='row' align='left'>
                        {$strings.autoRefresh}
                    </td>
                    <td >
                        <select name='autoRefresh' >
                            {html_options options=$autoRefreshOptions selected=$autoRefreshSelect}
                        </select>
                    </td>

                </tr>
            {/if}
            <tr>
                <td >
                    {$columnChooser}
                </td>
            </tr>
            {if $showMyItemsOnly || !empty($searchFields)}
                <tr>
                    <td scope='row' colspan='4' align='left'>
                        <br>
                        <h2>{$strings.filters}</h2>
                    </td>
                </tr>
                {if $showMyItemsOnly}
                    <tr>
                        <td scope='row'>
                            {$strings.myItems}
                        </td>
                        <td>
                            <input type='checkbox' {if $myItemsOnly == 'true'}checked{/if} name='myItemsOnly'
                                   value='true'>
                        </td>
                    </tr>
                {/if}
                <tr>
                {foreach name=searchIteration from=$searchFields key=name item=params}
                    <td  scope='row' valign='top'>
                        {$params.label}
                    </td>
                    <td  valign='top' style='padding-bottom: 5px'>
                        {$params.input}
                    </td>
                    {if ($smarty.foreach.searchIteration.iteration is even) and $smarty.foreach.searchIteration.iteration != $smarty.foreach.searchIteration.last}                        </tr>
                        </tr>

                        <tr>
                    {/if}
                {/foreach}

            {/if}
            <tr>
                <td colspan='4' align='right'>
                    <input type='submit' class='button' value='{$strings.save}'>
                    {if $showClearButton}
                        <input type='submit' class='button' value='{$strings.clear}'
                               onclick='SUGAR.searchForm.clear_form(this.form,["dashletTitle","displayRows","autoRefresh"]);return false;'>
                    {/if}
                </td>
            </tr>
        </table>
    </form>
</div>
