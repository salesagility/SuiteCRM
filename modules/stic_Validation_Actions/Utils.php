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

class stic_Validation_ActionsUtils
{

    /**
     * Execute the Validation Actions associated with $scheduledJob. This function is called from the validationActions scheduled task.
     *
     * @param Object $scheduledJob 
     * @return Boolean True if ok
     */
    public static function runSchedulersValidationTasks($scheduledJob)
    {
        require_once 'modules/stic_Validation_Actions/DataAnalyzer/DataAnalyzer.php';
        $scheduledJob->load_relationship('schedulers');
        $schedulers = $scheduledJob->schedulers->getBeans();
        foreach ($schedulers as $scheduler) {
            $scheduler->load_relationship('stic_validation_actions_schedulers');
            $checkActions = $scheduler->stic_validation_actions_schedulers->getBeans();
            $da = new stic_DataAnalyzer();
            $da->processActions($scheduler, $checkActions);
        }        
        
        // Must return true
        return true;

    }
}
