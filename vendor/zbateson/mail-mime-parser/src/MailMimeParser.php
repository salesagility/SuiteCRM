<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser;

use GuzzleHttp\Psr7;

/**
 * Parses a MIME message into a \ZBateson\MailMimeParser\Message object.
 *
 * To invoke, call parse on a MailMimeParser object.
 * 
 * $handle = fopen('path/to/file.txt');
 * $parser = new MailMimeParser();
 * $parser->parse($handle);
 * fclose($handle);
 * 
 * @author Zaahid Bateson
 */
class MailMimeParser
{
    /**
     * @var string the default charset used to encode strings (or string content
     *      like streams) returned by MailMimeParser (for e.g. the string
     *      returned by calling $message->getTextContent()).
     */
    const DEFAULT_CHARSET = 'UTF-8';

    /**
     * @var \ZBateson\MailMimeParser\Container dependency injection container
     */
    protected $di;
    
    /**
     * Sets up the parser.
     *
     * @param Container $di pass a Container object to use it for
     *        initialization.
     */
    public function __construct(Container $di = null)
    {
        if ($di === null) {
            $di = new Container();
        }
        $this->di = $di;
    }

    /**
     * Parses the passed stream handle into a ZBateson\MailMimeParser\Message
     * object and returns it.
     * 
     * Internally, the message is first copied to a temp stream (with php://temp
     * which may keep it in memory or write it to disk) and its stream is used.
     * That way if the message is too large to hold in memory it can be written
     * to a temporary file if need be.
     * 
     * @param resource|string $handleOrString the resource handle to the input
     *        stream of the mime message, or a string containing a mime message
     * @return \ZBateson\MailMimeParser\Message
     */
    public function parse($handleOrString)
    {
        $stream = Psr7\Utils::streamFor($handleOrString);
        $copy = Psr7\Utils::streamFor(fopen('php://temp', 'r+'));

        Psr7\Utils::copyToStream($stream, $copy);
        $copy->rewind();

        // don't close it when $stream gets destroyed
        $stream->detach();
        $parser = $this->di->newMessageParser();
        return $parser->parse($copy);
    }
}
