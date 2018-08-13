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
<p class="text-muted">{sugar_translate label="LBL_SEARCH_HEADER_DESC"}</p>

<form id="SearchSettings"
      name="ConfigureSettings"
      class="detail-view"
      enctype='multipart/form-data'
      method="POST"
      action="index.php?module=Administration&action=SearchSettings&do=Save">

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">{sugar_translate label="LBL_SEARCH_CONTROLLER"}</div>
                <div class="panel-body tab-content">
                    <div class="form-group">
                        <label for="search-controller">{sugar_translate label="LBL_SEARCH_CONTROLLER"}</label>
                        {html_options
                        options=$APP_LIST.search_controllers
                        selected=$selectedController
                        id="search-controller"
                        name="search-controller"
                        class="form-control"
                        }
                        <small class="form-text text-muted">{sugar_translate label="LBL_SEARCH_CONTROLLER_HELP"}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">{sugar_translate label="LBL_SEARCH_ENGINE"}</div>
                <div class="panel-body tab-content">
                    <div class="form-group">
                        <label for="search-engine">{sugar_translate label="LBL_SEARCH_ENGINE"}</label>
                        {html_options
                        options=$engines
                        selected=$selectedEngine
                        id="search-engine"
                        name="search-engine"
                        class="form-control"
                        }
                        <small class="form-text text-muted">{sugar_translate label="LBL_SEARCH_ENGINE_HELP"}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">{sugar_translate label="LBL_SEARCH_MODULES"}</div>
                <div class="panel-body tab-content">
                    <label>{sugar_translate label="LBL_SEARCH_MODULES"}</label>
                    <p>
                        <small class="form-text text-muted">{sugar_translate label="LBL_SEARCH_MODULES_HELP"}</small>
                    </p>
                    {modules_selector name='search-modules' selectedModules=$selectedModules}
                </div>
            </div>
        </div>
    </div>

    <div>
        {$BUTTONS}
    </div>

    {$JAVASCRIPT}

</form>