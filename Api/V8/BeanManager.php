<?php
namespace Api\V8;

class BeanManager
{
    const MAX_RECORDS_PER_PAGE = 20;

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
     *
     * @return \SugarBean
     * @throws \InvalidArgumentException When the module is invalid
     */
    public function newBeanSafe($module)
    {
        $bean = \BeanFactory::newBean($module);

        if (!$bean instanceof \SugarBean) {
            throw new \InvalidArgumentException(sprintf('Module %s does not exist', $module));
        }

        return $bean;
    }

    /**
     * @param string $module
     * @param string|null $id
     * @param array $params
     * @param boolean $deleted
     *
     * @return \SugarBean|boolean
     */
    public function getBean($module, $id = null, array $params = [], $deleted = true)
    {
        return \BeanFactory::getBean($module, $id, $params, $deleted);
    }

    /**
     * @param string $module
     * @param string $id
     * @param array $params
     * @param bool $deleted
     *
     * @return \SugarBean
     * @throws \DomainException When bean id is empty or bean is not found by name.
     * @throws \InvalidArgumentException When bean is not found with the given id.
     */
    public function getBeanSafe(
        $module,
        $id,
        array $params = [],
        $deleted = true
    ) {
        if (empty($id)) {
            throw new \DomainException('Module id is empty when trying to fetch ' . $module);
        }

        $objectName = \BeanFactory::getObjectName($module);
        if (!$objectName && array_key_exists($module, $this->beanAliases)) {
            $objectName = \BeanFactory::getObjectName($this->beanAliases[$module]);
            $module = $this->beanAliases[$module];
        }

        if (!$objectName) {
            throw new \DomainException(sprintf('Module with name %s is not found', $module));
        }

        $bean = $this->getBean($module, $id, $params, $deleted);
        if ($bean === false) {
            throw new \InvalidArgumentException(
                sprintf('%s module with id %s is not found', $module, $id)
            );
        }

        return $bean;
    }

    /**
     * @param string $module
     *
     * @return \SugarBean
     */
    public function findBean($module)
    {
        if (array_key_exists($module, $this->beanAliases)) {
            $module = $this->beanAliases[$module];
        }

        $bean = $this->newBeanSafe($module);

        return $bean;
    }
}
