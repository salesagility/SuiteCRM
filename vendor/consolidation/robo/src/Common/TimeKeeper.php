<?php

namespace Robo\Common;

class TimeKeeper
{
    const MINUTE = 60;
    const HOUR = 3600;
    const DAY = 86400;

    /**
     * @var float|null
     */
    protected $startedAt;

    /**
     * @var float|null
     */
    protected $finishedAt;

    public function start()
    {
        if ($this->startedAt) {
            return;
        }
        // Get time in seconds as a float, accurate to the microsecond.
        $this->startedAt = microtime(true);
    }

    public function stop()
    {
        $this->finishedAt = microtime(true);
    }

    public function reset()
    {
        $this->startedAt = $this->finishedAt = null;
    }

    /**
     * @return float|null
     */
    public function elapsed()
    {
        $finished = $this->finishedAt ? $this->finishedAt : microtime(true);
        if ($finished - $this->startedAt <= 0) {
            return null;
        }
        return $finished - $this->startedAt;
    }

    /**
     * Format a duration into a human-readable time.
     *
     * @param float $duration
     *   Duration in seconds, with fractional component.
     *
     * @return string
     */
    public static function formatDuration($duration)
    {
        if ($duration >= self::DAY * 2) {
            return gmdate('z \d\a\y\s H:i:s', (int) $duration);
        }
        if ($duration >= self::DAY) {
            return gmdate('\1 \d\a\y H:i:s', (int) $duration);
        }
        if ($duration >= self::HOUR) {
            return gmdate("H:i:s", (int) $duration);
        }
        if ($duration >= self::MINUTE) {
            return gmdate("i:s", (int) $duration);
        }
        return round($duration, 3) . 's';
    }
}
