<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Helper;

use ZBateson\MailMimeParser\Message\Part\Factory\PartBuilderFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\PartFactoryService;

/**
 * Responsible for creating helper singletons.
 *
 * @author Zaahid Bateson
 */
class MessageHelperService
{
    /**
     * @var PartBuilderFactory the PartBuilderFactory
     */
    private $partBuilderFactory;

    /**
     * @var GenericHelper the GenericHelper singleton
     */
    private $genericHelper;

    /**
     * @var MultipartHelper the MultipartHelper singleton
     */
    private $multipartHelper;

    /**
     * @var PrivacyHelper the PrivacyHelper singleton
     */
    private $privacyHelper;

    /**
     * @var PartFactoryService the PartFactoryService
     */
    private $partFactoryService;

    /**
     * Constructor
     *
     * @param PartBuilderFactory $partBuilderFactory
     */
    public function __construct(PartBuilderFactory $partBuilderFactory)
    {
        $this->partBuilderFactory = $partBuilderFactory;
    }

    /**
     * Set separately to avoid circular dependencies (PartFactoryService needs a
     * MessageHelperService).
     *
     * @param PartFactoryService $partFactoryService
     */
    public function setPartFactoryService(PartFactoryService $partFactoryService)
    {
        $this->partFactoryService = $partFactoryService;
    }

    /**
     * Returns the GenericHelper singleton
     * 
     * @return GenericHelper
     */
    public function getGenericHelper()
    {
        if ($this->genericHelper === null) {
            $this->genericHelper = new GenericHelper(
                $this->partFactoryService->getMimePartFactory(),
                $this->partFactoryService->getUUEncodedPartFactory(),
                $this->partBuilderFactory
            );
        }
        return $this->genericHelper;
    }

    /**
     * Returns the MultipartHelper singleton
     *
     * @return MultipartHelper
     */
    public function getMultipartHelper()
    {
        if ($this->multipartHelper === null) {
            $this->multipartHelper = new MultipartHelper(
                $this->partFactoryService->getMimePartFactory(),
                $this->partFactoryService->getUUEncodedPartFactory(),
                $this->partBuilderFactory,
                $this->getGenericHelper()
            );
        }
        return $this->multipartHelper;
    }

    /**
     * Returns the PrivacyHelper singleton
     *
     * @return PrivacyHelper
     */
    public function getPrivacyHelper()
    {
        if ($this->privacyHelper === null) {
            $this->privacyHelper = new PrivacyHelper(
                $this->partFactoryService->getMimePartFactory(),
                $this->partFactoryService->getUUEncodedPartFactory(),
                $this->partBuilderFactory,
                $this->getGenericHelper(),
                $this->getMultipartHelper()
            );
        }
        return $this->privacyHelper;
    }
}
