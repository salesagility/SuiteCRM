<?php
require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldCronSchedule extends SugarFieldBase {

    private function getDays(){
        $days = array();
        $date = new DateTime("1986-05-01");
        $period = new DateInterval('P1D');
        for($x = 1; $x <= 31; $x++){
            $days[$x] = $date->format('jS');;
            $date->add($period);
        }
        return $days;
    }
    private function getWeekDays(){
        $days = array();
        $date = new DateTime("1986-05-04");
        $period = new DateInterval('P1D');
        for($x = 0; $x < 7; $x++){
            $days[$x] = $date->format('D');
            $date->add($period);
        }
        return $days;
    }

    function setup($parentFieldArray, $vardef, $displayParams, $tabindex, $twopass = true) {
        global $app_list_strings,$app_strings;
        parent::setup($parentFieldArray, $vardef, $displayParams, $tabindex, $twopass);
        $this->ss->assign('APP',$app_strings);
        $this->ss->assign('types',get_select_options_with_id($app_list_strings['aor_scheduled_report_schedule_types'],''));
        $weekdays = $this->getWeekDays();
        $this->ss->assign('weekday_vals',json_encode($weekdays));
        $this->ss->assign('weekdays',get_select_options($weekdays,''));
        $days = $this->getDays();
        $this->ss->assign('days',get_select_options($days,''));
        $minutes = array_map([$this, 'padNumbers'],range(0,59));
        $hours = array_map([$this, 'padNumbers'],range(0,23));
        $this->ss->assign('minutes',get_select_options($minutes,''));
        $this->ss->assign('hours',get_select_options($hours,''));
    }

    private function padNumbers($x){
        return str_pad($x,2,'0',STR_PAD_LEFT);
    }
}
