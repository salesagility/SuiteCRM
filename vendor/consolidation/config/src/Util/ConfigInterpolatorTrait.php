<?php

namespace Consolidation\Config\Util;

/**
 * Provides configuration objects with an 'interpolate' method
 * that may be used to inject config values into tokens embedded
 * in strings..
 */
trait ConfigInterpolatorTrait
{

    /**
     * @var \Consolidation\Config\Util\Interpolator
     */
    protected $interpolator;

    protected function getInterpolator()
    {
        if (!isset($this->interpolator)) {
            $this->interpolator = new Interpolator();
        }
        return $this->interpolator;
    }

    /**
     * {@inheritdoc }
     */
    public function interpolate($message, $default = '')
    {
        return $this->getInterpolator()->interpolate($this, $message, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function mustInterpolate($message)
    {
        return $this->getInterpolator()->mustInterpolate($this, $message);
    }
}
