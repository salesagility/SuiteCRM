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
class stic_GrantsUtils {
    /**
     * Indicates if the relationship is active.
     *   1. If start_date is future returns false
     *   2. If end_date is null or future returns true
     *
     * @param Object $CRBean stic_Grants bean
     * @return boolean
     */
    public static function isActive($GBean) {

        // Calculate if relationship is active using similar pattern that in setRelationshipType function
        $today = date("Y-m-d");
        $start = $GBean->start_date;
        $end = $GBean->end_date;

        if (
            (empty($start) || $start <= $today)
            && (empty($end) || $end > $today)
        ) {
            return true;
        } else {
            return false;
        }

    }

}
