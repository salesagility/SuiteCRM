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
{sugar_include type="smarty" file="modules/Activities/tpls/PopupHeader.tpl"}

<div class="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                                                  data-toggle="tab">{$mod.LBL_OVERVIEW}</a>
        </li>
        <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab"
                                   data-toggle="tab">{$mod.LBL_TASKS}</a></li>
        <li role="presentation"><a href="#meetings" aria-controls="meetings" role="tab"
                                   data-toggle="tab">{$mod.LBL_MEETINGS}</a></li>
        <li role="presentation"><a href="#calls" aria-controls="calls" role="tab" data-toggle="tab">{$mod.LBL_CALLS}</a>
        </li>
        <li role="presentation"><a href="#emails" aria-controls="emails" role="tab"
                                   data-toggle="tab">{$mod.LBL_EMAILS}</a>
        </li>
        <li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">{$mod.LBL_NOTES}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th>{$mod.LBL_LIST_SUBJECT}</th>
                    <th>{$mod.LBL_LIST_STATUS}</th>
                    <th>{$mod.LBL_LIST_CONTACT}</th>
                    <th>{$mod.LBL_LIST_DATE}</th>
                </tr>
                </thead>

                <tbody>
                {foreach from=$summaryList key=k item=activity}

                    <!-- BEGIN: row -->
                    <td>
                        <span class="suitepicon suitepicon-module-{$activity.module|lower|replace:'_':'-'}"></span>
                    </td>
                    <td>{$activity.name} {$activity.attachment}</td>
                    <td>{$activity.type} {$activity.status}</td>
                    <td>{$activity.contact_name}</td>
                    <td>{$activity.date_type} {$activity.date_modified}</td>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td>{$activity.description}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                {/foreach}

                </tbody>
                <!-- END: row -->
            </table>
        </div>

        <div role="tabpanel" class="tab-pane" id="tasks">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th>{$mod.LBL_LIST_SUBJECT}</th>
                    <th>{$mod.LBL_LIST_STATUS}</th>
                    <th>{$mod.LBL_LIST_CONTACT}</th>
                    <th>{$mod.LBL_LIST_DATE}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$taskslist key=k item=activity}

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-{$activity.module|lower|replace:'_':'-'}"></span>
                        </td>
                        <td>{$activity.name} {$activity.attachment}</td>
                        <td>{$activity.type} {$activity.status}</td>
                        <td>{$activity.contact_name}</td>
                        <td>{$activity.date_type} {$activity.date_modified}</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td>{$activity.description}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                {/foreach}

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="meetings">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th>{$mod.LBL_LIST_SUBJECT}</th>
                    <th>{$mod.LBL_LIST_STATUS}</th>
                    <th>{$mod.LBL_LIST_CONTACT}</th>
                    <th>{$mod.LBL_LIST_DATE}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$meetingList key=k item=activity}

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-{$activity.module|lower|replace:'_':'-'}"></span>
                        </td>
                        <td>{$activity.name} {$activity.attachment}</td>
                        <td>{$activity.type} {$activity.status}</td>
                        <td>{$activity.contact_name}</td>
                        <td>{$activity.date_type} {$activity.date_modified}</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td>{$activity.description}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                {/foreach}

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="calls">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th>{$mod.LBL_LIST_SUBJECT}</th>
                    <th>{$mod.LBL_LIST_STATUS}</th>
                    <th>{$mod.LBL_LIST_CONTACT}</th>
                    <th>{$mod.LBL_LIST_DATE}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$callsList key=k item=activity}

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-{$activity.module|lower|replace:'_':'-'}"></span>
                        </td>
                        <td>{$activity.name} {$activity.attachment}</td>
                        <td>{$activity.type} {$activity.status}</td>
                        <td>{$activity.contact_name}</td>
                        <td>{$activity.date_type} {$activity.date_modified}</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td>{$activity.description}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                {/foreach}

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="emails">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th>{$mod.LBL_LIST_SUBJECT}</th>
                    <th>{$mod.LBL_LIST_STATUS}</th>
                    <th>{$mod.LBL_LIST_CONTACT}</th>
                    <th>{$mod.LBL_LIST_DATE}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$emailsList key=k item=activity}

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-{$activity.module|lower|replace:'_':'-'}"></span>
                        </td>
                        <td>{$activity.name} {$activity.attachment}</td>
                        <td>{$activity.type} {$activity.status}</td>
                        <td>{$activity.contact_name}</td>
                        <td>{$activity.date_type} {$activity.date_modified}</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td>{$activity.description}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                {/foreach}

                </tbody>
                <!-- END: row -->
            </table>

        </div>

        <div role="tabpanel" class="tab-pane" id="notes">
            <table class="list view table-responsive subpanel-table">
                <thead>
                <tr class="footable-header">
                    <th>
                        <img class="blank-space" src="include/images/blank.gif">
                    </th>
                    <th>{$mod.LBL_LIST_SUBJECT}</th>
                    <th>{$mod.LBL_LIST_STATUS}</th>
                    <th>{$mod.LBL_LIST_CONTACT}</th>
                    <th>{$mod.LBL_LIST_DATE}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$notesList key=k item=activity}

                    <!-- BEGIN: row -->
                    <tr>
                        <td>
                            <span class="suitepicon suitepicon-module-{$activity.module|lower|replace:'_':'-'}"></span>
                        </td>
                        <td>{$activity.name} {$activity.attachment}</td>
                        <td>{$activity.type} {$activity.status}</td>
                        <td>{$activity.contact_name}</td>
                        <td>{$activity.date_type} {$activity.date_modified}</td>
                    </tr>
                    <!--  BEGIN: description -->
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td>{$activity.description}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--  END: description -->


                {/foreach}

                </tbody>
                <!-- END: row -->
            </table>

        </div>
    </div>
</div>

{sugar_include type="smarty" file="modules/Activities/tpls/PopupFooter.tpl"}