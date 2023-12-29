<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message;

use ZBateson\MailMimeParser\Message\Part\MessagePart;
use ZBateson\MailMimeParser\Message\Part\MimePart;
use InvalidArgumentException;

/**
 * Provides a way to define a filter of MessagePart for use in various calls to
 * add/remove MessagePart.
 * 
 * A PartFilter is defined as a set of properties in the class, set to either be
 * 'included' or 'excluded'.  The filter is simplistic in that a property
 * defined as included must be set on a part for it to be passed, and an
 * excluded filter must not be set for the part to be passed.  There is no
 * provision for creating logical conditions.
 * 
 * The only property set by default is $signedpart, which defaults to
 * FILTER_EXCLUDE.
 * 
 * A PartFilter can be instantiated with an array of keys matching class
 * properties, and values to set them for convenience.
 * 
 * ```php
 * $inlineParts = $message->getAllParts(new PartFilter([
 *     'multipart' => PartFilter::FILTER_INCLUDE,
 *     'headers' => [ 
 *         FILTER_EXCLUDE => [
 *             'Content-Disposition': 'attachment'
 *         ]
 *     ]
 * ]));
 * 
 * $inlineTextPart = $message->getAllParts(PartFilter::fromInlineContentType('text/plain'));
 * ```
 *
 * @author Zaahid Bateson
 */
class PartFilter
{
    /**
     * @var int indicates a filter is not in use
     */
    const FILTER_OFF = 0;
    
    /**
     * @var int an excluded filter must not be included in a part
     */
    const FILTER_EXCLUDE = 1;
    
    /**
     * @var int an included filter must be included in a part
     */
    const FILTER_INCLUDE = 2;

    /**
     * @var int filters based on whether MessagePart::hasContent is true
     */
    private $hascontent = PartFilter::FILTER_OFF;

    /**
     * @var int filters based on whether MimePart::isMultiPart is true
     */
    private $multipart = PartFilter::FILTER_OFF;
    
    /**
     * @var int filters based on whether MessagePart::isTextPart is true
     */
    private $textpart = PartFilter::FILTER_OFF;
    
    /**
     * @var int filters based on whether the parent of a part is a
     *      multipart/signed part and this part has a content-type equal to its
     *      parent's 'protocol' parameter in its content-type header
     */
    private $signedpart = PartFilter::FILTER_EXCLUDE;
    
    /**
     * @var string calculated hash of the filter
     */
    private $hashCode;
    
    /**
     * @var string[][] array of header rules.  The top-level contains keys of
     * FILTER_INCLUDE and/or FILTER_EXCLUDE, which contain key => value mapping
     * of header names => values to search for.  Note that when searching
     * MimePart::getHeaderValue is used (so additional parameters need not be
     * matched) and strcasecmp is used.
     * 
     * ```php
     * $filter = new PartFilter();
     * $filter->headers = [ PartFilter::FILTER_INCLUDE => [ 'Content-Type' => 'text/plain' ] ];
     * ```
     */
    private $headers = [];
    
    /**
     * Convenience method to filter for a specific mime type.
     * 
     * @param string $mimeType
     * @return PartFilter
     */
    public static function fromContentType($mimeType)
    {
        return new static([
            'headers' => [
                static::FILTER_INCLUDE => [
                    'Content-Type' => $mimeType
                ]
            ]
        ]);
    }
    
    /**
     * Convenience method to look for parts of a specific mime-type, and that
     * do not specifically have a Content-Disposition equal to 'attachment'.
     * 
     * @param string $mimeType
     * @return PartFilter
     */
    public static function fromInlineContentType($mimeType)
    {
        return new static([
            'headers' => [
                static::FILTER_INCLUDE => [
                    'Content-Type' => $mimeType
                ],
                static::FILTER_EXCLUDE => [
                    'Content-Disposition' => 'attachment'
                ]
            ]
        ]);
    }
    
    /**
     * Convenience method to search for parts with a specific
     * Content-Disposition, optionally including multipart parts.
     * 
     * @param string $disposition
     * @param int $multipart
     * @return PartFilter
     */
    public static function fromDisposition($disposition, $multipart = PartFilter::FILTER_OFF)
    {
        return new static([
            'multipart' => $multipart,
            'headers' => [
                static::FILTER_INCLUDE => [
                    'Content-Disposition' => $disposition
                ]
            ]
        ]);
    }
    
    /**
     * Constructs a PartFilter, optionally instantiating member variables with
     * values in the passed array.
     * 
     * The passed array must use keys equal to member variable names, e.g.
     * 'multipart', 'textpart', 'signedpart' and 'headers'.
     * 
     * @param array $filter
     */
    public function __construct(array $filter = [])
    {
        $params = [ 'hascontent', 'multipart', 'textpart', 'signedpart', 'headers' ];
        foreach ($params as $param) {
            if (isset($filter[$param])) {
                $this->__set($param, $filter[$param]);
            }
        }
    }
    
    /**
     * Validates an argument passed to __set to insure it's set to a value in
     * $valid.
     * 
     * @param string $name Name of the member variable
     * @param string $value The value to test
     * @param array $valid an array of valid values
     * @throws InvalidArgumentException
     */
    private function validateArgument($name, $value, array $valid)
    {
        if (!in_array($value, $valid)) {
            $last = array_pop($valid);
            throw new InvalidArgumentException(
                '$value parameter for ' . $name . ' must be one of '
                . join(', ', $valid) . ' or ' . $last . ' - "' . $value
                . '" provided'
            );
        }
    }
    
