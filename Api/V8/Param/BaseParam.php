<?php
namespace Api\V8\Param;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Factory\ValidatorFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseParam implements \JsonSerializable
{
    const REGEX_MODULE_NAME_PATTERN = '/^(\d|\W)|\W/';
    const REGEX_FIELD_PATTERN = '/[^\w-,]/';
    const REGEX_SORT_PATTERN = '/[^\w-]/';
    const REGEX_PAGE_PATTERN = '/[^\d]/';

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @var BeanManager
     */
    protected $beanManager;

    /**
     * @param ValidatorFactory $validatorFactory
     * @param BeanManager $beanManager
     */
    public function __construct(ValidatorFactory $validatorFactory, BeanManager $beanManager)
    {
        $this->validatorFactory = $validatorFactory;
        $this->beanManager = $beanManager;
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
}
