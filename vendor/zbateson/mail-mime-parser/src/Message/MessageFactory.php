<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message;

use Psr\Http\Message\StreamInterface;
use ZBateson\MailMimeParser\Message;
use ZBateson\MailMimeParser\Message\Helper\MessageHelperService;
use ZBateson\MailMimeParser\Message\Part\PartBuilder;
use ZBateson\MailMimeParser\Message\Part\Factory\MimePartFactory;
use ZBateson\MailMimeParser\Message\Part\Factory\PartStreamFilterManagerFactory;
use ZBateson\MailMimeParser\Message\PartFilterFactory;
use ZBateson\MailMimeParser\Stream\StreamFactory;

/**
 * Responsible for creating Message instances.
 *
 * @author Zaahid Bateson
 */
class MessageFactory extends MimePartFactory
{
    /**
     * @var MessageHelperService helper class for message manipulation routines.
     */
    protected $messageHelperService;

    /**
     * Constructor
     * 
     * @param StreamFactory $sdf
     * @param PartStreamFilterManagerFactory $psf
     * @param PartFilterFactory $pf
     * @param MessageHelperService $mhs
     */
    public function __construct(
        StreamFactory $sdf,
        PartStreamFilterManagerFactory $psf,
        PartFilterFactory $pf,
        MessageHelperService $mhs
    ) {
        parent::__construct($sdf, $psf, $pf);
        $this->messageHelperService = $mhs;
    }

    /**
     * Constructs a new Message object and returns it
     *
     * @param PartBuilder $partBuilder
     * @param StreamInterface $stream
     * @return \ZBateson\MailMimeParser\Message\Part\MimePart
     */
    public function newInstance(PartBuilder $partBuilder, StreamInterface $stream = null)
    {
        $contentStream = null;
        if ($stream !== null) {
            $contentStream = $this->streamFactory->getLimitedContentStream($stream, $partBuilder);
        }
        return new Message(
            $this->partStreamFilterManagerFactory->newInstance(),
            $this->streamFactory,
            $this->partFilterFactory,
            $partBuilder,
            $this->messageHelperService,
            $stream,
            $contentStream
        );
    }
}
