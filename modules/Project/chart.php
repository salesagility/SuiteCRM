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

class chart {

    private $start_date;
    private $end_date;
    private $tasks;

    public function __construct($start_date, $end_date, $tasks)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->tasks = $tasks;
        //draw the grid
        $this->draw($this->start_date, $this->end_date, $this->tasks);
    }

    public function draw($start_date, $end_date, $resources){
        global $current_user, $db, $mod_strings;

        $time_span = $this->year_month($start_date, $end_date);
        $day_count = $this->count_days($start_date, $end_date) + 1;
        $weeks = $this->get_weeks($start_date, $end_date);

        //Get users that are associated to any project. This is for the Select box values
        $resource_query = "SELECT project_users_1users_idb AS id, first_name, last_name, 'project_users_1_c' AS
                                    type
                                    FROM project_users_1_c
                                    JOIN users ON users.id = project_users_1users_idb
                                    WHERE project_users_1_c.deleted =0
                                    UNION
                                    SELECT project_contacts_1contacts_idb AS id, first_name, last_name, 'project_contacts_1_c' AS
                                    type
                                    FROM project_contacts_1_c
                                    JOIN contacts ON contacts.id = project_contacts_1contacts_idb
                                    WHERE project_contacts_1_c.deleted =0";
        $resources_list = $db->query($resource_query);

        $resource_list = array();
        while($row = $db->fetchByAssoc($resources_list))
        {
            //create array of user objects
            $resource_list[] = (object)$row;
        }

        //Generate main table and the first row containing the months
        echo '<table class="main_table">
                <tr class="select_row">
                    <td colspan="100%">
                        <table id="header_table_chart">
                        <tr>
                            <td class="heading_chart">'.$mod_strings["LBL_RESOURCES"].'</td>
                        </tr>
                        <tr>
                            <td class="field_chart">
                                <input id="date_start" type="hidden" name="date_start" value="'.$start_date.'" />
                                <input id="date_end" class="date_chart" type="hidden" name="date_end" value="'.$end_date.'" />
                                <select id="resources" name="resources">
                                <option value="all">All Resources</option>';
                                $re_id ='';
                                $re=0;
                                //get resources passed in to the draw function
                                foreach($resources as $resource){
                                    $re_id = $resource->id;
                                    $re++;
                                }

                                //From the query above, populates the select box
                                foreach( $resource_list as $resource)
                                {
                                    if($re == 1){//Make sure its a single selected resource
                                        if($re_id == $resource->id){//Check if the select box option matches the resource passed in.
                                            $selected = "selected='selected'"; //if so set it to selected
                                        }
                                        else {
                                            $selected = "";
                                        }
                                    }
                                    echo '<option '.$selected.' data-type="'.$resource->type.'" value="'.$resource->id.'">'.$resource->last_name.'</option>';
                                }

                           echo '</select><br /><br />';

                            if(empty($resource_list)){
                                echo '<span style="color: red;">'.$mod_strings['LBL_RESOURCE_CHART_WARNING'].'</span><br /><br />';
                            }

                          echo '</td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="100%">
                        <table style="border: none;" class="main_table" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td class="top_row" style="text-align: left; width: 100px; white-space: nowrap;"><a id="prev_month" href="index.php?module=Project&action=ResourceList"><img width="6" height="10" border="0" align="absmiddle" alt="Previous Month" src="themes/default/images/calendar_previous.gif"> '.$mod_strings['LBL_RESOURCE_CHART_PREVIOUS_MONTH'].'</a></td>
                                <td class="top_row" style="text-align: center; width: 98%;"><span class="heading_chart">'.$mod_strings['LBL_RESOURCE_CHART'].'</span></td>
                                <td class="top_row" style="padding-right:5px; text-align: right; width: 100px; white-space: nowrap;"><a id="next_month" href="index.php?module=Project&action=ResourceList">'.$mod_strings['LBL_RESOURCE_CHART_NEXT_MONTH'].' <img width="6" height="10" border="0" align="absmiddle" alt="Next Month" src="themes/default/images/calendar_next.gif"></a></td>
                            </tr>
                        </table>
                    </td>
             </tr>';
        echo '<tr>';
        echo '<td class="main_table week">'.$mod_strings['LBL_RESOURCE_CHART_WEEK'].'</td>';
        foreach($weeks as $week){
            echo '<td class="main_table weeks" colspan="7">'.$week.'</td>';
        }

        echo '</tr><tr><td rowspan="3" class="main_table day">'.$mod_strings['LBL_RESOURCE_CHART_DAY'].'</td>';
        foreach($time_span as $year => $months) {
            foreach($months as $month => $days){//count the number of days in each month
                $daycount=0;
                foreach($days as $day){
                    $daycount++;
                }
                $width = $daycount * 26; //used to set width on years row. width needed for css text clipping
                echo '<td colspan="'.$daycount.'" class="main_table years"><div style="width: '.$width.'px;" class="year_div">'.$month.', '.$year.'</div></td>';
            }
        }
        echo '</tr><tr class="days_row">';

        $month_count = 0;//start month count
        foreach($time_span as $year => $months) {

            foreach($months as $days){

                foreach($days as $day => $d){
                    echo '<td class="inner_td"><div class="cell_width">'.$day.'</div></td>';//day number shown
                }
            }
        }
        echo '</tr><tr class="days_row">';

        foreach($time_span as $year => $months) {

            foreach($months as $days){

                foreach($days as $day => $d){
                    echo '<td class="inner_td"><div class="cell_width">'.$d[0].'</div></td>';//First letter of the days name shown
                }
            }
        }

        echo '</tr>';

        foreach($resources as $resource){

            $count = $resource->task_count;

            if($resource->type == 'project_users_1_c'){
                echo '<tr id="'.$resource->id.'" class="task_row"><td no class="main_table no_wrap"><a title="'.$mod_strings["LBL_RESOURCE_TYPE_TITLE_USER"].'" href="index.php?module=Users&action=DetailView&record='.$resource->id.'">'.$resource->last_name.'</a></td>';
            }
            else if($resource->type == 'project_contacts_1_c') {
                echo '<tr id="'.$resource->id.'" class="task_row"><td no class="main_table no_wrap"><a title="'.$mod_strings["LBL_RESOURCE_TYPE_TITLE_CONTACT"].'" href="index.php?module=Contacts&action=DetailView&record='.$resource->id.'">'.$resource->last_name.'</a></td>';
            }

            $i=0;
            for ($x=0; $x< $day_count; $x++)
            {
                //Get date for each day
                $dateq = $this->get_date($start_date, $i);

                $class = '';

                if($this->check_weekend($dateq) == 'today'){
                    $class = 'today';
                }
                elseif($this->check_weekend($dateq) == 'weekend'){
                    $class = 'weekend';
                }
                elseif($this->check_weekend($dateq) == 'weekend-today'){
                    $class = 'weekend-today';
                }

                $square = '';
                for($c=0; $c < $count; $c++){

                    if($x == $resource->tasks[$c]['start_day']){

                        $square =  '<td class="inner_td"><div style="color: #ffffff;" rel="'.$dateq.'|'.$resource->id.'|'.$resource->type.'" class="cell_width day_block '.$class.' h"></div></td>';

                    }
                    else if($x > $resource->tasks[$c]['start_day'] && $x <= $resource->tasks[$c]['end_day']){
                        $square =  '<td class="inner_td"><div rel="'.$dateq.'|'.$resource->id.'|'.$resource->type.'" class="cell_width day_block '.$class.' h"></div></td>';
                    }

                }

                if($square == ''){
                    $square = '<td class="inner_td"><div class="cell_width day_block"><div class="'.$class.'"></div></div></td>';
                }
                echo $square;
            $i++;
            }
        }
        echo '</table>';
    }


