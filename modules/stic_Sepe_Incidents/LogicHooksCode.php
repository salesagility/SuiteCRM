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

class stic_Sepe_IncidentsLogicHooks {

    public function before_save(&$bean, $event, $arguments) {
        global $app_list_strings;
        // Create name if empty
        if (empty($bean->name)) {
            if ($bean->load_relationship('stic_sepe_incidents_contacts')) {      
                $relatedBeans = $bean->stic_sepe_incidents_contacts->getBeans();
                $relatedBean = array_pop($relatedBeans);
                $contactName = $relatedBean->first_name .' '.$relatedBean->last_name;
            }
            $incidentType = $app_list_strings['stic_sepe_incident_types_list'][$bean->type];
            $bean->name = $contactName .' - '.$incidentType .' - '. $bean->incident_date;
        }
    }
}
