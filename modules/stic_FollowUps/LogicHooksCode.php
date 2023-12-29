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
// Prevents directly accessing this file from a web browser
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class stic_FollowUpsLogicHooks {

    public function before_save(&$bean, $event, $arguments) {

        if (empty($bean->name)) {
            global $app_list_strings;
            include_once 'SticInclude/Utils.php';
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Entry into LH');

            // Concatenate bean name using either the Family or the Contact name.
            $name = '';
            if (!empty($bean->stic_families_stic_followupsstic_families_ida)) {
                    $relatedBean = SticUtils::getRelatedBeanObject($bean, 'stic_families_stic_followups');
                    $name = $relatedBean->name;
            } elseif (!empty($bean->stic_followups_contactscontacts_ida)) {
                    $relatedBean = SticUtils::getRelatedBeanObject($bean, 'stic_followups_contacts');
                    $name = $relatedBean->first_name . ' ' . $relatedBean->last_name;
            }
            
            $start_date = date($GLOBALS["sugar_config"]["datef"], strtotime($bean->start_date));
            $bean->name = $name . ' - ' . $app_list_strings['stic_followups_types_list'][$bean->type] . ' - ' . $start_date;

        }
    }

}
