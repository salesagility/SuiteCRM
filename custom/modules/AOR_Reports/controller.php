<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
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
 *
 * @author SalesAgility <info@salesagility.com>
 */


require_once("modules/AOR_Reports/controller.php");

class customAOR_ReportsController extends AOR_ReportsController {


    protected function action_changeReportPage(){
        $tableId = !empty($_REQUEST['table_id']) ? $_REQUEST['table_id'] : '';
        $group = !empty($_REQUEST['group']) ? $_REQUEST['group'] : '';
        $offset = !empty($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
        if(!empty($this->bean->id)){
            $this->bean->user_parameters = requestToUserParameters();
            echo $this->bean->build_report_html($offset, true,$group,$tableId);
            //echo $this->bean->build_group_report($offset, true);
        }

        die();
    }
}