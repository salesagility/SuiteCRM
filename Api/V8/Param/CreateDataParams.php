<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CreateDataParams extends BaseParam
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
    public function getBean()
    {
        return $this->parameters['bean'];
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return isset($this->parameters['attributes']) ? $this->parameters['attributes'] : [];
    }

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException If attributes parameters have invalid property.
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
            ->setDefined('bean')
            ->setDefault('bean', function (Options $options) {
                return $this->beanManager->newBeanSafe($options->offsetGet('type'));
            })
            ->setAllowedTypes('bean', [\SugarBean::class]);

        $resolver
            ->setDefined('attributes')
            ->setAllowedTypes('attributes', ['array'])
            ->setAllowedValues('attributes', $this->validatorFactory->createClosureForIterator([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_FIELD_PATTERN,
                    'match' => false,
                ]),
            ]))
            ->setNormalizer('attributes', function (Options $options, $values) {
                $bean = $options->offsetGet('bean');

                foreach ($values as $attribute => $value) {
                    if (!property_exists($bean, $attribute)) {
                        throw new \InvalidArgumentException(sprintf(
                            'Property %s in %s module is invalid',
                            $attribute,
                            $bean->getObjectName()
                        ));
                    }
                }

                return $values;
            });
    }
}
