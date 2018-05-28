<?php
namespace Api\V8\Param;

use Api\V8\Param\Options as ParamOption;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteRelationshipDataParams extends BaseParam
{
    /**
     * @return string
     */
    public function getType()
    {
        return $this->parameters['type'];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->parameters['id'];
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
                ParamOption\Id::class,
            ]
        );

        $resolver
            ->setDefined('relatedBean')
            ->setDefault('relatedBean', function (Options $options) {
                return $this->beanManager->getBeanSafe(
                    $options->offsetGet('type'),
                    $options->offsetGet('id')
                );
            })
            ->setAllowedTypes('relatedBean', [\SugarBean::class]);
    }
}
