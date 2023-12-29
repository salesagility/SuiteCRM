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
class stic_AttendancesController extends SugarController
{

    /**
     * Main function for generating attendances that can be invoked using a url like
     * <SERVER_URL>/index.php?module=stic_Attendances&action=createAttendances&date=2020-03-01
     *
     * @return void
     */
    public function action_createAttendances()
    {
        require_once 'modules/stic_Attendances/Utils.php';
        if (empty($_REQUEST['date'])) {stic_AttendancesUtils::createAttendances();} else {
            $GLOBALS['log']->debug(__METHOD__ . '. Creando asistencias solo para el día  ' . $_REQUEST['date']);
            stic_AttendancesUtils::createAttendances($_REQUEST['date'], null, null);
            SugarApplication::redirect('index.php?module=stic_Attendances&action=index');

        }

    }

    /**
     * Recalculates totals relative to total attendance hours and percentage for a given registration. Can be invoked using unaurl like the following
     * <SERVER_URL>index.php?module=stic_Attendances&action=recalculateAttendancesTotalsForRegistration&registration_id=9d5905e8-de23-13fa-4eb7-5c6beb3e4705
     *
     * @return void
     */
    public function action_recalculateAttendancesTotalsForRegistration()
    {
        require_once 'modules/stic_Attendances/Utils.php';
        $GLOBALS['log']->debug(__METHOD__ . '. Calculando totales  ' . $_REQUEST['registration_id']);
        $registration_id = $_REQUEST['registration_id'];
        stic_AttendancesUtils::setRegistrationTotalHoursAndPercentage($registration_id);
        SugarApplication::redirect("index.php?module=stic_Registrations&action=DetailView&record=$registration_id");

    }

    /**
     * Function to create the attendances of a specific range between two dates. Can be used by invoking a url like
     * <SERVER_URL>index.php?module=stic_Attendances&action=createAttendancesRange&start=2020-03-01&end=2020-03-25'
     *
     * @return void
     */
    public function action_createAttendancesRange()
    {
        require_once 'modules/stic_Attendances/Utils.php';
        global $timedate;
        $GLOBALS['log']->debug(__METHOD__ . '. line ' . __LINE__ . ' hi');
        if (empty($_REQUEST['start']) || empty($_REQUEST['end'])) {
            $GLOBALS['log']->debug(__METHOD__ . '. line ' . __LINE__ . 'FECHAS ERRONEAS: START ' . $_REQUEST['start'] . ' --- END ' . $_REQUEST['end']);
            return;
        }
        $registration_id = $_REQUEST['registration_id'];
        $session_id = $_REQUEST['session_id'];
        $start = new DateTime($_REQUEST['start']);
        $end = new DateTime($_REQUEST['end']);
        $GLOBALS['log']->debug(__METHOD__ . '. line ' . __LINE__ . ' START ' . $_REQUEST['start'] . ' --- END ' . $_REQUEST['end'] . ' DAYS: ' . $numDays);

        $numDays = $start->diff($end)->days;
        $dayToCreate = $start->format('Y-m-d');
        while ($a <= $numDays) {
            $GLOBALS['log']->debug(__METHOD__ . '. line ' . __LINE__ . ' Creando asistencias para el día ' . $dayToCreate);
            stic_AttendancesUtils::createAttendances($dayToCreate, $registration_id, $session_id);
            $dayToCreate = $start->add(new DateInterval('P1D'))->format('Y-m-d');
            $a++;

        }
        SugarApplication::redirect('index.php?module=stic_Attendances&action=index');

    }

}
