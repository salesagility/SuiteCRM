<?php

namespace Robo\Log;

use Robo\Common\TimeKeeper;
use Consolidation\Log\LogOutputStyler;

/**
 * Robo Log Styler.
 */
class RoboLogStyle extends LogOutputStyler
{
    const TASK_STYLE_SIMULATED = 'options=reverse;bold';

    /**
     * RoboLogStyle constructor.
     *
     * @param array $labelStyles
     * @param array $messageStyles
     */
    public function __construct($labelStyles = [], $messageStyles = [])
    {
        parent::__construct($labelStyles, $messageStyles);

        $this->labelStyles += [
            RoboLogLevel::SIMULATED_ACTION => self::TASK_STYLE_SIMULATED,
        ];
        $this->messageStyles += [
            RoboLogLevel::SIMULATED_ACTION => '',
        ];
    }

    /**
     * Log style customization for Robo: replace the log level with
     * the task name.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     *
     * @return string
     */
    protected function formatMessageByLevel($level, $message, $context)
    {
        $label = $level;
        if (array_key_exists('name', $context)) {
            $label = $context['name'];
        }
        return $this->formatMessage($label, $message, $context, $this->labelStyles[$level], $this->messageStyles[$level]);
    }

    /**
     * Log style customization for Robo: add the time indicator to the
     * end of the log message if it exists in the context.
     *
     * @param string $label
     * @param string $message
     * @param array $context
     * @param string $taskNameStyle
     * @param string $messageStyle
     *
     * @return string
     */
    protected function formatMessage($label, $message, $context, $taskNameStyle, $messageStyle = '')
    {
        $message = parent::formatMessage($label, $message, $context, $taskNameStyle, $messageStyle);

        if (array_key_exists('time', $context) && !empty($context['time']) && array_key_exists('timer-label', $context)) {
            $duration = TimeKeeper::formatDuration($context['time']);
            $message .= ' ' . $context['timer-label'] . ' ' . $this->wrapFormatString($duration, 'fg=yellow');
        }

        return $message;
    }
}
