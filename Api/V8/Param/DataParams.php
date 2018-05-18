<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\OptionsResolver;

class DataParams extends BaseParam
{
    /**
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('type')
            ->setAllowedTypes('type', ['string']);

        $resolver
            ->setRequired('attributes')
            ->setAllowedTypes('attributes', ['array']);
    }
}
