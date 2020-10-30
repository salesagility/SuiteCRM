<?php

class DateTimeService
{

    /**
     * @param string $start
     * @param string|null $end
     * @return int|null
     * @throws Exception
     */
    public function diffDateStrings(string $start, string $end = null): ?int
    {
        /* @noinspection PhpIncludeInspection */
        require_once 'include/portability/Services/DateTime/DateFormatService.php';
        $dateFormatService = new DateFormatService();

        $startDateTime = $dateFormatService->toDateTime($start);

        if ($startDateTime === null) {
            return null;
        }

        $endDateTime = new DateTime();
        if (!empty($end)) {
            $parsed = $dateFormatService->toDateTime($end);
            if ($parsed !== null) {
                $endDateTime = $parsed;
            }
        }

        return $this->diffDateTimes($startDateTime, $endDateTime);
    }

    /**
     * @param DateTime $start
     * @param DateTime $end
     * @return int
     */
    public function diffDateTimes(DateTime $start, DateTime $end): int
    {
        $diff = $start->diff($end);

        if ($diff->days === false) {
            throw new UnexpectedValueException('Unexpected date diff value');
        }

        return $diff->days;
    }

}
