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
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class stic_Job_ApplicationsLogicHooks {

    public function before_save(&$bean, $event, $arguments)
    {
        // Create name if empty
        if (empty($bean->name)) {
            if ($bean->load_relationship('stic_job_applications_contacts')) {
                $related_beans = $bean->stic_job_applications_contacts->getBeans();
                $related_bean = array_pop($related_beans);
                $contact_name = $related_bean->first_name .' '.$related_bean->last_name;
            }
            if ($bean->load_relationship('stic_job_applications_stic_job_offers')) {
                $related_beans = $bean->stic_job_applications_stic_job_offers->getBeans();
                $related_bean = array_pop($related_beans);
                $offer_name = $related_bean->name;
            }
            $bean->name = $contact_name .' - '.$offer_name;
        }
    }
}