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

class stic_Job_ApplicationsUtils
{
    /**
     * Generate a record in the Work Experience module
     *
     * @param Object $jobApplicationBean The Job application bean
     * @return void
     */
    public static function createWorkExperience($jobApplicationBean)
    {
        include_once 'SticInclude/Utils.php';

        global $current_user, $timedate;

        // Create the new work experience
        $workBean = new stic_Work_Experience();

        $workBean->name = translate('LBL_WORK_EXPERIENCE_SUBJECT', 'stic_Job_Applications');
        if (!empty($jobApplicationBean->stic_job_applications_contactscontacts_ida)) {
            $workBean->name .= "- {$jobApplicationBean->stic_job_applications_contacts_name}";
        }

        $workBean->assigned_user_id = (empty($jobApplicationBean->assigned_user_id) ? $current_user->id : $jobApplicationBean->assigned_user_id);
        if ($jobApplicationBean->stic_job_applications_stic_job_offersstic_job_offers_ida instanceof Link2) {
            $offerBean = SticUtils::getRelatedBeanObject($jobApplicationBean, 'stic_job_applications_stic_job_offers');
        } else {
            $offerBean = BeanFactory::getBean('stic_Job_Offers', $jobApplicationBean->stic_job_applications_stic_job_offersstic_job_offers_ida);
        }

        $accountOfferId = SticUtils::getRelatedBeanObject($offerBean, 'stic_job_offers_accounts')->id;

        if ($jobApplicationBean->stic_job_applications_contactscontacts_ida instanceof Link2) {
            $contactApplicationId = SticUtils::getRelatedBeanObject($jobApplicationBean, 'stic_job_applications_contacts');
            $contactApplicationId = $contactApplicationId->id;
        } else {
            $contactApplicationId= $jobApplicationBean->stic_job_applications_contactscontacts_ida;
        }



        $applicationId = $jobApplicationBean->id;

        $workBean->stic_work_experience_accountsaccounts_ida = $accountOfferId;
        $workBean->stic_work_experience_contactscontacts_ida = $contactApplicationId;
        $workBean->stic_work_9fefcations_idb = $applicationId;
        $workBean->sector = $offerBean->sector;
        $workBean->subsector = $offerBean->subsector;
        $workBean->position_type = $offerBean->position_type;
        $workBean->workday_type = $offerBean->workday_type;
        $workBean->contract_type = $offerBean->contract_type;
        $workBean->achieved=true;
        $workBean->save();

    }

}
