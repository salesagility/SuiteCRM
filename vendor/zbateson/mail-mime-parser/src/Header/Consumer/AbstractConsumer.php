<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

use ZBateson\MailMimeParser\Header\Consumer\ConsumerService;
use ZBateson\MailMimeParser\Header\Part\HeaderPartFactory;
use ZBateson\MailMimeParser\Header\Part\MimeLiteralPart;
use ArrayIterator;
use Iterator;
use NoRewindIterator;

/**
 * Abstract base class for all header token consumers.
 *
 * Defines the base parser that loops over tokens, consuming them and creating
 * header parts.
 *
 * @author Zaahid Bateson
 */
abstract class AbstractConsumer
{
    /**
     * @var \ZBateson\MailMimeParser\Header\Consumer\ConsumerService used to
     *      get consumer instances for sub-consumers
     */
    protected $consumerService;

    /**
     * @var \ZBateson\MailMimeParser\Header\Part\HeaderPartFactory used to construct
     * HeaderPart objects
     */
    protected $partFactory;

    /**
     * Initializes the instance.
     *
     * @param ConsumerService $consumerService
     * @param HeaderPartFactory $partFactory
     */
    public function __construct(ConsumerService $consumerService, HeaderPartFactory $partFactory)
    {
        $this->consumerService = $consumerService;
        $this->partFactory = $partFactory;
    }

    /**
     * Returns the singleton instance for the class.
     *
     * @param ConsumerService $consumerService
     * @param HeaderPartFactory $partFactory
     */
    public static function getInstance(ConsumerService $consumerService, HeaderPartFactory $partFactory)
    {
        static $instances = [];
        $class = get_called_class();
        if (!isset($instances[$class])) {
            $instances[$class] = new static($consumerService, $partFactory);
        }
        return $instances[$class];
    }

    /**
     * Invokes parsing of a header's value into header parts.
     *
     * @param string $value the raw header value
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[] the array of parsed
     *         parts
     */
    public function __invoke($value)
    {
        if ($value !== '') {
            return $this->parseRawValue($value);
        }
        return [];
    }

    /**
     * Called during construction to set up the list of sub-consumers that will
     * take control from this consumer should a token match a sub-consumer's
     * start token.
     *
     * @return AbstractConsumer[] the array of consumers
     */
    abstract protected function getSubConsumers();

    /**
     * Returns this consumer and all unique sub consumers.
     *
     * Loops into the sub-consumers (and their sub-consumers, etc...) finding
     * all unique consumers, and returns them in an array.
     *
     * @return \ZBateson\MailMimeParser\Header\AbstractConsumer[]
     */
    protected function getAllConsumers()
    {
        $found = [$this];
        do {
            $current = current($found);
            $subConsumers = $current->getSubConsumers();
            foreach ($subConsumers as $consumer) {
                if (!in_array($consumer, $found)) {
                    $found[] = $consumer;
                }
            }
        } while (next($found) !== false);
        return $found;
    }

    /**
     * Called by __invoke to parse the raw header value into header parts.
     *
     * Calls splitTokens to split the value into token part strings, then calls
     * parseParts to parse the returned array.
     *
     * @param string $value
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[] the array of parsed
     *         parts
     */
    private function parseRawValue($value)
    {
        $tokens = $this->splitRawValue($value);
        return $this->parseTokensIntoParts(new NoRewindIterator(new ArrayIterator($tokens)));
    }

    /**
     * Returns an array of regular expression separators specific to this
     * consumer.  The returned patterns are used to split the header value into
     * tokens for the consumer to parse into parts.
     *
     * Each array element makes part of a generated regular expression that is
     * used in a call to preg_split().  RegEx patterns can be used, and care
     * should be taken to escape special characters.
     *
     * @return string[] the array of patterns
     */
    abstract protected function getTokenSeparators();

    /**
     * Returns a list of regular expression markers for this consumer and all
     * sub-consumers by calling 'getTokenSeparators'..
     *
     * @return string[] an array of regular expression markers
     */
    protected function getAllTokenSeparators()
    {
        $markers = $this->getTokenSeparators();
        $subConsumers = $this->getAllConsumers();
        foreach ($subConsumers as $consumer) {
            $markers = array_merge($consumer->getTokenSeparators(), $markers);
        }
        return array_unique($markers);
    }

    /**
     * Returns a regex pattern used to split the input header string.  The
     * default implementation calls getAllTokenSeparators and implodes the
     * returned array with the regex OR '|' character as its glue.
     *
     * @return string the regex pattern
     */
    protected function getTokenSplitPattern()
    {
        $sChars = implode('|', $this->getAllTokenSeparators());
        $mimePartPattern = MimeLiteralPart::MIME_PART_PATTERN;
        return '~(' . $mimePartPattern . '|\\\\.|' . $sChars . ')~';
    }

