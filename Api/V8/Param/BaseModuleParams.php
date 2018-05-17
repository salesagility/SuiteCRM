<?php
namespace Api\V8\Param;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Factory\ValidatorFactory;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BaseModuleParams extends BaseParam
{
    /**
     * @var BeanManager
     */
    protected $beanManager;

    /**
     * @param ValidatorFactory $validatorFactory
     * @param BeanManager $beanManager
     */
    public function __construct(ValidatorFactory $validatorFactory, BeanManager $beanManager)
    {
        parent::__construct($validatorFactory);

        $this->beanManager = $beanManager;
    }

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
            ->setAllowedTypes('moduleName', ['string']);

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
                $bean = $this->beanManager->newBeanSafe(key($values));
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
