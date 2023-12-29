<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Helper;

use ZBateson\MailMimeParser\Message\Part\Factory\MimePartFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\PartBuilderFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\UUEncodedPartFactory;

/**
 * Base class for message helpers.
 *
 * @author Zaahid Bateson
 */
abstract class AbstractHelper
{
    /**
     * @var MimePartFactory to create parts for attachments/content
     */
    protected $mimePartFactory;

    /**
     * @var UUEncodedPartFactory to create parts for attachments
     */
    protected $uuEncodedPartFactory;

    /**
     * @var PartBuilderFactory to create parts for attachments/content
     */
    protected $partBuilderFactory;

    /**
     * Constructor
     * 
     * @param MimePartFactory $mimePartFactory
     * @param UUEncodedPartFactory $uuEncodedPartFactory
     * @param PartBuilderFactory $partBuilderFactory
     */
    public function __construct(
        MimePartFactory $mimePartFactory,
        UUEncodedPartFactory $uuEncodedPartFactory,
        PartBuilderFactory $partBuilderFactory
    ) {
        $this->mimePartFactory = $mimePartFactory;
        $this->uuEncodedPartFactory = $uuEncodedPartFactory;
        $this->partBuilderFactory = $partBuilderFactory;
    }
}
