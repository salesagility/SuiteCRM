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

class SurveyQuestionResponsesUtils {
    /**
     * It returns the DateTime format of the user needed for the MySQL function DATE_FORMAT
     *
     * @return date
     */
    static function getDateTimeFormat() {
        global $current_user, $timedate;

        $time_format = $timedate->getCalFormat($timedate->get_time_format($current_user));
        $date_format = $timedate->getCalFormat($timedate->get_date_format($current_user));
        $time_separator = ":";
        $match = array();
        if (preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match)) {
            $time_separator = $match[1];
        }
        if (!isset($match[2]) || $match[2] == '') {
            return $date_format . ' ' . "%H" . $time_separator . "%i";
        } else {
            $pm = $match[2] == "pm" ? "%P" : "%p";
            return $date_format . ' ' . "%H" . $time_separator . "%i" . $pm;
        }
    }
    
    /**
     * It returns the Date format of the user needed for the MySQL function DATE_FORMAT
     *
     * @return date
     */
    static function getDateFormat() {
        global $current_user, $timedate;

        $date_format = $timedate->getCalFormat($timedate->get_date_format($current_user));
        return $date_format;
    }
}
