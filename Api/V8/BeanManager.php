<?php
namespace Api\V8;

use Api\V8\Exception\BeanNotFoundException;

class BeanManager
{
    /**
     * @var array
     */
    private $beanAliases;

    /**
     * @param array $beanAliases
     */
    public function __construct(array $beanAliases)
    {
        $this->beanAliases = $beanAliases;
    }

    /**
     * @param string $module
     * @return \SugarBean
     * @throws \InvalidArgumentException When the module is unknown.
     */
    public function newBeanSafe(string $module): \SugarBean
    {
        $bean = \BeanFactory::newBean($module);
        if (!$bean instanceof \SugarBean) {
            throw new \InvalidArgumentException(sprintf('Could not get new bean for module: %s', $module));
        }

        return $bean;
    }

    /**
     * @param string $module
     * @param string $id
     * @param array $params
     * @param bool $deleted
     * @return \SugarBean
     * @throws \DomainException In case id/module is invalid, bean with this id is not found or has unexpected class.
     * @throws BeanNotFoundException When the given combinations of params don't result a bean.
     */
    public function getBeanSafe(
        string $module,
        string $id,
        array $params = [],
        bool $deleted = true
    ): \SugarBean {
        if (empty($id)) {
            throw new \DomainException('Empty or invalid bean id provided while fetching ' .$module);
        }

        $objectName = \BeanFactory::getObjectName($module);
        if (!$objectName && array_key_exists($module, $this->beanAliases)) {
            $objectName = \BeanFactory::getObjectName($this->beanAliases[$module]);
            $module = $this->beanAliases[$module];
        }
        if (!$objectName) {
            throw new \DomainException('Could not find object name for this module: ' . $module);
        }

        $bean = \BeanFactory::getBean($module, $id, $params, $deleted);
        if ($bean === false) {
            throw new BeanNotFoundException(
                sprintf('Bean %s with id %s not found', $module, $id),
                BeanNotFoundException::CODE_BY_ID
            );
        }
        if (!($bean instanceof $objectName)) {
            throw new \DomainException(
                sprintf('Bean has class %s, but %s was expected', get_class($bean), $objectName)
            );
        }

        return $bean;
    }
}