    /**
     * Sets the PartFilter's headers filter to the passed array after validating
     * it.
     * 
     * @param array $headers
     * @throws InvalidArgumentException
     */
    public function setHeaders(array $headers)
    {
        array_walk($headers, function ($v, $k) {
            $this->validateArgument(
                'headers',
                $k,
                [ static::FILTER_EXCLUDE, static::FILTER_INCLUDE ]
            );
            if (!is_array($v)) {
                throw new InvalidArgumentException(
                    '$value must be an array with keys set to FILTER_EXCLUDE, '
                    . 'FILTER_INCLUDE and values set to an array of header '
                    . 'name => values'
                );
            }
        });
        $this->headers = $headers;
    }
    
    /**
     * Sets the member variable denoted by $name to the passed $value after
     * validating it.
     * 
     * @param string $name
     * @param int|array $value
     * @throws InvalidArgumentException
     */
    public function __set($name, $value)
    {
        if ($name === 'hascontent' || $name === 'multipart'
            || $name === 'textpart' || $name === 'signedpart') {
            if (is_array($value)) {
                throw new InvalidArgumentException('$value must be not be an array');
            }
            $this->validateArgument(
                $name,
                $value,
                [ static::FILTER_OFF, static::FILTER_EXCLUDE, static::FILTER_INCLUDE ]
            );
            $this->$name = $value;
        } elseif ($name === 'headers') {
            if (!is_array($value)) {
                throw new InvalidArgumentException('$value must be an array');
            }
            $this->setHeaders($value);
        }
    }
    
    /**
     * Returns true if the variable denoted by $name is a member variable of
     * PartFilter.
     * 
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->$name);
    }
    
    /**
     * Returns the value of the member variable denoted by $name
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Returns true if the passed MessagePart fails the filter's hascontent
     * filter settings.
     *
     * @param MessagePart $part
     * @return bool
     */
    private function failsHasContentFilter(MessagePart $part)
    {
        return ($this->hascontent === static::FILTER_EXCLUDE && $part->hasContent())
            || ($this->hascontent === static::FILTER_INCLUDE && !$part->hasContent());
    }
    
    /**
     * Returns true if the passed MessagePart fails the filter's multipart
     * filter settings.
     * 
     * @param MessagePart $part
     * @return bool
     */
    private function failsMultiPartFilter(MessagePart $part)
    {
        if (!($part instanceof MimePart)) {
            return $this->multipart !== static::FILTER_EXCLUDE;
        }
        return ($this->multipart === static::FILTER_EXCLUDE && $part->isMultiPart())
            || ($this->multipart === static::FILTER_INCLUDE && !$part->isMultiPart());
    }
    
    /**
     * Returns true if the passed MessagePart fails the filter's textpart filter
     * settings.
     * 
     * @param MessagePart $part
     * @return bool
     */
    private function failsTextPartFilter(MessagePart $part)
    {
        return ($this->textpart === static::FILTER_EXCLUDE && $part->isTextPart())
            || ($this->textpart === static::FILTER_INCLUDE && !$part->isTextPart());
    }
    
    /**
     * Returns true if the passed MessagePart fails the filter's signedpart
     * filter settings.
     * 
     * @param MessagePart $part
     * @return boolean
     */
    private function failsSignedPartFilter(MessagePart $part)
    {
        if ($this->signedpart === static::FILTER_OFF) {
            return false;
        } elseif (!$part->isMime() || $part->getParent() === null) {
            return ($this->signedpart === static::FILTER_INCLUDE);
        }
        $partMimeType = $part->getContentType();
        $parentMimeType = $part->getParent()->getContentType();
        $parentProtocol = $part->getParent()->getHeaderParameter('Content-Type', 'protocol');
        if (strcasecmp($parentMimeType, 'multipart/signed') === 0 && strcasecmp($partMimeType, $parentProtocol) === 0) {
            return ($this->signedpart === static::FILTER_EXCLUDE);
        }
        return ($this->signedpart === static::FILTER_INCLUDE);
    }
    
    /**
     * Tests a single header value against $part, and returns true if the test
     * fails.
     * 
     * @staticvar array $map
     * @param MessagePart $part
     * @param int $type
     * @param string $name
     * @param string $header
     * @return boolean
     */
    private function failsHeaderFor(MessagePart $part, $type, $name, $header)
    {
        $headerValue = null;
        
        static $map = [
            'content-type' => 'getContentType',
            'content-disposition' => 'getContentDisposition',
            'content-transfer-encoding' => 'getContentTransferEncoding',
            'content-id' => 'getContentId'
        ];
        $lower = strtolower($name);
        if (isset($map[$lower])) {
            $headerValue = call_user_func([$part, $map[$lower]]);
        } elseif (!($part instanceof MimePart)) {
            return ($type === static::FILTER_INCLUDE);
        } else {
            $headerValue = $part->getHeaderValue($name);
        }
        
        return (($type === static::FILTER_EXCLUDE && strcasecmp($headerValue, $header) === 0)
            || ($type === static::FILTER_INCLUDE && strcasecmp($headerValue, $header) !== 0));
    }
    
    /**
     * Returns true if the passed MessagePart fails the filter's header filter
     * settings.
     * 
     * @param MessagePart $part
     * @return boolean
     */
    private function failsHeaderPartFilter(MessagePart $part)
    {
        foreach ($this->headers as $type => $values) {
            foreach ($values as $name => $header) {
                if ($this->failsHeaderFor($part, $type, $name, $header)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Determines if the passed MessagePart should be filtered out or not.
     * If the MessagePart passes all filter tests, true is returned.  Otherwise
     * false is returned.
     * 
     * @param MessagePart $part
     * @return boolean
     */
    public function filter(MessagePart $part)
    {
        return !($this->failsMultiPartFilter($part)
            || $this->failsTextPartFilter($part)
            || $this->failsSignedPartFilter($part)
            || $this->failsHeaderPartFilter($part));
    }
}
