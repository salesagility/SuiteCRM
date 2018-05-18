<?php
namespace Api\V8\Param;

use Api\V8\JsonApi\Repository\Filter;
use Api\V8\JsonApi\Repository\Sort;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class GetModulesParams extends BaseGetModuleParams
{
    /**
     * @return PageParams
     */
    public function getPage()
    {
        return isset($this->parameters['page'])
            ? $this->parameters['page']
            : new PageParams($this->validatorFactory, $this->beanManager);
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return isset($this->parameters['sort']) ? $this->parameters['sort'] : '';
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return isset($this->parameters['filter']) ? $this->parameters['filter'] : '';
    }

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException If page key is invalid.
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
                    'match' => false,
                ]),
            ], true))
            ->setNormalizer('page', function (Options $options, $values) {
                $pageParams = new PageParams($this->validatorFactory, $this->beanManager);
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
                $bean = $this->beanManager->newBeanSafe($options->offsetGet('moduleName'));
                $sort = new Sort();

                return $sort->parseOrderBy($bean, $value);
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
                $filter = new Filter($bean->db);

                return $filter->parseWhere($bean, $values);
            });

        parent::configureParameters($resolver);
    }
}
