<?php
namespace Api\V8\Param;

use Api\V8\Param\Options as ParamOption;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

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
    public function getLinkedFieldName()
    {
        return $this->parameters['linkFieldName'];
    }

    /**
     * @return \SugarBean
     */
    public function getSourceBean()
    {
        return $this->parameters['sourceBean'];
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
            ->setDefined('sourceBean')
            ->setDefault('sourceBean', function (Options $options) {
                return $this->beanManager->getBeanSafe(
                    $options->offsetGet('moduleName'),
                    $options->offsetGet('id')
                );
            })
            ->setAllowedTypes('sourceBean', [\SugarBean::class]);

        // dependency on sourceBean field
        $this->setOptions($resolver, [ParamOption\LinkFieldName::class]);
    }
}
