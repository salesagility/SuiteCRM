<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

require_once 'SticInclude/Views.php';

class stic_EventsViewsessionassistant extends SugarView
{
    public function preDisplay() {

        parent::preDisplay();

        SticViews::preDisplay($this);

    }

    public function display()
    {

        global $sugar_config, $current_language, $app_list_strings, $current_user;

        parent::display();

        SticViews::display($this);

        $repeat_intervals = array();
        for ($i = 1; $i <= 30; $i++) {
            $repeat_intervals[$i] = $i;
        }

        $repeat_hours = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24");

        // Set minute interval as defined in $sugar_config
        $m = 0;
        $minutesInterval = $sugar_config['stic_datetime_combo_minute_interval'] ?: 15;
        $repeat_minutes = array('00');
        do {
            $m = $m + $minutesInterval;
            $repeat_minutes[] = str_pad($m, 2, '0', STR_PAD_LEFT);
        } while ($m < (60 - $minutesInterval));

        $fdow = $current_user->get_first_day_of_week();
        $dow = array();
        for ($i = $fdow; $i < $fdow + 7; $i++) {
            $day_index = $i % 7;
            $dow[] = array("index" => $day_index, "label" => $app_list_strings['dom_cal_day_short'][$day_index + 1]);
        }

        $sessionBean = BeanFactory::getBean('stic_Sessions');
        // $activityType = $sessionBean->field_name_map['activity_type'];

        $this->ss->assign('ACTIVITY_TYPE', $app_list_strings[$sessionBean->field_name_map['activity_type']['options']]);
        $this->ss->assign('COLOR', $app_list_strings[$sessionBean->field_name_map['color']['options']]);
        $this->ss->assign('REQUEST', $_REQUEST);
        $this->ss->assign('APPLIST', $app_list_strings);
        $this->ss->assign('repeat_intervals', $repeat_intervals);
        $this->ss->assign('repeat_hours', $repeat_hours);
        $this->ss->assign('repeat_minutes', $repeat_minutes);
        $this->ss->assign('minutes_interval', $sugar_config['stic_datetime_combo_minute_interval'] ?: 15);
        $this->ss->assign('dow', $dow);
        $this->ss->assign('MOD_SESSION', return_module_language($current_language, 'stic_Sessions'));
        $this->ss->display('modules/stic_Events/tpls/SessionWizard.tpl'); //call tpl file
    }
}
