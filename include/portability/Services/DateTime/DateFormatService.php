<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

class DateFormatService
{
    /**
     * @param $dateString
     * @return string|null
     */
    public function dbToUserDate($dateString): ?string
    {
        global $timedate;

        $date = $timedate->fromDbDate($dateString);

        if ($date !== null) {
            return $timedate->asUserDate($date);
        }

        return null;
    }

    /**
     * @param $dateString
     * @return string|null
     */
    public function userToDbDate($dateString): ?string
    {
        global $timedate;

        $date = $timedate->fromUserDate($dateString);

        if ($date !== null) {
            return $timedate->asDbDate($date);
        }

        return null;
    }

    /**
     * @param $dateString
     * @return string|null
     */
    public function toUserDateTime($dateString): ?string
    {

        global $timedate;

        $date = $this->toDateTime($dateString);

        if ($date !== null) {
            return $timedate->asUser($date);
        }

        return null;
    }

    /**
     * @param $dateString
     * @return string|null
     */
    public function toUserDate($dateString): ?string
    {

        global $timedate;

        $date = $this->toDateTime($dateString);

        if ($date !== null) {
            return $timedate->asUserDate($date);
        }

        return null;
    }


    /**
     * @param $dateString
     * @return string|null
     */
    public function toDBDate($dateString): ?string
    {
        global $timedate;

        $date = $this->toDateTime($dateString);

        if ($date !== null) {
            return $timedate->asDbDate($date);
        }

        return null;
    }

    /**
     * @param $dateString
     * @return string|null
     */
    public function toDBDateTime($dateString): ?string
    {
        global $timedate;

        $date = $this->toDateTime($dateString);

        if ($date !== null) {
            return $timedate->asDbDate($date) . ' ' . $timedate->asDbTime($date);
        }

        return null;
    }

    /**
     * @param $dateString
     * @return SugarDateTime|null
     */
    public function toDateTime($dateString): ?SugarDateTime
    {
        global $timedate;

        $dateTime = null;
        if ($this->isUserDate($dateString)) {

            $dateTime = $timedate->fromUserDate($dateString);

        } elseif ($this->isDBDate($dateString)) {

            $dateTime = $timedate->fromDbDate($dateString);

        } elseif ($this->isUserDateTime($dateString)) {

            $dateTime = $timedate->fromUser($dateString);

        } elseif ($this->isDBDateTime($dateString)) {

            $dateTime = $timedate->fromDb($dateString);
        }

        return $dateTime ?? null;
    }

    /**
     * @param $dateStr
     * @return bool
     */
    public function isUserDate($dateStr): bool
    {
        global $timedate;
        $format = $timedate->get_date_format();
        $date = DateTime::createFromFormat($format, $dateStr);

        return $date && $date->format($format) === $dateStr;
    }

    /**
     * @param $dateStr
     * @return bool
     */
    public function isDBDate($dateStr): bool
    {
        global $timedate;
        $format = $timedate->get_db_date_format();
        $date = DateTime::createFromFormat($format, $dateStr);

        return $date && $date->format($format) === $dateStr;
    }

    /**
     * @param $dateStr
     * @return bool
     */
    public function isUserDateTime($dateStr): bool
    {
        global $timedate;
        $format = $timedate->get_date_time_format();
        $date = DateTime::createFromFormat($format, $dateStr);

        return $date && $date->format($format) === $dateStr;
    }

    /**
     * @param $dateStr
     * @return bool
     */
    public function isDBDateTime($dateStr): bool
    {
        global $timedate;
        $format = $timedate->get_db_date_time_format();
        $date = DateTime::createFromFormat($format, $dateStr);

        return $date && $date->format($format) === $dateStr;
    }

    /**
     * @return string
     */
    public function getJSDateFormat(): string
    {
        global $timedate;

        return $timedate->get_cal_date_format();
    }

    /**
     * @param $dateStr
     * @param $modification
     * @return string
     */
    public function modifyDate($dateStr, $modification): string
    {
        global $timedate;

        $format = false;
        if ($this->isUserDate($dateStr)) {
            $format = $timedate->get_date_format();
        }
        if ($this->isDBDate($dateStr)) {
            $format = $timedate->get_db_date_format();
        }
        if (!$format) {
            return '';
        }

        $date = $this->toDateTime($dateStr);

        if (!$date) {
            return '';
        }

        return $date->modify($modification)->format($format);
    }
}

