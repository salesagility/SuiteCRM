<?php
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
 * @Package Gantt chart
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/MVC/View/views/view.detail.php');

class ProjectViewGanttChart extends ViewDetail
{
    public function display()
    {
        global $mod_strings, $app_strings, $app_list_strings, $timedate, $current_user;

        $project = new Project();

        if (!isset($_REQUEST['project_id']) || trim($_REQUEST['project_id']) === '') {
            $_REQUEST['project_id'] = $_REQUEST['record'];
        }
        $project->retrieve($_REQUEST['project_id']);

        parent::display();

        $ss = new Sugar_Smarty();
        $ss->assign('app', $app_strings);
        $ss->assign('mod', $mod_strings);
        $ss->assign('theme', SugarThemeRegistry::current());
        $ss->assign('langHeader', get_language_header());
        $ss->assign('currentUserId', $current_user->id);
        $ss->assign('currentUserName', $current_user->name);
        $ss->assign('projectID', $project->id);
        $ss->assign('projectBusinessHours', $project->override_business_hours);
        $ss->assign('relationshipDropdown',
            get_select_options_with_id($app_list_strings['relationship_type_list'], ''));
        $ss->assign('durationDropDown', get_select_options_with_id($app_list_strings['duration_unit_dom'], ''));
        $ss->assign('projectTasks', $_REQUEST['record']);
        $ieCompatMode = false;
        if (isset($sugar_config['meta_tags']['meta_tags']['ieCompatMode'])) {
            $ieCompatMode = $sugar_config['meta_tags']['ieCompatMode'];
        }
        $ss->assign('ieCompatMode', $ieCompatMode);
        $charset = isset($app_strings['LBL_CHARSET']) ? $app_strings['LBL_CHARSET'] : $sugar_config['default_charset'];
        $ss->assign('charset', $charset);
        $ss->assign('CALENDAR_DATEFORMAT', $timedate->get_cal_date_format());

        $access = false;

        if (ACLController::checkAccess('Project', 'edit', true)) {
            $access = true;
        }

        $ss->assign('showButton', $access);

        $ss->display('modules/Project/tpls/PopupBody.tpl');
    }
}
