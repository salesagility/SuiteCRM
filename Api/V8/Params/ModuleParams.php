<?php
namespace Api\V8\Params;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ModuleParams extends AbstractParams
{
    /**
     * @return string
     */
    public function getModule()
    {
        return $this->arguments['module'];
    }

    /**
     * @return string
     */
    public function getRecordId()
    {
        return $this->arguments['recordId'];
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('module')
            ->setAllowedTypes('module', ['string'])
            ->setAllowedValues(
                'module',
                $this->validatorFactory->createClosure([
                    new Assert\NotBlank(),
                ])
            );

        $resolver
            ->setRequired('recordId')
            ->setAllowedTypes('recordId', ['string'])
            ->setAllowedValues(
                'recordId',
                $this->validatorFactory->createClosure([
                    new Assert\NotBlank(),
                    new Assert\Uuid(['strict' => false]),
                ])
            );

    }
}
