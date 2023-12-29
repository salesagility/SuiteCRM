<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header;

use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;

/**
 * Reads the header using GenericConsumer.
 * 
 * Header's may contain mime-encoded parts, quoted parts, and comments.
 * GenericConsumer returns a single part value.
 *
 * @author Zaahid Bateson
 */
class GenericHeader extends AbstractHeader
{
    /**
     * Returns a GenericConsumer.
     * 
     * @param ConsumerService $consumerService
     * @return \ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer
     */
    protected function getConsumer(ConsumerService $consumerService)
    {
        return $consumerService->getGenericConsumer();
    }
}