//Returns an array containing the years, months and days between two dates
    public function year_month($start_date, $end_date)
    {
        $begin = new DateTime( $start_date );
        $end = new DateTime( $end_date);
        $end->add(new DateInterval('P1D')); //Add 1 day to include the end date as a day
        $interval = new DateInterval('P1D'); // 1 month interval
        $period = new DatePeriod($begin, $interval, $end);
        $aResult = array();

        foreach ( $period as $dt )
        {
            $aResult[$dt->format('Y')][$dt->format('M')][$dt->format('j')] = $dt->format('D');
        }

        return $aResult;
    }

    function get_weeks($start_date, $end_date)
    {
        $begin = new DateTime( $start_date );
        $end = new DateTime( $end_date);
        $end->add(new DateInterval('P1D')); //Add 1 day to include the end date as a day
        $interval = new DateInterval('P1W'); // 1 week interval
        $period = new DatePeriod($begin, $interval, $end);
        $aResult = array();

        foreach ( $period as $dt )
        {
            $aResult[] = $dt->format('W');
        }

        return $aResult;
    }


    //Returns the total number of days between two dates
    function count_days($start_date, $end_date){
        $d1 = new DateTime($start_date);
        $d2 = new DateTime($end_date);
        //If the task's end date is before chart's start date return -1 to make sure task starts on first day of the chart
        if($d2 < $d1){
            return -1;
        }
        else if($d2 == $d1){
            return 1;
        }
       // $d2->add(new DateInterval('P1D')); //Add 1 day to include the end date as a day
        $difference = $d1->diff($d2);
        return $difference->days;
    }

    //get date of passed in day in relation to the charts start date
    function get_date($start, $day){
        $date = DateTime::createFromFormat('Y-m-d', $start);
       // $date->setTimezone(new DateTimeZone("Europe/London"));
        $date->modify('+'.$day.' days');

        return $date->format('Y-m-d');
    }


    //checks if the day is a weekend and if the day is today.
    function check_weekend($day){
        global $current_user;
        //get users timezone setting
        $timezone = TimeDate::userTimezone($current_user);
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone($timezone));
        $date1 = DateTime::createFromFormat('Y-m-d', $day);
        $date = $date1->format('Y-m-d');
        $now = $now->format('Y-m-d');
       // $GLOBALS['log']->fatal("date2 ".$now);

        if ($date1->format('l') == 'Sunday' && $date == $now){
            return 'weekend-today';
        }
        else if ($date1->format('l') == 'Saturday' && $date == $now){
            return 'weekend-today';
        }
        else if ($date1->format('l') == 'Sunday'){
            return 'weekend';
        }
        else if ($date1->format('l') == 'Saturday'){
            return 'weekend';
        }
        else if($date == $now){
            return 'today';
        }
        else {
            return false;
        }

    }



//Returns the time span between two dates in years months and days
    public function time_range($start_date, $end_date){

        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime($end_date);
        $interval = $datetime1->diff($datetime2);
        echo $interval->format('%y years %m months and %d days');
    }

}
