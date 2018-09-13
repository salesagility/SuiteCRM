<?php
namespace Api\V8\Param\Options;

use InvalidArgumentException;
use OutOfBoundsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class Attributes extends BaseOption
{
    /**
     * @inheritdoc
     *
     * @throws InvalidArgumentException If attributes parameters have invalid property.
     */
    public function add(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined('attributes')
            ->setAllowedTypes('attributes', 'array')
            ->setAllowedValues('attributes', $this->validatorFactory->createClosureForIterator([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => Fields::REGEX_FIELD_PATTERN,
                    'match' => false,
                ]),
            ]))
            ->setNormalizer('attributes', function (Options $options, $values) {
                $bean = $this->beanManager->newBeanSafe($options->offsetGet('type'));
                
                foreach ($values as $attribute => $value) {
                    $invalidProperty = 
                        !property_exists($bean, $attribute) && 
                        !array_key_exists($attribute, $bean->field_defs) &&
                        !array_key_exists($attribute, $bean->field_name_map); 
                    if ($invalidProperty) {
                        throw new OutOfBoundsException(sprintf(
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
