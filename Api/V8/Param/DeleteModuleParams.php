<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteModuleParams extends BaseParam
{
    /**
     * @return string
     */
    public function getModuleName()
    {
        return $this->parameters['moduleName'];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->parameters['id'];
    }

    /**
     * @return \SugarBean
     */
    public function getBean()
    {
        return $this->parameters['bean'];
    }

    /**
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('moduleName')
            ->setAllowedTypes('moduleName', ['string'])
            ->setAllowedValues('moduleName', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => self::REGEX_MODULE_NAME_PATTERN,
                    'match' => false,
                ]),
            ]));

        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', ['string'])
            ->setAllowedValues('id', $this->validatorFactory->createClosure([
                new Assert\NotBlank(),
                new Assert\Uuid(['strict' => false]),
            ]));

        $resolver
            ->setDefined('bean')
            ->setDefault('bean', function (Options $options) {
                return $this->beanManager->getBeanSafe(
                    $options->offsetGet('moduleName'),
                    $options->offsetGet('id')
                );
            })
            ->setAllowedTypes('bean', [\SugarBean::class]);
    }
}
