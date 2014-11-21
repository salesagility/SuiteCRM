<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 * @Package Project templates
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */

require_once('include/MVC/View/views/view.detail.php');

class AM_ProjectTemplatesViewDetail extends ViewDetail {


    function AM_ProjectTemplatesViewDetail(){
        parent::ViewDetail();
    }

    function display(){
        parent::display();

        echo '<style>
                    .p_form { font-size: 62.5%; }
                    .p_form label, .p_form input { display:block; }
                    .p_form input.text { margin-bottom:12px; width:95%; padding: .4em; }
                    .p_form fieldset { padding:0; border:0; margin-top:25px; }
                    .p_form h1 { font-size: 1.2em; margin: .6em 0; }
                    .ui-dialog .ui-state-error { padding: .3em; }
                    .validateTips { border: 1px solid transparent; padding: 0.3em; }
                </style>';

        echo '<div style="display: none;" id="dialog-confirm" title="Create a new project from this template?">
                 <p class="validateTips">Project Name is required.</p>
                <p class="p_form">
                     <form id="project_form" action="index.php?module=AM_ProjectTemplates&action=create_project" method="post">
                        <fieldset style="border: none;">
                             <label for="name">Project Name</label>
                             <input style="margin-bottom:12px; width:95%; padding: .4em;" type="text" name="p_name" id="p_name" class="text ui-widget-content ui-corner-all" />

                             <label for="start_date">Start Date</label>
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
                            </script>
                             <input type="hidden" name="template_id" value="'.$this->bean->id .'" />
                        </fieldset>
                     </form>
                </p>
              </div>';
    }


}