<?php
namespace Api\V8\Param;

use Api\V8\BeanDecorator\Filter;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterParams extends BaseParam
{
    private static $allowedFilterKeys = [
        'eq' => Filter::EQ
    ];

    /**
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined(array_flip(self::$allowedFilterKeys));
    }
}
