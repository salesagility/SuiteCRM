<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BaseGetModuleParams extends BaseParam
{
    /**
     * @return string
     */
    public function getModuleName()
    {
        return $this->parameters['moduleName'];
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
     * @throws \InvalidArgumentException In case of field is not found.
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
                $bean = $this->beanManager->newBeanSafe($options->offsetGet('moduleName'));
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
