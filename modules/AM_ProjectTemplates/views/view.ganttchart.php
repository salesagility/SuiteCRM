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

class AM_ProjectTemplatesViewGanttChart extends ViewDetail
{

    /**
     * AM_ProjectTemplatesViewGanttChart constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function display()
    {
        global $mod_strings, $app_strings, $app_list_strings, $timedate, $current_user;

        $project_template = new AM_ProjectTemplates();

        if (!isset($_REQUEST['record']) || trim($_REQUEST['record']) === '') {
            $_REQUEST['record'] = $_REQUEST['project_id'];
        }

        $project_template->retrieve($_REQUEST['record']);

        parent::display();

        $ss = new Sugar_Smarty();
        $ss->assign('app', $app_strings);
        $ss->assign('mod', $mod_strings);
        $ss->assign('theme', SugarThemeRegistry::current());
        $ss->assign('langHeader', get_language_header());
        $ss->assign('currentUserId', $current_user->id);
        $ss->assign('currentUserName', $current_user->name);
        $ss->assign('projectID', $project_template->id);
        $ss->assign('projectBusinessHours', $project_template->override_business_hours);
        $ss->assign(
            'relationshipDropdown',
            get_select_options_with_id(
                $app_list_strings['relationship_type_list'],
                ''
            )
        );
        $ss->assign('projectTasks', $_REQUEST['record']);
        $ieCompatMode = false;
        if (isset($sugar_config['meta_tags']['meta_tags']['ieCompatMode'])) {
            $ieCompatMode = $sugar_config['meta_tags']['ieCompatMode'];
        }
        $ss->assign('ieCompatMode', $ieCompatMode);
        $charset = isset($app_strings['LBL_CHARSET']) ? $app_strings['LBL_CHARSET'] : $sugar_config['default_charset'];
        $ss->assign('charset', $charset);
        $ss->assign(
            'assign_user_select',
            SugarThemeRegistry::current()->getImage(
                'id-ff-select',
                '',
                null,
                null,
                '.png',
                $mod_strings['LBL_SELECT']
            )
        );
        $ss->assign(
            'assign_user_clear',
            SugarThemeRegistry::current()->getImage(
                'id-ff-clear',
                '',
                null,
                null,
                '.gif',
                $mod_strings['LBL_ID_FF_CLEAR']
            )
        );

        $access = false;

        if (ACLController::checkAccess('AM_ProjectTemplates', 'edit', true)) {
            $access = true;
        }

        $ss->assign('showButton', $access);

        $ss->display('modules/AM_ProjectTemplates/tpls/PopupBody.tpl');

    }

    /**
     * This function rturns the time span between two dates in years months and days
     *
     * @param string $start_date a formatted date string
     * @param string $end_date a formatted date string
     *
     * @return string formmated date string
     */
    function time_range($start_date, $end_date)
    {
        global $mod_strings;

        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime($end_date);
        $datetime2->add(new DateInterval('P1D')); //Add 1 day to include the end date as a day
        $interval = $datetime1->diff($datetime2);

        return $interval->format('%m ' . $mod_strings['LBL_MONTHS'] . ', %d ' . $mod_strings['LBL_DAYS']);
    }
}
