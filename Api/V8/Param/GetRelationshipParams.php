<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class GetRelationshipParams extends GetModulesParams
{
    /**
     * @return string
     */
    public function getId()
    {
        return $this->parameters['id'];
    }

    /**
     * @return string
     */
    public function getRelationshipName()
    {
        return $this->parameters['relationshipName'];
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

        $resolver
            ->setRequired('relationshipName')
            ->setAllowedTypes('relationshipName', ['string']);

        parent::configureParameters($resolver);
    }
}
