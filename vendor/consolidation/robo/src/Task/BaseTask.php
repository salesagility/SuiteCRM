<?php

namespace Robo\Task;

use Robo\Common\InflectionTrait;
use Robo\Contract\InflectionInterface;
use Robo\Common\TaskIO;
use Robo\Contract\TaskInterface;
use Robo\Contract\ProgressIndicatorAwareInterface;
use Robo\Contract\VerbosityThresholdInterface;
use Robo\Common\ProgressIndicatorAwareTrait;
use Robo\Contract\ConfigAwareInterface;
use Psr\Log\LoggerAwareInterface;
use Robo\Contract\OutputAwareInterface;

abstract class BaseTask implements TaskInterface, LoggerAwareInterface, VerbosityThresholdInterface, ConfigAwareInterface, ProgressIndicatorAwareInterface, InflectionInterface, OutputAwareInterface
{
    use TaskIO; // uses LoggerAwareTrait, OutputAwareTrait, VerbosityThresholdTrait and ConfigAwareTrait
    use ProgressIndicatorAwareTrait;
    use InflectionTrait;

    /**
     * ConfigAwareInterface uses this to decide where configuration
     * items come from. Default is this prefix + class name + key,
     * e.g. `task.Remote.Ssh.remoteDir`.
     *
     * @return string
     */
    protected static function configPrefix()
    {
        return 'task.';
    }

    /**
     * ConfigAwareInterface uses this to decide where configuration
     * items come from. Default is this prefix + class name + key,
     * e.g. `task.Ssh.remoteDir`.
     *
     * @return string
     */
    protected static function configPostfix()
    {
        return '.settings';
    }

    /**
     * {@inheritdoc}
     */
    public function injectDependencies($child)
    {
        if ($child instanceof LoggerAwareInterface && $this->logger) {
            $child->setLogger($this->logger);
        }
        if ($child instanceof OutputAwareInterface) {
            $child->setOutput($this->output());
        }
        if ($child instanceof ProgressIndicatorAwareInterface && $this->progressIndicator) {
            $child->setProgressIndicator($this->progressIndicator);
        }
        if ($child instanceof ConfigAwareInterface && $this->getConfig()) {
            $child->setConfig($this->getConfig());
        }
        if ($child instanceof VerbosityThresholdInterface && $this->outputAdapter()) {
            $child->setOutputAdapter($this->outputAdapter());
        }
    }
}
