<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

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
            ->setDefined('relatedBean')
            ->setDefault('relatedBean', function (Options $options) {
                $bean = $this->beanManager->newBeanSafe($options->offsetGet('type'));
                $bean->save();

                return $bean;
            })
            ->setAllowedTypes('relatedBean', [\SugarBean::class]);
    }
}