    /**
     * Returns an array of split tokens from the input string.
     *
     * The method calls preg_split using getTokenSplitPattern.  The split
     * array will not contain any empty parts and will contain the markers.
     *
     * @param string $rawValue the raw string
     * @return array the array of tokens
     */
    protected function splitRawValue($rawValue)
    {
        return preg_split(
            $this->getTokenSplitPattern(),
            $rawValue,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
    }

    /**
     * Returns true if the passed string token marks the beginning marker for
     * the current consumer.
     *
     * @param string $token the current token
     * @return bool
     */
    abstract protected function isStartToken($token);

    /**
     * Returns true if the passed string token marks the end marker for the
     * current consumer.
     *
     * @param string $token the current token
     * @return bool
     */
    abstract protected function isEndToken($token);

    /**
     * Constructs and returns a \ZBateson\MailMimeParser\Header\Part\HeaderPart
     * for the passed string token.  If the token should be ignored, the
     * function must return null.
     *
     * The default created part uses the instance's partFactory->newInstance
     * method.
     *
     * @param string $token the token
     * @param bool $isLiteral set to true if the token represents a literal -
     *        e.g. an escaped token
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart|null the
     *         constructed header part or null if the token should be ignored
     */
    protected function getPartForToken($token, $isLiteral)
    {
        if ($isLiteral) {
            return $this->partFactory->newLiteralPart($token);
        } elseif (preg_match('/^\s+$/', $token)) {
            return $this->partFactory->newToken(' ');
        }
        return $this->partFactory->newInstance($token);
    }

    /**
     * Iterates through this consumer's sub-consumers checking if the current
     * token triggers a sub-consumer's start token and passes control onto that
     * sub-consumer's parseTokenIntoParts.  If no sub-consumer is responsible
     * for the current token, calls getPartForToken and returns it in an array.
     *
     * @param Iterator $tokens
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[]|array
     */
    protected function getConsumerTokenParts(Iterator $tokens)
    {
        $token = $tokens->current();
        $subConsumers = $this->getSubConsumers();
        foreach ($subConsumers as $consumer) {
            if ($consumer->isStartToken($token)) {
                $this->advanceToNextToken($tokens, true);
                return $consumer->parseTokensIntoParts($tokens);
            }
        }
        return [$this->getPartForToken($token, false)];
    }

    /**
     * Returns an array of \ZBateson\MailMimeParser\Header\Part\HeaderPart for
     * the current token on the iterator.
     *
     * If the current token is a start token from a sub-consumer, the sub-
     * consumer's parseTokensIntoParts method is called.
     *
     * @param Iterator $tokens
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[]|array
     */
    protected function getTokenParts(Iterator $tokens)
    {
        $token = $tokens->current();
        if (strlen($token) === 2 && $token[0] === '\\') {
            return [$this->getPartForToken(substr($token, 1), true)];
        }
        return $this->getConsumerTokenParts($tokens);
    }

    /**
     * Determines if the iterator should be advanced to the next token after
     * reading tokens or finding a start token.
     *
     * The default implementation will advance for a start token, but not
     * advance on the end token of the current consumer, allowing the end token
     * to be passed up to a higher-level consumer.
     *
     * @param Iterator $tokens
     * @param bool $isStartToken
     */
    protected function advanceToNextToken(Iterator $tokens, $isStartToken)
    {
        if (($isStartToken) || ($tokens->valid() && !$this->isEndToken($tokens->current()))) {
            $tokens->next();
        }
    }

    /**
     * Iterates over the passed token Iterator and returns an array of parsed
     * \ZBateson\MailMimeParser\Header\Part\HeaderPart objects.
     *
     * The method checks each token to see if the token matches a sub-consumer's
     * start token, or if it matches the current consumer's end token to stop
     * processing.
     *
     * If a sub-consumer's start token is matched, the sub-consumer is invoked
     * and its returned parts are merged to the current consumer's header parts.
     *
     * After all tokens are read and an array of Header\Parts are constructed,
     * the array is passed to AbstractConsumer::processParts for any final
     * processing.
     *
     * @param Iterator $tokens an iterator over a string of tokens
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[] an array of
     *         parsed parts
     */
    protected function parseTokensIntoParts(Iterator $tokens)
    {
        $parts = [];
        while ($tokens->valid() && !$this->isEndToken($tokens->current())) {
            $parts = array_merge($parts, $this->getTokenParts($tokens));
            $this->advanceToNextToken($tokens, false);
        }
        return $this->processParts($parts);
    }

    /**
     * Performs any final processing on the array of parsed parts before
     * returning it to the consumer client.
     *
     * The default implementation simply returns the passed array after
     * filtering out null/empty parts.
     *
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[]
     */
    protected function processParts(array $parts)
    {
        return array_values(array_filter($parts));
    }
}
