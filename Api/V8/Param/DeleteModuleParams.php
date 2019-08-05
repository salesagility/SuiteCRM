<?php
namespace Api\V8\Param;

use Api\V8\Param\Options as ParamOption;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
     * @inheritdoc
     */
    protected function configureParameters(OptionsResolver $resolver)
    {
        $this->setOptions(
            $resolver,
            [
                ParamOption\ModuleName::class,
                ParamOption\Id::class,
            ]
        );
    }
}
