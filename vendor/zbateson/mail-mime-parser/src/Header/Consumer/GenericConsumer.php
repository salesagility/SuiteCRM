<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

use ZBateson\MailMimeParser\Header\Part\HeaderPart;
use ZBateson\MailMimeParser\Header\Part\Token;

/**
 * A minimal implementation of AbstractConsumer defining a CommentConsumer and
 * QuotedStringConsumer as sub-consumers, and splitting tokens by whitespace.
 *
 * Note that GenericConsumer should be instantiated with a
 * MimeLiteralPartFactory instead of a HeaderPartFactory.  Sub-classes may not
 * need MimeLiteralPartFactory instances though.
 * 
 * @author Zaahid Bateson
 */
class GenericConsumer extends AbstractConsumer
{
    /**
     * Returns \ZBateson\MailMimeParser\Header\Consumer\CommentConsumer and
     * \ZBateson\MailMimeParser\Header\Consumer\QuotedStringConsumer as
     * sub-consumers.
     * 
     * @return AbstractConsumer[] the sub-consumers
     */
    protected function getSubConsumers()
    {
        return [
            $this->consumerService->getCommentConsumer(),
            $this->consumerService->getQuotedStringConsumer(),
        ];
    }
    
    /**
     * Returns the regex '\s+' (whitespace) pattern matcher as a token marker so
     * the header value is split along whitespace characters.  GenericConsumer
     * filters out whitespace-only tokens from getPartForToken.
     * 
     * The whitespace character delimits mime-encoded parts for decoding.
     * 
     * @return string[] an array of regex pattern matchers
     */
    protected function getTokenSeparators()
    {
        return ['\s+'];
    }
    
    /**
     * GenericConsumer doesn't have start/end tokens, and so always returns
     * false.
     * 
     * @param string $token
     * @return boolean false
     */
    protected function isEndToken($token)
    {
        return false;
    }
    
    /**
     * GenericConsumer doesn't have start/end tokens, and so always returns
     * false.
     * 
     * @codeCoverageIgnore
     * @param string $token
     * @return boolean false
     */
    protected function isStartToken($token)
    {
        return false;
    }
    
    /**
     * Returns true if a space should be added based on the passed last and next
     * parts.
     * 
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart $nextPart
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart $lastPart
     * @return bool
     */
    private function shouldAddSpace(HeaderPart $nextPart, HeaderPart $lastPart)
    {
        return (!$lastPart->ignoreSpacesAfter() || !$nextPart->ignoreSpacesBefore());
    }
    
    /**
     * Loops over the $parts array from the current position, checks if the
     * space should be added, then adds it to $retParts and returns.
     * 
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $retParts
     * @param int $curIndex
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart $spacePart
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart $lastPart
     */
    private function addSpaceToRetParts(
        array $parts,
        array &$retParts,
        $curIndex,
        HeaderPart &$spacePart,
        HeaderPart $lastPart
    ) {
        $nextPart = $parts[$curIndex];
        if ($this->shouldAddSpace($nextPart, $lastPart)) {
            $retParts[] = $spacePart;
            $spacePart = null;
        }
    }
    
    /**
     * Checks if the passed space part should be added to the returned parts and
     * adds it.
     * 
     * Never adds a space if it's the first part, otherwise only add it if
     * either part isn't set to ignore the space
     * 
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $retParts
     * @param int $curIndex
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart $spacePart
     */
    private function addSpaces(array $parts, array &$retParts, $curIndex, HeaderPart &$spacePart = null)
    {
        $lastPart = end($retParts);
        if ($spacePart !== null && $curIndex < count($parts) && $parts[$curIndex]->getValue() !== '' && $lastPart !== false) {
            $this->addSpaceToRetParts($parts, $retParts, $curIndex, $spacePart, $lastPart);
        }
    }
    
    /**
     * Returns true if the passed HeaderPart is a Token instance and a space.
     * 
     * @param HeaderPart $part
     * @return bool
     */
    private function isSpaceToken(HeaderPart $part)
    {
        return ($part instanceof Token && $part->isSpace());
    }
    
    /**
     * Filters out ignorable spaces between parts in the passed array.
     * 
     * Spaces with parts on either side of it that specify they can be ignored
     * are filtered out.  filterIgnoredSpaces is called from within
     * processParts, and if needed by an implementing class that overrides
     * processParts, must be specifically called.
     * 
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[]
     */
    protected function filterIgnoredSpaces(array $parts)
    {
        $partsFiltered = array_values(array_filter($parts));
        $retParts = [];
        $spacePart = null;
        $count = count($partsFiltered);
        for ($i = 0; $i < $count; ++$i) {
            $part = $partsFiltered[$i];
            if ($this->isSpaceToken($part)) {
                $spacePart = $part;
                continue;
            }
            $this->addSpaces($partsFiltered, $retParts, $i, $spacePart);
            $retParts[] = $part;
        }
        // ignore trailing spaces
        return $retParts;
    }
    
    /**
     * Overridden to combine all part values into a single string and return it
     * as an array with a single element.
     * 
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @return \ZBateson\MailMimeParser\Header\Part\LiteralPart[]|array
     */
    protected function processParts(array $parts)
    {
        $strValue = '';
        $filtered = $this->filterIgnoredSpaces($parts);
        foreach ($filtered as $part) {
            $strValue .= $part->getValue();
        }
        return [$this->partFactory->newLiteralPart($strValue)];
    }
}
