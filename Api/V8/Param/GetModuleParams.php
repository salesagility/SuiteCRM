<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class GetModuleParams extends BaseParam
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
     * @return \SugarBean
     */
    public function getBean()
    {
        return $this->parameters['bean'];
    }

    /**
     * @return array|null
     */
    public function getFields()
    {
        return isset($this->parameters['fields']) ? $this->parameters['fields'] : null;
    }

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException If fields have invalid property.
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('moduleName')
            ->setAllowedTypes('moduleName', ['string'])
            ->setAllowedValues('moduleName', $this->validatorFactory->createClosure([
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
            ->setDefined('bean')
            ->setDefault('bean', function (Options $options) {
                return $this->beanManager->getBeanSafe(
                    $options->offsetGet('moduleName'),
                    $options->offsetGet('id')
                );
            })
            ->setAllowedTypes('bean', [\SugarBean::class]);

        $resolver
            ->setDefined('fields')
            ->setAllowedTypes('fields', ['array'])
            ->setAllowedValues('fields', $this->validatorFactory->createClosureForIterator([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_FIELD_PATTERN,
                    'match' => false,
                ]),
            ], true))
            ->setNormalizer('fields', function (Options $options, $values) {
                $bean = $options->offsetGet('bean');
                $attributes = $bean->toArray();
                $fields = explode(',', array_shift($values));

                $invalidFields = array_filter($fields, function ($field) use ($attributes) {
                    return !array_key_exists($field, $attributes);
                });

                if ($invalidFields) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'The following field%s in %s module %s not found: %s',
                            count($invalidFields) > 1 ? 's' : '',
                            $bean->getObjectName(),
                            count($invalidFields) > 1 ? 'are' : 'is',
                            implode(', ', $invalidFields)
                        )
                    );
                }

                return $fields;
            });
    }
}
