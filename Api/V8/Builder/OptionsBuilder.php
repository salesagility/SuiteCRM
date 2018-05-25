<?php
namespace Api\V8\Builder;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Factory\ValidatorFactory;
use Api\V8\Param\Options\BaseOption;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionsBuilder
{
    const REGEX_SORT_PATTERN = '/[^\w-]/';

    /**
     * @var BeanManager
     */
    private $beanManager;

    /**
     * @var ValidatorFactory
     */
    private $validatorFactory;

    /**
     * @param BeanManager $beanManager
     * @param ValidatorFactory $validatorFactory
     */
    public function __construct(BeanManager $beanManager, ValidatorFactory $validatorFactory)
    {
        $this->beanManager = $beanManager;
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * @param OptionsResolver $optionResolver
     * @param array $options
     */
    public function setOptions(OptionsResolver $optionResolver, array $options)
    {
        foreach ($options as $option) {
            $className = sprintf('Api\V8\Param\Options\%s', ucfirst($option));
            if (!class_exists($className)) {
                throw new \InvalidArgumentException(
                    sprintf('Option %s does not exist!', ucfirst($option))
                );
            }

            /** @var BaseOption $class */
            $class = new $className($this);
            $class->add($optionResolver);
        }
    }

    /**
     * @return ValidatorFactory
     */
    public function getValidatorInstance()
    {
        return $this->validatorFactory;
    }

    /**
     * @return BeanManager
     */
    public function getBeanManagerInstance()
    {
        return $this->beanManager;
    }
}