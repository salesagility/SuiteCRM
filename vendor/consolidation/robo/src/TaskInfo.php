<?php

namespace Robo;

class TaskInfo
{
    /**
     * Return a context useful for logging messages.
     *
     * @param object $task
     *
     * @return array
     */
    public static function getTaskContext($task)
    {
        return [
            'name' => TaskInfo::formatTaskName($task),
            'task' => $task,
        ];
    }

    /**
     * @param object $task
     *
     * @return string
     */
    public static function formatTaskName($task)
    {
        $name = get_class($task);
        $name = preg_replace('~Stack^~', '', $name);
        $name = str_replace('Robo\\Task\Base\\', '', $name);
        $name = str_replace('Robo\\Task\\', '', $name);
        $name = str_replace('Robo\\Collection\\', '', $name);
        return $name;
    }
}
