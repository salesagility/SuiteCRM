{*
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
 *}
<h2 class="moduleTitle">{$APP.LBL_SEARCH_REAULTS_TITLE}</h2>
{if isset($error)}
    <p class="error">{$APP.ERR_SEARCH_INVALID_QUERY}</p>
{else}

    {foreach from=$results->getHitsAsBeans() item=beans key=module}
    <h3>{$module}</h3>
    <table class="list view">
        <thead>
            <tr>
                {foreach from=$headers[$module] item=header}
                <th title="{$header.comment}">{$header.label}</th>
                {/foreach}
            </tr>
        </thead>
        <tbody>
            {foreach from=$beans item=bean}
            <tr class="{cycle values="oddListRowS1,evenListRowS1"}">
                {foreach from=$headers[$module] item=header}
                <td><span><a href="{$APP_CONFIG.site_url}/index.php?action=DetailView&module={$module}&record={$bean->id}&offset=1">{php}
                        // using php to access to a smarty template object 
                        // variable field by a dynamic indexed array element 
                        // because it's impossible only with smarty syntax
                        echo $this->get_template_vars('bean')->{$this->get_template_vars('header')['field']};
                    {/php}</a></span></td>
                {/foreach}
            </tr>
            {/foreach}
        </tbody>
        </thead>
    </table>
    {foreachelse}
    <p class="error">{$APP.ERR_SEARCH_NO_RESULTS}</p>
    {/foreach}
    
    {if !empty($results->getSearchTime())}
        <p class="text-muted text-right" id="search-time">
            {$APP.LBL_SEARCH_PERFORMED_IN} {$results->getSearchTime()*1000|string_format:"%.2f"} ms
        </p>
    {/if}
{/if}