<?php
namespace Consolidation\AnnotatedCommand\Parser\Internal;

/**
 * Hold the tag definition for one tag in a DocBlock.
 *
 * The tag can be sliced into the following forms:
 * - "@tag content"
 * - "@tag word description"
 * - "@tag $variable description"
 * - "@tag word $variable description"
 */
class DocblockTag
{
    /** @var string Name of the tag */
    protected $tag;

    /** @var string|null Contents of the tag. */
    protected $content;

    const TAG_REGEX = '@(?P<tag>[^\s$]+)[\s]*';
    const VARIABLE_REGEX = '\\$(?P<variable>[^\s$]+)[\s]*';
    const VARIABLE_OR_WORD_REGEX = '\\$?(?P<variable>[^\s$]+)[\s]*';
    const TYPE_REGEX = '(?P<type>[^\s$]+)[\s]*';
    const WORD_REGEX = '(?P<word>[^\s$]+)[\s]*';
    const DESCRIPTION_REGEX = '(?P<description>.*)';
    const IS_TAG_REGEX = '/^[*\s]*@/';

    /**
     * Check if the provided string begins with a tag
     * @param string $subject
     * @return bool
     */
    public static function isTag($subject)
    {
        return preg_match(self::IS_TAG_REGEX, $subject);
    }

    /**
     * Use a regular expression to separate the tag from the content.
     *
     * @param string $subject
     * @param string[] &$matches Sets $matches['tag'] and $matches['description']
     * @return bool
     */
    public static function splitTagAndContent($subject, &$matches)
    {
        $regex = '/' . self::TAG_REGEX . self::DESCRIPTION_REGEX . '/s';
        return preg_match($regex, $subject, $matches);
    }

    /**
     * DockblockTag constructor
     */
    public function __construct($tag, $content = null)
    {
        $this->tag = $tag;
        $this->content = $content;
    }

    /**
     * Add more content onto a tag during parsing.
     */
    public function appendContent($line)
    {
        $this->content .= "\n$line";
    }

    /**
     * Return the tag - e.g. "@foo description" returns 'foo'
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Return the content portion of the tag - e.g. "@foo bar baz boz" returns
     * "bar baz boz"
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Convert tag back into a string.
     */
    public function __toString()
    {
        return '@' . $this->getTag() . ' ' . $this->getContent();
    }

    /**
     * Determine if tag is one of:
     * - "@tag variable description"
     * - "@tag $variable description"
     * - "@tag type $variable description"
     *
     * @param string $subject
     * @param string[] &$matches Sets $matches['variable'] and
     *   $matches['description']; might set $matches['type'].
     * @return bool
     */
    public function hasVariable(&$matches)
    {
        return
            $this->hasTypeVariableAndDescription($matches) ||
            $this->hasVariableAndDescription($matches);
    }

    /**
     * Determine if tag is "@tag $variable description"
     * @param string $subject
     * @param string[] &$matches Sets $matches['variable'] and
     *   $matches['description']
     * @return bool
     */
    public function hasVariableAndDescription(&$matches)
    {
        $regex = '/^\s*' . self::VARIABLE_OR_WORD_REGEX . self::DESCRIPTION_REGEX . '/s';
        return preg_match($regex, $this->getContent(), $matches);
    }

    /**
     * Determine if tag is "@tag type $variable description"
     *
     * @param string $subject
     * @param string[] &$matches Sets $matches['variable'],
     *   $matches['description'] and $matches['type'].
     * @return bool
     */
    public function hasTypeVariableAndDescription(&$matches)
    {
        $regex = '/^\s*' . self::TYPE_REGEX . self::VARIABLE_REGEX . self::DESCRIPTION_REGEX . '/s';
        return preg_match($regex, $this->getContent(), $matches);
    }

    /**
     * Determine if tag is "@tag word description"
     * @param string $subject
     * @param string[] &$matches Sets $matches['word'] and
     *   $matches['description']
     * @return bool
     */
    public function hasWordAndDescription(&$matches)
    {
        $regex = '/^\s*' . self::WORD_REGEX . self::DESCRIPTION_REGEX . '/s';
        return preg_match($regex, $this->getContent(), $matches);
    }
}
