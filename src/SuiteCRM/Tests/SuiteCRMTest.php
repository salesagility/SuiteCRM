<?php
/**
 * Created by Adam Jakab.
 * Date: 05/07/16
 * Time: 12.10
 */

namespace SuiteCRM\Tests;

/**
 * Class SuiteCRMTest
 *
 * Collection of generic test methods
 *
 * @package SuiteCRM\Tests
 */
class SuiteCRMTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Compare two strings with ignoring differences in white spaces (mostly for sql)
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    protected function assertSameStringWhiteSpaceIgnore($expected, $actual, $message = '')
    {
        $expected = $this->getWhitespaceCompactedStrings($expected);
        $actual = $this->getWhitespaceCompactedStrings($actual);
        $this->assertSame($expected, $actual, $message);
    }
    
    
    /**
     * Trim and compact multiple whitespaces to single ones
     *
     * @param string $text
     * @return string
     */
    protected function getWhitespaceCompactedStrings($text)
    {
        $answer = trim((string) $text);
        $answer = preg_replace('#\s+#', ' ', $answer);
        
        return $answer;
    }
}