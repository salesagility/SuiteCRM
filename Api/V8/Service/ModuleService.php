<?php
namespace Api\V8\Service;

use Api\V8\BeanManager;
use Api\V8\Params\ModuleParams;
use Api\V8\Response\ModuleResponse;

class ModuleService
{
    /**
     * @var BeanManager
     */
    private $beanManager;

    /**
     * @param BeanManager $beanManager
     */
    public function __construct(BeanManager $beanManager)
    {
        $this->beanManager = $beanManager;
    }

    /**
     * @param ModuleParams $params
     *
     * @return ModuleResponse
     */
    public function getRecords(ModuleParams $params)
    {
        $bean = $this->beanManager->getBeanSafe(
            $params->getModule(),
            $params->getRecordId()
        );

        $moduleResponse = new ModuleResponse();
        $moduleResponse->setName($bean->name);
        $moduleResponse->setDateEntered($bean->date_entered);
        $moduleResponse->setDateModified($bean->date_modified);
        $moduleResponse->setDescription($bean->description);

        return $moduleResponse;
    }
}
