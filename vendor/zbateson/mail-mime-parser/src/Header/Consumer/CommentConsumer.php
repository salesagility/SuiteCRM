<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Consumer;

use ZBateson\MailMimeParser\Header\Part\LiteralPart;
use ZBateson\MailMimeParser\Header\Part\CommentPart;
use Iterator;

/**
 * Consumes all tokens within parentheses as comments.
 * 
 * Parenthetical comments in mime-headers can be nested within one
 * another.  The outer-level continues after an inner-comment ends.
 * Additionally, quoted-literals may exist with comments as well meaning
 * a parenthesis inside a quoted string would not begin or end a comment
 * section.
 * 
 * In order to satisfy these specifications, CommentConsumer inherits
 * from GenericConsumer which defines CommentConsumer and
 * QuotedStringConsumer as sub-consumers.
 * 
 * Examples:
 * X-Mime-Header: Some value (comment)
 * X-Mime-Header: Some value (comment (nested comment) still in comment)
 * X-Mime-Header: Some value (comment "and part of original ) comment" -
 *      still a comment)
 *
 * @author Zaahid Bateson
 */
class CommentConsumer extends GenericConsumer
{
    /**
     * Returns patterns matching open and close parenthesis characters
     * as separators.
     * 
     * @return string[] the patterns
     */
    protected function getTokenSeparators()
    {
        return ['\(', '\)'];
    }
    
    /**
     * Returns true if the token is an open parenthesis character, '('.
     * 
     * @param string $token
     * @return bool
     */
    protected function isStartToken($token)
    {
        return ($token === '(');
    }
    
    /**
     * Returns true if the token is a close parenthesis character, ')'.
     * 
     * @param string $token
     * @return bool
     */
    protected function isEndToken($token)
    {
        return ($token === ')');
    }
    
    /**
     * Instantiates and returns Part\Token objects.  Tokens from this
     * and sub-consumers are combined into a Part\CommentPart in
     * combineParts.
     * 
     * @param string $token
     * @param bool $isLiteral
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart
     */
    protected function getPartForToken($token, $isLiteral)
    {
        return $this->partFactory->newToken($token);
    }
    
    /**
     * Calls $tokens->next() and returns.
     * 
     * The default implementation checks if the current token is an end token,
     * and will not advance past it.  Because a comment part of a header can be
     * nested, its implementation must advance past its own 'end' token.
     * 
     * @param Iterator $tokens
     * @param bool $isStartToken
     */
    protected function advanceToNextToken(Iterator $tokens, $isStartToken)
    {
        $tokens->next();
    }
    
    /**
     * Post processing involves creating a single Part\CommentPart out of
     * generated parts from tokens.  The Part\CommentPart is returned in an
     * array.
     * 
     * @param \ZBateson\MailMimeParser\Header\Part\HeaderPart[] $parts
     * @return \ZBateson\MailMimeParser\Header\Part\HeaderPart[]|array
     */
    protected function processParts(array $parts)
    {
        $comment = '';
        foreach ($parts as $part) {
            // order is important here - CommentPart extends LiteralPart
            if ($part instanceof CommentPart) {
                $comment .= '(' . $part->getComment() . ')';
            } elseif ($part instanceof LiteralPart) {
                $comment .= '"' . $part->getValue() . '"';
            } else {
                $comment .= $part->getValue();
            }
        }
        return [$this->partFactory->newCommentPart($comment)];
    }
}
