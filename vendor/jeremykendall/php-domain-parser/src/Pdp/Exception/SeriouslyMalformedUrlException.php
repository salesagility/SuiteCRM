<?php

/**
 * PHP Domain Parser: Public Suffix List based URL parsing.
 *
 * @link      http://github.com/jeremykendall/php-domain-parser for the canonical source repository
 *
 * @copyright Copyright (c) 2014 Jeremy Kendall (http://about.me/jeremykendall)
 * @license   http://github.com/jeremykendall/php-domain-parser/blob/master/LICENSE MIT License
 */
namespace Pdp\Exception;

/**
 * Should be thrown when pdp_parse_url() return false.
 *
 * Exception name based on the PHP documentation: "On seriously malformed URLs, 
 * parse_url() may return FALSE."
 *
 * @see http://php.net/parse_url
 */
class SeriouslyMalformedUrlException extends \InvalidArgumentException implements PdpException
{
    /**
     * Public constructor.
     *
     * @param string     $malformedUrl URL that caused pdp_parse_url() to return false
     * @param int        $code         The Exception code
     * @param \Exception $previous     The previous exception used for the exception chaining
     */
    public function __construct($malformedUrl = '', $code = 0, $previous = null)
    {
        $message = sprintf('"%s" is one seriously malformed url.', $malformedUrl);
        parent::__construct($message, $code, $previous);
    }
}
