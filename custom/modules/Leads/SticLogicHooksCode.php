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

class LeadsLogicHooks {

    public function after_retrieve(&$bean, $event, $arguments) {
        // In order to avoid identification number loss due to GUI JS validation, set the right identification type
        // when this field is empty and the identification number is set.
        if (!empty($bean->stic_identification_number_c) && (empty($bean->stic_identification_type_c) || trim($bean->stic_identification_type_c) == '')) {
            include_once 'SticInclude/Utils.php';
            if (!SticUtils::isValidNIForNIE($bean->stic_identification_number_c)) {
                $bean->stic_identification_type_c = 'other';
            } else {
                $firstCharacter = strtoupper($bean->stic_identification_number_c[0]);
                if (is_numeric($firstCharacter) || in_array($firstCharacter, array('K', 'L', 'M'))) {
                    $bean->stic_identification_type_c = 'nif';
                } else {
                    $bean->stic_identification_type_c = 'nie';
                }
            };
            $bean->save();
        }
    }
}
