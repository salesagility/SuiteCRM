<?php
namespace Api\V8\Param\Options;

use Api\V8\Param\PageParams;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class Page extends BaseOption
{
    const REGEX_PAGE_PATTERN = '/[^\d]/';

    /**
     * @inheritdoc
     */
    public function add(OptionsResolver $resolver)
    {
        $validator = $this->optionBuilder->getValidatorInstance();

        $resolver
            ->setDefined('page')
            ->setAllowedTypes('page', 'array')
            ->setAllowedValues('page', $validator->createClosureForIterator([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_PAGE_PATTERN,
                    'match' => false,
                ]),
            ], true))
            ->setNormalizer('page', function (Options $options, $values) {
                $pageParams = new PageParams($this->optionBuilder);
                $pageParams->configure($values);

                return $pageParams;
            });
    }
}
