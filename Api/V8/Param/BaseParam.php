<?php
namespace Api\V8\Param;

use Api\V8\Builder\OptionsBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseParam implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var OptionsBuilder
     */
    protected $optionBuilder;

    /**
     * @param $optionBuilder
     */
    public function __construct($optionBuilder)
    {
        $this->optionBuilder = $optionBuilder;
    }

    /**
     * @param array $arguments
     *
     * @return $this
     */
    final public function configure(array $arguments)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureParameters($optionsResolver);
        $this->parameters = $optionsResolver->resolve($arguments);

        return $this;
    }

    /**
     * Configure parameters.
     * They can be set by reusing already existed options or create new ones in this method.
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException In case of invalid access.
     * @throws \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException In case of invalid option.
     */
    abstract protected function configureParameters(OptionsResolver $resolver);

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->parameters;
    }

    public function getOptionBuilderInstance()
    {
        return $this->optionBuilder;
    }
}
