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

require_once 'include/MVC/View/views/view.detail.php';
require_once 'SticInclude/Views.php';

class stic_Work_CalendarViewDetail extends ViewDetail
{

    public function __construct()
    {
        parent::__construct();

    }

    public function preDisplay()
    {
        require_once 'modules/stic_Work_Calendar/stic_Work_Calendar.php';
        global $timedate, $current_user;

        // If it is not an all day type record
        if (in_array($this->bean->type, stic_Work_Calendar::ALL_DAY_TYPES)) 
        {
            // Start date
            $startDate = $timedate->fromUser($this->bean->start_date, $current_user);
            $this->bean->start_date = $timedate->asUserDate($startDate, false, $current_user);

            // End date
            $endDate = $timedate->fromUser($this->bean->end_date, $current_user);
            $endDate = $endDate->modify("previous day");
            $this->bean->end_date = $timedate->asUserDate($endDate, false, $current_user);
        }

        parent::preDisplay();

        SticViews::preDisplay($this);

        // Write here you custom code
    }

    public function display()
    {
        parent::display();

        SticViews::display($this);

        echo getVersionedScript("modules/stic_Work_Calendar/Utils.js");

        // Write here you custom code
    }

}
