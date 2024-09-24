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

class stic_Work_CalendarViewWorkCalendarAssistantSummary extends SugarView
{
    public function preDisplay() 
    {
        parent::preDisplay();
        SticViews::preDisplay($this);
    }

    public function display()
    {
        parent::display();
        SticViews::display($this);
        
        global $sugar_config;
        $this->ss->assign('DATA', $_SESSION['summary']['global']);
        $this->ss->assign('RECORDS_NOT_CREATED_BY_EMPLOYEE', json_encode($_SESSION['summary']['users']));
        $this->ss->assign('RECORDS_PER_PAGE', $sugar_config['list_max_entries_per_page']);
        $this->ss->display('modules/stic_Work_Calendar/tpls/workCalendarAssistantSummary.tpl'); //call tpl file
        
        // Session variables for periodic creation without selecting users
        $_SESSION['summaryEmployeeIds'] = '';
        foreach ($_SESSION['summary']['users'] as $key => $user){
            $_SESSION['summaryEmployeeNames'][] = $user['name'];
            $_SESSION['summaryEmployeeIds'] = $_SESSION['summaryEmployeeIds'] == '' ?  $key : $_SESSION['summaryEmployeeIds'] . ',' . $key;
        }
        unset($_SESSION['summary']);
    }
}
