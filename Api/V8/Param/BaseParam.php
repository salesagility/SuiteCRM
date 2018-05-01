<?php
namespace Api\V8\Param;

use Api\V8\Factory\ValidatorFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseParam implements \JsonSerializable
{
    const REGEX_FIELDS_PATTERN = '/[^A-Za-z0-9-_,]/';
    const REGEX_PAGE_PATTERN = '/^\d+$/';

    /**
     * @var array
     */
    protected $parameters = [];

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
     *
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException In case of invalid access.
     * @throws \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException In case of invalid option.
     */
    abstract protected function configureParameters(OptionsResolver $resolver);

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->parameters;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
