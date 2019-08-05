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
<h1>{sugar_translate label="LBL_SEARCH_HEADER"}</h1>

<form id="SearchSettings"
      name="ConfigureSettings"
      class="detail-view"
      enctype='multipart/form-data'
      method="POST"
      action="index.php?module=Administration&action=SearchSettings&do=Save">

    <table class="edit view" width="100%" cellspacing="1" cellpadding="0" border="0">
        <tr>
            <th scope="row" colspan="4" align="left">
                <h4>{sugar_translate label="LBL_SEARCH_INTERFACE"}</h4>
            </th>
        </tr>

        <tr>
            {*search engine*}
            <td>
                <div class="td-container">
                    <div>
                        <label for="search-engine">{sugar_translate label="LBL_SEARCH_ENGINE"}</label>
                        {sugar_help text=$MOD.LBL_SEARCH_ENGINE_TOOLTIP}
                    </div>
                    <div>
                        <small class="form-text text-muted">{sugar_translate label="LBL_SEARCH_ENGINE_HELP"}</small>
                    </div>
                </div>
            </td>
            <td scope="row" style="vertical-align: middle">
                {html_options
                options=$engines
                selected=$selectedEngine
                id="search-engine"
                name="search-engine"
                class="form-control"
                }
            </td>
        </tr>
    </table>

    <div class="settings-buttons">
        {$BUTTONS}
    </div>

    {$JAVASCRIPT}

    <script src="modules/Administration/Search/ajaxSubmit.js"></script>

</form>
