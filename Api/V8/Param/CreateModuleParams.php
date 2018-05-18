<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CreateModuleParams extends BaseParam
{
    /**
     * @return string
     */
    public function getType()
    {
        return $this->parameters['type'];
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->parameters['data'];
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
            ->setRequired('data')
            ->setAllowedTypes('data', ['array'])
            ->setAllowedValues('data', $this->validatorFactory->createClosureForIterator([
                new Assert\NotBlank(),
            ]))
            ->setNormalizer('data', function (Options $options, $values) {
                $lol = 1;

                $dataParams = new DataParams($this->validatorFactory, $this->beanManager);
                $dataParams->configure($values);

                $bean = $this->beanManager->newBeanSafe($options->offsetGet('moduleName'));

//                $attributes = $bean->toArray();
//                $fields = explode(',', array_shift($values));
//
//                $invalidFields = array_filter($fields, function ($field) use ($attributes) {
//                    return !array_key_exists($field, $attributes);
//                });
//
//                if ($invalidFields) {
//                    throw new \InvalidArgumentException(
//                        sprintf(
//                            'The following field%s in %s module %s not found: %s',
//                            count($invalidFields) > 1 ? 's' : '',
//                            $bean->getObjectName(),
//                            count($invalidFields) > 1 ? 'are' : 'is',
//                            implode(', ', $invalidFields)
//                        )
//                    );
//                }

//                return $fields;
            });


    }
}
