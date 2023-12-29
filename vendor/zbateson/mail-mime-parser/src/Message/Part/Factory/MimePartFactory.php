<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Part\Factory;

use Psr\Http\Message\StreamInterface;
use ZBateson\MailMimeParser\Stream\StreamFactory;
use ZBateson\MailMimeParser\Message\PartFilterFactory;
use ZBateson\MailMimeParser\Message\Part\MimePart;
use ZBateson\MailMimeParser\Message\Part\PartBuilder;

/**
 * Responsible for creating MimePart instances.
 *
 * @author Zaahid Bateson
 */
class MimePartFactory extends MessagePartFactory
{
    /**
     * @var PartFilterFactory an instance used for creating MimePart objects
     */
    protected $partFilterFactory;

    /**
     * Initializes dependencies.
     *
     * @param StreamFactory $sdf
     * @param PartStreamFilterManagerFactory $psf
     * @param PartFilterFactory $pf
     */
    public function __construct(
        StreamFactory $sdf,
        PartStreamFilterManagerFactory $psf,
        PartFilterFactory $pf
    ) {
        parent::__construct($sdf, $psf);
        $this->partFilterFactory = $pf;
    }

    /**
     * Constructs a new MimePart object and returns it
     * 
     * @param PartBuilder $partBuilder
     * @param StreamInterface $messageStream
     * @return \ZBateson\MailMimeParser\Message\Part\MimePart
     */
    public function newInstance(PartBuilder $partBuilder, StreamInterface $messageStream = null)
    {
        $partStream = null;
        $contentStream = null;
        if ($messageStream !== null) {
            $partStream = $this->streamFactory->getLimitedPartStream($messageStream, $partBuilder);
            $contentStream = $this->streamFactory->getLimitedContentStream($messageStream, $partBuilder);
        }
        return new MimePart(
            $this->partStreamFilterManagerFactory->newInstance(),
            $this->streamFactory,
            $this->partFilterFactory,
            $partBuilder,
            $partStream,
            $contentStream
        );
    }
}
