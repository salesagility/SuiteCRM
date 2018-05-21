<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

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
        $resolver
            ->setRequired('type')
            ->setAllowedTypes('type', ['string'])
            ->setAllowedValues('type', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_MODULE_NAME_PATTERN,
                    'match' => false,
                ]),
            ]));

        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', ['string'])
            ->setAllowedValues('id', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Uuid(['strict' => false]),
            ]));

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
