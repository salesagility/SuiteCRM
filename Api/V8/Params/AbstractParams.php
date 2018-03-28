<?php
namespace Api\V8\Params;

use Api\V8\Factory\ValidatorFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractParams implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @param ValidatorFactory $validatorFactory
     */
    public function __construct(ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * @param array ...$arguments
     *
     * @return $this
     */
    public function configure(...$arguments)
    {
        $arguments = array_merge(...$arguments);

        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->arguments = $optionsResolver->resolve($arguments);

        return $this;
    }

    /**
     * Configure param options.
     *
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException In case of invalid access.
     * @throws \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException In case of invalid option.
     */
    abstract protected function configureOptions(OptionsResolver $resolver);

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->arguments;
    }
}
