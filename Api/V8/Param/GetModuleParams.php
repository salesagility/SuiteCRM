<?php
namespace Api\V8\Param;

use Symfony\Component\OptionsResolver\OptionsResolver;

class GetModuleParams extends BaseParam
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
     * @return array|null
     */
    public function getFields()
    {
        return isset($this->parameters['fields']) ? $this->parameters['fields'] : null;
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
        $this->optionBuilder->setOptions(
            $resolver,
            ['moduleName', 'id', 'fields', 'bean']
        );
    }
}
