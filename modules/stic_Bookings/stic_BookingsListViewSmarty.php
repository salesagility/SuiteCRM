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
/**
 * If the all_day field is checked, the hours:minutes section of the start_date and end_date fields should be removed. 
 * Need to take into account that dates might change depending on the timezone.
 *
 * As all_day field is not included by default (or should have been removed by the user) in the listview, 
 * it is explicitly included in the 'custom_select' property of the $params array just before calling the 
 * setup() function, that will retrieve the data.
 *
 * This is done by creating this custom class instead of working in parent::display() in the view.list.php
 * (which would be the usual way) because the $params array is completely overrided in the listViewPrepare() 
 * SuiteCRM core method (include/MVC/View/views/view.list.php#L245). This might be a core bug. Anyway,
 * here is the workaround.
 *
 * Before sending the data to the smarty template, date fields are properly formatted using the function formatDateFields()
 */

require_once 'custom/include/SticListViewSmarty.php';

class stic_BookingsListViewSmarty extends SticListViewSmarty
{
    /**
     * Overriding the setup function of the ListViewDisplay to:
     * - include all_day field in the fields to be retrieved from the db.
     * - format the start_date and end_date fields before sending them to the smarty template.
     *
     * @param [type] $seed
     * @param [type] $file
     * @param [type] $where
     * @param array $params
     * @param integer $offset
     * @param integer $limit
     * @param array $filter_fields
     * @param string $id_field
     * @param [type] $id
     * @return void
     */
    public function setup(
        $seed,
        $file,
        $where,
        $params = array(),
        $offset = 0,
        $limit = -1,
        $filter_fields = array(),
        $id_field = 'id',
        $id = null
    ) {
        // Force all_day retrieving from database
        $params['custom_select'] = ' ,stic_bookings.all_day';

        parent::setup($seed,
            $file,
            $where,
            $params,
            $offset,
            $limit,
            $filter_fields,
            $id_field,
            $id);

        $this->formatDateFields();
    }

    protected function formatDateFields()
    {
        global $timedate, $current_user;

        foreach ($this->data['data'] as $key => $row) {
            if ($row['ALL_DAY'] == '1') {
                $this->data['data'][$key]['ALL_DAY'] = '1';
                $allDayRows[] = $row['ID'];
                if ($row['START_DATE']) {
                    $startDate = $timedate->fromUser($row['START_DATE'], $current_user);
                    $startDate = $timedate->asDb($startDate);
                    $startDate = explode(' ', $startDate);
                    if ($startDate[1] > "12:00") {
                        $startDate = new DateTime($startDate[0]);
                        $startDate = $startDate->modify("next day");
                        $startDate = $timedate->asUserDate($startDate, false, $current_user);
                        $this->data['data'][$key]['START_DATE'] = $startDate;
                    } else {
                        $startDate = new DateTime($startDate[0]);
                        $startDate = $timedate->asUserDate($startDate, false, $current_user);
                        $this->data['data'][$key]['START_DATE'] = $startDate;
                    }
                }
                if ($row['END_DATE']) {
                    $endDate = $timedate->fromUser($row['END_DATE'], $current_user);
                    $endDate = $timedate->asDb($endDate);
                    $endDate = explode(' ', $endDate);
                    if ($endDate[1] > "12:00") {
                        $endDate = new DateTime($endDate[0]);
                        $endDate = $timedate->asUserDate($endDate, false, $current_user);
                        $this->data['data'][$key]['END_DATE'] = $endDate;
                    } else {
                        $endDate = new DateTime($endDate[0]);
                        $endDate = $endDate->modify("previous day");
                        $endDate = $timedate->asUserDate($endDate, false, $current_user);
                        $this->data['data'][$key]['END_DATE'] = $endDate;
                    }
                }
            }
        }

    }

}
