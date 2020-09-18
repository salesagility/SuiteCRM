<?php

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

