<?php
namespace Api\V8\Param\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class Id extends BaseOption
{
    /**
     * @inheritdoc
     */
    public function add(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', 'string')
            ->setAllowedValues('id', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Uuid(['strict' => false]),
            ]));
    }
}
