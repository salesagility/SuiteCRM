<?php
namespace SuiteCRM\Robo\Traits;
require_once dirname(__DIR__) . '/config.php';

/**
 * Reusable methods which extent \Robo\Tasks
 */
trait RoboTrait
{
    /**
     * Asks user to set option when option is empty
     * @param string $question
     * @param string $default
     * @param &string key to options param
     */
    private function askDefaultOptionWhenEmpty($question, $default, &$option)
    {
        if (empty($option)) {
            $option = $this->askDefault($question, $default);
        }
    }

    /**
     * @param string sugar config key eg db_config.db_name
     * @default string failback value
     * @return config value or fallback when config is not available
     */
    private function chooseConfigOrDefault($configKey, $default)
    {
        if (empty($configKey)) {
            return $default;
        }

        $config = \SugarConfig::getInstance();
        return $config->get($configKey, $default);
    }
}
