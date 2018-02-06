<?php
namespace Api\V8\Params;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LoginParams extends AbstractParams
{
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->arguments['username'];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->arguments['password'];
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('username')
            ->setAllowedTypes('username', ['string'])
            ->setAllowedValues(
                'username',
                $this->validatorFactory->createClosure([
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 60]),
                    new Assert\Regex(['pattern' => '/[0-9a-zA-Z_.-@]/']),
                ])
            );

        $resolver
            ->setRequired('password')
            ->setAllowedTypes('password', ['string'])
            ->setAllowedValues(
                'password',
                $this->validatorFactory->createClosure([
                    new Assert\NotBlank()
                ])
            );
    }
}
