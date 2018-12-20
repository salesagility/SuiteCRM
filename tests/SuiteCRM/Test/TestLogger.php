<?php
namespace SuiteCRM\Test;

/**
 * Class TestLogger
 */
class TestLogger
{

    /**
     * @var array
     */
    public $calls;

    /**
     * @var array
     */
    public $notes;

    /**
     * TestLogger constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $this->calls[$name][] = $arguments;
        $this->notes[] = array(
            'entry_date' => date('Y-m-d H:i:s'),
            'level' => $name,
            'message' => array_shift($arguments),
            'arguments' => $arguments,
            'backtrace' => debug_backtrace(),
        );
    }

    /**
     * @param string|string[] $levels
     * @return array
     */
    public function getNotes($levels = 'fatal')
    {
        $results = array();
        if (is_string($levels)) {
            $levels = explode(',', $levels);
            foreach ($levels as &$level) {
                $level = strtolower(trim($level));
            }
        }
        foreach ($this->notes as $note) {
            if (in_array($note['level'], $levels, true)) {
                $results[] = $note;
            }
        }
        return $results;
    }

    /**
     *
     */
    public function reset()
    {
        $this->calls = array();
        $this->notes = array();
    }
}
