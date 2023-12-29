<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header;

use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;

/**
 * Represents a Content-ID, Message-ID, In-Reply-To or References header.
 *
 * For a multi-id header like In-Reply-To or References, all IDs can be
 * retrieved by calling ``` getIds() ```.  Otherwise, to retrieve the first (or
 * only) ID call ``` getValue() ```.
 * 
 * @author Zaahid Bateson
 */
class IdHeader extends MimeEncodedHeader
{
    /**
     * Returns an IdBaseConsumer.
     *
     * @param ConsumerService $consumerService
     * @return \ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer
     */
    protected function getConsumer(ConsumerService $consumerService)
    {
        return $consumerService->getIdBaseConsumer();
    }

    /**
     * Synonym for getValue().
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getValue();
    }

    /**
     * Returns all IDs parsed for a multi-id header like References or
     * In-Reply-To.
     * 
     * @return string[]
     */
    public function getIds()
    {
        return $this->parts;
    }
}
