<?php
namespace Api\V8\Param\Options;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Bean extends BaseOption
{
    /**
     * @inheritdoc
     */
    public function add(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined('bean')
            ->setDefault('bean', function (Options $options) {
                return $this->beanManager->getBeanSafe(
                    $options->offsetGet('moduleName'),
                    $options->offsetGet('id')
                );
            })
            ->setAllowedTypes('bean', [\SugarBean::class]);
    }
}
