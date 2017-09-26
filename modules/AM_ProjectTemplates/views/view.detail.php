<?php
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/views/view.detail.php');

class AM_ProjectTemplatesViewDetail extends ViewDetail
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function AM_ProjectTemplatesViewDetail()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function display()
    {
        global $mod_strings;
        parent::display();

        echo '<link rel="stylesheet" type="text/css" href="modules/Project/qtip/jquery.qtip.min.css" />';
        echo '<script type="text/javascript" src="modules/Project/qtip/jquery.qtip.min.js"></script>';

        echo '<style>
                    .p_form { font-size: 62.5%; }
                    .p_form label, .p_form input { display:block; }
                    .p_form input.text { margin-bottom:12px; width:95%; padding: .4em; }
                    .p_form fieldset { padding:0; border:0; margin-top:25px; }
                    .p_form h1 { font-size: 1.2em; margin: .6em 0; }
                    .ui-dialog .ui-state-error { padding: .3em; }
                    .validateTips { border: 1px solid transparent; padding: 0.3em; }
                </style>';

        echo '<div style="display: none;" id="dialog-confirm" title="' . $mod_strings['LBL_CREATE_PROJECT_TITLE'] . '">
                 <p class="validateTips"></p>
                <p class="p_form">
                     <form id="project_form" name="project_form" action="index.php?module=AM_ProjectTemplates&action=create_project" method="post">
                        <fieldset style="border: none;">
                             <label for="name">' . $mod_strings['LBL_PROJECT_NAME'] . ':<span class="required">*</span></label>
                             <input style="margin-bottom:12px; width:95%; padding: .4em;" type="text" name="p_name" id="p_name" class="text ui-widget-content ui-corner-all" />

                             <label for="start_date">' . $mod_strings['LBL_START_DATE'] . ':<span class="required">*</span></label>
                             <input style="margin-bottom:12px; width:95%; padding: .4em;" type="text" name="start_date" id="start_date" class="text ui-widget-content ui-corner-all" />

                             <script type="text/javascript">
                                var now = new Date();
                                Calendar.setup ({
                                    inputField : "start_date",
                                    ifFormat : cal_date_format,
                                    daFormat : "%m/%d/%Y %I:%M%P",
                                    button : "start_date",
                                    singleClick : true,
                                    step : 1,
                                    weekNumbers: false,
                                    startWeekday: 0
                                });
                                addForm("project_form");
                                addToValidate("project_form", "p_name", "name", true,"' . $mod_strings['LBL_PROJECT_NAME'] . '" );
                                addToValidate("project_form", "start_date", "date", true,"' . $mod_strings['LBL_START_DATE'] . '" );
                            </script>
							 <label for="copy_all_tasks">' . $mod_strings['LBL_COPY_ALL_TASKS'] . ':</label>&nbsp;
                             <input type="checkbox" style="position: relative; vertical-align:middle" id="copy_all_tasks" name="copy_all_tasks" value="1" title="" />&nbsp;
							 <span style="position: relative;"  id="copy_all_tasks_help"><!--not_in_theme!--><img border="0" src="themes/SuiteR/images/info_inline.gif" alt="Help class="info" vertical-align="middle"></span>
							<script type="text/javascript">

									var help = $("#copy_all_tasks_help");
									//set tooltip title
									var title = "' . $mod_strings['LBL_TOOLTIP_TITLE'] . '" ;
									var text = "' . $mod_strings['LBL_TOOLTIP_TEXT'] . '" ;
									//console.log(title);

									help.qtip({
										content: {
											text: text,
											title: {
												//button: true,
												text: title
											}
										},
										position: {
											my: "bottom center",
											at: "top center",
											target: "mouse",
											adjust: {
												mouse: false,
												scroll: false,
												y: -10
											}
										},
										show: {
											event: "mouseover"
										},
										hide: {
											event: "mouseout"
										},
										style: {
											classes : "qtip-green qtip-shadow qtip_box", //qtip-rounded"
											tip: {
												offset: 10

											}
										}
									});

									//help.qtip("disable");

							</script>
                             <label for="tasks" id="tasks_label">' . $mod_strings['LBL_COPY_SEL_TASKS'] . ':</label>
                             <select id="tasks" name="tasks[]" multiple style="margin-bottom:12px; width:95%; padding: .4em;" >';

        $this->bean->load_relationship('am_tasktemplates_am_projecttemplates');
        $task_list = $this->bean->get_linked_beans('am_tasktemplates_am_projecttemplates', 'AM_TaskTemplates');

        //From the query above, populates the select box
        foreach ($task_list as $task) {
            echo '<option value="' . $task->id . '">' . $task->name . '</option>';
        }

        echo '</select><br />

							 <input type="hidden" name="template_id" value="' . $this->bean->id . '" />

                        </fieldset>
                     </form>
                </p>
              </div>';
    }


}