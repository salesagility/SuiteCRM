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
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */

/**
 * controller.php
 * Overrides save function and allows a date range of holidays to be saved as Individual date records.
 */

class AM_ProjectHolidaysController extends SugarController {

    //Override save function
    function action_save() {
        global $current_user;
        //Get users date format
        $dateformat = $current_user->getPreference('datef');
        //create datetime objects
        $startdate = DateTime::createFromFormat($dateformat, $_REQUEST['holiday_start_date']);
        $enddate = DateTime::createFromFormat($dateformat, $_REQUEST['holiday_end_date']);
        $enddate->modify('+1 day');//1 day has to be added to include the last day as a holiday
        //Create an array of days between the start and end dates
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startdate, $interval, $enddate);
        //loop through days and save new holiday record for each day.
        foreach ( $period as $dt ){
            //format to default mysql date format
            $holiday_day = $dt->format('Y-m-d');

            $this->bean = new AM_ProjectHolidays();
            $this->bean->name = $_REQUEST['name'];
            $this->bean->description = $_REQUEST['description'];
            $this->bean->resourse_users = $_REQUEST['resourse_users'];
            $this->bean->holiday_date = $holiday_day;
            $this->bean->save();
        }

    }
}