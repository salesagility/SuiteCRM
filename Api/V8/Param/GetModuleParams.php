<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class GetModuleParams extends BaseGetModuleParams
{
    /**
     * @return string
     */
    public function getId()
    {
        return $this->parameters['id'];
    }

    /**
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', ['string'])
            ->setAllowedValues('id', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Uuid(['strict' => false]),
            ]));

        parent::configureParameters($resolver);
    }
}
