<?php
namespace Api\V8\Param;

use Api\V8\Param\Options as ParamOption;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetRelationshipDataParams extends BaseParam
{
    /**
     * @return string
     */
    public function getType()
    {
        return $this->parameters['type'];
    }

    /**
     * @return \SugarBean
     */
    public function getRelatedBean()
    {
        return $this->parameters['relatedBean'];
    }

    /**
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $this->setOptions(
            $resolver,
            [
                ParamOption\Type::class,
            ]
        );

        $resolver
            ->setDefined('relatedBean')
            ->setDefault('relatedBean', function (Options $options) {
                $bean = $this->beanManager->newBeanSafe($options->offsetGet('type'));
                $bean->save();

                return $bean;
            })
            ->setAllowedTypes('relatedBean', [\SugarBean::class]);
    }
}
