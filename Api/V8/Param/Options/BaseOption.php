<?php
namespace Api\V8\Param\Options;

use Api\V8\Builder\OptionsBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseOption
{
    /**
     * @var OptionsBuilder
     */
    protected $optionBuilder;

    /**
     * @param OptionsBuilder $optionBuilder
     */
    public function __construct(OptionsBuilder $optionBuilder)
    {
        $this->optionBuilder = $optionBuilder;
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    abstract public function add(OptionsResolver $resolver);
}
