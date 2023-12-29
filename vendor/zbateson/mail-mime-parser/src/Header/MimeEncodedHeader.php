<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header;

use ZBateson\MailMimeParser\Header\Consumer\AbstractConsumer;
use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;
use ZBateson\MailMimeParser\Header\Part\MimeLiteralPart;
use ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory;

/**
 * Allows a header to be mime-encoded and be decoded with a consumer after
 * decoding.
 *
 * The entire header's value must only consist of mime-encoded parts for this to
 * apply.
 * 
 * @author Zaahid Bateson
 */
abstract class MimeEncodedHeader extends AbstractHeader
{
    /**
     * @var \ZBateson\MailMimeParser\Header\Part\MimeLiteralPartFactory for
     * mime decoding.
     */
    protected $mimeLiteralPartFactory;

    /**
     * Includes
     *
     * @param ConsumerService $consumerService
     * @param string $name
     * @param string $value
     */
    public function __construct(
        MimeLiteralPartFactory $mimeLiteralPartFactory,
        ConsumerService $consumerService,
        $name,
        $value
    ) {
        $this->mimeLiteralPartFactory = $mimeLiteralPartFactory;
        parent::__construct($consumerService, $name, $value);
    }

    /**
     * Mime-decodes the raw value if the whole raw value only consists of mime-
     * encoded parts and whitespace prior to invoking the passed consumer.
     *
     * @param AbstractConsumer $consumer
     */
    protected function setParseHeaderValue(AbstractConsumer $consumer)
    {
        $value = $this->rawValue;
        $matchp = '~^(\s*' . MimeLiteralPart::MIME_PART_PATTERN . '\s*)+$~';
        if (preg_match($matchp, $value)) {
            $p = $this->mimeLiteralPartFactory->newInstance($value);
            $value = $p->getValue();
        }
        $this->parts = $consumer($value);
    }
}
