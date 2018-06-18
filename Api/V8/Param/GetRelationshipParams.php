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
    public function getBean()
    {
        return $this->parameters['bean'];
    }

    /**
     * @inheritdoc
     * @throws \RuntimeException When relationship cannot be loaded.
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
            ->setDefined('bean')
            ->setDefault('bean', function (Options $options) {
                return $this->beanManager->getBeanSafe(
                    $options->offsetGet('moduleName'),
                    $options->offsetGet('id')
                );
            })
            ->setAllowedTypes('bean', [\SugarBean::class]);

        $resolver
            ->setRequired('linkFieldName')
            ->setAllowedTypes('linkFieldName', ['string'])
            ->setAllowedValues('linkFieldName', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => ParamOption\ModuleName::REGEX_MODULE_NAME_PATTERN,
                    'match' => false,
                ]),
            ]))
            ->setNormalizer('linkFieldName', function (Options $options, $value) {
                $bean = $options->offsetGet('bean');

                if (!$bean->load_relationship($value)) {
                    throw new \RuntimeException(
                        sprintf('Cannot load relationship %s for %s module', $value, $bean->getObjectName())
                    );
                }

                return $value;
            });
    }
}
