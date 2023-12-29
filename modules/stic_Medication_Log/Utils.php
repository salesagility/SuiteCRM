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
class stic_Medication_LogUtils
{

    /**
     * createLogs Creates medication logs according to the parameters provided
     *
     * @param String $date String in Y-m-d format '2019-05-05' Optional, default null (apply current_date)
     * @param String $prescriptionId Optional, default null
     * @return void
     */
    public static function createLogs($date = null)
    {
        global $app_list_strings;

        if ($date > date('Y-m-d')) {
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  $date is future... no medication logs will be created.');
            return;
        }

        
        if ($date == null) {
            $date = date('Y-m-d');
        }
        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Creating medication logs for date ' . $date);

        $db = DBManagerFactory::getInstance();

        $sql =
            "select
                concat(con.first_name, ' ', con.last_name, ' - ', med.name, ' - ', date_format(curdate(), '%d/%m/%Y'), ' - ') as name,
                con.id as contactId,
                pre.id as prescriptionId,
                med.name as medicamento,
                pre.schedule,
                pre.dosage,
                pre.assigned_user_id,
                existingLog.schedule as existingSchedule
            from
                stic_prescription pre
            join stic_prescription_stic_medication_c premed on
                premed.stic_prescription_stic_medicationstic_prescription_idb = pre.id
            join stic_medication med on
                med.id = premed.stic_prescription_stic_medicationstic_medication_ida
            join stic_prescription_contacts_c precon on
                precon.stic_prescription_contactsstic_prescription_idb = pre.id
            join contacts con on
                con.id = precon.stic_prescription_contactscontacts_ida
            left join 
                (
                select mlpre.stic_medication_log_stic_prescriptionstic_prescription_ida as prescriptionId, concat('^', GROUP_CONCAT(ml.schedule separator '^,^'), '^') as schedule
                from stic_medication_log_stic_prescription_c mlpre
                join stic_medication_log ml on ml.id = mlpre.stic_medication_log_stic_prescriptionstic_medication_log_idb and ml.deleted = 0 and ml.intake_date = curdate()
                group by prescriptionId
                ) existingLog on existingLog.prescriptionId = pre.id
            where
                pre.deleted = 0
                and premed.deleted = 0
                and precon.deleted = 0
                and med.deleted = 0
                and con.deleted = 0
                and pre.start_date <= CURRENT_DATE()
                and (pre.end_date is null
                    or pre.end_date > CURRENT_DATE())
                and pre.frequency = 'daily'
                and (pre.skip_intake not like concat('%', mod(WEEKDAY(CURRENT_DATE())+ 1, 7), '%') or pre.skip_intake is null)
                and (pre.dont_create_logs is null or pre.dont_create_logs <> 1)
            ";

        $result = $db->query($sql, true);

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  num_rows = ' . print_r($result->num_rows, true));

        if (!$result) {
            $GLOBALS['log']->error(__METHOD__ . ' Error SELECT query medication log: ' . $sql);
            return false;
        }

        while ($row = $db->fetchByAssoc($result)) {

            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Creating medication log: ' . $row['name']);

            // Process schedule
            $scheduleList = explode('^,^', trim($row['schedule'], '^'));
            $existingSchedule = explode('^,^', trim($row['existingSchedule'], '^'));
            $newScheduleList = array_diff($scheduleList, $existingSchedule);



            foreach($newScheduleList as $schedule) {
                // Set basic data
                $medicationLog = BeanFactory::newBean('stic_Medication_Log');
                $medicationLog->assigned_user_id = $row['assigned_user_id'];
                $medicationLog->name = $row['name'] . $app_list_strings['stic_medication_schedule_list'][$schedule];
                $medicationLog->intake_date = $date;
                $medicationLog->medication = $row['medicamento'];
                $medicationLog->dosage = $row['dosage'];
                $medicationLog->administered = 'pending';
                $medicationLog->schedule = $schedule;

                $medicationLog->stic_medication_log_stic_prescriptionstic_prescription_ida = $row['prescriptionId'];
                $medicationLog->stic_medication_log_contactscontacts_ida = $row['contactId'];

                $medicationLog->save();
            }

        }
        return true;
    }

}
