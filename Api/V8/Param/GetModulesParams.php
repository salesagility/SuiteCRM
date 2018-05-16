<?php
namespace Api\V8\Param;

use Api\V8\BeanDecorator\Filter;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class GetModulesParams extends BaseModuleParams
{
    private static $allowedPageKeys = ['size', 'number'];

    /**
     * @return PageParams
     */
    public function getPage()
    {
        return isset($this->parameters['page'])
            ? $this->parameters['page']
            : new PageParams($this->validatorFactory);
    }

    /**
     * @return string|null
     */
    public function getSort()
    {
        return isset($this->parameters['sort']) ? $this->parameters['sort'] : null;
    }

    /**
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined('page')
            ->setAllowedTypes('page', ['array'])
            ->setAllowedValues('page', $this->validatorFactory->createClosureForIterator([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_PAGE_PATTERN,
                ]),
            ], true))
            ->setNormalizer('page', function (Options $options, $values) {
                $invalidKeys = array_diff_key($values, array_flip(self::$allowedPageKeys));
                if ($invalidKeys) {
                    throw new \InvalidArgumentException(
                        'Invalid key(s) for page parameter: ' . implode(', ', array_keys($invalidKeys))
                    );
                }

                $pageParams = new PageParams($this->validatorFactory);
                $pageParams->configure($values);

                return $pageParams;
            });

        $resolver
            ->setDefined('sort')
            ->setAllowedTypes('sort', ['string'])
            ->setAllowedValues('sort', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_SORT_PATTERN,
                    'match' => false,
                ]),
            ], true))
            ->setNormalizer('sort', function (Options $options, $value) {
                // we don't support multiple sorting. for now.
                $bean = $this->beanManager->newBeanSafe($options->offsetGet('moduleName'));
                $sortBy = ' ASC';

                if ($value[0] === '-') {
                    $sortBy = ' DESC';
                    $value = ltrim($value, '-');
                }

                if (!property_exists($bean, $value)) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Sort field %s in %s module is not found',
                            $value,
                            $bean->getObjectName()
                        )
                    );
                }

                return $value . $sortBy;
            });

        $resolver
            ->setDefined('filter')
            ->setAllowedTypes('filter', ['array'])
            ->setAllowedValues('filter', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
            ]))
            ->setNormalizer('filter', function (Options $options, $values) {
                // we don't support multiple level filtering. for now.
                $bean = $this->beanManager->newBeanSafe($options->offsetGet('moduleName'));

                $operator = $values['operator'];
                unset($values['operator']);

                foreach ($values as $key => $value) {
                    if (!property_exists($bean, $key)) {
                        throw new \InvalidArgumentException(
                            sprintf(
                                'Filter field %s in %s module is not found',
                                $key,
                                $bean->getObjectName()
                            )
                        );
                    }

                    if (!is_array($value)) {
                        throw new \InvalidArgumentException(
                            sprintf('Filter field %s must be an array', $key)
                        );
                    }

                    $filterParams = new FilterParams($this->validatorFactory);
                    $filterParams->configure($value);
                }
            });

        return parent::configureParameters($resolver);
    }
}
