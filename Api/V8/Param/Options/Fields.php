<?php
namespace Api\V8\Param\Options;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class Fields extends BaseOption
{
    const REGEX_FIELD_PATTERN = '/[^\w-,]/';

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException In case fields are invalid.
     */
    public function add(OptionsResolver $resolver)
    {
        $validator = $this->optionBuilder->getValidatorInstance();
        $beanManager = $this->optionBuilder->getBeanManagerInstance();

        $resolver
            ->setDefined('fields')
            ->setAllowedTypes('fields', 'array')
            ->setAllowedValues('fields', $validator->createClosureForIterator([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_FIELD_PATTERN,
                    'match' => false,
                ]),
            ], true))
            ->setNormalizer('fields', function (Options $options, $values) use ($beanManager) {
                $bean = $beanManager->newBeanSafe(key($values));
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
