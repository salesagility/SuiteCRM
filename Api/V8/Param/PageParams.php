<?php
namespace Api\V8\Param;

use Api\V8\BeanDecorator\BeanManager;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PageParams extends BaseParam
{
    /**
     * @return int
     */
    public function getSize()
    {
        return isset($this->parameters['size']) ? intval($this->parameters['size']) : BeanManager::DEFAULT_MAX;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return isset($this->parameters['number']) ? intval($this->parameters['number']) : BeanManager::DEFAULT_OFFSET;
    }

    /**
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined('size')
            ->setAllowedTypes('size', ['string']);

        $resolver
            ->setDefined('number')
            ->setAllowedTypes('number', ['string'])
            ->setAllowedValues('number', $this->validatorFactory->createClosure([
                new Assert\GreaterThan(0),
                new Assert\LessThanOrEqual(BeanManager::MAX_RECORDS_PER_PAGE),
            ]));
    }
}
