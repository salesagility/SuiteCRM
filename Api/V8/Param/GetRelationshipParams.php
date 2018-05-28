<?php
namespace Api\V8\Param;

use Api\V8\Param\Options as ParamOption;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetRelationshipParams extends BaseParam
{
    /**
     * @return string
     */
    public function getModuleName()
    {
        return $this->parameters['moduleName'];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->parameters['id'];
    }

    /**
     * @return string
     */
    public function getRelationshipName()
    {
        return $this->parameters['relationshipName'];
    }

    /**
     * @return \SugarBean
     */
    public function getSourceBean()
    {
        return $this->parameters['sourceBean'];
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
                ParamOption\ModuleName::class,
                ParamOption\Id::class,
            ]
        );

        $resolver
            ->setRequired('relationshipName')
            ->setAllowedTypes('relationshipName', ['string']);

        $resolver
            ->setDefined('sourceBean')
            ->setDefault('sourceBean', function (Options $options) {
                return $this->beanManager->getBeanSafe(
                    $options->offsetGet('moduleName'),
                    $options->offsetGet('id')
                );
            })
            ->setAllowedTypes('sourceBean', [\SugarBean::class]);

        $resolver
            ->setDefined('relatedBean')
            ->setDefault('relatedBean', function (Options $options) {
                return $this->beanManager->newBeanSafe($options->offsetGet('relationshipName'));
            })
            ->setAllowedTypes('relatedBean', [\SugarBean::class]);
    }
}
